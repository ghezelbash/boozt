<?php

namespace App\Commands;


abstract class BaseCommand
{
    protected $app;

    public function __construct()
    {
        $this->app = new \Bootstrap();
    }

    public abstract function runner();
}