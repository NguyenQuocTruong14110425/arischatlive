<?php
namespace SkypeSDK\Command;

use SkypeSDK\Api\Api;
use SkypeSDK\Api\HttpClient;
use SkypeSDK\DataProvider\OpenIdKeysProvider;
use SkypeSDK\Entity\Jwk\JsonWebKey;
use SkypeSDK\Exception\PayloadException;
use SkypeSDK\SkypeSDK;

class GetListSigningKeys extends AnonymousCommand
{

    private $endpoint;

    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return new Api(
            $this->endpoint,
            [
                Api::PARAM_JSON_REQUEST => true,
                Api::PARAM_METHOD => HttpClient::METHOD_GET
            ]
        );
    }

    public function processResult($result)
    {
        if (!property_exists($result, 'keys') || !is_array($result->keys)) {
            throw new PayloadException('Signing keys should be an array');
        }
        $keys = array();
        foreach ($result->keys as $obj) {
            $key = new JsonWebKey($obj);
            $keys[$key->getKeyId()] = $key;
        }
        SkypeSDK::getInstance()->getOpenIdKeysProvider()->saveKeys($keys);
    }
}