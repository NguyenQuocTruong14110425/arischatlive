<?php

namespace BotBuilder;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use BotBuilder\Components\Request as BotRequest;
use BotBuilder\Components\Response;
use BotBuilder\Components\Auth;
use GuzzleHttp\Exception\BadResponseException;
class Client
{
    /**
     * @var \BotBuilder\Models\AccessToken
     */
    private $accessToken;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var \BotBuilder\Components\Request
     */
    private $request;

    /**
     * @var \BotBuilder\Components\Response
     */
    private $response;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * Client constructor.
     * Initiate instance of Guzzle, authenticate client and receive access token
     *
     * $authOptions = [
     *  'grantType' => 'client_credentials',
     *  'clientId' => 'your_client_id',
     *  'clientSecret' => 'your_client_secret',
     *  'scope' => 'https://graph.microsoft.com/.default',
     *  'reciveTokenURL' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
     * ];
     *
     * @param array $authOptions
     */
    public function __construct($authOptions)
    {
        $this->client = new GuzzleClient();
        $this->auth = new Auth( $this->client,$authOptions);
        $this->accessToken = $this->auth();
    }

    /**
     * Authenticate client and receive access token
     *
     * @return $this
     */
    public function auth()
    {
        $this->accessToken = $this->auth->auth();
        return $this;
    }

    /**
     * Return access token object
     *
     * @return \BotBuilder\Models\AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set request data for client
     *
     * @param array $request
     * @return $this
     */
    public function setRequest(array $request)
    {
        $this->request = new BotRequest($request);
        return $this;
    }

    /**
     * Get request object
     *
     * @return \BotBuilder\Components\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Create correct response
     *
     * @param string $message
     * @return $this
     */
    public function makeResponse($message)
    {
        $this->response = new Response($this->request, $message);
        return $this;
    }

    /**
     * Get response object
     *
     * @return \BotBuilder\Components\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function createActivity($channelId)
    {
        try
        {
            $headers = [
                'Authorization' => 'Bearer ' . $this->accessToken->getAccessToken(),
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Origin'   => '*',
                'Access-Control-Allow-Headers'  => 'Content-Type, X-Auth-Token, Origin'
            ];
            $channel = $channelId;

            $request = new Request(
                "POST",
                "https://{$channel}.trafficmanager.net/apis/v3/conversations/",
                $headers
            );
            $response = $this->client->send($request, ['timeout' => 2]);
            return $response;
        }
        catch (BadResponseException $e)
        {
            return $e->getMessage();
        }
    }
    public function send()
    {
        try
        {
            $headers = [
                'Authorization' => 'Bearer ' . $this->accessToken->getAccessToken(),
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Origin'   => '*',
                'Access-Control-Allow-Headers'  => 'Content-Type, X-Auth-Token, Origin'
            ];
            $channel = $this->request->channelId;
            $conversationId = urlencode($this->request->conversation->id);
            $id = $this->request->id;
            $body = $this->getResponse()->asJson();

            $request = new Request(
                "POST",
                "https://{$channel}.trafficmanager.net/apis/v3/conversations/{$conversationId}/activities/{$id}",
                $headers,
                $body
            );
            $response = $this->client->send($request, ['timeout' => 2]);
            return $response;
        }
        catch (BadResponseException $e)
        {
            return $e->getMessage();
        }
    }
}