<?php 
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;


class NewsModel extends Model
{
    protected $table = 'tb_news';
    protected $primaryKey = 'news_id';
    
    protected $allowedFields = ['news_topic','news_facebook', 'news_content','news_img','news_date','news_view','news_category'];

    public function getNewsSuggestions($searchTerm)
    {
        return $this->like('news_topic', $searchTerm)
                    ->orderBy('news_date', 'DESC')
                    ->limit(10)
                    ->get()
                    ->getResultArray();
    }
}