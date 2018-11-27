<?php
namespace SkypeSDK\DataProvider;

use SkypeSDK\Command\GetListSigningKeys;
use SkypeSDK\Entity\Jwk\JsonWebKey;
use SkypeSDK\Interfaces\DataStorage;
use SkypeSDK\SkypeSDK;

class OpenIdKeysProvider extends DataProvider
{
    const KEY_STORAGE = 'openid_keys';

    /**
     * @var DataStorage
     */
    protected $storage;

    private $keys;

    /**
     * OpenIdKeysProvider constructor.
     * @param DataStorage $storage
     */
    public function __construct(DataStorage $storage) {
        $this->storage = $storage;
    }

    /**
     * @param $keys
     */
    public function saveKeys($keys) {
        $this->keys = $keys;
        $this->storage->set(static::KEY_STORAGE, $keys);
    }

    /**
     * @return JsonWebKey[]
     */
    public function getKeys() {
        if ($this->keys === null) {
            $this->keys = $this->storage->get(static::KEY_STORAGE);
        }
        if ($this->keys === null) {
            $this->resyncKeys();
        }
        return $this->keys;
    }

    public function resyncKeys()
    {
        $jwkUri = SkypeSDK::getInstance()->getOpenIdConfigProvider()->getConfig()->getJwksUri();
        $api = new GetListSigningKeys($jwkUri);
        $this->getApiClient()->call($api);
        $this->keys = $this->storage->get(static::KEY_STORAGE);
    }

    /**
     * @param $kId
     * @return JsonWebKey
     */
    public function getKeyById($kId)
    {
        $keys = $this->getKeys();
        if (isset($keys[$kId])) {
            return $keys[$kId];
        }
    }
}