<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;

class ConMaintenance extends BaseController
{
    public function index()
    {
        // Simply return the maintenance view
        return view('User/PageMaintenance/index');
    }
}
