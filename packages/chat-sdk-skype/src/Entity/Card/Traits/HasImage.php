<?php

namespace SkypeSDK\Entity\Card\Traits;

use SkypeSDK\Entity\Card\CardAction;
use SkypeSDK\Entity;
use SkypeSDK\Entity\Card\CardImage;

trait HasImage
{
    /**
     * @param CardImage $image
     * @return $this
     */
    function setImage(CardImage $image)
    {
        return $this->set('image', $image);
    }

    /**
     * @return null|CardImage
     */
    function getImage()
    {
        return $this->get('image', CardImage::class);
    }
}