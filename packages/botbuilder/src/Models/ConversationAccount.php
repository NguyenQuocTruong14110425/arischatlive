<?php


namespace BotBuilder\Models;

use BotBuilder\Components\Component;

class ConversationAccount extends Component
{
    /**
     *  Is this a reference to a group
     * @var boolean
     */
    public $isGroup;

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

    public function __construct($source = [])
    {
        $this->setProperty($source);
    }
}