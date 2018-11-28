<?php

namespace Skype\Api;

class Conversation extends BaseApi implements ApiInterface
{
    public function CreateActivity($text)
    {
        $json = [
            'bot' => ["id" => "0fcda35d-d319-4e2d-9139-3432bab9fd95","name"=>"Chat_Aris_demo"],
            'isGroup' => false,
            'member' => [["id" => "0fcda35d-d319-4e2d-9139-3432bab9fd95","name"=>"Chat_Aris_demo"]],
            'topicName' => 'New Alert!',
            'activity' => [ "type" => "message", "text" => $text]
        ];
        if (!empty($suggestedActions)) {
            $json['suggestedActions']['actions'] = $suggestedActions;
        }
        $url = '/v3/conversations';
        $result = $this->request('POST',$url , [
            'json' => $json
        ]);
        dd($result);
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
    public function activity($target, $text, $suggestedActions = [])
    {
        $json = [
            'type' => 'message/text',
            'text' => $text,
        ];

        if (!empty($suggestedActions)) {
            $json['suggestedActions']['actions'] = $suggestedActions;
        }
        $url = '/v3/conversations/' . $target . '/activities';
        return $this->request('POST',$url , [
            'json' => $json
        ]);
    }
}
