<?php

namespace SkypeSDK\Interfaces;

use SkypeSDK\Entity\MessagePayload;

interface MessageHandler
{
    public function handlerMessage(MessagePayload $message);
}