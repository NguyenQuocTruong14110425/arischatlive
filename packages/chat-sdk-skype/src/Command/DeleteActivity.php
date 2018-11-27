<?php
namespace SkypeSDK\Command;

use SkypeSDK\Api\Api;
use SkypeSDK\Api\HttpClient;
use SkypeSDK\Entity\Activity;
use SkypeSDK\Entity\Attachment;
use SkypeSDK\Entity\AttachmentFactory;
use SkypeSDK\Entity\Result;
use SkypeSDK\SkypeSDK;

class DeleteActivity extends ApiCommand {

    protected $activityId;
    protected $conversation;

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct($activityId, $conversation) {
        $this->activityId = $activityId;
        $this->conversation = $conversation;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        $config = SkypeSDK::getInstance()->getConfig();
        $api = new Api(
            $config->getApiEndpoint() . '/v3/conversations/' . $this->conversation . '/activities/' . $this->activityId
        );
        $api->setRequestMethod(HttpClient::METHOD_DELETE);
        return $api;
    }
}