<?php

namespace App\Controllers\Manager;

use App\Controllers\BaseController;
use App\Models\EvaluationModel;
use App\Models\PersonnalModel;
use App\Models\PositionModel;

class ConManagerEvaluation extends BaseController
{
    public function index()
    {
        $evaluationModel = new EvaluationModel();
        
        // Get fiscal year (default to current year + 543)
        $year = $this->request->getGet('year') ?: (date('Y') + 543);
        $round = $this->request->getGet('round') ?: 1;

        $evaluations = $evaluationModel->getEvaluationsWithPersonnel($year, $round);

        // Fetch all unique years for the dropdown
        $all_years = $evaluationModel->select('eva_year')->distinct()->orderBy('eva_year', 'DESC')->get()->getResultArray();
        if (empty($all_years)) $all_years = [['eva_year' => (date('Y') + 543)]];

        // Calculate Stats
        $db_personnel = \Config\Database::connect('personnal');
        
        // Including teachers (1-9) and deputy directors (posi_002)
        $targetPositions = ['1', '2', '3', '4', '5', '6', '7', '8', '9', 'posi_002', 'posi_003', 'posi_004', 'posi_005'];
        
        $total_personnel = $db_personnel->table('tb_personnel')
            ->where('pers_status', 'กำลังใช้งาน')
            ->whereIn('pers_position', $targetPositions)
            ->countAllResults();
        
        if ($total_personnel == 0) $total_personnel = $db_personnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->countAllResults();

        $submitted_count = count($evaluations);
        $pending_count = max(0, $total_personnel - $submitted_count);

        $data = [
            'title' => 'ระบบการประเมินผลการปฏิบัติงาน',
            'description' => 'ติดตามผลการประเมินและไฟล์เอกสารของบุคลากร (รวมทั้งครูและรองผู้อำนวยการ)',
            'evaluations' => $evaluations,
            'year' => $year,
            'round' => $round,
            'all_years' => $all_years,
            'stats' => [
                'total' => $total_personnel,
                'submitted' => $submitted_count,
                'pending' => $pending_count,
                'percent' => $total_personnel > 0 ? round(($submitted_count / $total_personnel) * 100, 1) : 0
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

    public function submitForm()
    {
        $pers_id = str_replace('P', '', session('AdminID')); // ถ้าเป็น P123 ให้เอาแค่ 123
        $evaluationModel = new EvaluationModel();
        
        $year = $this->request->getGet('year') ?: (date('Y') + 543);
        $round = $this->request->getGet('round') ?: 1;

        // ดึงข้อมูลการประเมินที่เคยส่งแล้ว (ถ้ามี)
        $evaluation = $evaluationModel->where('eva_teacher_id', $pers_id)
            ->where('eva_year', $year)
            ->where('eva_round', $round)
            ->first();

        // ดึงประวัติการส่งงานของตัวเองย้อนหลัง
        $history = $evaluationModel->where('eva_teacher_id', $pers_id)
            ->orderBy('eva_year', 'DESC')
            ->orderBy('eva_round', 'DESC')
            ->findAll();

        $data = [
            'title' => 'ส่งผลการปฏิบัติงาน',
            'description' => 'ส่งไฟล์เอกสารและลิงก์สรุปผลการปฏิบัติงาน',
            'evaluation' => $evaluation,
            'year' => $year,
            'round' => $round,
            'personnel' => session('personnel'),
            'history' => $history
        ];

        return view('Manager/ManagerEvaluation/PageEvaluationSubmit', array_merge($this->data, $data));
    }

    public function saveEvaluation()
    {
        $pers_id = str_replace('P', '', session('AdminID'));
        $evaluationModel = new EvaluationModel();
        
        $year = $this->request->getPost('eva_year');
        $round = $this->request->getPost('eva_round');
        $canva_link = $this->request->getPost('eva_canva_link');
        $fileName = $this->request->getPost('eva_file_name');

        // Check if already exists
        $existing = $evaluationModel->where('eva_teacher_id', $pers_id)
            ->where('eva_year', $year)
            ->where('eva_round', $round)
            ->first();

        $saveData = [
            'eva_teacher_id' => $pers_id,
            'eva_year' => $year,
            'eva_round' => $round,
            'eva_file' => $fileName,
            'eva_canva_link' => $canva_link,
            'eva_status' => 'ส่งแล้ว'
        ];

        if ($existing) {
            $status = $evaluationModel->update($existing['eva_id'], $saveData);
        } else {
            $status = $evaluationModel->insert($saveData);
        }

        if ($status) {
            return $this->response->setJSON(['status' => true, 'message' => 'บันทึกข้อมูลการส่งงานสำเร็จ']);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
    }

    public function uploadChunk()
    {

        $file = $this->request->getFile('file');
        $post = $this->request->getPost();
        
        $uploadUrl = trim(env('upload.server.url'), '" ');
        $client = \Config\Services::curlrequest();

        try {
            $postData = [
                'path'     => $post['path'],
                'filename' => $post['filename'],
                'chunk'    => $post['chunk'],
                'chunks'   => $post['chunks'],
                'file'     => new \CURLFile($file->getTempName(), $file->getMimeType(), $post['filename'])
            ];

            $response = $client->post($uploadUrl, [
                'multipart' => $postData,
                'http_errors' => false,
                'verify' => false
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                log_message('error', 'Upload Error (' . $statusCode . '): ' . $response->getBody());
            }

            return $this->response->setStatusCode($statusCode)->setBody($response->getBody());
        } catch (\Exception $e) {
            log_message('error', 'Upload Exception: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function deleteEvaluation($id)
    {
        $evaluationModel = new EvaluationModel();
        $evaluation = $evaluationModel->find($id);

        if (!$evaluation) {
            return $this->response->setJSON(['status' => false, 'message' => 'ไม่พบข้อมูลที่ต้องการลบ']);
        }

        // ลบไฟล์ในเซิร์ฟเวอร์ปลายทาง
        if ($evaluation['eva_file']) {
            $remotePath = 'evaluation/' . $evaluation['eva_year'] . '/' . $evaluation['eva_round'] . '/' . $evaluation['eva_file'];
            $this->_deleteFileFromServer($remotePath);
        }

        if ($evaluationModel->delete($id)) {
            return $this->response->setJSON(['status' => true, 'message' => 'ลบข้อมูลสำเร็จ']);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'ไม่สามารถลบข้อมูลได้']);
    }

    private function _deleteFileFromServer($remoteFilePath)
    {
        $deleteUrl = trim(env('upload.server.delete.url'), '" ');
        if (!$deleteUrl) return false;

        try {
            $client = \Config\Services::curlrequest();
            $path = dirname($remoteFilePath);
            $filename = basename($remoteFilePath);

            $jsonData = json_encode([
                'path' => $path,
                'files' => [$filename]
            ]);

            $response = $client->setBody($jsonData)->post($deleteUrl, [
                'headers' => ['Content-Type' => 'application/json'],
                'http_errors' => false,
                'verify' => false
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            log_message('error', 'CURL Delete Error: ' . $e->getMessage());
            return false;
        }
    }
}
