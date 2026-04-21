<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardModel extends Model
{
    protected $DBGroup          = 'personnal';
    protected $table            = 'tb_board';
    protected $primaryKey       = 'board_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'row_id',
        'board_prefix',
        'board_firstname',
        'board_lastname',
        'board_position',
        'board_type',
        'board_img',
        'board_sort'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBoardWithRows()
    {
        return $this->select('tb_board.*, tb_board_rows.row_title, tb_board_rows.row_cols')
            ->join('tb_board_rows', 'tb_board_rows.row_id = tb_board.row_id', 'left')
            ->orderBy('tb_board_rows.row_sort', 'ASC')
            ->orderBy('tb_board.board_sort', 'ASC')
            ->findAll();
    }
}
