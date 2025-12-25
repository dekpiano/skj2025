<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserHistoryModel extends Model
{
    protected $table = 'tb_visit_user_history';
    protected $primaryKey = 'visitU_id';
    protected $allowedFields = ['visitU_date', 'visitU_ip', 'visitU_agent','visitU_count'];
}

?>