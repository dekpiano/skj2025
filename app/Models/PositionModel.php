<?php 
namespace App\Models;
use CodeIgniter\Model;


class PositionModel extends Model
{
    protected $table = 'tb_position';
    protected $primaryKey = 'posi_id';
    
    protected $allowedFields = ['posi_id', 'posi_name'];
}