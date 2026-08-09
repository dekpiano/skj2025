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
        
        $rawItems = $settingsModel->getStatus('welcome_modal_items');
        $items = json_decode($rawItems ?: '[]', true);
        
        // Backward compatibility fallback: if welcome_modal_items is empty, convert old welcome_modal_images string list into items array
        if (empty($items)) {
            $rawImages = $settingsModel->getStatus('welcome_modal_images');
            $legacyImages = json_decode($rawImages ?: '[]', true);
            if (is_array($legacyImages) && !empty($legacyImages)) {
                $globalStart = $settingsModel->getStatus('welcome_modal_start_datetime');
                $globalEnd = $settingsModel->getStatus('welcome_modal_end_datetime');
                $items = [];
                foreach ($legacyImages as $img) {
                    if (is_string($img)) {
                        $items[] = [
                            'file' => $img,
                            'title' => '',
                            'start_datetime' => $globalStart !== 'off' ? $globalStart : '',
                            'end_datetime' => $globalEnd !== 'off' ? $globalEnd : ''
                        ];
                    } elseif (is_array($img) && isset($img['file'])) {
                        $items[] = $img;
                    }
                }
            }
        }

        $data = [
            'title' => "จัดการป๊อปอัปแจ้งเตือน",
            'description' => "จัดการรูปภาพประกาศ ตั้งค่าชื่อประกาศ และกำหนดช่วงเวลาแสดงผลแยกตามรายรูปภาพ",
            'status' => $settingsModel->getStatus('welcome_modal_status'),
            'items' => $items
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
            $settingsModel->updateStatus('welcome_modal_status', $status);
            
            // Load existing items from database
            $rawDbItems = $settingsModel->getStatus('welcome_modal_items');
            $dbItems = json_decode($rawDbItems ?: '[]', true) ?: [];
            $dbFiles = array_column($dbItems, 'file');

            // Legacy backup check
            if (empty($dbFiles)) {
                $legacyImages = json_decode($settingsModel->getStatus('welcome_modal_images') ?: '[]', true) ?: [];
                $dbFiles = array_filter(array_map(function($i) { return is_array($i) ? ($i['file'] ?? null) : $i; }, $legacyImages));
            }

            // Get existing item inputs submitted by client
            $inputFiles = $this->request->getPost('item_file') ?: [];
            $inputTitles = $this->request->getPost('item_title') ?: [];
            $inputStarts = $this->request->getPost('item_start_datetime') ?: [];
            $inputEnds = $this->request->getPost('item_end_datetime') ?: [];

            $uploadPath = FCPATH . 'uploads/welcome/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete removed image files
            $keptFiles = array_values(array_filter($inputFiles));
            $removedFiles = array_diff($dbFiles, $keptFiles);
            foreach ($removedFiles as $removedFile) {
                if ($removedFile) {
                    $filePath = $uploadPath . $removedFile;
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
            }

            // Build item objects for existing files
            $finalItems = [];
            foreach ($inputFiles as $idx => $fileName) {
                if (!empty($fileName)) {
                    $finalItems[] = [
                        'file' => $fileName,
                        'title' => $inputTitles[$idx] ?? '',
                        'start_datetime' => $inputStarts[$idx] ?? '',
                        'end_datetime' => $inputEnds[$idx] ?? ''
                    ];
                }
            }

            // Handle newly uploaded files
            $files = $this->request->getFiles();
            $newTitles = $this->request->getPost('new_item_title') ?: [];
            $newStarts = $this->request->getPost('new_item_start_datetime') ?: [];
            $newEnds = $this->request->getPost('new_item_end_datetime') ?: [];

            if (isset($files['welcome_modal_imgs'])) {
                foreach ($files['welcome_modal_imgs'] as $nIdx => $file) {
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $jpgName = pathinfo($newName, PATHINFO_FILENAME) . '.jpg';
                        
                        \Config\Services::image()
                            ->withFile($file)
                            ->save($uploadPath . $jpgName, 90);
                            
                        $finalItems[] = [
                            'file' => $jpgName,
                            'title' => $newTitles[$nIdx] ?? '',
                            'start_datetime' => $newStarts[$nIdx] ?? '',
                            'end_datetime' => $newEnds[$nIdx] ?? ''
                        ];
                    }
                }
            }

            // Clean array and update DB
            $finalItems = array_values($finalItems);
            $settingsModel->updateStatus('welcome_modal_items', json_encode($finalItems));
            // Keep legacy setting synced with filename list for compatibility
            $legacyFilenameList = array_column($finalItems, 'file');
            $settingsModel->updateStatus('welcome_modal_images', json_encode($legacyFilenameList));
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'บันทึกการตั้งค่าป๊อปอัปแจ้งเตือนเรียบร้อยแล้ว',
                'items' => $finalItems
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
