<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo\AIBot;


class BestMatch extends Basic
{
    protected $sefl;

    protected $input_statement;

    protected $arr_input_statement;

    protected $arr_check_poin_end;

    protected $rate;

    protected $word_pre;

    protected $word_next;

    public function __construct($sefl,$input_statement)
    {
        $this->input_statement = $input_statement;
        $this->CompareLenString($sefl,$input_statement);
    }
    protected function CompareLenString($sefl,$input_statement)
    {
        $input_statement_len = $this->countLen($input_statement);
        $sefl_len = $this->countLen($sefl);
        $this->arr_check_poin_end =  $this->splitInput($input_statement);
        if($input_statement_len > $sefl_len)
        {
            $this->sefl = $sefl . ' ';

            $this->arr_input_statement = $this->splitInput($input_statement);
        }
        else
        {
            $this->sefl = $input_statement . ' ';

            $this->arr_input_statement = $this->splitInput($sefl);
        }
    }
    protected function checkIsSefl()
    {

        if($this->sefl === $this->input_statement)
        {
            return true;
        }
        return false;
    }
    protected function maximum_similarity_threshold($input)
    {
        return $input <= 0.95 ? $input : 0.95;
    }
    public function canProcess()
    {

    }
    protected function CheckMatch($word)
    {
        $flag = strpos($this->sefl,$word);
        if($flag === false)
        {
            return false;
        }
        return true;
    }
    protected function ValidWord($input_a,$input_b)
    {
        $word = $input_a . ' ' . $input_b;
        $flag = $this->CheckMatch($word);
        return $flag;
    }
    public function joinWord($word,$value,$check_rate)
    {
        if(is_null($word)) {
            $result = $value;
            $this->word_pre = $value;
        }
        else {
            $this->word_pre = $value;
            $result = $word . ' ' . $value;
            $this->rate = 1/$check_rate;
        }
        return  $result;
    }
    public function Process()
    {
        $this->word_pre = null;
        if($this->checkIsSefl() == true)
            {
                $this->rate = 1;
                return 1;
            }
            else
            {
                $check_point = 0;
                $check_rate = 0;
                foreach ($this->arr_input_statement as $key=>$value)
                {
                    $this->word_next = $value;
                    $check_rate = $check_rate + 1;
                    $word= $this->joinWord($this->word_pre,$this->word_next,$check_rate);
                    $value = $value . ' ';
                    $flag = strpos($this->sefl,$value);
                    $isWord = strpos($this->sefl,$word);

                    if($flag === false)
                    {
                        $check_point = $check_point + 0;
                    }
                    else {
                        if($isWord !== false && $this->countLen($word) > $this->countLen($value))
                        {
                            $check_point = $check_point + $this->rate;
                        }
                        else
                        {
                            $check_point = $check_point + 1;
                        }
                    }
                }
                $count_of_arr = count($this->arr_check_poin_end);
                $check_point = $check_point/$count_of_arr;
                return $this->maximum_similarity_threshold($check_point);
            }
    }
}