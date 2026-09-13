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
    protected $PosiModel;
    protected $LearModel;
    protected $PersModel;
    protected $NewsModel;
    protected $BannerModel;
    protected $AboutModel;

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

    public function index()
    {
        $first = $this->AboutModel->orderBy('id', 'ASC')->first();
        if ($first) {
            $menu = is_array($first) ? $first['about_menu'] : $first->about_menu;
            return redirect()->to(base_url('About/' . urlencode($menu)));
        }
        return redirect()->to(base_url('/'));
    }

    public function AboutDetail($Key = null)
    {        
        if (empty($Key)) {
            return $this->index();
        }

        $Key = urldecode($Key);
        $page_data = $this->DataMain();

        $about = $this->AboutModel->where('about_menu', $Key)->get()->getRow();
        if (!$about) {
            $first = $this->AboutModel->orderBy('id', 'ASC')->first();
            if ($first) {
                $menu = is_array($first) ? $first['about_menu'] : $first->about_menu;
                return redirect()->to(base_url('About/' . urlencode($menu)));
            }
            return redirect()->to(base_url('/'));
        }

        $page_data['AboutDetail'] = $about;
        $page_data['title'] = $about->about_menu . " | โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $page_data['description'] = "ข้อมูล" . $about->about_menu . " โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
                               
        $data = array_merge($this->data, $page_data);
      
        return  view('User/layout/header',$data)
        .view('User/layout/navbar', $data)
        .view('User/PageAboutSchool/PageAboutSchoolDetail', $data)
        .view('User/layout/footer', $data);
    }
}
