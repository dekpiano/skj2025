<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WebLogModel;

class AdminLogs extends BaseController
{
    public function index()
    {
        $logModel = new WebLogModel();
        
        // Paginate results
        $data = [
            'logs' => $logModel->orderBy('log_created_at', 'DESC')->paginate(50, 'logs'),
            'pager' => $logModel->pager,
            'title' => 'บันทึกการใช้งานระบบ (Website Logs)',
            'description' => 'รายการบันทึกการเข้าใช้งานและหัวข้อคำขอในระบบเว็บไซต์',
            'uri'   => $this->request->getUri()
        ];

        return view('Admin/PageAdminLogs/PageAdminLogsIndex', array_merge($this->data, $data));
    }

    public function deleteOldLogs()
    {
        // Delete logs older than 90 days (Compliance minimum 90 days)
        $logModel = new WebLogModel();
        $days = 90;
        $date = date('Y-m-d H:i:s', strtotime("-$days days"));
        
        $logModel->where('log_created_at <', $date)->delete();

        return redirect()->back()->with('success', "ลบข้อมูล Log ที่เก่ากว่า $days วัน เรียบร้อยแล้ว");
    }
}
