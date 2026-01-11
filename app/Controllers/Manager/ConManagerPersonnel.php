<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use App\Models\PersonnalModel;

class ConManagerPersonnel extends BaseController
{
    public function index()
    {
        $db_skj = \Config\Database::connect('default');
        $db_personnel = \Config\Database::connect('personnal');

        // 1. Fetch Learning Groups
        $learning_groups = $db_skj->table('tb_learning')->orderBy('lear_id', 'ASC')->get()->getResultArray();

        // 2. Fetch All Active Personnel with Position Names
        $builder = $db_personnel->table('tb_personnel');
        $builder->select('
            skjacth_personnel.tb_personnel.*, 
            skjacth_skj.tb_position.posi_name,
            skjacth_skj.tb_learning.lear_namethai as learning_name
        ');
        $builder->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position', 'left');
        $builder->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = skjacth_personnel.tb_personnel.pers_learning', 'left');
        $builder->where('pers_status', 'กำลังใช้งาน');
        $builder->orderBy('pers_id', 'ASC');
        $all_personnel = $builder->get()->getResultArray();

        // Grouping logic
        $grouped_data = [];

        // 1. Group by Teacher Blocks (Learning Groups)
        foreach ($learning_groups as $group) {
            $members = array_filter($all_personnel, function($p) use ($group) {
                return $p['pers_learning'] == $group['lear_id'];
            });
            
            if (!empty($members)) {
                $grouped_data['learning'][] = [
                    'id'   => $group['lear_id'],
                    'name' => $group['lear_namethai'],
                    'icon' => 'bx-book-reader',
                    'members' => array_values($members)
                ];
            }
        }

        // 2. Group by Management (if any specific filter needed, but let's do support for now)
        // Group remaining as Support if they don't have a learning group
        $support_staff = array_filter($all_personnel, function($p) {
            return empty($p['pers_learning']) || $p['pers_learning'] == '-' || $p['pers_learning'] == '0';
        });

        if (!empty($support_staff)) {
            $grouped_data['support'][] = [
                'name' => 'บุคลากรสายสนับสนุน / ผู้บริหาร',
                'icon' => 'bx-support',
                'members' => array_values($support_staff)
            ];
        }

        // Summary Stats for Charts
        $stats = [
            'learning_labels' => [],
            'learning_counts' => [],
            'position_labels' => [],
            'position_counts' => []
        ];

        // 1. Learning Stats
        if (isset($grouped_data['learning'])) {
            foreach ($grouped_data['learning'] as $g) {
                $stats['learning_labels'][] = $g['name'];
                $stats['learning_counts'][] = count($g['members']);
            }
        }
        if (isset($grouped_data['support'])) {
            $stats['learning_labels'][] = 'สายสนับสนุน/บริหาร';
            $stats['learning_counts'][] = count($grouped_data['support'][0]['members']);
        }

        // 2. Position Stats
        $pos_counts = [];
        foreach ($all_personnel as $p) {
            $pos_name = $p['posi_name'] ?? 'ไม่ระบุ';
            $pos_counts[$pos_name] = ($pos_counts[$pos_name] ?? 0) + 1;
        }
        arsort($pos_counts);
        $top_pos = array_slice($pos_counts, 0, 5, true);
        $stats['position_labels'] = array_keys($top_pos);
        $stats['position_counts'] = array_values($top_pos);

        // 3. Real Attendance Summary for Today
        $today = date('Y-m-d');
        $attendance = $db_personnel->table('tb_personnel_attendance')
            ->where('att_date', $today)
            ->get()->getResultArray();
        
        $att_counts = [];
        foreach ($attendance as $row) {
            $status = $row['att_status'];
            $att_counts[$status] = ($att_counts[$status] ?? 0) + 1;
        }

        $total_active = count($all_personnel);
        $recorded_count = count($attendance);
        $no_record = max(0, $total_active - $recorded_count);

        $leaveStats = [
            'labels' => ['มาปกติ', 'สาย', 'ขาด', 'ลา', 'ไม่ลงเวลา'],
            'data' => [
                $att_counts['มา'] ?? 0,
                $att_counts['สาย'] ?? 0,
                $att_counts['ขาด'] ?? 0,
                ($att_counts['ลากิจ'] ?? 0) + ($att_counts['ลาป่วย'] ?? 0) + ($att_counts['ไปราชการ'] ?? 0) + ($att_counts['อื่นๆ'] ?? 0),
                $no_record
            ]
        ];

        $data = [
            'title' => 'ทำเนียบบุคลากร',
            'description' => 'รายชื่อและข้อมูลบุคลากรแบ่งตามกลุ่มสาระฯ',
            'grouped_data' => $grouped_data,
            'total_count' => $total_active,
            'stats' => $stats,
            'leaveStats' => $leaveStats
        ];

        return view('Manager/ManagerPersonnel/PageManagerPersonnel', array_merge($this->data, $data));
    }

    public function getPersonnelDetail($id)
    {
        $db_personnel = \Config\Database::connect('personnal');
        $db_skj = \Config\Database::connect('default');

        $person = $db_personnel->table('tb_personnel')
            ->select('skjacth_personnel.tb_personnel.*, skjacth_skj.tb_position.posi_name, skjacth_skj.tb_learning.lear_namethai as learning_name')
            ->join('skjacth_skj.tb_position', 'skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position', 'left')
            ->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = skjacth_personnel.tb_personnel.pers_learning', 'left')
            ->where('pers_id', $id)
            ->get()->getRowArray();

        if ($person) {
            $education = $db_personnel->table('tb_personnel_education')->where('pers_id', $id)->get()->getResultArray();
            $work_history = $db_personnel->table('tb_personnel_work_history')->where('pers_id', $id)->orderBy('work_date', 'DESC')->get()->getResultArray();
            $training = $db_personnel->table('tb_personnel_training')->where('pers_id', $id)->orderBy('train_start_date', 'DESC')->get()->getResultArray();

            return $this->response->setJSON([
                'status' => true,
                'data' => $person,
                'education' => $education,
                'work_history' => $work_history,
                'training' => $training
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'ไม่พบข้อมูลบุคลากร'
        ]);
    }

    public function getAttendanceAnalysis()
    {
        $db_personnel = \Config\Database::connect('personnal');
        $startDate = $this->request->getGet('startDate') ?: date('Y-m-d');
        $endDate = $this->request->getGet('endDate') ?: date('Y-m-d');
        
        // 1. Leave Stats (Real data from tb_leave_requests)
        $leave_builder = $db_personnel->table('tb_leave_requests lr')
            ->select('lt.leave_type_name as label, SUM(lr.leave_total_days) as value')
            ->join('tb_leave_types lt', 'lr.leave_type_id = lt.leave_type_id')
            ->where('lr.leave_status', 'approved')
            ->where('lr.leave_start_date >=', $startDate)
            ->where('lr.leave_end_date <=', $endDate)
            ->groupBy('lt.leave_type_name');
        
        $leave_data = $leave_builder->get()->getResultArray();

        $colors = ['danger', 'warning', 'info', 'primary', 'secondary', 'success'];
        $icons = ['bx-plus-medical', 'bx-briefcase', 'bx-graduation', 'bx-sun', 'bx-time', 'bx-check'];
        
        $leave_details = [];
        foreach ($leave_data as $i => $row) {
            $leave_details[] = [
                'label' => $row['label'],
                'value' => (float)$row['value'],
                'color' => $colors[$i % count($colors)],
                'icon' => $icons[$i % count($icons)]
            ];
        }

        // 2. Abnormal Frequency (Those with high leave counts)
        $ab_builder = $db_personnel->table('tb_leave_requests lr')
            ->select('p.pers_firstname, p.pers_lastname, 
                     SUM(CASE WHEN lt.leave_type_name LIKE "%ป่วย%" THEN lr.leave_total_days ELSE 0 END) as sick,
                     SUM(CASE WHEN lt.leave_type_name LIKE "%กิจ%" THEN lr.leave_total_days ELSE 0 END) as personal,
                     SUM(lr.leave_total_days) as total')
            ->join('tb_personnel p', 'lr.pers_id = p.pers_id')
            ->join('tb_leave_types lt', 'lr.leave_type_id = lt.leave_type_id')
            ->where('lr.leave_status', 'approved')
            ->where('lr.leave_start_date >=', $startDate)
            ->where('lr.leave_end_date <=', $endDate)
            ->groupBy('lr.pers_id')
            ->orderBy('total', 'DESC')
            ->limit(10);
        
        $abnormal = $ab_builder->get()->getResultArray();
        
        $abnormal_formatted = array_map(function($row) {
            return [
                'name' => $row['pers_firstname'] . ' ' . mb_substr($row['pers_lastname'], 0, 1) . '.',
                'sick' => (float)$row['sick'],
                'personal' => (float)$row['personal'],
                'total' => (float)$row['total']
            ];
        }, $abnormal);

        // 3. Late / Absent / No clock-in (Today)
        $all_active = $db_personnel->table('tb_personnel')
            ->select('pers_id, pers_firstname, pers_lastname')
            ->where('pers_status', 'กำลังใช้งาน')
            ->get()->getResultArray();
        
        $attendance_range = $db_personnel->table('tb_personnel_attendance')
            ->where('att_date >=', $startDate)
            ->where('att_date <=', $endDate)
            ->get()->getResultArray();
        
        $att_map = [];
        $att_counts = [];
        foreach ($attendance_range as $att) {
            $att_map[$att['att_person_id']] = $att;
            $status = $att['att_status'];
            $att_counts[$status] = ($att_counts[$status] ?? 0) + 1;
        }

        $total_active = $db_personnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->countAllResults();
        
        // Calculate no-record (tricky for range, usually we look at average or today if range is 1 day)
        // For simplicity: if 1 day, use total - recorded. If range, just show 0 or don't show.
        $no_record = ($startDate === $endDate) ? max(0, $total_active - count($attendance_range)) : 0;

        $summary_data = [
            $att_counts['มา'] ?? 0,
            $att_counts['สาย'] ?? 0,
            $att_counts['ขาด'] ?? 0,
            ($att_counts['ลากิจ'] ?? 0) + ($att_counts['ลาป่วย'] ?? 0) + ($att_counts['ไปราชการ'] ?? 0) + ($att_counts['อื่นๆ'] ?? 0),
            $no_record
        ];

        // Prepare late report details
        $late_report = ['late' => [], 'absent' => [], 'no_clock_in' => []];
        foreach ($all_active as $p) {
            if (!isset($att_map[$p['pers_id']])) {
                if ($startDate === $endDate) { // Only show No Record if it's a single day
                    $late_report['no_clock_in'][] = [
                        'name' => $p['pers_firstname'] . ' ' . $p['pers_lastname'],
                        'status' => 'ไม่ลงเวลา'
                    ];
                }
            } else {
                $status = $att_map[$p['pers_id']]['att_status'];
                if ($status == 'สาย') {
                    $late_report['late'][] = [
                        'name' => $p['pers_firstname'] . ' ' . $p['pers_lastname'],
                        'status' => 'สาย'
                    ];
                } elseif ($status == 'ขาด') {
                    $late_report['absent'][] = [
                        'name' => $p['pers_firstname'] . ' ' . $p['pers_lastname'],
                        'status' => 'ขาด'
                    ];
                }
            }
        }

        return $this->response->setJSON([
            'status' => true,
            'leave_details' => $leave_details,
            'abnormal' => $abnormal_formatted,
            'late_report' => $late_report,
            'summary_data' => $summary_data
        ]);
    }
}
