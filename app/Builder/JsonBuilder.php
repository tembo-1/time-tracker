<?php

namespace App\Builder;

class JsonBuilder
{
    protected $json = [];

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function text($key, $value)
    {
        $this->json[$key] = $value;

        return $this;
    }

    public function array($key, $array)
    {
        $this->json[$key] = $array;

        return $this;
    }

    /**
     * @return false|string
     */
    public function build()
    {
        return json_encode($this->json);
    }
}
