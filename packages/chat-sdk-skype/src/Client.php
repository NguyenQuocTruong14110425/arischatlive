<?php

namespace Skype;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Skype\Authentication\FileTokenStorage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Client
{
    /**
     * @var null|ClientInterface
     */
    private $client;
    /**
     * @var
     */
    private $token;
    /**
     * @var FileTokenStorage
     */
    private $tokenStorage;
    /**
     * @var
     */
    private $handlerStack;
    /**
     * @var null|LoggerInterface
     */
    private $logger;
    /**
     * @var null|OutputInterface
     */
    private $output;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var int
     */
    private $reAuthCounter = 0;

    /**
     * Client constructor.
     * @param array                $config
     * @param OutputInterface|null $output
     * @param InputInterface|null  $input
     * @param ClientInterface|null $client
     */
    public function __construct(array $config = [], LoggerInterface $logger = null, OutputInterface $output = null, ClientInterface $client = null)
    {
        $this->config = new Config($config);
        if (is_object($this->config->get('tokenStorageService'))){
            $this->tokenStorage = $this->config->get('tokenStorageService');
        } else {
            try {
                $class = $this->config->get('tokenStorageClass');
                $this->tokenStorage = (new \ReflectionClass($class))->newInstance();
            } catch (\Exception $exception) {
                $this->tokenStorage = new FileTokenStorage($this->config->get('fileTokenStoragePath'));
            }
        }
        $this->logger = $logger;
        $this->output = $output;

        $this->initializeHttpClient($client);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function api($name)
    {
        $class = 'Skype\\Api\\' . ucfirst($name);

        if (class_exists($class)) {
            return new $class($this->client, $this->token, $this->logger);
        } else {
            throw new \InvalidArgumentException('Unknown Api "' . $name . '" requested');
        }
    }

    /**
     * Authentication
     */
    public function auth()
    {
        $this->handlerStack->remove('reAuth');
        $options =[
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->config->get('token')),
                'Content-Type'=> 'application/json'
            ]
        ];
        $res = $this->client->request('POST',$this->config->get('authUri'),$options);
        $json = \GuzzleHttp\json_decode($res->getBody(), true);
        $this->tokenStorage->write($json);
    }

    /**
     * @param null $token
     */
    public function authorize($token = null)
    {
        if ($token) {
            $this->token = $token;
        } else {
            $this->token = $this->config->get('token');
        }
        return $this;
    }

    /**
     * @param  ClientInterface|null               $client
     * @return \GuzzleHttp\Client|ClientInterface
     */
    private function initializeHttpClient(ClientInterface $client = null)
    {
        if ($client) {
            return $this->client = $client;
        }

        return $this->client = $this->createDefaultHttpClient();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    private function createDefaultHttpClient()
    {
        $this->handlerStack = HandlerStack::create(new CurlHandler());
        $this->handlerStack->push(Middleware::mapRequest($this->getReAuthMiddlewareClosure()), 'reAuth');

        $config = [
            'base_uri' => $this->config->get('baseUri'),
            'handler' => $this->handlerStack,
            'http_errors' => $this->config->get('httpErrors'),
        ];

        return new \GuzzleHttp\Client($config);
    }

    /**
     * @return \Closure
     */
    private function getReAuthMiddlewareClosure()
    {
        return function (RequestInterface $request) {
            if ($this->reAuthCounter > 0) {
                $this->reAuthCounter = 0;

                return $request;
            }

            $now = new \DateTime('now', new \DateTimeZone('UTC'));

            if (
                ($this->tokenStorage->read('expires_in') < ($now->getTimestamp() + 600))
                && $this->config->get('clientId')
                && $this->config->get('clientSecret')
            ) {
                $this->log('<info>Trying to re-authenticate.</info>');

                ++$this->reAuthCounter;

                $this->auth();
                $this->authorize();

                $this->log('<info>Sending the request again with a token.</info>');

                return $request->withHeader(
                    'Authorization',
                    sprintf('Bearer %s', $this->token)
                );
            }

            if (
                ($this->tokenStorage->read('expires_in') < ($now->getTimestamp() + 600))
            ) {
                $this->log('<info>You should re-auth in the following 10 minutes.</info>');
            }

            return $request;
        };
    }

    private function log($message)
    {
        if ($this->output) {
            $this->output->writeln($message);
        }

        if ($this->logger) {
            $this->logger->info($message);
        }
    }
}
