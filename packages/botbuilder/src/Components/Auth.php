<?php

namespace BotBuilder\Components;

use BotBuilder\Models\AccessToken;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class Auth extends Component
{
    /**
     * @var string
     */
    public $grantType;

    /**
     * @var string
     */
    public $clientId;

    /**
     * @var string
     */
    public $clientSecret;

    /**
     * @var string
     */
    public $scope = 'https://graph.microsoft.com/.default';

    /**
     * @var string
     */
    public $reciveTokenURL = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';

    /**
     * @var Client
     */
    private $client;

    /**
     * Auth constructor.
     * @param \GuzzleHttp\Client $client
     * @param array $options
     */
    public function __construct($client, $options = [])
    {
        $this->client = $client;
        $this->setProperty($options);
    }

    /**
     * @return AccessToken
     */
    public function auth()
    {
        return $accessToken = $this->retrieveAccessToken();
    }

    /**
     * @return AccessToken
     */
    private function retrieveAccessToken()
    {
        try
        {
            $opition = [
                'multipart' => [
                    [
                        'name' => 'grant_type',
                        'contents' => $this->grantType,
                    ],
                    [
                        'name' => 'client_id',
                        'contents' => $this->clientId,
                    ],
                    [
                        'name' => 'client_secret',
                        'contents' => $this->clientSecret,
                    ],
                    [
                        'name' => 'scope',
                        'contents' => $this->scope,
                    ]
                ]
            ];
            $response = $this->client->request('POST', $this->reciveTokenURL, $opition);
            $content = $response->getBody()->getContents();
            return new AccessToken($content);
        }
        catch (\GuzzleHttp\Exception\GuzzleException  $e)
        {
            dd($e);
        }

    }
}