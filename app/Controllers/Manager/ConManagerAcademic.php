<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;

class ConManagerAcademic extends BaseController
{
    public function index()
    {
        $db_academic = \Config\Database::connect('academic');
        
        // Get current schoolyear with all details
        $schoolyear = $db_academic->table('tb_schoolyear')->orderBy('schyear_id', 'DESC')->get()->getRowArray();
        $fullYear = $schoolyear['schyear_year'] ?? '2568';
        $currentYear = preg_replace('/[^0-9]/', '', substr($fullYear, -4));
        if (strlen($currentYear) < 4) $currentYear = date('Y') + 543;

        $student_stats = $db_academic->table('tb_students')
            ->select('COUNT(*) as total,
                     SUM(CASE WHEN StudentClass LIKE "ม.1%" OR StudentClass LIKE "ม.2%" OR StudentClass LIKE "ม.3%" THEN 1 ELSE 0 END) as junior,
                     SUM(CASE WHEN StudentClass LIKE "ม.4%" OR StudentClass LIKE "ม.5%" OR StudentClass LIKE "ม.6%" THEN 1 ELSE 0 END) as senior,
                     SUM(CASE WHEN StudentPrefix IN ("นาย", "เด็กชาย") THEN 1 ELSE 0 END) as male,
                     SUM(CASE WHEN StudentPrefix IN ("นางสาว", "เด็กหญิง") THEN 1 ELSE 0 END) as female')
            ->where('StudentStatus LIKE', '1/%')
            ->get()->getRowArray();

        foreach($student_stats as $key => $val) $student_stats[$key] = (int)$val;

        $grades = $db_academic->table('tb_register')
            ->select('Grade, COUNT(*) as count')
            ->like('RegisterYear', $currentYear, 'before')
            ->groupBy('Grade')
            ->get()->getResultArray();
        
        $grade_summary = ['good' => 0, 'pass' => 0, 'fail' => 0];
        foreach ($grades as $g) {
            $grade = $g['Grade'];
            if (in_array($grade, ['3.5', '4', '4.0'])) $grade_summary['good'] += $g['count'];
            elseif (in_array($grade, ['1', '1.5', '2', '2.5', '3'])) $grade_summary['pass'] += $g['count'];
            elseif (in_array($grade, ['0', 'ร', 'มส', 'มผ'])) $grade_summary['fail'] += $g['count'];
        }

        $students_raw = $db_academic->table('tb_students')
            ->select('StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentNumber, StudentStatus, StudentID')
            ->where('StudentStatus LIKE', '1/%')
            ->orderBy('StudentClass', 'ASC')
            ->orderBy('StudentNumber', 'ASC')
            ->get()->getResult();

        $grouped_students = [];
        foreach ($students_raw as $s) {
            $grouped_students[$s->StudentClass][] = $s;
        }

        $data = [
            'title' => 'ข้อมูลนักเรียน',
            'description' => 'ข้อมูลนักเรียนและผลสัมฤทธิ์ทางการเรียน',
            'current_year' => $currentYear,
            'schoolyear' => $schoolyear,
            'student_stats' => $student_stats,
            'grade_summary' => $grade_summary,
            'grouped_students' => $grouped_students
        ];

        return view('Manager/ManagerAcademicStudent/PageManagerAcademicStudent', array_merge($this->data, $data));
    }

    public function teacherIndex()
    {
        $db_academic = \Config\Database::connect('academic');
        $db_personnel = \Config\Database::connect('personnal');
        
        // Get schoolyear
        $schoolyear = $db_academic->table('tb_schoolyear')->orderBy('schyear_id', 'DESC')->get()->getRowArray();
        $currentYear = preg_replace('/[^0-9]/', '', substr($schoolyear['schyear_year'] ?? '2568', -4));
        if (strlen($currentYear) < 4) $currentYear = date('Y') + 543;

        // Fetch all teachers with teaching data
        $sql = "SELECT TeacherID, 
                COUNT(DISTINCT SubjectID) as subjects, 
                COUNT(DISTINCT RegisterClass) as classes,
                SUM(CASE WHEN Grade IN ('0', 'ร', 'มส', 'มผ') THEN 1 ELSE 0 END) as fail,
                SUM(CASE WHEN Grade NOT IN ('0', 'ร', 'มส', 'มผ', '') AND Grade IS NOT NULL THEN 1 ELSE 0 END) as pass,
                COUNT(*) as total
                FROM tb_register 
                WHERE RegisterYear LIKE '%{$currentYear}'
                GROUP BY TeacherID 
                ORDER BY subjects DESC";
        $teachers_raw = $db_academic->query($sql)->getResultArray();

        // Get teacher names from personnel DB
        $db_skj = \Config\Database::connect('default');
        $learning_groups = $db_skj->table('tb_learning')->orderBy('lear_id', 'ASC')->get()->getResultArray();
        
        $teacher_stats = [];
        $grouped_by_learning = [];
        $performance_stats = [];
        $total_fail = 0;
        $total_pass = 0;

        foreach ($teachers_raw as $t) {
            $person = $db_personnel->table('tb_personnel')
                ->select('pers_prefix, pers_firstname, pers_lastname, pers_learning')
                ->where('pers_id', $t['TeacherID'])
                ->get()->getRowArray();
            
            $name = $person ? $person['pers_prefix'] . $person['pers_firstname'] . ' ' . mb_substr($person['pers_lastname'], 0, 1) . '.' : $t['TeacherID'];
            $learning_id = $person['pers_learning'] ?? '0';
            
            // Find learning group name
            $learning_name = 'ไม่ระบุกลุ่มสาระ';
            foreach ($learning_groups as $lg) {
                if ($lg['lear_id'] == $learning_id) {
                    $learning_name = $lg['lear_namethai'];
                    break;
                }
            }
            
            $entry = [
                'id' => $t['TeacherID'],
                'name' => $name,
                'learning_id' => $learning_id,
                'learning_name' => $learning_name,
                'subjects' => (int)$t['subjects'],
                'classes' => (int)$t['classes'],
                'pass' => (int)$t['pass'],
                'fail' => (int)$t['fail'],
                'total' => (int)$t['total']
            ];
            
            $teacher_stats[] = $entry;
            $grouped_by_learning[$learning_name][] = $entry;
            $total_fail += (int)$t['fail'];
            $total_pass += (int)$t['pass'];
        }

        // Sort by fail rate for performance chart
        $performance_stats = $teacher_stats;
        usort($performance_stats, function($a, $b) {
            $rateA = $a['total'] > 0 ? ($a['fail'] / $a['total']) : 0;
            $rateB = $b['total'] > 0 ? ($b['fail'] / $b['total']) : 0;
            return $rateB <=> $rateA;
        });

        $data = [
            'title' => 'ข้อมูลครูผู้สอน',
            'description' => 'ภาระงานสอนและผลการสอน',
            'current_year' => $currentYear,
            'schoolyear' => $schoolyear,
            'teacher_stats' => $teacher_stats,
            'grouped_by_learning' => $grouped_by_learning,
            'learning_groups' => $learning_groups,
            'performance_stats' => $performance_stats,
            'total_teachers' => count($teacher_stats),
            'total_subjects' => $db_academic->table('tb_subjects')->countAllResults(),
            'total_classes' => $db_academic->query("SELECT COUNT(DISTINCT RegisterClass) as cnt FROM tb_register WHERE RegisterYear LIKE '%{$currentYear}'")->getRow()->cnt ?? 0,
            'total_fail' => $total_fail,
            'total_pass' => $total_pass
        ];

        return view('Manager/ManagerAcademicTeacher/PageManagerAcademicTeacher', array_merge($this->data, $data));
    }
    public function getAcademicAnalysis()
    {
        $db_academic = \Config\Database::connect('academic');
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        // 1. Grade Results Summary
        $grade_builder = $db_academic->table('tb_register')
            ->select('Grade, COUNT(*) as count')
            ->groupBy('Grade');
        
        if ($startDate && $endDate) {
            $grade_builder->where('Grade_UpdateTime >=', $startDate . ' 00:00:00')
                          ->where('Grade_UpdateTime <=', $endDate . ' 23:59:59');
        }
        $grades = $grade_builder->get()->getResultArray();
        
        $grade_summary = ['good' => 0, 'pass' => 0, 'fail' => 0];
        foreach ($grades as $g) {
            $grade = $g['Grade'];
            if (in_array($grade, ['3.5', '4', '4.0'])) $grade_summary['good'] += $g['count'];
            elseif (in_array($grade, ['1', '1.5', '2', '2.5', '3'])) $grade_summary['pass'] += $g['count'];
            elseif (in_array($grade, ['0', 'ร', 'มส', 'มผ'])) $grade_summary['fail'] += $g['count'];
        }

        // 2. Plan Submission Status by Learning Group
        $plan_builder = $db_academic->table('tb_send_plan')
            ->select('skjacth_skj.tb_learning.lear_namethai as status, COUNT(*) as count')
            ->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = tb_send_plan.seplan_learning', 'left')
            ->groupBy('seplan_learning');

        if ($startDate && $endDate) {
            $plan_builder->where('seplan_createdate >=', $startDate . ' 00:00:00')
                         ->where('seplan_createdate <=', $endDate . ' 23:59:59');
        }
        $plans = $plan_builder->get()->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'grade_summary' => $grade_summary,
            'plans' => $plans
        ]);
    }

    public function getStudentAnalysis()
    {
        $db_academic = \Config\Database::connect('academic');
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        // Grade Results Summary filtered by date range
        $grade_builder = $db_academic->table('tb_register')
            ->select('Grade, COUNT(*) as count')
            ->groupBy('Grade');
        
        if ($startDate && $endDate) {
            $grade_builder->where('Grade_UpdateTime >=', $startDate . ' 00:00:00')
                          ->where('Grade_UpdateTime <=', $endDate . ' 23:59:59');
        }
        $grades = $grade_builder->get()->getResultArray();
        
        $grade_summary = ['good' => 0, 'pass' => 0, 'fail' => 0];
        foreach ($grades as $g) {
            $grade = $g['Grade'];
            if (in_array($grade, ['3.5', '4', '4.0'])) $grade_summary['good'] += $g['count'];
            elseif (in_array($grade, ['1', '1.5', '2', '2.5', '3'])) $grade_summary['pass'] += $g['count'];
            elseif (in_array($grade, ['0', 'ร', 'มส', 'มผ'])) $grade_summary['fail'] += $g['count'];
        }

        return $this->response->setJSON([
            'status' => true,
            'grade_summary' => $grade_summary
        ]);
    }

    public function getTeacherAnalysis()
    {
        $db_academic = \Config\Database::connect('academic');
        $db_personnel = \Config\Database::connect('personnal');
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        // Build date filter for query
        $dateFilter = "";
        if ($startDate && $endDate) {
            $dateFilter = " AND Grade_UpdateTime >= '{$startDate} 00:00:00' AND Grade_UpdateTime <= '{$endDate} 23:59:59'";
        }

        // Fetch teacher stats with date filter
        $sql = "SELECT TeacherID, 
                COUNT(DISTINCT SubjectID) as subjects, 
                COUNT(DISTINCT RegisterClass) as classes,
                SUM(CASE WHEN Grade IN ('0', 'ร', 'มส', 'มผ') THEN 1 ELSE 0 END) as fail,
                SUM(CASE WHEN Grade NOT IN ('0', 'ร', 'มส', 'มผ', '') AND Grade IS NOT NULL THEN 1 ELSE 0 END) as pass,
                COUNT(*) as total
                FROM tb_register 
                WHERE 1=1 {$dateFilter}
                GROUP BY TeacherID 
                ORDER BY fail DESC LIMIT 10";
        $teachers_raw = $db_academic->query($sql)->getResultArray();

        $performance = [];
        $total_fail = 0;
        $total_pass = 0;

        foreach ($teachers_raw as $t) {
            $person = $db_personnel->table('tb_personnel')
                ->select('pers_prefix, pers_firstname, pers_lastname')
                ->where('pers_id', $t['TeacherID'])
                ->get()->getRowArray();
            
            $name = $person ? $person['pers_prefix'] . $person['pers_firstname'] . ' ' . mb_substr($person['pers_lastname'], 0, 1) . '.' : $t['TeacherID'];
            
            $performance[] = [
                'name' => $name,
                'fail' => (int)$t['fail'],
                'total' => (int)$t['total'],
                'rate' => $t['total'] > 0 ? round(($t['fail'] / $t['total']) * 100, 1) : 0
            ];
            
            $total_fail += (int)$t['fail'];
            $total_pass += (int)$t['pass'];
        }

        return $this->response->setJSON([
            'status' => true,
            'performance' => $performance,
            'total_fail' => $total_fail,
            'total_pass' => $total_pass
        ]);
    }
}
