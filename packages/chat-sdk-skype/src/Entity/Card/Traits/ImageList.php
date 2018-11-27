<?php

namespace SkypeSDK\Entity\Card\Traits;

use SkypeSDK\Entity\Card\CardImage;

trait ImageList
{
    /**
     * @param CardImage $image
     * @return $this
     */
    function addImage(CardImage $image)
    {
        return $this->add('images', $image);
    }

    /**
     * @return null
     */
    function getImages()
    {
        return $this->get('images');
    }
}