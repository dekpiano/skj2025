<?php 
namespace App\Models;
use CodeIgniter\Model;


class AboutModel extends Model
{
    protected $table = 'tb_aboutschool';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['about_menu', 'about_detail', 'about_date', 'about_personnel_id'];
}