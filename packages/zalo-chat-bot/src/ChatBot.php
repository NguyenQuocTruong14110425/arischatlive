<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo;
use foo\bar;
use Zalo\AIBot\Basic;
use Zalo\AIBot\Learning;
use Zalo\AIBot\LogicAdapter;

class ChatBot extends Basic
{
    protected  $path_data;

    protected  $path_data_train;

    protected  $path_log;

    protected  $data_traing;

    public function __construct()
    {
        $this->path_data = storage_path('bot/training.json');

        $this->path_log = storage_path('bot/log.json');

        $this->path_data_train = storage_path('bot/training.json');
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
    public function GetMatchWord($input)
    {
        $data_traing = $this->getDataTraining();
        $LogicAdapter = new LogicAdapter($data_traing, $input);
        $match_word = $LogicAdapter->GetMatch();
        return $match_word;
    }
    public function getMessage($input)
    {
        $flag = strpos($input,"mấy giờ");
        if($flag !== false)
        {
            return now();
        }
        else {
            $match_word = $this->GetMatchWord($input);
            if(isset($match_word))
            {
                $data = $this->data_traing[$match_word];
                $randomKey = rand(0,count($data) - 1);
                return $data[$randomKey];
            }
            return false;
        }
    }

    public function traingBot($input_bot,$input_user,$user_id)
    {
        try
        {
            //read file
            $read_log = file_get_contents($this->path_log);
            $read_traing = file_get_contents($this->path_data_train);

            //decode file json
            $arr_log = \GuzzleHttp\json_decode($read_log, true);
            $arr_training = \GuzzleHttp\json_decode($read_traing, true);
            $Model_traing = new Learning($arr_log,$arr_training,$input_bot,$input_user,$user_id);
            $path = storage_path('bot/.bot');

            if($Model_traing->findRowUser() !== false)
            {
                $key_log_traing = $Model_traing->findRowUser();

                $arr_train_input = $Model_traing->findRowTraingByUser($key_log_traing);
                if($arr_train_input !== false)
                {
                    $arr_train_result = $Model_traing->getDataLogTraing($arr_train_input);
                    file_put_contents($path, $arr_train_result);
                    $arr_training[$key_log_traing] = $arr_train_result;
                    file_put_contents($path, $key_log_traing,FILE_APPEND);
                    file_put_contents($path, $arr_train_result,FILE_APPEND);
                }
                else
                {
                    $match_word = $this->GetMatchWord($input_user);
                    $arr_train_input_match = $Model_traing->findRowTraingByUser($match_word);
                    if($arr_train_input_match !== false)
                    {
                        $arr_train_result = $Model_traing->getDataLogTraing($arr_train_input_match);
                        $arr_training[$match_word] = $arr_train_result;
                        $arr_training[$key_log_traing] = [$input_user];
                    }
                }
                $this->saveAnswer($arr_training);
            }
                $arr_log =   $Model_traing->getDataLogSave();
                $this->saveQuestionLog($arr_log);
            return $Model_traing;
        }
        catch (\Exception $e)
        {
            $path = storage_path('bot/.bot');
            $error =  '#' . now()->getTimestamp() . ':' . $e->getMessage();
            file_put_contents($path, $error,FILE_APPEND);
        }
    }
}