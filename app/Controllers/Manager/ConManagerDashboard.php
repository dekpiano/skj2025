<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use App\Models\PersonnalModel;
use App\Models\StudentModels;

class ConManagerDashboard extends BaseController
{
    public function index()
    {
        $db_skj = \Config\Database::connect('default');
        $db_personnel = \Config\Database::connect('personnal');
        $db_academic = \Config\Database::connect('academic');
        $db_general = \Config\Database::connect('general');

        // 1. Personnel Overview
        $countPersonnel = $db_personnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->countAllResults();
        
        // Personnel by Learning Group
        $learningGroups = $db_skj->table('tb_learning')->orderBy('lear_id', 'ASC')->get()->getResultArray();
        $personnel_learning = $db_personnel->table('tb_personnel')
            ->select('pers_learning, COUNT(*) as count')
            ->where('pers_status', 'กำลังใช้งาน')
            ->groupBy('pers_learning')
            ->get()->getResultArray();
            
        $chart_learning = ['labels' => [], 'data' => []];
        $learning_map = array_column($personnel_learning, 'count', 'pers_learning');
        foreach ($learningGroups as $group) {
            $count = $learning_map[$group['lear_id']] ?? 0;
            if ($count > 0) {
                $chart_learning['labels'][] = $group['lear_namethai'];
                $chart_learning['data'][] = (int)$count;
            }
        }

        // 2. Academic Student Overview
        $currentYear = $db_academic->table('tb_schoolyear')->orderBy('schyear_id', 'DESC')->get()->getRowArray();
        $yearStr = $currentYear['schyear_year'] ?? date('Y') + 543;

        $student_stats = [
            'total' => $db_academic->table('tb_students')->where('StudentBehavior', 'ปกติ')->countAllResults(),
            'junior' => $db_academic->table('tb_students')->where('StudentBehavior', 'ปกติ')->like('StudentClass', 'ม.1')->orLike('StudentClass', 'ม.2')->orLike('StudentClass', 'ม.3')->countAllResults(),
            'senior' => $db_academic->table('tb_students')->where('StudentBehavior', 'ปกติ')->like('StudentClass', 'ม.4')->orLike('StudentClass', 'ม.5')->orLike('StudentClass', 'ม.6')->countAllResults()
        ];

        // Grade Summary (Approximate from tb_register)
        $grades = $db_academic->table('tb_register')
            ->select('Grade, COUNT(*) as count')
            ->where('RegisterYear', $yearStr)
            ->groupBy('Grade')
            ->get()->getResultArray();
        
        $grade_summary = ['pass' => 0, 'fail' => 0];
        foreach ($grades as $g) {
            if (in_array($g['Grade'], ['0', 'ร', 'มส', 'มผ'])) $grade_summary['fail'] += $g['count'];
            else $grade_summary['pass'] += $g['count'];
        }

        // 3. Academic Teacher Overview
        $teacher_count = $db_academic->table('tb_register')
            ->select('COUNT(DISTINCT TeacherID) as count')
            ->where('RegisterYear', $yearStr)
            ->get()->getRow()->count ?? 0;

        // 4. General Admin Overview
        $general_stats = [
            'booking_pending' => $db_general->table('tb_booking')->where('booking_admin_approve', 'รอตรวจสอบ')->countAllResults(),
            'car_pending' => $db_general->table('tb_car_reservation')->where('car_reserv_status', 'รอตรวจสอบ')->countAllResults(),
            'repair_pending' => $db_general->table('tb_repair')->whereNotIn('repair_status', ['เสร็จสิ้น', 'ยกเลิก'])->countAllResults(),
            'food_report' => $db_general->table('tb_food_reports')->like('food_date', date('Y-m'))->countAllResults()
        ];

        $data = [
            'title' => 'ภาพรวมบริหารจัดการ',
            'description' => 'ข้อมูลสรุปสำหรับผู้บริหาร',
            'schoolyear' => $currentYear,
            'countPersonnel' => $countPersonnel,
            'student_stats' => $student_stats,
            'grade_summary' => $grade_summary,
            'teacher_count' => $teacher_count,
            'general_stats' => $general_stats,
            'chart_learning' => $chart_learning,
            'visitStats' => (new \App\Models\VisitorModel())->getStats(),
            'countNews' => (new \App\Models\NewsModel())->countAllResults()
        ];

        return view('Manager/ManagerDashboard/PageManagerDashboard', array_merge($this->data, $data));
    }
}
