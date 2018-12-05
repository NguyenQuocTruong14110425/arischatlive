<?php

namespace BotBuilder\Components;

use BotBuilder\Helpers\ArrayHelper;
use BotBuilder\Models\Activity;

class Response
{
    /**
     * @var Activity
     */
    private $activity;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $type = 'message';

    /**
     * Response constructor.
     * @param Request $request
     * @param string $message
     */
    public function __construct(Request $request, $message)
    {
        $this->message = $message;
        $this->request = $request;
        $this->activity = $this->createResponseActivity();
    }

    /**
     * @return Activity
     */
    private function createResponseActivity()
    {
        $request = $this->request->getRawRequest();
        $activity = new Activity();
        $activity->text = $this->message;
        $activity->type = $this->type;
        $activity->replyToId = $request['id'];
        $activity->setFrom($request['recipient']);
        $activity->setRecipient($request['from']);
        $activity->setConversation($request['conversation']);
        return $activity;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return ArrayHelper::toArray($this->activity);
    }

    /**
     * @return string
     */
    public function asJson()
    {
        return json_encode(ArrayHelper::toArray($this->activity));
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        if (property_exists($this->activity, $name)) {
            return $this->activity->{$name};
        }

        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }
}