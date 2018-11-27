<?php
namespace SkypeSDK\Command;

use SkypeSDK\Entity\Activity;

class SendMessage extends SendActivity  {

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct($message, $conversation) {
        $this->activity = new Activity();
        $this->activity->setText($message);
        $this->conversation = $conversation;
    }
}