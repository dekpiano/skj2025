<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BoardRowModel;
use App\Models\BoardModel;

class ConBoard extends BaseController
{
    public function index()
    {
        $boardRowModel = new BoardRowModel();
        
        $page_data['title'] = 'คณะกรรมการสถานศึกษา | โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์';
        $page_data['description'] = 'ทำเนียบคณะกรรมการสถานศึกษาขั้นพื้นฐาน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์';
        $page_data['board_rows'] = $boardRowModel->getRowsWithMembers();
        
        $data = array_merge($this->data, $page_data);

        return view('User/layout/header', $data)
             . view('User/layout/navbar', $data)
             . view('User/Board/PageBoard', $data)
             . view('User/layout/footer', $data);
    }
}
