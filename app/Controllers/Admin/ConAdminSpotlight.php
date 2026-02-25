<?php
namespace App\Controllers\Admin;
use App\Models\SpotlightModel;

class ConAdminSpotlight extends \App\Controllers\BaseController
{
    protected $spotlightModel;

    public function __construct(){
        $this->spotlightModel = new SpotlightModel();
    }

    private function downloadFacebookImage($imageUrl, $savePath) {
        $ch = curl_init($imageUrl);
        $fp = fopen($savePath, 'wb');
        
        if ($fp === false) return false;

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);

        return ($statusCode == 200);
    }

    public function index()
    {        
        $data['title'] = "Spotlight ประชาสัมพันธ์พิเศษ";
        $data['description'] = "จัดการพื้นที่ผลงานเด่น ข่าวพิเศษ หน้าแรกเว็บไซต์";
        $data['spotlights'] = $this->spotlightModel->orderBy('spotlight_date','DESC')->findAll();
        
        return view('Admin/PageAdminSpotlight/PageAdminSpotlightMain', array_merge($this->data, $data));
    }

    public function SpotlightOnoff(){
        $status = $this->request->getPost('Onoffstatus');
        $id = $this->request->getPost('Keystatus');
        
        if($this->spotlightModel->update($id, ['spotlight_status' => $status])){
            echo $id;
        }else{
            echo "error";
        }
    }

    public function AddSpotlight()
    {
        $imageFile = $this->request->getFile('spotlight_img');
        
        $dataSave = [
            'spotlight_badge' => $this->request->getPost('spotlight_badge'),
            'spotlight_badge_color' => $this->request->getPost('spotlight_badge_color'),
            'spotlight_topic' => $this->request->getPost('spotlight_topic'),
            'spotlight_topic_highlight' => $this->request->getPost('spotlight_topic_highlight'),
            'spotlight_content' => $this->request->getPost('spotlight_content'),
            'spotlight_btn_text' => $this->request->getPost('spotlight_btn_text'),
            'spotlight_btn_link' => $this->request->getPost('spotlight_btn_link'),
            'spotlight_btn_color' => $this->request->getPost('spotlight_btn_color'),
            'spotlight_facebook_embed' => $this->request->getPost('spotlight_facebook_embed'),
            'spotlight_layout' => $this->request->getPost('spotlight_layout'),
            'spotlight_theme' => $this->request->getPost('spotlight_theme'),
            'spotlight_date' => $this->request->getPost('spotlight_date'),
            'spotlight_status' => 'on',
            'spotlight_personnel_id' => session('AdminID')
        ];

        // Ensure upload directory exists
        $uploadPath = FCPATH . 'uploads/spotlight/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $fbImgUrl = $this->request->getPost('spotlight_facebook_img_url');

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $RandomName = $imageFile->getRandomName();
            try {
                \Config\Services::image()
                    ->withFile($imageFile)
                    ->resize(1200, 1200, true, 'auto') // Fit image
                    ->save($uploadPath . $RandomName);
                $dataSave['spotlight_img'] = $RandomName;
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'เกิดข้อผิดพลาดในการบันทึกภาพ: ' . $e->getMessage()
                ]);
            }
        } else if (!empty($fbImgUrl)) {
            $RandomName = time() . '_fb.jpg';
            if ($this->downloadFacebookImage($fbImgUrl, $uploadPath . $RandomName)) {
                $dataSave['spotlight_img'] = $RandomName;
            }
        }

        $insertID = $this->spotlightModel->insert($dataSave);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'บันทึก Spotlight สำเร็จ!',
            'data' => array_merge(['spotlight_id' => $insertID], $dataSave)
        ]);
    }

    public function EditSpotlight()
    {
        $id = $this->request->getVar('KeySpotlightid');
        $data = $this->spotlightModel->find($id);

        if ($data) {
            $imagePath = FCPATH . 'uploads/spotlight/' . $data['spotlight_img'];
            if (empty($data['spotlight_img']) || !file_exists($imagePath)) {
                $data['spotlight_img'] = ''; 
            }
        }

        return $this->response->setJSON($data);
    }

    public function UpdateSpotlight()
    {
        $id = $this->request->getPost('spotlight_id');
        $originalImg = $this->request->getPost('original_spotlight_img');
        $imageFile = $this->request->getFile('spotlight_img');

        $dataUpdate = [
            'spotlight_badge' => $this->request->getPost('spotlight_badge'),
            'spotlight_badge_color' => $this->request->getPost('spotlight_badge_color'),
            'spotlight_topic' => $this->request->getPost('spotlight_topic'),
            'spotlight_topic_highlight' => $this->request->getPost('spotlight_topic_highlight'),
            'spotlight_content' => $this->request->getPost('spotlight_content'),
            'spotlight_btn_text' => $this->request->getPost('spotlight_btn_text'),
            'spotlight_btn_link' => $this->request->getPost('spotlight_btn_link'),
            'spotlight_btn_color' => $this->request->getPost('spotlight_btn_color'),
            'spotlight_facebook_embed' => $this->request->getPost('spotlight_facebook_embed'),
            'spotlight_layout' => $this->request->getPost('spotlight_layout'),
            'spotlight_theme' => $this->request->getPost('spotlight_theme'),
            'spotlight_date' => $this->request->getPost('spotlight_date'),
            'spotlight_personnel_id' => session('AdminID')
        ];

        $uploadPath = FCPATH . 'uploads/spotlight/';

        $fbImgUrl = $this->request->getPost('spotlight_facebook_img_url');

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            if ($originalImg && file_exists($uploadPath . $originalImg)) {
                @unlink($uploadPath . $originalImg);
            }

            $RandomName = $imageFile->getRandomName();
            try {
                \Config\Services::image()
                    ->withFile($imageFile)
                    ->resize(1200, 1200, true, 'auto')
                    ->save($uploadPath . $RandomName);
                
                $dataUpdate['spotlight_img'] = $RandomName;
            } catch (\Exception $e) {
                log_message('error', 'Update Spotlight Image Error: ' . $e->getMessage());
            }
        } else if (!empty($fbImgUrl) && empty($originalImg)) {
            $RandomName = time() . '_fb.jpg';
            if ($this->downloadFacebookImage($fbImgUrl, $uploadPath . $RandomName)) {
                $dataUpdate['spotlight_img'] = $RandomName;
            }
        }

        $update = $this->spotlightModel->update($id, $dataUpdate);
        $updatedData = $this->spotlightModel->find($id);

        return $this->response->setJSON([
            'status' => $update ? true : false,
            'message' => $update ? 'อัปเดต Spotlight สำเร็จ!' : 'อัปเดต Spotlight ไม่สำเร็จ!',
            'data' => $updatedData
        ]);
    }

    public function DeleteSpotlight(){
        $id = $this->request->getPost('KeySpotlightid');
        $data = $this->spotlightModel->find($id);
        if($data && $data['spotlight_img'] != ''){
            @unlink(FCPATH . "uploads/spotlight/" . $data['spotlight_img']);
        }        
        $result = $this->spotlightModel->delete($id);        
        echo $result ? 1 : 0;
    }
}
