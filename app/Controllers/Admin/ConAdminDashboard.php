<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;

class ConAdminDashboard extends \App\Controllers\BaseController
{
    public function index()
    {        
        $newsModel = new \App\Models\NewsModel();
        $bannerModel = new \App\Models\BannerModel();
        $logModel = new \App\Models\WebLogModel();
        $visitorModel = new \App\Models\VisitorModel();

        $data = [
            'title' => "แดชบอร์ด",
            'description' => "ภาพรวมของระบบและสถิติการใช้งาน",
            'countNews' => $newsModel->countAllResults(),
            'countBanner' => $bannerModel->countAllResults(),
            'countLogs' => $logModel->countAllResults(),
            'todayLogs' => $logModel->where('DATE(log_created_at)', date('Y-m-d'))->countAllResults(),
            'visitorStats' => $visitorModel->getStats(),
            'recentLogs' => $logModel->orderBy('log_created_at', 'DESC')->limit(5)->get()->getResultArray()
        ];
        
        return view('Admin/PageAdminDashboard', array_merge($this->data, $data));
    }
}
