<?php

namespace SkypeSDK\Entity\Card\Traits;

use SkypeSDK\Entity\Card\CardAction;
use SkypeSDK\Entity;

trait Tapable
{
    /**
     * @param CardAction $tap
     * @return $this
     */
    function setTap(CardAction $tap)
    {
        return $this->set('tap', $tap);
    }

    /**
     * @return null|CardAction
     */
    function getTap()
    {
        return $this->get('tap', CardAction::class);
    }
}