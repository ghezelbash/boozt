<?php

namespace App\Controllers;

use App\Core\Request;
use App\Services\CustomerService;
use App\Services\OrderService;

class DashboardControllers
{
    protected $customerService;
    protected $orderService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
        $this->orderService = new OrderService();
    }

    public function index(Request $request)
    {
        return '<h1 style="text-align: center;padding: 20% 0">You are here: ' . $request->request_uri . '</h1>';
    }
}