<?php

namespace SkypeSDK\Interfaces;

use SkypeSDK\Entity\ContactUpdatePayload;

interface ContactUpdateHandler
{
    public function handlerPayload(ContactUpdatePayload $payload);
}