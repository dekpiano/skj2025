<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\WebSettingsModel;

class ConAdminSettings extends BaseController
{
    public function index()
    {
        $settingsModel = new WebSettingsModel();
        
        $data = [
            'title' => "ตั้งค่าระบบ",
            'description' => "จัดการการตั้งค่าต่างๆ ของเว็บไซต์",
            'settings' => $settingsModel->whereNotIn('setting_name', ['welcome_modal_status', 'welcome_modal_image'])->findAll()
        ];

        return view('Admin/PageAdminSettings/AdminSettingsMain', array_merge($this->data, $data));
    }

    public function toggleFestival()
    {
        $status = $this->request->getPost('status');
        $model = new WebSettingsModel();
        
        if ($model->updateStatus('festival_theme', $status)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'ปรับปรุงสถานะธีมเทศกาลเรียบร้อยแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถปรับปรุงสถานะได้']);
        }
    }

    public function updateSetting()
    {
        $id = $this->request->getPost('id');
        $value = $this->request->getPost('value');
        
        $model = new WebSettingsModel();
        if ($model->update($id, ['setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')])) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
        }
    }
}
