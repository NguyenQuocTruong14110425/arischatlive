<?php

namespace SkypeSDK\Entity\Card;

use SkypeSDK\Entity\Card\Traits\HasSubtitle;
use SkypeSDK\Entity\Card\Traits\ImageList;
use SkypeSDK\Entity\Card\Traits\Tapable;

class ThumbnailCard extends Base
{
    use Tapable;
    use ImageList;
    use HasSubtitle;

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.thumbnail';
    }
}