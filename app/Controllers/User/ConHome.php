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
use App\Models\StudentModels;


class ConHome extends BaseController
{
    public function __construct(){
        parent::__construct(); // It's good practice to call the parent constructor
        $this->PosiModel = new PositionModel();
        $this->LearModel = new LearningModel();
        $this->PersModel = new PersonnalModel();
        $this->NewsModel = new NewsModel();
        $this->BannerModel = new BannerModel();
        $this->AboutModel = new AboutModel();
        $this->StudentModel = new StudentModels();
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['dateThai'] = new Datethai();
        $data['Lear'] = $this->LearModel->get()->getResult();
        $data['PosiOther'] = $this->PosiModel->where(array('posi_id >='=>'posi_007','posi_id <='=>'posi_012'))->get()->getResult();
        $data['AboutSchool'] = $this->AboutModel->get()->getResult();
        $data['uri'] = service('uri'); 
        // $data['v'] = $this->VisitorsUser(); // REMOVED - This is now handled in BaseController
        return $data;
    }

    public function index()
    {        
        $page_data = $this->DataMain();
     
        $page_data['title'] = "โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $page_data['description'] = "เป็นผู้นำ รักเพื่อน นับถือพี่ เคารพครู กตัญญูพ่อแม่ ดูแลน้อง สนองคุณแผ่นดิน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $page_data['news'] = $this->NewsModel->where('news_category !=' , 'ข่าวรางวัล')->limit(6)->orderBy('news_date', 'DESC')->get()->getResult();
        $page_data['NewsReward'] = $this->NewsModel->where('news_category','ข่าวรางวัล')->limit(6)->orderBy('news_date', 'DESC')->get()->getResult();
        $page_data['Director'] = $this->PersModel->where('pers_position','posi_001')->where('pers_status','กำลังใช้งาน')->get()->getRow();
      
        $page_data['banner'] = $this->BannerModel->select('banner_id,banner_name,banner_img,banner_linkweb,banner_status')
                                        ->where('banner_status','on')
                                        ->orderBy('banner_id', 'DESC')
                                        ->findAll();
        $page_data['ConutStudent'] = $this->StudentModel->CountStudentAll();
        $page_data['count_personnel'] = $this->PersModel->where('pers_status', 'กำลังใช้งาน')->countAllResults();
        $page_data['count_learning'] = $this->LearModel->countAllResults();

        // Merge data from BaseController (contains visitor stats) with page-specific data
        $data = array_merge($this->data, $page_data);

        return  view('User/layout/header',$data)
                .view('User/layout/navbar', $data)
                .view('User/Home/PageHomeMain', $data)
                .view('User/layout/footer', $data);
    }

    function PageGroup(){
        $page_data = $this->DataMain();
        $page_data['title'] = "กลุ่มภายในโรงเรียน";
        $page_data['description'] = "กลุ่มภายในโรงเรียน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";

        // Merge data from BaseController (contains visitor stats) with page-specific data
        $data = array_merge($this->data, $page_data);

        return  view('User/layout/header',$data)
                .view('User/layout/navbar', $data)
                .view('User/PageGroup/PageGroupMain', $data)
                .view('User/layout/footer', $data);
    }

}