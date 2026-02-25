<?php
namespace App\Models;

use CodeIgniter\Model;

class SpotlightModel extends Model
{
    protected $table = 'tb_spotlight';
    protected $primaryKey = 'spotlight_id';
    protected $allowedFields = [
        'spotlight_badge',
        'spotlight_badge_color',
        'spotlight_topic',
        'spotlight_topic_highlight',
        'spotlight_content',
        'spotlight_btn_text',
        'spotlight_btn_link',
        'spotlight_btn_color',
        'spotlight_facebook_embed',
        'spotlight_img',
        'spotlight_layout',
        'spotlight_theme',
        'spotlight_status',
        'spotlight_date',
        'spotlight_personnel_id'
    ];
}
