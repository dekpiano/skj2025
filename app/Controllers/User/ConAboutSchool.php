<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\NewsModel;
use App\Models\BannerModel;
use App\Libraries\Datethai;
use App\Models\PositionModel;
use App\Models\LearningModel;
use App\Models\PersonnalModel;
use App\Models\AboutModel;


class ConAboutSchool extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->PosiModel = new PositionModel();
        $this->LearModel = new LearningModel();
        $this->PersModel = new PersonnalModel();
        $this->NewsModel = new NewsModel();
        $this->BannerModel = new BannerModel();
        $this->AboutModel = new AboutModel();
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['dateThai'] = new Datethai();
        $data['Lear'] = $this->LearModel->get()->getResult();
        $data['PosiOther'] = $this->PosiModel->where(array('posi_id >='=>'posi_007','posi_id <='=>'posi_012'))->get()->getResult();
        $data['AboutSchool'] = $this->AboutModel->get()->getResult();
        $data['uri'] = service('uri'); 
        // $data['v'] = $this->VisitorsUser(); // REMOVED
        return $data;
    }

    public function AboutDetail($Key)
    {        
        $page_data = $this->DataMain();

        $page_data['AboutDetail'] = $this->AboutModel->where('about_menu',$Key)->get()->getRow();
        $page_data['title'] = "โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $page_data['description'] = "เป็นผู้นำ รักเพื่อน นับถือพี่ เคารพครู กตัญญูพ่อแม่ ดูแลน้อง สนองคุณแผ่นดิน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
                               
        $data = array_merge($this->data, $page_data);
      
        return  view('User/layout/header',$data)
        .view('User/layout/navbar', $data)
        .view('User/PageAboutSchool/PageAboutSchoolDetail', $data)
        .view('User/layout/footer', $data);
    }

}
