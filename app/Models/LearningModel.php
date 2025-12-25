<?php 
namespace App\Models;
use CodeIgniter\Model;


class LearningModel extends Model
{
    protected $table = 'tb_learning';
    protected $primaryKey = 'lear_id';
    
    protected $allowedFields = ['lear_id', 'lear_namethai'];
}