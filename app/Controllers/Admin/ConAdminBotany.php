<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BotanyModel;

class ConAdminBotany extends BaseController
{
    protected $BotanyModel;
    protected $BotanyNewsModel;
    protected $BotanyNewsImageModel;

    public function __construct()
    {
        $this->BotanyModel = new BotanyModel();
        $this->BotanyNewsModel = new \App\Models\BotanyNewsModel();
        $this->BotanyNewsImageModel = new \App\Models\BotanyNewsImageModel();
    }

    /**
     * ลดขนาดรูปภาพเพื่อประหยัดพื้นที่และเพิ่มความเร็วในการโหลด
     */
    private function optimizeImage($path, $filename, $targetWidth = 1200)
    {
        try {
            $image = \Config\Services::image()
                ->withFile($path . $filename);

            $width = $image->getWidth();
            
            // ปรับขนาดถ้ากว้างเกินเป้าหมาย
            if ($width > $targetWidth) {
                $image->resize($targetWidth, $targetWidth, true, 'width');
            }

            // บันทึกใหม่ด้วยคุณภาพ 80% เพื่อลดขนาดไฟล์แต่ยังคงความชัดเจน
            return $image->save($path . $filename, 80);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function BotanyMain()
    {
        $data['title'] = "แผงควบคุมสวนพฤกษศาสตร์";
        $data['description'] = "ภาพรวมการดำเนินงานและสถิติข้อมูลพรรณไม้";
        
        // Stats
        $data['total_plants'] = $this->BotanyModel->countAllResults();
        $data['active_plants'] = $this->BotanyModel->where('botany_status', 'active')->countAllResults();
        $data['inactive_plants'] = $data['total_plants'] - $data['active_plants'];
        
        return view('Admin/PageAdminBotany/PageAdminBotanyDashboard', array_merge($this->data, $data));
    }

    public function BotanyList()
    {
        $data['title'] = "จัดการข้อมูลพรรณไม้";
        $data['description'] = "เพิ่ม ลบ แก้ไข ข้อมูลพรรณไม้ในโรงเรียน";
        $data['botany'] = $this->BotanyModel->orderBy('created_at', 'DESC')->findAll();

        return view('Admin/PageAdminBotany/PageAdminBotanyMain', array_merge($this->data, $data));
    }

    public function BotanyOnoff()
    {
        $id = $this->request->getPost('Keystatus');
        $status = $this->request->getPost('Onoffstatus');
        
        $update = $this->BotanyModel->update($id, ['botany_status' => $status]);
        echo $id;
    }

    public function BotanyAdd()
    {
        $imageFile = $this->request->getFile('botany_image');
        $imageName = '';

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $path = FCPATH . 'uploads/botany/';
            $imageFile->move($path, $imageName);
            $this->optimizeImage($path, $imageName); // Optimize
        }

        $dataSave = [
            'botany_name_th' => $this->request->getPost('botany_name_th'),
            'botany_name_en' => $this->request->getPost('botany_name_en'),
            'botany_science_name' => $this->request->getPost('botany_science_name'),
            'botany_family' => $this->request->getPost('botany_family'),
            'botany_description' => $this->request->getPost('botany_description'),
            'botany_benefit' => $this->request->getPost('botany_benefit'),
            'botany_type' => $this->request->getPost('botany_type'),
            'botany_location' => $this->request->getPost('botany_location'),
            'botany_image' => $imageName,
            'botany_status' => 'active'
        ];

        $insert = $this->BotanyModel->insert($dataSave);

        if ($insert) {
            return $this->response->setJSON(['status' => true, 'message' => 'บันทึกข้อมูลพรรณไม้สำเร็จ!']);
        } else {
            return $this->response->setJSON(['status' => false, 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
        }
    }

    public function BotanyEdit()
    {
        $id = $this->request->getPost('KeyBotanyid');
        $data = $this->BotanyModel->find($id);
        return $this->response->setJSON($data);
    }

    public function BotanyUpdate()
    {
        $id = $this->request->getPost('botany_id');
        $originalImg = $this->request->getPost('original_botany_image');
        $imageFile = $this->request->getFile('botany_image');
        
        $dataUpdate = [
            'botany_name_th' => $this->request->getPost('botany_name_th'),
            'botany_name_en' => $this->request->getPost('botany_name_en'),
            'botany_science_name' => $this->request->getPost('botany_science_name'),
            'botany_family' => $this->request->getPost('botany_family'),
            'botany_description' => $this->request->getPost('botany_description'),
            'botany_benefit' => $this->request->getPost('botany_benefit'),
            'botany_type' => $this->request->getPost('botany_type'),
            'botany_location' => $this->request->getPost('botany_location'),
        ];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Delete old image
            if ($originalImg && file_exists(FCPATH . 'uploads/botany/' . $originalImg)) {
                @unlink(FCPATH . 'uploads/botany/' . $originalImg);
            }

            $imageName = $imageFile->getRandomName();
            $path = FCPATH . 'uploads/botany/';
            $imageFile->move($path, $imageName);
            $this->optimizeImage($path, $imageName); // Optimize
            $dataUpdate['botany_image'] = $imageName;
        }

        $update = $this->BotanyModel->update($id, $dataUpdate);

        if ($update) {
            return $this->response->setJSON(['status' => true, 'message' => 'อัปเดตข้อมูลพรรณไม้สำเร็จ!']);
        } else {
            return $this->response->setJSON(['status' => false, 'message' => 'อัปเดตข้อมูลไม่สำเร็จ']);
        }
    }

    public function BotanyDelete()
    {
        $id = $this->request->getPost('KeyBotanyid');
        $plant = $this->BotanyModel->find($id);
        
        if ($plant && $plant->botany_image) {
            @unlink(FCPATH . 'uploads/botany/' . $plant->botany_image);
        }
        
        $delete = $this->BotanyModel->delete($id);
        echo $delete;
    }

    // --- News Management ---

    public function NewsList()
    {
        $data['title'] = "จัดการกิจกรรมและข่าวสาร";
        $data['description'] = "เพิ่ม ลบ แก้ไข ข่าวสารกิจกรรมสวนพฤกษศาสตร์";
        $data['news'] = $this->BotanyNewsModel->orderBy('news_date', 'DESC')->findAll();

        return view('Admin/PageAdminBotany/PageAdminBotanyNews', array_merge($this->data, $data));
    }

    public function NewsAdd()
    {
        $imageFile = $this->request->getFile('news_img');
        $imageName = '';

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $path = FCPATH . 'uploads/botany/news/';
            $imageFile->move($path, $imageName);
            $this->optimizeImage($path, $imageName); // Optimize
        }

        $dataSave = [
            'news_title' => $this->request->getPost('news_title'),
            'news_content' => $this->request->getPost('news_content'),
            'news_date' => $this->request->getPost('news_date'),
            'news_img' => $imageName,
            'news_status' => 'active'
        ];

        $insertId = $this->BotanyNewsModel->insert($dataSave);
        
        // Handle Album Images
        $albumFiles = $this->request->getFileMultiple('news_album');
        if ($albumFiles) {
            foreach ($albumFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $path = FCPATH . 'uploads/botany/news/album/';
                    $file->move($path, $newName);
                    $this->optimizeImage($path, $newName, 1000); // Album images slightly smaller
                    $this->BotanyNewsImageModel->insert([
                        'news_id' => $insertId,
                        'img_path' => $newName,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        return $this->response->setJSON(['status' => $insertId ? true : false, 'message' => $insertId ? 'บันทึกข่าวและอัลบั้มสำเร็จ!' : 'เกิดข้อผิดพลาด']);
    }

    public function NewsEdit()
    {
        $id = $this->request->getPost('KeyNewsid');
        $data['news'] = $this->BotanyNewsModel->find($id);
        $data['images'] = $this->BotanyNewsImageModel->getImagesByNews($id);
        return $this->response->setJSON($data);
    }

    public function NewsUpdate()
    {
        $id = $this->request->getPost('news_id');
        $originalImg = $this->request->getPost('original_news_img');
        $imageFile = $this->request->getFile('news_img');
        
        $dataUpdate = [
            'news_title' => $this->request->getPost('news_title'),
            'news_content' => $this->request->getPost('news_content'),
            'news_date' => $this->request->getPost('news_date'),
        ];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            if ($originalImg && file_exists(FCPATH . 'uploads/botany/news/' . $originalImg)) {
                @unlink(FCPATH . 'uploads/botany/news/' . $originalImg);
            }
            $imageName = $imageFile->getRandomName();
            $path = FCPATH . 'uploads/botany/news/';
            $imageFile->move($path, $imageName);
            $this->optimizeImage($path, $imageName); // Optimize
            $dataUpdate['news_img'] = $imageName;
        }

        $update = $this->BotanyNewsModel->update($id, $dataUpdate);

        // Handle New Album Images
        $albumFiles = $this->request->getFileMultiple('news_album');
        if ($albumFiles) {
            foreach ($albumFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $path = FCPATH . 'uploads/botany/news/album/';
                    $file->move($path, $newName);
                    $this->optimizeImage($path, $newName, 1000); // Optimize
                    $this->BotanyNewsImageModel->insert([
                        'news_id' => $id,
                        'img_path' => $newName,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        return $this->response->setJSON(['status' => $update ? true : false, 'message' => $update ? 'อัปเดตข่าวและอัลบั้มสำเร็จ!' : 'เกิดข้อผิดพลาด']);
    }

    public function NewsDelete()
    {
        $id = $this->request->getPost('KeyNewsid');
        $news = $this->BotanyNewsModel->find($id);
        if ($news && $news->news_img) {
            @unlink(FCPATH . 'uploads/botany/news/' . $news->news_img);
        }

        // Delete Album Images
        $albumImages = $this->BotanyNewsImageModel->getImagesByNews($id);
        foreach ($albumImages as $img) {
            @unlink(FCPATH . 'uploads/botany/news/album/' . $img->img_path);
            $this->BotanyNewsImageModel->delete($img->img_id);
        }

        $delete = $this->BotanyNewsModel->delete($id);
        echo $delete;
    }

    public function NewsDeleteImage()
    {
        $id = $this->request->getPost('KeyImgid');
        $img = $this->BotanyNewsImageModel->find($id);
        if ($img) {
            @unlink(FCPATH . 'uploads/botany/news/album/' . $img->img_path);
            $delete = $this->BotanyNewsImageModel->delete($id);
            return $this->response->setJSON(['status' => $delete ? true : false]);
        }
        return $this->response->setJSON(['status' => false]);
    }

    public function NewsOnoff()
    {
        $id = $this->request->getPost('Keystatus');
        $status = $this->request->getPost('Onoffstatus');
        
        $update = $this->BotanyNewsModel->update($id, ['news_status' => $status]);
        echo $id;
    }
}
