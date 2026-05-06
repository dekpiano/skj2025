<?php

namespace App\Models;

use CodeIgniter\Model;

class BotanyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_botany';
    protected $primaryKey       = 'botany_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'botany_name_th',
        'botany_name_en',
        'botany_science_name',
        'botany_family',
        'botany_description',
        'botany_benefit',
        'botany_image',
        'botany_type',
        'botany_location',
        'botany_status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActivePlants()
    {
        return $this->where('botany_status', 'active')
                    ->orderBy('botany_name_th', 'ASC')
                    ->findAll();
    }
    
    public function getPlantBySlug($id)
    {
        return $this->where('botany_id', $id)
                    ->first();
    }
}
