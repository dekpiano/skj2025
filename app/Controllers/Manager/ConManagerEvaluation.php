<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use App\Models\EvaluationModel;
use App\Models\PersonnalModel;

class ConManagerEvaluation extends BaseController
{
    public function index()
    {
        $evaluationModel = new EvaluationModel();
        $db_skj = \Config\Database::connect('default');
        
        // Get fiscal year (default to current year + 543)
        $year = $this->request->getGet('year') ?: (date('Y') + 543);
        $round = $this->request->getGet('round') ?: 1;

        $evaluations = $evaluationModel->getEvaluationsWithPersonnel($year, $round);

        // Fetch all unique years for the dropdown
        $all_years = $evaluationModel->select('eva_year')->distinct()->orderBy('eva_year', 'DESC')->get()->getResultArray();
        if (empty($all_years)) $all_years = [['eva_year' => (date('Y') + 543)]];

        // Calculate Stats
        $db_personnel = \Config\Database::connect('personnal');
        $total_teachers = $db_personnel->table('tb_personnel')
            ->where('pers_status', 'กำลังใช้งาน')
            ->whereIn('pers_position', ['1', '2', '3', '4', '5', '6', '7', '8', '9']) // Assuming these are teaching positions
            ->countAllResults();
        
        if ($total_teachers == 0) $total_teachers = $db_personnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->countAllResults();

        $submitted_count = count($evaluations);
        $pending_count = max(0, $total_teachers - $submitted_count);

        $data = [
            'title' => 'ระบบการประเมินผลการปฏิบัติงาน',
            'description' => 'ติดตามผลการประเมินและไฟล์เอกสารของบุคลากร',
            'evaluations' => $evaluations,
            'year' => $year,
            'round' => $round,
            'all_years' => $all_years,
            'stats' => [
                'total' => $total_teachers,
                'submitted' => $submitted_count,
                'pending' => $pending_count,
                'percent' => $total_teachers > 0 ? round(($submitted_count / $total_teachers) * 100, 1) : 0
            ]
        ];

        return view('Manager/ManagerEvaluation/PageManagerEvaluation', array_merge($this->data, $data));
    }

    public function updateStatus()
    {
        $evaluationModel = new EvaluationModel();
        $id = $this->request->getPost('eva_id');
        $status = $this->request->getPost('eva_status');
        $comment = $this->request->getPost('eva_comment');

        if ($evaluationModel->update($id, [
            'eva_status' => $status,
            'eva_comment' => $comment
        ])) {
            return $this->response->setJSON(['status' => true, 'message' => 'อัปเดตสถานะสำเร็จ']);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'ไม่สามารถอัปเดตได้']);
    }
}
