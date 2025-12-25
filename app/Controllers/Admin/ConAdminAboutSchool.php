<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;

class ConAdminAboutSchool extends \App\Controllers\BaseController
{
    public function __construct(){
        //$this->session = \Config\Services::session();
        $this->NewsModel = new NewsModel();
        $this->AboutModel = new AboutModel();
    }

    public function AboutSchoolDetail($key)
    {        
        $data['title'] = "จัดการข้อมูลเกี่ยวกับโรงเรียน";
        $data['description'] = "ภาพรวมของระบบ จัดการข้อมูลเกี่ยวกับโรงเรียน";
        $data['AboutSchoolDetail'] = $this->AboutModel->where('id',$key)->get()->getRow();
        
        return view('Admin/PageAdminAboutSchool/PageAdminAboutSchoolUpdate', array_merge($this->data, $data));
    }

    public function AboutSchoolEdit($key){
        $data['AboutSchoolDetail'] = $this->AboutModel->where('id',$key)->get()->getRow();
        echo json_encode($data['AboutSchoolDetail']);
    }

    public function AboutSchoolUpdate($key){   
        $session = session();
        $database = \Config\Database::connect();
        $builder = $database->table('tb_aboutschool');

        $data = [              
            'about_menu'         => $this->request->getPost('about_menu'),
            'about_detail'       => $this->request->getPost('About_content'),
            'about_date'         => date('Y-m-d H:i:s'),
            'about_personnel_id' => $session->get('AdminID')
        ];
        $builder->where('id',  $key);
        $save = $builder->update($data);

        echo $save;
    }

    public function AboutSchoolAdd(){
        $session = session();
        $save = $this->AboutModel->save([
            'about_menu'         => $this->request->getPost('about_menu'),
            'about_detail'       => $this->request->getPost('About_content'),
            'about_date'         => date('Y-m-d H:i:s'),
            'about_personnel_id' => $session->get('AdminID')
        ]);
        echo $save;
    }

}
