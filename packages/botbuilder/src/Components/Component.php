<?php


namespace BotBuilder\Components;


abstract class Component
{
    /**
     * @param $source
     * @return mixed
     */
    protected function setProperty($source)
    {
        if (!is_array($source) || empty($source)) {
            return $this;
        }

        foreach ($source as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}