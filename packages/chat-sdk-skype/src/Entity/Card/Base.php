<?php

namespace SkypeSDK\Entity\Card;

use SkypeSDK\Entity\Card\Traits\HasText;
use SkypeSDK\Entity\Card\Traits\HasTitle;
use SkypeSDK\Entity\Entity;

abstract class Base extends Entity
{
    use HasText;
    use HasTitle;

    public function __construct()
    {
        $this->rawObj = new \stdClass();
    }

    function addButton(CardAction $button)
    {
        return $this->add('buttons', $button);
    }

    function getButtons()
    {
        return $this->get('buttons');
    }

    public abstract function getContentType();
}