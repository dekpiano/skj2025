<?php
namespace App\Models;

use CodeIgniter\Model;

class NewsImageModel extends Model
{
    protected $table      = 'tb_news_images';
    protected $primaryKey = 'news_img_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['news_id', 'news_img_name', 'news_img_created_at'];

    protected $useTimestamps = false;
}
