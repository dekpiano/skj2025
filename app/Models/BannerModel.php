<?php 
namespace App\Models;
use CodeIgniter\Model;


class BannerModel extends Model
{
    protected $table = 'tb_banner';
    protected $primaryKey = 'banner_id';
    
    protected $allowedFields = ['banner_name', 'banner_img'];
}