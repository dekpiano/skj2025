<?php

namespace App\Models;

use CodeIgniter\Model;

class BotanyNewsModel extends Model
{
    protected $table            = 'tb_botany_news';
    protected $primaryKey       = 'news_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['news_title', 'news_content', 'news_img', 'news_date', 'news_status'];

    // Get active news
    public function getActiveNews($limit = null)
    {
        $builder = $this->where('news_status', 'active')->orderBy('news_date', 'DESC');
        if ($limit) {
            return $builder->limit($limit)->get()->getResult();
        }
        return $builder->get()->getResult();
    }
}
