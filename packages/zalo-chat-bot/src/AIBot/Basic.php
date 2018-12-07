<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo\AIBot;


class Basic
{
    public function countLen($word)
    {
        return strlen($word);
    }

    public function splitInput($input)
    {
        $arr_input = preg_split("/[\s,]+/",$input);
        return $arr_input;
    }

    public function CheckExitElementOfArray($arr_input,$element)
    {
         return array_search($element,$arr_input);
    }

    public function CheckDuplicateArray($arr_input)
    {
        return count($arr_input) !== count(array_unique($arr_input));;
    }

    public function PushKeyForArray($arr_input, $key)
    {
        $arr_input[$key]  =  [];
        return $arr_input;
    }

    public function GetValueByKeyArray($arr_input, $key)
    {
        return  $arr_input[$key];
    }

    public function saveQuestionLog($data_write)
    {
        $data_json = \GuzzleHttp\json_encode($data_write, JSON_UNESCAPED_UNICODE);
        file_put_contents($this->path_log, $data_json);
    }

    public function saveAnswer($data_write)
    {
        $data_json = \GuzzleHttp\json_encode($data_write, JSON_UNESCAPED_UNICODE);
        file_put_contents($this->path_data_train, $data_json);
    }
}