<?php


namespace BotBuilder\Models;

use BotBuilder\Components\Component;

class ChannelAccount extends Component
{
    /**
     * Channel id for the user or bot on this channel (Example: joe@smith.com, or @joesmith or 123456)
     * @var string
     */
    public $id;

    /**
     * Display friendly name
     * @var string
     */
    public $name;

    /**
     * ChannelAccount constructor.
     * @param $source
     */
    public function __construct($source = [])
    {
        $this->setProperty($source);
    }
}