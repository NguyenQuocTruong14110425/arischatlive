<?php

namespace SkypeSDK\Entity\Card;

use SkypeSDK\Entity\Card\Traits\HasImage;
use SkypeSDK\Entity\Card\Traits\HasSubtitle;
use SkypeSDK\Entity\Card\Traits\HasText;
use SkypeSDK\Entity\Card\Traits\HasTitle;
use SkypeSDK\Entity\Card\Traits\Tapable;
use SkypeSDK\Entity\Entity;

class ReceiptItem extends Entity
{
    use Tapable;
    use HasSubtitle;
    use HasImage;
    use HasText;
    use HasTitle;

    function setPrice($price)
    {
        return $this->set('price', $price);
    }

    function getPrice()
    {
        return $this->get('price');
    }

    function setQuantity($quantity)
    {
        return $this->set('quantity', $quantity);
    }

    function getQuantity()
    {
        return $this->get('quantity');
    }
}