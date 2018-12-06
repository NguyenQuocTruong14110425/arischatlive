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
}