<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo;
use Zalo\AIBot\LogicAdapter;

class ChatBot
{
    protected  $path_data;

    protected  $data_traing;

    public function __construct()
    {
        $this->path_data = storage_path('bot/data.json');
    }

    public function getDataTraining()
    {
        $string = file_get_contents($this->path_data);
        $json_input = \GuzzleHttp\json_decode($string, true);
        $this->data_traing = $json_input;
        $response = [];
        foreach ($json_input as $key=>$value)
        {
            array_push($response,$key);
        }
        return $response;
    }
    public function getMessage($input)
    {
        $flag = strpos($input,"mấy giờ");
        if($flag !== false)
        {
            return now();
        }
        else {
            $data_traing = $this->getDataTraining();
            $LogicAdapter = new LogicAdapter($data_traing, $input);
            $match_word = $LogicAdapter->GetMatch();
            $out_put = $this->data_traing[$match_word];
            return $out_put;
        }
    }
}