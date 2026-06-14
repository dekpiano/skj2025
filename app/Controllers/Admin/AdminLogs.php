<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WebLogModel;

class AdminLogs extends BaseController
{
    public function index()
    {
        $logModel = new WebLogModel();
        
        $search = $this->request->getGet('search');
        $method = $this->request->getGet('method');
        $userType = $this->request->getGet('user_type');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Apply filters
        $query = $logModel->orderBy('log_created_at', 'DESC');

        if (!empty($search)) {
            $query->groupStart()
                  ->like('log_user_name', $search)
                  ->orLike('log_ip_address', $search)
                  ->orLike('log_url', $search)
                  ->orLike('log_agent', $search)
                  ->groupEnd();
        }
        if (!empty($method)) {
            $query->where('log_method', $method);
        }
        if ($userType === 'member') {
            $query->where('log_user_id IS NOT NULL');
        } elseif ($userType === 'guest') {
            $query->where('log_user_id IS NULL');
        }
        if (!empty($startDate)) {
            $query->where('log_created_at >=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $query->where('log_created_at <=', $endDate . ' 23:59:59');
        }

        // Stats calculations
        $stats = [
            'total' => (new WebLogModel())->countAllResults(),
            'unique_ips' => (new WebLogModel())->select('COUNT(DISTINCT log_ip_address) as total_ips')->first()['total_ips'] ?? 0,
            'top_ip' => (new WebLogModel())->select('log_ip_address, COUNT(log_ip_address) as count')
                ->groupBy('log_ip_address')
                ->orderBy('count', 'DESC')
                ->first(),
            'top_user' => (new WebLogModel())->select('log_user_name, COUNT(log_user_name) as count')
                ->where('log_user_id IS NOT NULL')
                ->groupBy('log_user_name')
                ->orderBy('count', 'DESC')
                ->first()
        ];

        $data = [
            'logs' => $query->paginate(50, 'logs'),
            'pager' => $logModel->pager,
            'title' => 'บันทึกการใช้งานระบบ (Website Logs)',
            'description' => 'รายการบันทึกการเข้าใช้งานและหัวข้อคำขอในระบบเว็บไซต์',
            'uri'   => $this->request->getUri(),
            'filters' => [
                'search' => $search,
                'method' => $method,
                'user_type' => $userType,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
            'stats' => $stats
        ];

        return view('Admin/PageAdminLogs/PageAdminLogsIndex', array_merge($this->data, $data));
    }

    public function export()
    {
        $logModel = new WebLogModel();
        
        $search = $this->request->getGet('search');
        $method = $this->request->getGet('method');
        $userType = $this->request->getGet('user_type');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Apply same filters for export
        $query = $logModel->orderBy('log_created_at', 'DESC');

        if (!empty($search)) {
            $query->groupStart()
                  ->like('log_user_name', $search)
                  ->orLike('log_ip_address', $search)
                  ->orLike('log_url', $search)
                  ->orLike('log_agent', $search)
                  ->groupEnd();
        }
        if (!empty($method)) {
            $query->where('log_method', $method);
        }
        if ($userType === 'member') {
            $query->where('log_user_id IS NOT NULL');
        } elseif ($userType === 'guest') {
            $query->where('log_user_id IS NULL');
        }
        if (!empty($startDate)) {
            $query->where('log_created_at >=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $query->where('log_created_at <=', $endDate . ' 23:59:59');
        }

        $logs = $query->findAll();

        $filename = 'website_logs_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add UTF-8 BOM for Excel Thai display
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Header
        fputcsv($output, ['วัน-เวลา', 'ชื่อผู้ใช้งาน (ID)', 'IP Address', 'Method', 'URL', 'Browser/Agent']);
        
        foreach ($logs as $log) {
            $user = $log['log_user_id'] ? $log['log_user_name'] . ' (ID: ' . $log['log_user_id'] . ')' : 'Guest';
            fputcsv($output, [
                $log['log_created_at'],
                $user,
                $log['log_ip_address'],
                $log['log_method'],
                $log['log_url'],
                $log['log_agent']
            ]);
        }
        
        fclose($output);
        exit;
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
