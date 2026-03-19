<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationModel extends Model
{
    protected $DBGroup          = 'personnal';
    protected $table            = 'tb_teacher_evaluation';
    protected $primaryKey       = 'eva_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'eva_teacher_id',
        'eva_year',
        'eva_round',
        'eva_file',
        'eva_canva_link',
        'eva_status',
        'eva_comment'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'eva_created_at';
    protected $updatedField  = 'eva_updated_at';

    /**
     * ดึงข้อมูลการประเมินพร้อมข้อมูลครู
     */
    public function getEvaluationsWithPersonnel($year = null, $round = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            tb_teacher_evaluation.*,
            tb_personnel.pers_prefix,
            tb_personnel.pers_firstname,
            tb_personnel.pers_lastname,
            tb_personnel.pers_img,
            tb_personnel.pers_learning,
            tb_personnel.pers_position,
            skjacth_skj.tb_learning.lear_namethai as learning_name
        ');
        $builder->join('tb_personnel', 'tb_personnel.pers_id = tb_teacher_evaluation.eva_teacher_id', 'left');
        $builder->join('skjacth_skj.tb_learning', 'skjacth_skj.tb_learning.lear_id = tb_personnel.pers_learning', 'left');
        
        if ($year) $builder->where('eva_year', $year);
        if ($round) $builder->where('eva_round', $round);
        
        $builder->orderBy('eva_updated_at', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}
