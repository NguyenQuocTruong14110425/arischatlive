<?php

namespace SkypeSDK\Entity\Card\Traits;

use SkypeSDK\Entity\Card\CardAction;
use SkypeSDK\Entity;

trait HasText
{
    /**
     * @param $text
     * @return $this
     */
    function setText($text)
    {
        return $this->set('text', $text);
    }

    /**
     * @return null|string
     */
    function getText()
    {
        return $this->get('text');
    }
}