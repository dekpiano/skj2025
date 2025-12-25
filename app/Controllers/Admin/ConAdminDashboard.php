<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;

class ConAdminDashboard extends \App\Controllers\BaseController
{
    public function index()
    {        
        $data['title'] = "หน้าแรก";
        $data['description'] = "ภาพรวมของระบบ";
        
        return view('Admin/PageAdminDashboard', array_merge($this->data, $data));
    }
}
