<?php

namespace App\Builder;

class JsonDirector
{
    private $json;

    public function addField($name, $value)
    {
        $this->json[$name] = $value;
    }
}
