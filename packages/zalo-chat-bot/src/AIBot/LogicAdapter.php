<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo\AIBot;


class LogicAdapter extends Basic
{
    protected $adapter;

    protected $input;

    protected $len_input;


    public function __construct($adapter,$input)
    {
        //array
        $this->adapter = $adapter;
        //string
        $this->input = $input;

        $this->len_input = $this->countLen($input);

    }

    public function getNowTime()
    {
        $now = now();
        return $now;
    }

    public function Traing()
    {
        $arr_result = [];
        foreach ($this->adapter as $key=>$value)
        {
                $match = new BestMatch($value,$this->input);
                $result = $match->Process();
            $arr_result[$value] = $result;
        }
        return $arr_result;
    }

    public function GetMatch()
    {
            $out_put = $this->Traing();
            $max_rate = max($out_put);
            if($max_rate == 0)
            {
                $response = null;
            }
            else
            {
                $response = array_search($max_rate,$out_put);
            }
            return $response;
    }
}