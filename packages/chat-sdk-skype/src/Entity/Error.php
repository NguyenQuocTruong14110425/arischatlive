<?php

namespace SkypeSDK\Entity;

class Error extends Entity
{
    public function getMessage()
    {
        return $this->get('message');
    }
}