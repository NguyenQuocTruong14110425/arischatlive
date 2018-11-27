<?php
namespace SkypeSDK\Command;

use SkypeSDK\Api\Api;
use SkypeSDK\Entity\Activity;
use SkypeSDK\Entity\Attachment;
use SkypeSDK\Entity\AttachmentFactory;
use SkypeSDK\Entity\Result;
use SkypeSDK\SkypeSDK;

class SendActivity extends ApiCommand
{

    protected $activity;
    protected $conversation;

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct(Activity $activity, $conversation) {
        $this->activity = $activity;
        $this->conversation = $conversation;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        $config = SkypeSDK::getInstance()->getConfig();
        return new Api(
            $config->getApiEndpoint() . '/v3/conversations/' . $this->conversation . '/activities',
            array(
                APi::PARAM_PARAMS => $this->activity->getRaw()
            )
        );
    }

    /**
     * @return Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @return mixed
     */
    public function getConversation()
    {
        return $this->conversation;
    }


}