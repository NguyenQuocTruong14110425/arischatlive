<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo\AIBot;


class Learning extends Basic
{
    // string
    private $file_log;
    // array
    private $file_traing;
    //string
    private $input_log;

    //string
    private $input_train;

    private $user_id;

    private $key_question;

    public function __construct($file_log,$file_traing,$input_log,$input_train,$user_id)
    {
        //string
        $this->file_log = $file_log;
        //array
        $this->file_traing = $file_traing;
       //string
        $this->input_log = $input_log;
        //string
        $this->input_train = $input_train;
        //string
        $this->user_id = $user_id;
    }

    public function findRowUser()
    {
       if(isset($this->file_log[$this->user_id]))
       {
           return $this->file_log[$this->user_id];
       }
       return false;
    }

    public function findRowTraingByUser($key_question)
    {
        if(isset($this->file_traing[$key_question]))
        {
            return $this->file_traing[$key_question];
        }
        return false;
    }

    public function getDataLogSave()
    {
       $this->file_log[$this->user_id] = $this->input_log;
        return $this->file_log;
    }

    public function getDataLogTraing($arr_train_input)
    {
        $flag = $this->CheckExitElementOfArray($arr_train_input,$this->input_train);
        if($flag === false)
        {
            array_push($arr_train_input,$this->input_train);
        }
        return $arr_train_input;
    }

}