<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo;


class ChatBot
{
    protected  $path_data;

    public function __construct()
    {
        $this->path_data = storage_path('bot/data.json');
    }

    public function getMessage($input)
    {
        $string = file_get_contents($this->path_data);
        $json_a = \GuzzleHttp\json_decode($string, true);
        $arr_input = preg_split("/[\s,]+/",$input);
        $rank = [];
        foreach ($json_a as $key=>$value)
        {
            $rank[$key] = 0;
            foreach ($arr_input as $values)
            {
                $rate = 0;
                $flag = strpos($key,$values);
                if($flag !== false || $flag === 0)
                {
                    $rate = (int)($rank[$key]) + 1;
                    $rank[$key] = $rate;
                }
            }
        }
        $max_rate = max($rank);
        $out_put = $json_a[array_search($max_rate,$rank)];
        if($max_rate == 0)
        {
            $out_put = 'Chỉ chấp nhận tin nhắn của con người, vui lòng nhập lại ...';
        }
        return $out_put;
    }
}