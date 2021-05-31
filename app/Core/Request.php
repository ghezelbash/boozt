<?php

namespace App\Core;

class Request
{
    public function __construct()
    {
        foreach ($_SERVER as $serverParameter => $value){
            $this->__set(strtolower($serverParameter), $value);
        }
        foreach ($_GET as $queryParameter => $value){
            $this->__set($queryParameter, $value);
        }
        foreach ($_POST as $postParameter => $value){
            $this->__set($postParameter, $value);
        }
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        if (isset($this->{$name})){
            return $this->{$name};
        }
        return null;
    }
}