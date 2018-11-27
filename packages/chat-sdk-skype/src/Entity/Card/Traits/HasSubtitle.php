<?php

namespace SkypeSDK\Entity\Card\Traits;

use SkypeSDK\Entity\Card\CardAction;
use SkypeSDK\Entity;

trait HasSubtitle
{
    /**
     * @param $subtitle
     * @return mixed
     */
    function setSubtitle($subtitle)
    {
        return $this->set('subtitle', $subtitle);
    }

    /**
     * @return mixed
     */
    function getSubtitle()
    {
        return $this->get('subtitle');
    }
}