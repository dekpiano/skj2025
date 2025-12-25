<?php
namespace App\Controllers\Admin;
use App\Models\BannerModel;
use App\Models\AboutModel;

class ConAdminBanner extends \App\Controllers\BaseController
{
    public function __construct(){
        $this->BannerModel = new BannerModel();
        $this->AboutModel = new AboutModel();
    }

    public function BannerMain()
    {        
        $data['title'] = "แบนเนอร์ประชาสัมพันธ์";
        $data['description'] = "รวมแบนเนอร์ประชาสัมพันธ์ กิจกรรมต่าง ๆ ของโรงเรียน";
        $data['banner'] = $this->BannerModel->orderBy('banner_date','DESC')->get()->getResult();
        
        return view('Admin/PageAdminBanner/PageAdminBannerMain', array_merge($this->data, $data));
    }

    public function BannerOnoff(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_banner');
        $data = array('banner_status' => $this->request->getPost('Onoffstatus'));
        $builder->where('banner_id',  $this->request->getPost('Keystatus'));
        $update =  $builder->update($data);
        echo $this->request->getPost('Keystatus');
    }

    public function AddBanner()
    {
        $database = \Config\Database::connect();
        $builder = $database->table('tb_banner');

        // จุดที่ 1: แก้ validate จาก 'file' เป็น 'banner_img'
        $validateImg = $this->validate([
            'banner_img' => [
                'uploaded[banner_img]',
                'mime_in[banner_img,image/jpg,image/jpeg,image/png,image/gif]',
                
            ]
        ]);

        if (!$validateImg) {
            // ส่งกลับเป็น json (Dropzone ใช้ได้)
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ไฟล์สกุลไม่ถูกต้อง หรือ ขนาดไฟล์เกิน 2 mb'
            ]);
        } else {
            $imageFile = $this->request->getFile('banner_img');

            if ($imageFile && $imageFile->getError() == 0) {
                $RandomName = $imageFile->getRandomName();

                // Resize และบันทึกไฟล์
                \Config\Services::image()
                    ->withFile($imageFile)
                    ->resize(1920, 720, false, 'auto')
                    ->save(FCPATH . '/uploads/banner/all/' . $RandomName);

                $NameImg = $RandomName;

                $dataSave = [
                    'banner_img' => $NameImg,
                    'banner_name' => $this->request->getPost('banner_name'),
                    'banner_linkweb' => $this->request->getPost('banner_linkweb'),
                    'banner_date' => $this->request->getPost('banner_date'),
                    'banner_status' => 'on',
                    'banner_personnel_id' => session('AdminID')
                ];
                $builder->insert($dataSave);
                $insertID = $database->getInsertID();

                // ส่งกลับเป็น json
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'บันทึกแบนเนอร์สำเร็จ!',
                    'banner_id' => $insertID,
                    'data' => $dataSave
                ]);
            } else {
                // ไม่มีไฟล์ภาพก็ยังสามารถบันทึกข้อความอื่นได้
                $dataSave = [
                    'banner_name' => $this->request->getPost('banner_name'),
                    'banner_linkweb' => $this->request->getPost('banner_linkweb'),
                    'banner_date' => $this->request->getPost('banner_date'),
                    'banner_status' => 'on',
                    'banner_personnel_id' => session('AdminID')
                ];
                $save = $builder->insert($dataSave);

                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'บันทึกแบนเนอร์ (ไม่มีรูป) สำเร็จ!',
                    'data' => $dataSave
                ]);
            }
        }
    }

    public function EditBanner()
    {
        $id = $this->request->getVar('KeyBannerid');
        $data = $this->BannerModel->where('banner_id', $id)->first();

        if ($data) {
            $imagePath = FCPATH . 'uploads/banner/all/' . $data['banner_img'];
            if (empty($data['banner_img']) || !file_exists($imagePath)) {
                $data['banner_img'] = ''; // Set to empty if not found, JS will handle placeholder
            }
        }

        return $this->response->setJSON($data);
    }

    public function NewsEdit(){
        $KeyNewsid = $this->request->getPost('KeyNewsid');
        $EditNews = $this->BannerModel->select('*,CAST(news_date AS DATE) AS news_dateNews')->where('news_id',$KeyNewsid)->get()->getResult();
        echo json_encode($EditNews);
        
    }

    public function NewsUpdate(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_news');
        $id = $this->request->getPost('edit_news_id');
        $sel_img = $this->BannerModel->select('news_img')->where('news_id',$id)->get()->getResult();
        if($sel_img[0]->news_img != ''){
            @unlink(("uploads/news/".$sel_img[0]->news_img));
        }

        $imageFile = $this->request->getFile('edit_news_img'); 
        if($imageFile->getError() == 0){
            $RandomName = $imageFile->getRandomName();

            $image = \Config\Services::image()
            ->withFile($imageFile)
            ->resize(2560, 1440, true, 'height')
            ->save(FCPATH.'/uploads/news/'. $RandomName);
   
            $data = [              
               'news_img' => $RandomName,
               'news_topic' =>  $this->request->getPost('edit_news_topic'),
               'news_content' => $this->request->getPost('edit_news_content'),
               'news_date' => $this->request->getPost('edit_news_date'),
               'news_category' => $this->request->getPost('edit_news_category'),
               'personnel_id' => session('AdminID')
               ];
                    $builder->where('news_id',  $this->request->getPost('edit_news_id'));
            $save = $builder->update($data);
           echo $save;
        }else{
            $data = [              
                'news_topic' =>  $this->request->getPost('edit_news_topic'),
                'news_content' => $this->request->getPost('edit_news_content'),
                'news_date' => $this->request->getPost('edit_news_date'),
                'news_category' => $this->request->getPost('edit_news_category'),
                'personnel_id' => session('AdminID')
                ];
                    $builder->where('news_id',  $this->request->getPost('edit_news_id'));
            $save = $builder->update($data);
            echo $save;
        }
    }

    public function DeleteBanner(){
        $id = $this->request->getPost('KeyBannerid');
        $sel_img = $this->BannerModel->select('banner_img')->where('banner_id',$id)->get()->getResult();
        if($sel_img[0]->banner_img != ''){
            @unlink("uploads/banner/all/".$sel_img[0]->banner_img);
        }        
        $result = $this->BannerModel->delete(['banner_id' => $id]);        
        echo $result;
    }

    public function Updatebanner()
    {
        $database = \Config\Database::connect();
        $builder = $database->table('tb_banner');

        $id = $this->request->getPost('banner_id');
        $originalImg = $this->request->getPost('original_banner_img');
        $imageFile = $this->request->getFile('banner_img');

        $dataUpdate = [
            'banner_name' => $this->request->getPost('banner_name'),
            'banner_linkweb' => $this->request->getPost('banner_linkweb'),
            'banner_date' => $this->request->getPost('banner_date'),
            'banner_personnel_id' => session('AdminID')
        ];

        // Check if a new image is uploaded
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $validateImg = $this->validate([
                'banner_img' => [
                    'uploaded[banner_img]',
                    'mime_in[banner_img,image/jpg,image/jpeg,image/png,image/gif]',
                ]
            ]);

            if (!$validateImg) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไฟล์สกุลไม่ถูกต้อง หรือ ขนาดไฟล์เกิน 2 mb'
                ]);
            }

            // Delete old image if it exists
            if ($originalImg && file_exists(FCPATH . 'uploads/banner/all/' . $originalImg)) {
                @unlink(FCPATH . 'uploads/banner/all/' . $originalImg);
            }

            $RandomName = $imageFile->getRandomName();
            \Config\Services::image()
                ->withFile($imageFile)
                ->resize(1920, 720, false, 'auto')
                ->save(FCPATH . '/uploads/banner/all/' . $RandomName);
            
            $dataUpdate['banner_img'] = $RandomName;
        }

        $builder->where('banner_id', $id);
        $update = $builder->update($dataUpdate);

        // Fetch fresh data for UI update
        $updatedData = $database->table('tb_banner')->where('banner_id', $id)->get()->getRowArray();

        return $this->response->setJSON([
            'status' => $update ? true : false,
            'message' => $update ? 'อัปเดตแบนเนอร์สำเร็จ!' : 'อัปเดตแบนเนอร์ไม่สำเร็จ!',
            'data' => $updatedData
        ]);
    }

}