<?php

namespace SkypeSDK\DataProvider;

use SkypeSDK\Api\ApiClient;
use SkypeSDK\SkypeSDK;

abstract class DataProvider
{
    protected $apiClient;

    /**
     * @param ApiClient $client
     */
    public function setApiClient(ApiClient $client)
    {
        $this->apiClient = $client;
    }

    /**
     * @return ApiClient
     */
    protected function getApiClient()
    {
        if ($this->apiClient === null) {
            $this->apiClient = SkypeSDK::getInstance()->getApiClient();
        }
        return $this->apiClient;
    }
}