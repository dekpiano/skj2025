<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardRowModel extends Model
{
    protected $DBGroup          = 'personnal';
    protected $table            = 'tb_board_rows';
    protected $primaryKey       = 'row_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'row_title',
        'row_cols',
        'row_sort'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRowsWithMembers()
    {
        $rows = $this->orderBy('row_sort', 'ASC')->findAll();
        foreach ($rows as $row) {
            $row->members = (new BoardModel())->where('row_id', $row->row_id)
                ->orderBy('board_sort', 'ASC')
                ->findAll();
        }
        return $rows;
    }
}
