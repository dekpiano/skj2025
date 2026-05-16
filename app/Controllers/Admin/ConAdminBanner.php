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
        // อัปเดตสถานะแบนเนอร์ที่หมดอายุให้เป็น 'off' โดยอัตโนมัติ
        $this->BannerModel->where('banner_end_date !=', null)
                          ->where('banner_end_date <', date('Y-m-d'))
                          ->where('banner_status', 'on')
                          ->set(['banner_status' => 'off'])
                          ->update();

        $data['title'] = "แบนเนอร์ประชาสัมพันธ์";
        $data['description'] = "รวมแบนเนอร์ประชาสัมพันธ์ กิจกรรมต่าง ๆ ของโรงเรียน";
        $data['banner'] = $this->BannerModel->orderBy('banner_id','DESC')->get()->getResult();
        
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

        // ตรวจสอบว่ามี Banner Name ส่งมาหรือไม่ (ถ้าไฟล์ใหญ่เกิน limit ค่า POST จะหายไป)
        if (empty($this->request->getPost('banner_name'))) {
             return $this->response->setJSON([
                'status' => false,
                'message' => 'ไม่สามารถบันทึกได้: ข้อมูลไม่ครบถ้วน หรือไฟล์อาจมีขนาดใหญ่เกินกว่าที่เซิร์ฟเวอร์กำหนด'
            ]);
        }

        $imageFile = $this->request->getFile('banner_img');
        $imageMobileFile = $this->request->getFile('banner_img_mobile');

        $dataSave = [
            'banner_name' => $this->request->getPost('banner_name'),
            'banner_linkweb' => $this->request->getPost('banner_linkweb'),
            'banner_date' => $this->request->getPost('banner_date'),
            'banner_end_date' => $this->request->getPost('banner_end_date') ?: null,
            'banner_status' => 'on',
            'banner_personnel_id' => session('AdminID')
        ];

        try {
            // Handle Horizontal Image (JPG Fallback)
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $newName = $imageFile->getRandomName();
                $jpgName = pathinfo($newName, PATHINFO_FILENAME) . '.jpg';
                \Config\Services::image()
                    ->withFile($imageFile)
                    ->resize(1920, 822, false, 'auto')
                    ->save(FCPATH . 'uploads/banner/all/' . $jpgName, 85); // Save as JPG with 85% quality
                $dataSave['banner_img'] = $jpgName;
            }

            // Handle Vertical Image (JPG Fallback)
            if ($imageMobileFile && $imageMobileFile->isValid() && !$imageMobileFile->hasMoved()) {
                $newNameMobile = $imageMobileFile->getRandomName();
                $jpgNameMobile = 'mobile_' . pathinfo($newNameMobile, PATHINFO_FILENAME) . '.jpg';
                \Config\Services::image()
                    ->withFile($imageMobileFile)
                    ->resize(1080, 1920, false, 'auto')
                    ->save(FCPATH . 'uploads/banner/all/' . $jpgNameMobile, 85);
                $dataSave['banner_img_mobile'] = $jpgNameMobile;
            }

            $builder->insert($dataSave);
            $insertID = $database->insertID();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'บันทึกแบนเนอร์สำเร็จ! (รองรับ Responsive)',
                'banner_id' => $insertID,
                'data' => $dataSave
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'เกิดข้อผิดพลาดในการบันทึกภาพ: ' . $e->getMessage()
            ]);
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

    // ลบโค้ดส่วนเกินที่ไม่ได้ใช้งานออก

    public function DeleteBanner(){
        $id = $this->request->getPost('KeyBannerid');
        $sel_img = $this->BannerModel->where('banner_id',$id)->first();
        if($sel_img['banner_img'] != ''){
            @unlink("uploads/banner/all/".$sel_img['banner_img']);
        }        
        if($sel_img['banner_img_mobile'] != ''){
            @unlink("uploads/banner/all/".$sel_img['banner_img_mobile']);
        }
        $result = $this->BannerModel->delete(['banner_id' => $id]);        
        echo $result;
    }

    public function Updatebanner()
    {
        if (empty($this->request->getPost())) {
            return $this->response->setJSON(['status' => false, 'message' => 'ข้อมูลมีขนาดใหญ่เกินกว่าที่ Server กำหนด']);
        }

        $database = \Config\Database::connect();
        $builder = $database->table('tb_banner');

        $id = $this->request->getPost('banner_id');
        $originalImg = $this->request->getPost('original_banner_img');
        $originalImgMobile = $this->request->getPost('original_banner_img_mobile');
        
        $imageFile = $this->request->getFile('banner_img');
        $imageMobileFile = $this->request->getFile('banner_img_mobile');

        $dataUpdate = [
            'banner_name' => $this->request->getPost('banner_name'),
            'banner_linkweb' => $this->request->getPost('banner_linkweb'),
            'banner_date' => $this->request->getPost('banner_date'),
            'banner_end_date' => $this->request->getPost('banner_end_date') ?: null,
            'banner_personnel_id' => session('AdminID')
        ];

        try {
            // Update Horizontal Image (JPG Fallback)
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                if ($originalImg && file_exists(FCPATH . 'uploads/banner/all/' . $originalImg)) {
                    @unlink(FCPATH . 'uploads/banner/all/' . $originalImg);
                }
                $newName = $imageFile->getRandomName();
                $jpgName = pathinfo($newName, PATHINFO_FILENAME) . '.jpg';
                \Config\Services::image()
                    ->withFile($imageFile)
                    ->resize(1920, 822, false, 'auto')
                    ->save(FCPATH . 'uploads/banner/all/' . $jpgName, 85);
                $dataUpdate['banner_img'] = $jpgName;
            }

            // Update Mobile Image (JPG Fallback)
            if ($imageMobileFile && $imageMobileFile->isValid() && !$imageMobileFile->hasMoved()) {
                if ($originalImgMobile && file_exists(FCPATH . 'uploads/banner/all/' . $originalImgMobile)) {
                    @unlink(FCPATH . 'uploads/banner/all/' . $originalImgMobile);
                }
                $newNameMobile = $imageMobileFile->getRandomName();
                $jpgNameMobile = 'mobile_' . pathinfo($newNameMobile, PATHINFO_FILENAME) . '.jpg';
                \Config\Services::image()
                    ->withFile($imageMobileFile)
                    ->resize(1080, 1920, false, 'auto')
                    ->save(FCPATH . 'uploads/banner/all/' . $jpgNameMobile, 85);
                $dataUpdate['banner_img_mobile'] = $jpgNameMobile;
            }

            $builder->where('banner_id', $id);
            $update = $builder->update($dataUpdate);
            $updatedData = $database->table('tb_banner')->where('banner_id', $id)->get()->getRowArray();

            return $this->response->setJSON([
                'status' => $update ? true : false,
                'message' => $update ? 'อัปเดตแบนเนอร์สำเร็จ!' : 'อัปเดตแบนเนอร์ไม่สำเร็จ!',
                'data' => $updatedData
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function CleanupImages()
    {
        $database = \Config\Database::connect();
        $builder = $database->table('tb_banner');
        
        $query = $builder->select('banner_img, banner_img_mobile')->get()->getResultArray();
        $usedImages = [];
        foreach ($query as $row) {
            if (!empty($row['banner_img'])) $usedImages[] = $row['banner_img'];
            if (!empty($row['banner_img_mobile'])) $usedImages[] = $row['banner_img_mobile'];
        }

        $folderPath = FCPATH . 'uploads/banner/all/';
        if (!is_dir($folderPath)) {
            return $this->response->setJSON(['status' => false, 'message' => 'ไม่พบโฟลเดอร์เก็บรูปภาพ']);
        }

        $allFiles = array_diff(scandir($folderPath), array('.', '..', 'index.html')); 
        $deletedCount = 0;

        foreach ($allFiles as $file) {
            if (is_file($folderPath . $file)) {
                if (!in_array($file, $usedImages)) {
                    if (@unlink($folderPath . $file)) {
                        $deletedCount++;
                    }
                }
            }
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => "ดำเนินการเสร็จสิ้น! พบไฟล์ขยะและลบไปทั้งหมด {$deletedCount} ไฟล์",
            'deleted_count' => $deletedCount
        ]);
    }

}