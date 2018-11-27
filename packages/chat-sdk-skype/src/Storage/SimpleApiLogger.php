<?php

namespace SkypeSDK\Storage;


use SkypeSDK\Interfaces\ApiLogger;

class SimpleApiLogger implements ApiLogger
{
    private $handler;

    public function __construct()
    {
        if (php_sapi_name() === 'cli') {
            $this->handler = fopen('php://output', 'w');
            return;
        }
        $this->handler = fopen('php://memory', 'w');
    }

    public function __destruct()
    {
        if ($this->handler) {
            fclose($this->handler);
        }
    }

    public function log($message)
    {
        fwrite($this->handler, $message);
        fwrite($this->handler, PHP_EOL);
    }
}