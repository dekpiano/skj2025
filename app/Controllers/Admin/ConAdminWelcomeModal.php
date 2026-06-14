<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WebSettingsModel;

class ConAdminWelcomeModal extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        try {
            $db->query("ALTER TABLE tb_web_settings MODIFY COLUMN setting_value TEXT NULL");
        } catch (\Exception $e) {
            // Ignore if already changed or no permission
        }

        $settingsModel = new WebSettingsModel();
        
        $rawImages = $settingsModel->getStatus('welcome_modal_images');
        $images = json_decode($rawImages ?: '[]', true);
        
        // If JSON decode failed due to prior truncation, try to recover or fallback
        if ($rawImages && $images === null) {
            log_message('warning', 'WelcomeModal JSON decode failed: ' . $rawImages);
            // Fallback: search for filenames inside the broken string using regex
            preg_match_all('/"([^"]+\.(?:png|jpg|jpeg|webp))"/i', $rawImages, $matches);
            if (!empty($matches[1])) {
                $images = $matches[1];
                // Save the recovered array back to db
                $settingsModel->updateStatus('welcome_modal_images', json_encode($images));
            } else {
                $images = [];
            }
        }

        $data = [
            'title' => "จัดการป๊อปอัปแจ้งเตือน",
            'description' => "จัดการรูปภาพแบบหลายรูป เรียงลำดับ และเปิด-ปิดสถานะของป๊อปอัปแจ้งเตือนหน้าแรกของเว็บไซต์",
            'status' => $settingsModel->getStatus('welcome_modal_status'),
            'images' => $images
        ];

        return view('Admin/PageAdminWelcomeModal/WelcomeModalMain', array_merge($this->data, $data));
    }

    public function updateSetting()
    {
        if (strtolower($this->request->getMethod()) === 'get') {
            return redirect()->to('/Admin/WelcomeModal');
        }

        try {
            $settingsModel = new WebSettingsModel();
            
            $status = $this->request->getPost('status') ?: 'off';
            
            // 1. Update status
            $settingsModel->updateStatus('welcome_modal_status', $status);
            
            // 2. Load previous files from DB
            $dbImages = json_decode($settingsModel->getStatus('welcome_modal_images') ?: '[]', true);
            if (!is_array($dbImages)) {
                $dbImages = [];
            }
            
            // 3. Get existing images that are kept/reordered from the client
            $existingImages = $this->request->getPost('existing_images') ?: [];
            if (!is_array($existingImages)) {
                $existingImages = [];
            }
            
            // Ensure uploads/welcome/ folder exists
            $uploadPath = FCPATH . 'uploads/welcome/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete images that were removed by the user
            $removedImages = array_diff($dbImages, $existingImages);
            foreach ($removedImages as $removedImg) {
                if ($removedImg) {
                    $filePath = $uploadPath . $removedImg;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }
            
            // Start building final array
            $finalImages = $existingImages;
            
            // 4. Handle multiple new uploads
            $files = $this->request->getFiles();
            if (isset($files['welcome_modal_imgs'])) {
                foreach ($files['welcome_modal_imgs'] as $file) {
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $jpgName = pathinfo($newName, PATHINFO_FILENAME) . '.jpg';
                        
                        \Config\Services::image()
                            ->withFile($file)
                            ->save($uploadPath . $jpgName, 90);
                            
                        $finalImages[] = $jpgName;
                    }
                }
            }
            
            // 5. Clean and update settings in DB
            $finalImages = array_values(array_filter($finalImages));
            $settingsModel->updateStatus('welcome_modal_images', json_encode($finalImages));
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'บันทึกการตั้งค่าป๊อปอัปแจ้งเตือนเรียบร้อยแล้ว',
                'images' => $finalImages
            ]);
        } catch (\Exception $e) {
            log_message('error', 'WelcomeModal Update Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }
}
