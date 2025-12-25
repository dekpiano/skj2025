<?php 
namespace App\Models;
use CodeIgniter\Model;


class LoginModel extends Model
{
    protected $table = 'tb_admin';
    protected $primaryKey = 'admin_id';
    
    protected $allowedFields = ['admin_fullname', 'admin_username','admin_password', 'role_id', 'pers_id'];
}