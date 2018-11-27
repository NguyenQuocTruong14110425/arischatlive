<?php

namespace SkypeSDK\Entity;

class ContactUpdatePayload extends Payload
{
    const ACTION_ADD = 'add';
    const ACTION_REMVOVE = 'remove';

    public function getAction() {
        return $this->get('action');
    }
}