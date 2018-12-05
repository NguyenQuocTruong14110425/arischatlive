<?php


namespace BotBuilder\Models;

use BotBuilder\Components\Component;

class Attachment extends Component
{
    /**
     * mimetype/Contenttype for the file
     * @var string
     */
    public $contentType;

    /**
     * Content Url
     * @var string
     */
    public $contentUrl;

    /**
     * Embedded content
     * @var object
     */
    public $content;

    /**
     *  The name of the attachment
     * @var string
     */
    public $name;

    /**
     * Thumbnail associated with attachment
     * @var string
     */
    public $thumbnailUrl;


}