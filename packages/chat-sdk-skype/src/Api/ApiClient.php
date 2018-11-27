<?php
namespace SkypeSDK\Api;

use SkypeSDK\Command\AnonymousCommand;
use SkypeSDK\Command\Authenticate;
use SkypeSDK\Command\Command;
use SkypeSDK\DataProvider\TokenProvider;
use SkypeSDK\Exception\ResponseException;
use SkypeSDK\Exception\SecurityException;
use SkypeSDK\Interfaces\ApiLogger;
use SkypeSDK\SkypeSDK;
use SkypeSDK\Storage\TokenStorage;

class ApiClient {

    /**
     * @var ApiClient
     */
    static private $instance;

    private $httpClient;

    /**
     * @var TokenProvider
     */
    private $tokenProvider;

    private function __construct()
    {

    }

    /**
     * @return ApiClient
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new ApiClient();
        }
        return static::$instance;
    }

    public function setApiLogger(ApiLogger $logger)
    {
        $this->getHttpClient()->setLogger($logger);
        return $this;
    }

    /**
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        if ($this->httpClient == null) {
            $this->httpClient = SkypeSDK::getInstance()->getHttpClient();
        }
        return $this->httpClient;
    }

    public function call(Command $command)
    {
        $result = $this->callCommand($command);
        dd($result);
        if ($result === false) {
            if ($command instanceof Authenticate) {
                throw new SecurityException('Failed to authenticate!');
            }
            $this->getTokenProvider()->getNewToken();
            return $this->callCommand($command);
        }
        return $command->processResult($result);
    }

    private function callCommand(Command $command)
    {
        $api = $command->getApi();
        $fullUrl = $api->getRequestUrl();
        if (!($command instanceof AnonymousCommand)) {
            $this->getHttpClient()->setHeader(
                'Authorization',
                'Bearer ' . $this->getTokenProvider()->getAccessToken()->getToken()
            );
        }
        $requestMethod = $api->getRequestMethod();
        if ($requestMethod == HttpClient::METHOD_GET) {
            $result = $this->getHttpClient()->get($fullUrl, $api->getRequestParams());
        } else {
            $params = $api->getRequestParams();
            if ($api->isJsonRequest()) {
                $params = json_encode($params);
            }
            switch ($requestMethod) {
                case HttpClient::METHOD_POST:
                    $result = $this->getHttpClient()->post($fullUrl, $params);
                    break;
                case HttpClient::METHOD_PUT:
                    $result = $this->getHttpClient()->put($fullUrl, $params);
                    break;
                case HttpClient::METHOD_DELETE:
                    $result = $this->getHttpClient()->delete($fullUrl, $params);
                    break;
            }
        }
        if (!$result) {
            if ($this->getHttpClient()->getReturnCode() == 401) {
                return false;
            }
        }
        if ($api->getJsonResult()) {
            $json = json_decode($result);
            if ($json === null) {
                throw new ResponseException('Invalid Json format: ' . $result);
            }
            return $json;
        }

        return $result;
    }

    /**
     * @return TokenProvider
     */
    private function getTokenProvider()
    {
        if ($this->tokenProvider === null) {
            $this->tokenProvider = SkypeSDK::getInstance()->getTokenProvider();
        }
        return $this->tokenProvider;
    }
}
