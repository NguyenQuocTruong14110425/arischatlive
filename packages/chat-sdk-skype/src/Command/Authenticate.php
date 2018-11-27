<?php
namespace SkypeSDK\Command;

use SkypeSDK\Api\Api;
use SkypeSDK\Config;
use SkypeSDK\DataProvider\TokenProvider;
use SkypeSDK\Entity\AccessToken;
use SkypeSDK\SkypeSDK;

class Authenticate extends AnonymousCommand
{

    protected $appId;
    protected $appSecret;
    protected $authenticateEndpoint;

    public function __construct() {
        $config = SkypeSDK::getInstance()->getConfig();
        $this->appId = $config->getAppId();
        $this->appSecret = $config->getAppSecret();
        $this->authenticateEndpoint = $config->getAuthEndpoint();
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return new Api(
            $this->authenticateEndpoint,
            array (
                Api::PARAM_PARAMS => array(
                    'grant_type' => 'client_credentials',
                    'scope' => 'https://graph.microsoft.com/.default',
                    'client_id' => $this->appId,
                    'client_secret' => $this->appSecret
                ),
                Api::PARAM_HEADERS => array(
                    'Content-Type: application/x-www-form-urlencoded'
                )
            )
        );
    }

    public function processResult($result)
    {
        SkypeSDK::getInstance()->getTokenProvider()->saveToken(new AccessToken($result));
    }
}