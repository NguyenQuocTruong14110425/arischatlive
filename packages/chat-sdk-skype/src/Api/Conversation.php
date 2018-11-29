<?php

namespace Skype\Api;

class Conversation extends BaseApi implements ApiInterface
{
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
    public function activity($text, $suggestedActions = [])
    {
        $target = '20Pj8rFoZElCeI8ugIjDbF';
        $json = [
            'type' => 'message',
            'from' => [
                'id'   =>  "0fcda35d-d319-4e2d-9139-3432bab9fd95",
            ],
            'conversation' => [
                'id'   => $target,
            ],
            'text' => "Hello",
        ];
        $url = '/v3/directline/conversations/' . $target . '/activities';
        return $this->request('GET',$url , [
            'json' => $json
        ]);
    }
}
