<?php
namespace SkypeSDK\Command;

use SkypeSDK\Api\Api;
use SkypeSDK\Api\HttpClient;
use SkypeSDK\Entity\Jwk\OpenIdConfig;
use SkypeSDK\SkypeSDK;

class GetOpenIdConfiguration extends AnonymousCommand
{

    /**
     * @return Api
     */
    public function getApi()
    {
        return new Api(
            SkypeSDK::getInstance()->getConfig()->getOpenIdEndpoint() . '/v1/.well-known/openidconfiguration',
            array(
                Api::PARAM_JSON_RESPONSE => true,
                APi::PARAM_METHOD => HttpClient::METHOD_GET
            )
        );
    }

    public function processResult($result)
    {
        if (!$result) {
            return;
        }
        $configEntity = new OpenIdConfig($result, true);
        SkypeSDK::getInstance()->getOpenIdConfigProvider()->saveConfig($configEntity);
    }
}