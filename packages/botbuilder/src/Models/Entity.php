<?php


namespace BotBuilder\Models;

use BotBuilder\Components\Component;

class Entity extends Component
{
    /**
     * Entity Type (typically from schema.org types)
     * @var string
     */
    public $type;
}