<?php
namespace SkypeSDK\Command;

use SkypeSDK\Entity\Activity;
use SkypeSDK\Entity\Attachment;

class SendAttachment extends SendActivity {

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct(Attachment $attachment, $conversation, $message = null) {
        $this->activity = new Activity();
        $this->activity->addAttachment($attachment);
        if ($message) {
            $this->activity->setText($message);
        }
        $this->conversation = $conversation;
    }
}