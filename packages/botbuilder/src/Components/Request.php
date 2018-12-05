<?php

namespace BotBuilder\Components;

use BotBuilder\Models\Activity;


class Request extends Component
{
    /**
     * @var Activity
     */
    private $activity;

    /**
     * @var array
     */
    private $rawRequest;

    /**
     * Request constructor.
     * @param array $source
     */
    public function __construct(array $source)
    {
        $this->rawRequest = $source;
        $this->activity = new Activity($source);
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

    /**
     * Get raw request data
     *
     * @return array
     */
    public function getRawRequest()
    {
        return $this->rawRequest;
    }
}