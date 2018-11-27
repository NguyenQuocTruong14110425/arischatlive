<?php

namespace SkypeSDK\Listener;


use SkypeSDK\Entity\ContactUpdatePayload;
use SkypeSDK\Entity\ConversationUpdatePayload;
use SkypeSDK\Entity\MessagePayload;
use SkypeSDK\Entity\Payload;

class PayloadFactory
{
    public static function createPayload(\stdClass $requestObj)
    {
        $payload = new Payload($requestObj);
        switch ($payload->getType()) {
            case Payload::TYPE_MESSAGE_TEXT:
                return new MessagePayload($requestObj);
            case Payload::TYPE_CONTACT_UPDATE:
                return new ContactUpdatePayload($requestObj);
            case Payload::TYPE_CONVERSATION_UPDATE:
                return new ConversationUpdatePayload($requestObj);
        }

        return $payload;
    }
}