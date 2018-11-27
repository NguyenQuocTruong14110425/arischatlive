<?php

namespace SkypeSDK\Entity\Card;

use SkypeSDK\Entity\Entity;

class MediaUrl extends Entity
{
    function setProfile($profile)
    {
        return $this->set('profile', $profile);
    }

    function getProfile()
    {
        return $this->get('profile');
    }

    function setUrl($url)
    {
        return $this->set('url', $url);
    }

    function getUrl()
    {
        return $this->get('url');
    }
}