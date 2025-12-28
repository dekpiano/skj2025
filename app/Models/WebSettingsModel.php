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
        return $this->where('setting_name', $name)->set([
            'setting_value' => $value,
            'updated_at' => date('Y-m-d H:i:s')
        ])->update();
    }
}
