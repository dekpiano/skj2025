<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;

class ConAdminDashboard extends \App\Controllers\BaseController
{
    public function index()
    {        
        // Auto-initialize table if missing (for the first time)
        $db = \Config\Database::connect();
        if (!$db->tableExists('tb_web_settings')) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'setting_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
                'setting_name' => ['type' => 'VARCHAR', 'constraint' => '100'],
                'setting_value' => ['type' => 'TEXT', 'null' => true],
                'setting_description' => ['type' => 'TEXT', 'null' => true],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $forge->addKey('setting_id', true);
            $forge->createTable('tb_web_settings');
            
            $db->table('tb_web_settings')->insertBatch([
                [
                    'setting_name' => 'festival_theme',
                    'setting_value' => 'on',
                    'setting_description' => 'เปิด-ปิด ธีมเทศกาล (เช่น ปีใหม่ หิมะตก)',
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'setting_name' => 'welcome_modal_status',
                    'setting_value' => 'off',
                    'setting_description' => 'เปิด-ปิด ป๊อปอัปแจ้งเตือนหน้าแรก (on/off)',
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'setting_name' => 'welcome_modal_images',
                    'setting_value' => '["24 ตุลาคม ไว้อาลัยพระพันปีหลวง.png"]',
                    'setting_description' => 'รายชื่อไฟล์รูปภาพป๊อปอัปแจ้งเตือน (เก็บไว้ใน uploads/) รูปแบบ JSON Array',
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]);
        } else {
            // Ensure both settings exist even if the table was already created
            $existsStatus = $db->table('tb_web_settings')->where('setting_name', 'welcome_modal_status')->countAllResults();
            if ($existsStatus == 0) {
                $db->table('tb_web_settings')->insert([
                    'setting_name' => 'welcome_modal_status',
                    'setting_value' => 'off',
                    'setting_description' => 'เปิด-ปิด ป๊อปอัปแจ้งเตือนหน้าแรก (on/off)',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $existsImages = $db->table('tb_web_settings')->where('setting_name', 'welcome_modal_images')->countAllResults();
            if ($existsImages == 0) {
                // Check if old setting welcome_modal_image existed to migrate it
                $oldSetting = $db->table('tb_web_settings')->where('setting_name', 'welcome_modal_image')->get()->getRowArray();
                $initialValue = $oldSetting ? json_encode([$oldSetting['setting_value']]) : '["24 ตุลาคม ไว้อาลัยพระพันปีหลวง.png"]';
                
                $db->table('tb_web_settings')->insert([
                    'setting_name' => 'welcome_modal_images',
                    'setting_value' => $initialValue,
                    'setting_description' => 'รายชื่อไฟล์รูปภาพป๊อปอัปแจ้งเตือน (เก็บไว้ใน uploads/) รูปแบบ JSON Array',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $newsModel = new \App\Models\NewsModel();
        $bannerModel = new \App\Models\BannerModel();
        $logModel = new \App\Models\WebLogModel();
        $visitorModel = new \App\Models\VisitorModel();

        $data = [
            'title' => "แดชบอร์ด",
            'description' => "ภาพรวมของระบบและสถิติการใช้งาน",
            'countNews' => $newsModel->countAllResults(),
            'countBanner' => $bannerModel->countAllResults(),
            'countLogs' => $logModel->countAllResults(),
            'todayLogs' => $logModel->where('DATE(log_created_at)', date('Y-m-d'))->countAllResults(),
            'visitorStats' => $visitorModel->getStats(),
            'recentLogs' => $logModel->orderBy('log_created_at', 'DESC')->limit(5)->get()->getResultArray()
        ];
        
        return view('Admin/PageAdminDashboard', array_merge($this->data, $data));
    }
}
