<?php

namespace App\Models;

use CodeIgniter\Model;

class BotanyNewsImageModel extends Model
{
    protected $table            = 'tb_botany_news_images';
    protected $primaryKey       = 'img_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['news_id', 'img_path', 'created_at'];

    public function getImagesByNews($news_id)
    {
        return $this->where('news_id', $news_id)->findAll();
    }
}
