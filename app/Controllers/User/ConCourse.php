<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Libraries\Datethai;

use App\Models\PositionModel;
use App\Models\LearningModel;
use App\Models\PersonnalModel;
use App\Models\AboutModel;

class ConCourse extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->PosiModel = new PositionModel();
        $this->LearModel = new LearningModel();
        $this->PersModel = new PersonnalModel();
        $this->AboutModel = new AboutModel();
    }

    public function DataMain(){
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['dateThai'] = new Datethai();
        $data['Lear'] = $this->LearModel->get()->getResult();
        $data['PosiOther'] = $this->PosiModel->where(array('posi_id >='=>'posi_007','posi_id <='=>'posi_012'))->get()->getResult();
        $data['uri'] = service('uri'); 
        $data['AboutSchool'] = $this->AboutModel->get()->getResult();
        // $data['v'] = $this->VisitorsUser(); // REMOVED
        return $data;
    }

    public function index(){
        $page_data = $this->DataMain();
       
        $page_data['title'] = "หลักสูตรความเป็นเลิศ";
        $page_data['description'] = "รายละเอียดข้อมูลหลักสูตรความเป็นเลิศ";
        $page_data['banner'] = '';

        $data = array_merge($this->data, $page_data);

        return  view('User/layout/header',$data)
                .view('User/layout/navbar', $data)
                .view('User/PageCourse/PageCourseMain', $data)
                .view('User/layout/footer', $data);
        
    }

   
}
