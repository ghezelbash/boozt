<?php

namespace App\Services;


abstract class BaseService
{
    protected $app;

    public function __construct()
    {
        $this->app = new \Bootstrap();
    }
}