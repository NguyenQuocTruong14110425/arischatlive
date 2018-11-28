<?php

namespace Skype\Api;

class Conversation extends BaseApi implements ApiInterface
{
    public function CreateActivity()
    {
        $url = '/v3/conversations/';
        return $this->request('POST',$url);
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
