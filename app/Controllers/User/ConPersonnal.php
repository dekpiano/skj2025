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
    protected $PosiModel;
    protected $LearModel;
    protected $PersModel;
    protected $AboutModel;

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
        $data['PosiOther'] = $this->PosiModel->where('posi_id >=', 'posi_007')->orderBy('posi_id', 'ASC')->get()->getResult();
        $data['uri'] = service('uri'); 
        $data['AboutSchool'] = $this->AboutModel->get()->getResult();
        // $data['v'] = $this->VisitorsUser(); // REMOVED
        return $data;
    }

    public function PersonnalMain($PoisO = null,$Key = null){
        $page_data = $this->DataMain();
       
        $poisO_lower = strtolower(trim((string)$PoisO));
        $page_title_th = 'บุคลากรภายในโรงเรียน';
        $CheckPosi = null;
        
        // 1. Executive
        if($PoisO === "Management" || $poisO_lower === "executive" || $Key === "ผู้บริหารสถานศึกษา"){
            $page_title_th = "ผู้บริหารสถานศึกษา";
            $CheckPosi = "pers_status='กำลังใช้งาน' AND (pers_position='posi_001' OR pers_position='posi_002')";
        }
        // 2. Teaching Staff (สายการสอน)
        elseif($poisO_lower === 'teaching' || $PoisO === 'สายการสอน'){
            if($Key){
                $resolved = personnel_resolve_teaching_key($Key);
                if($resolved){
                    $lear_id = $resolved['lear_id'];
                    $lear_name = $resolved['name_th'];
                } else {
                    $searchThai = str_replace("-", " ", urldecode($Key));
                    $CheckLear = $this->LearModel->where('lear_namethai', $searchThai)
                                                 ->orWhere('lear_id', $Key)
                                                 ->get()->getResult();
                    $lear_id = $CheckLear[0]->lear_id ?? null;
                    $lear_name = $CheckLear[0]->lear_namethai ?? $searchThai;
                }

                if($lear_id){
                    $CheckPosi = ['pers_learning' => $lear_id];
                    $page_title_th = (str_contains($lear_name, 'งาน') || str_contains($lear_name, 'กลุ่มสาระ'))
                        ? $lear_name
                        : 'กลุ่มสาระการเรียนรู้' . $lear_name;
                } else {
                    $CheckPosi = "pers_position IN ('posi_003', 'posi_004', 'posi_005', 'posi_006')";
                    $page_title_th = "บุคลากรสายการสอนทั้งหมด";
                }
            } else {
                $CheckPosi = "pers_position IN ('posi_003', 'posi_004', 'posi_005', 'posi_006')";
                $page_title_th = "บุคลากรสายการสอนทั้งหมด";
            }
        }
        // 3. Support Staff (สายสนับสนุน)
        elseif($poisO_lower === 'support' || $PoisO === 'สายสนับสนุน'){
            if($Key){
                $resolved = personnel_resolve_support_key($Key);
                if($resolved){
                    $posi_id = $resolved['posi_id'];
                    $posi_name = $resolved['name_th'];
                } else {
                    $searchThai = str_replace("-", " ", urldecode($Key));
                    $CheckPosiObj = $this->PosiModel->where('posi_name', $searchThai)
                                                   ->orWhere('posi_id', $Key)
                                                   ->get()->getResult();
                    $posi_id = $CheckPosiObj[0]->posi_id ?? null;
                    $posi_name = $CheckPosiObj[0]->posi_name ?? $searchThai;
                }

                if($posi_id){
                    $CheckPosi = ['pers_position' => $posi_id];
                    $page_title_th = $posi_name;
                } else {
                    $CheckPosi = "pers_position >= 'posi_007'";
                    $page_title_th = "บุคลากรสายสนับสนุนทั้งหมด";
                }
            } else {
                $CheckPosi = "pers_position >= 'posi_007'";
                $page_title_th = "บุคลากรสายสนับสนุนทั้งหมด";
            }
        } else {
            // Default: Show all active personnel
            $page_title_th = "บุคลากรทั้งหมด";
            $CheckPosi = "pers_status='กำลังใช้งาน'";
        }

        $page_data['page_title_th'] = $page_title_th;
        $page_data['title'] = $page_title_th . " | โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $page_data['description'] = "รายละเอียดข้อมูล{$page_title_th} โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์";
        $page_data['banner'] = '';
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
