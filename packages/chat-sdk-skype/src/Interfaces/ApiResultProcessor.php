<?php

namespace SkypeSDK\Interfaces;

use SkypeSDK\Entity\Result;

interface ApiResultProcessor
{
    public function processResult(Result $result);
}