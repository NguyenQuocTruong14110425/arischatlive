<?php

namespace BotBuilder\Models;

class AccessToken
{
    /**
     * @var string
     */
    private $tokenType;

    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * AccessToken constructor.
     * @param $content string
     */
    public function __construct($content)
    {
        $obj = json_decode($content);
        $this->setTokenType($obj->token_type);
        $this->setExpiresIn($obj->expires_in);
        $this->setAccessToken($obj->access_token);
    }

    /**
     * @param $tokenType
     */
    private function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @param $expiresIn
     */
    private function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @param $accessToken
     */
    private function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}