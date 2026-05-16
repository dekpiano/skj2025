<?php 
namespace App\Models;
use CodeIgniter\Model;


class BannerModel extends Model
{
    protected $table = 'tb_banner';
    protected $primaryKey = 'banner_id';
    
    protected $allowedFields = ['banner_name', 'banner_img', 'banner_img_mobile', 'banner_end_date', 'banner_linkweb', 'banner_date', 'banner_status', 'banner_personnel_id'];
}