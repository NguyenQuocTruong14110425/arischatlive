<?php

namespace SkypeSDK\Entity\Card;

class VideoCard extends Base
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.video';
    }
}