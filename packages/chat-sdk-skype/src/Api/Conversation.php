<?php

namespace Skype\Api;

class Conversation extends BaseApi implements ApiInterface
{
    public function CreateConersation()
    {
        $url = '/v3/directline/conversations/';
        $result = $this->request('POST',$url);
        return $result;
    }
    public function Reconnect($conversation,$watermark)
    {
        $url = '/v3/directline/conversations/' . $conversation . '?watermark=' .$watermark ;
        $result = $this->request('GET',$url);
        return $result;
    }

    public function CreateActivity($text)
    {

        $url = '/v3/directline/conversations';
        $result = $this->request('POST',$url);
        return $result;
    }
    /**
     * Sends an activity message
     *
     * @param string $target In format of 8:<username> or 19:<group>
     * @param string $text The message
     * @param array $suggestedActions
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function activity($text, $conversation,$watermark)
    {
        $target = $conversation;
        $json = [
            'type' => 'message',
            'from' => [
                'id'   =>  "live:truong.nq_2",
            ],
            "channelId" => 'directline',
            'text' => $text
        ];

        $url = '/v3/directline/conversations/' . $target . '/activities';
        return $this->request('POST',$url , [
            'json' => $json
        ]);
    }

    public function closeActivity($conversation)
    {
        $target = $conversation;
        $json = [
            'type' => 'endOfConversation',
            'from' => [
                'id'   =>  "live:truong.nq_2",
            ],
        ];

        $url = '/v3/directline/conversations/' . $target . '/activities';
        return $this->request('GET',$url , [
            'json' => $json
        ]);
    }
}
