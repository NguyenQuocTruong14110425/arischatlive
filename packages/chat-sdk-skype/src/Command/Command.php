<?php
namespace SkypeSDK\Command;

use SkypeSDK\Api\Api;

abstract class Command {

    /**
     * @return Api
     */
    public abstract function getApi();
    public abstract function processResult($result);
}
