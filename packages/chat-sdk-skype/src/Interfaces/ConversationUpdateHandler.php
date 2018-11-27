<?php

namespace SkypeSDK\Interfaces;

use SkypeSDK\Entity\ConversationUpdatePayload;

interface ConversationUpdateHandler
{
    public function handlerPayload(ConversationUpdatePayload $payload);
}