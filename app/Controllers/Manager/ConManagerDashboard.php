<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use App\Models\PersonnalModel;
use App\Models\StudentModels;

class ConManagerDashboard extends BaseController
{
    public function index()
    {
        $personnalModel = new PersonnalModel();
        $studentModel = new StudentModels();
        $visitorModel = new \App\Models\VisitorModel();
        $newsModel = new \App\Models\NewsModel();

        // Count Active Personnel
        $countPersonnel = $personnalModel->where('pers_status', 'กำลังใช้งาน')->countAllResults();

        // Count Active Students
        $studentStats = $studentModel->CountStudentAll();
        $countStudents = 0;
        if (!empty($studentStats) && isset($studentStats[0]->C_ALL_Stu)) {
            $countStudents = $studentStats[0]->C_ALL_Stu;
        }

        // Visitor Stats
        $visitStats = $visitorModel->getStats();

        // News Count
        $countNews = $newsModel->countAllResults();

        // Personnel Stats for Comparison Chart
        $db_skj = \Config\Database::connect('default');
        $db_personnel = \Config\Database::connect('personnal');

        // Distribution by Learning Group
        $learningGroups = $db_skj->table('tb_learning')->orderBy('lear_id', 'ASC')->get()->getResultArray();
        $personnel = $db_personnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->get()->getResultArray();

        $chart_learning = [
            'labels' => [],
            'data' => []
        ];

        foreach ($learningGroups as $group) {
            $count = array_reduce($personnel, function($carry, $item) use ($group) {
                return $carry + ($item['pers_learning'] == $group['lear_id'] ? 1 : 0);
            }, 0);
            
            if ($count > 0) {
                $chart_learning['labels'][] = $group['lear_namethai'];
                $chart_learning['data'][] = $count;
            }
        }

        // Add Support/Admin category if there are people not in any learning group
        $supportCount = array_reduce($personnel, function($carry, $item) {
            return $carry + (empty($item['pers_learning']) || $item['pers_learning'] == '0' ? 1 : 0);
        }, 0);
        if ($supportCount > 0) {
            $chart_learning['labels'][] = 'สายสนับสนุน/บริหาร';
            $chart_learning['data'][] = $supportCount;
        }

        // Leave Summary (Mock Data - Connect to real attendance table later)
        $leaveStats = [
            'labels' => ['มาปฏิบัติราชการ', 'ลากิจ', 'ลาป่วย', 'ลาผักผ่อน', 'ไปราชการ'],
            'data' => [
                $countPersonnel - 5, // มาปกติ
                2, // ลากิจ
                1, // ลาป่วย
                1, // ลาพักผ่อน
                1  // ไปราชการ
            ]
        ];

        $data = [
            'title' => 'Executive Dashboard',
            'description' => 'ภาพรวมสำหรับผู้บริหาร',
            'countPersonnel' => $countPersonnel,
            'countStudents' => $countStudents,
            'visitStats' => $visitStats,
            'countNews' => $countNews,
            'chart_learning' => $chart_learning,
            'leaveStats' => $leaveStats
        ];

        return view('Manager/ManagerDashboard/PageManagerDashboard', array_merge($this->data, $data));
    }
}
