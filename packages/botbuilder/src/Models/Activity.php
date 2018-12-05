<?php


namespace BotBuilder\Models;

use BotBuilder\Components\Component;

class Activity extends Component
{
    /**
     * The type of the activity:
     * [message|contactRelationUpdate|converationUpdate|typing]
     * @var string
     */
    public $type;

    /**
     * Id for the activity
     * @var string
     */
    public $id;

    /**
     * Time when message was sent
     * @var string
     */
    public $timestamp;

    /**
     * Service endpoint
     * @var string
     */
    public $serviceUrl;

    /**
     * ChannelId the activity was on
     * @var string
     */
    public $channelId;

    /**
     * Sender address
     * @var ChannelAccount
     */
    public $from;

    /**
     * Conversation
     * @var ConversationAccount
     */
    public $conversation;

    /**
     *  (Outbound to bot only) Bot's address that received the message
     * @var ChannelAccount
     */
    public $recipient;

    /**
     * Format of text fields [plain|markdown] Default:markdown
     * @var
     */
    public $textFormat = 'markdown';

    /**
     * AttachmentLayout - hint for how to deal with multiple attachments Values:
     * [list|carousel] Default:list
     * @var string
     */
    public $attachmentLayout = 'list';

    /**
     * Array of address added
     * @var ChannelAccount[]
     */
    public $membersAdded;

    /**
     * Array of addresses removed
     * @var ChannelAccount[]
     */
    public $membersRemoved;

    /**
     * Conversations new topic name
     * @var string
     */
    public $topicName;

    /**
     * The previous history of the channel was disclosed
     * @var bool
     */
    public $historyDisclosed;

    /**
     * The language code of the Text field
     * @var string
     */
    public $locale;

    /**
     * Content for the message
     * @var string
     */
    public $text;

    /**
     * Text to display if you can't render cards
     * @var string
     */
    public $summary;

    /**
     * Attachments
     * @var Attachment[]
     */
    public $attachments;

    /**
     * Collection of Entity objects, each of which contains metadata about this activity. Each Entity object is typed
     * @var Entity[]
     */
    public $entities;

    /**
     * Channel specific payload
     * @var object
     */
    public $channelData;

    /**
     * ContactAdded/Removed action
     * @var string
     */
    public $action;

    /**
     * The original id this message is a response to
     * @var string
     */
    public $replyToId;

    /**
     * Activity constructor.
     * @param array $source
     */
    public function __construct($source = [])
    {
        if (!empty($source['from'])) {
            $this->setFrom($source['from']);
            unset($source['from']);
        }

        if (!empty($source['conversation'])) {
            $this->setConversation($source['conversation']);
            unset($source['conversation']);
        }

        if (!empty($source['recipient'])) {
            $this->setRecipient($source['recipient']);
            unset($source['recipient']);
        }

        $this->setProperty($source);
    }

    /**
     * @param $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = new ChannelAccount($from);

        return $this;
    }

    /**
     * @param $conversation
     * @return $this
     */
    public function setConversation($conversation)
    {
        $this->conversation = $conversationAccount = new ConversationAccount($conversation);

        return $this;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = new ChannelAccount($recipient);

        return $this;
    }
}