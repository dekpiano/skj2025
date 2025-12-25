<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Libraries\Datethai;

use App\Models\PositionModel;
use App\Models\LearningModel;
use App\Models\PersonnalModel;
use App\Models\AboutModel;

class ConPersonnal extends BaseController
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

    public function PersonnalMain($PoisO = null,$Key = null){
        $page_data = $this->DataMain();
       
        $page_data['title'] = "บุคลากรภายในโรงเรียน";
        $page_data['description'] = "รายละเอียดข้อมูลบุคลากรภายในโรงเรียน";
        $page_data['banner'] = '';
        
        if($Key === "ผู้บริหารสถานศึกษา"){
            $CheckPosi = "pers_status='กำลังใช้งาน' && pers_position='posi_001' OR pers_position='posi_002'";
        }elseif($PoisO === 'สายการสอน'){
            $CheckLear = $this->LearModel->where('lear_namethai',str_replace("-", " ", $Key))->get()->getResult();
            $CheckPosi = ['pers_learning' => $CheckLear[0]->lear_id];           
        }elseif($PoisO === 'สายสนับสนุน'){
            $CheckLear = $this->PosiModel->where('posi_name',str_replace("-", " ", $Key))->get()->getResult();
            $CheckPosi = ['pers_position' => $CheckLear[0]->posi_id];
           
        }
        $page_data['Pers'] = $this->PersModel->select('
            skjacth_personnel.tb_personnel.pers_position,
            skjacth_skj.tb_position.posi_name,
            skjacth_personnel.tb_personnel.pers_prefix,
            skjacth_personnel.tb_personnel.pers_firstname,
            skjacth_personnel.tb_personnel.pers_lastname,
            skjacth_personnel.tb_personnel.pers_phone,
            skjacth_personnel.tb_personnel.pers_facebook,
            skjacth_personnel.tb_personnel.pers_instagram,
            skjacth_personnel.tb_personnel.pers_youtube,
            skjacth_personnel.tb_personnel.pers_line,
            skjacth_personnel.tb_personnel.pers_twitter,
            skjacth_personnel.tb_personnel.pers_img,
            skjacth_personnel.tb_personnel.pers_academic,
            skjacth_personnel.tb_personnel.pers_numberGroup,
            skjacth_personnel.tb_personnel.pers_groupleade,
            skjacth_personnel.tb_personnel.pers_status,
            tb_position_main.work_name
        ')
        ->join('skjacth_skj.tb_position','skjacth_skj.tb_position.posi_id = skjacth_personnel.tb_personnel.pers_position')
        ->join('skjacth_skj.tb_position_main','skjacth_skj.tb_position_main.work_id = skjacth_personnel.tb_personnel.pers_workother_id','left')       
        ->where($CheckPosi)
        //->Where('pers_status','กำลังใช้งาน')
        ->orderBy('skjacth_personnel.tb_personnel.pers_groupleade DESC,skjacth_personnel.tb_personnel.pers_numberGroup ASC')
        ->get()->getResult();
        
        $data = array_merge($this->data, $page_data);

        //echo "<pre>";print_r($page_data['Pers']); exit();

        return  view('User/layout/header',$data)
                .view('User/layout/navbar', $data)
                .view('User/PagePersonnal/PagePersonnal', $data)
                .view('User/layout/footer', $data);
        
    }

   
}
