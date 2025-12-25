<?php

namespace App\Models;

use CodeIgniter\Model;

class WebLogModel extends Model
{
    protected $table            = 'tb_website_logs';
    protected $primaryKey       = 'log_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'log_user_id',
        'log_user_name',
        'log_ip_address',
        'log_method',
        'log_url',
        'log_agent',
        'log_session_id',
        'log_created_at'
    ];

    // Dates
    protected $useTimestamps = false;
}
