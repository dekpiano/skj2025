<?php

namespace App\Models;

use CodeIgniter\Model;

class WebSettingsModel extends Model
{
    protected $table = 'tb_web_settings';
    protected $primaryKey = 'setting_id';
    protected $allowedFields = ['setting_name', 'setting_value', 'setting_description', 'updated_at'];

    /**
     * Get setting by name
     */
    public function getStatus($name)
    {
        $setting = $this->where('setting_name', $name)->first();
        return $setting ? $setting['setting_value'] : 'off';
    }

    /**
     * Update setting by name
     */
    public function updateStatus($name, $value)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $exists = $builder->where('setting_name', $name)->countAllResults();
        
        if ($exists > 0) {
            return $builder->where('setting_name', $name)->update([
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $builder->insert([
                'setting_name' => $name,
                'setting_value' => $value,
                'setting_description' => 'Auto-created setting',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
