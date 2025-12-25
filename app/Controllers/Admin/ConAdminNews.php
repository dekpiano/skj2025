<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;

class ConAdminNews extends \App\Controllers\BaseController
{
    public function __construct(){
        $this->NewsModel = new NewsModel();
        $this->AboutModel = new AboutModel();
    }

    public function NewsMain()
    {        
        $data['title'] = "ข่าวประชาสัมพันธ์";
        $data['description'] = "รวมข่าวประชาสัมพันธ์ กิจกรรมต่าง ๆ ของโรงเรียน";
        $data['news'] = $this->NewsModel->orderBy('news_date', 'DESC')->get()->getResult();
        
        return view('Admin/PageAdminNews/PageAdminNewsMain', array_merge($this->data, $data));
    }

    public function NewsAdd(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_news');
        $checkID = $builder->select('news_id')->orderBy('news_id','DESC')->get()->getRow();
        if($checkID){
            $ex = explode('_',$checkID->news_id);
            $NewsIdNew = 'news_'.@sprintf("%03d",$ex[1]+1);
        }else{
            $NewsIdNew = 'news_001';
        }
       
        $validateImg = $this->validate([
            'news_img' => [
                'uploaded[news_img]',
            ]
        ]);

        if (!$validateImg) {           
           print_r('กรุณาอัปโหลดไฟล์รูปภาพ (jpg, jpeg, png, gif)');
        } else {
            
            $imageFile = $this->request->getFile('news_img'); 
       
            if($imageFile->isValid() && !$imageFile->hasMoved()){
                $RandomName = $imageFile->getRandomName();

                \Config\Services::image()
                    ->withFile($imageFile)
                    ->fit(1920, 1080, 'top')
                    ->save(FCPATH.'/uploads/news/'. $RandomName);
                
                $NameImg = $RandomName;
   
                $data = [
                   'news_id' => $NewsIdNew,
                   'news_img' => $NameImg,
                   'news_topic' =>  $this->request->getPost('news_topic'),
                   'news_content' => $this->request->getPost('news_content'),
                   'news_date' => $this->request->getPost('news_date'),
                   'news_category' => $this->request->getPost('news_category'),
                   'personnel_id' => session('AdminID')
                ];
                $save = $builder->insert($data);
                echo $save;
            } else {
                $data = [
                    'news_id' => $NewsIdNew,
                    'news_topic' =>  $this->request->getPost('news_topic'),
                    'news_content' => $this->request->getPost('news_content'),
                    'news_date' => $this->request->getPost('news_date'),
                    'news_category' => $this->request->getPost('news_category'),
                    'personnel_id' => session('AdminID')
                ];
                $save = $builder->insert($data);
                echo $save;
            }
        }
    }

    public function NewsEdit(){
        $KeyNewsid = $this->request->getPost('KeyNewsid');
        $EditNews = $this->NewsModel->select('*,CAST(news_date AS DATE) AS news_dateNews')->where('news_id',$KeyNewsid)->get()->getResult();
        echo json_encode($EditNews);
        
    }

    public function NewsUpdate(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_news');
        
        $id = $this->request->getPost('edit_news_id');
        $imageFile = $this->request->getFile('edit_news_img');
        $newContent = $this->request->getPost('edit_news_content');

        // Fetch old news content to compare images
        $oldNewsItem = $this->NewsModel->select('news_content')->where('news_id', $id)->first();
        $oldContent = $oldNewsItem ? $oldNewsItem['news_content'] : '';

        // Extract image URLs from old and new content
        $oldImageUrls = $this->extractImageUrls($oldContent);
        $newImageUrls = $this->extractImageUrls($newContent);

        // Identify images to delete (present in old but not in new)
        $imagesToDelete = array_diff($oldImageUrls, $newImageUrls);

        // Delete identified images from server
        foreach ($imagesToDelete as $imageUrl) {
            $this->deleteImageFile($imageUrl);
        }

        $updateData = [
            'news_topic' =>  $this->request->getPost('edit_news_topic'),
            'news_content' => $newContent,
            'news_date' => $this->request->getPost('edit_news_date'),
            'news_category' => $this->request->getPost('edit_news_category'),
            'personnel_id' => session('AdminID')
        ];

        // Check if a new image is uploaded for cover
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Validate the new image
            $validateImg = $this->validate([
                'edit_news_img' => [
                    'uploaded[edit_news_img]',
                    'mime_in[edit_news_img,image/jpg,image/jpeg,image/png,image/gif]',
                ]
            ]);

            if (!$validateImg) {
                print_r('กรุณาอัปโหลดไฟล์รูปภาพที่ถูกต้อง (jpg, jpeg, png, gif)');
                return;
            }

            // Delete the old cover image
            $oldCoverImage = $this->request->getPost('original_news_img');
            if ($oldCoverImage && file_exists(FCPATH.'/uploads/news/' . $oldCoverImage)) {
                @unlink(FCPATH.'/uploads/news/' . $oldCoverImage);
            }

            // Process and save the new cover image
            $RandomName = $imageFile->getRandomName();
            \Config\Services::image()
                ->withFile($imageFile)
                ->fit(1920, 1080, 'center')
                ->save(FCPATH.'/uploads/news/'. $RandomName);

            $updateData['news_img'] = $RandomName;
        }

        $builder->where('news_id', $id);
        $save = $builder->update($updateData);
        echo $save;
    }

    // Helper function to extract image URLs from HTML content
    private function extractImageUrls($htmlContent)
    {
        $urls = [];
        preg_match_all('/<img[^>]+src="([^"]+)"/', $htmlContent, $matches);
        foreach ($matches[1] as $imageUrl) {
            // Only consider URLs that are from our uploads/news/content directory
            // We'll extract the filename later for deletion
            if (strpos($imageUrl, 'uploads/news/content/') !== false) {
                $urls[] = $imageUrl;
            }
        }
        return $urls;
    }

    // Helper function to delete image file from server given its URL
    private function deleteImageFile($imageUrl)
    {
        // Extract filename from URL
        $filename = basename(parse_url($imageUrl, PHP_URL_PATH));
        $filePath = FCPATH . 'uploads/news/content/' . $filename;

        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }

    public function uploadImage()
    {
        // First, check if the GD library is available
        if (!extension_loaded('gd')) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'PHP GD library is not enabled on the server.']);
        }

        $imageFile = $this->request->getFile('image');

        // Check if the file is null - this can happen if the upload exceeds server limits.
        if ($imageFile === null) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No file was uploaded. This might be due to server size limits (upload_max_filesize in php.ini).']);
        }

        if (!$imageFile->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid file or no file uploaded']);
        }

        if ($imageFile->hasMoved()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File has already been moved']);
        }

        $RandomName = $imageFile->getRandomName();
        $uploadPath = rtrim(FCPATH, '/') . '/uploads/news/content/';

        // Ensure the upload directory exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Verify the directory exists and is writable
        if (!is_dir($uploadPath) || !is_writable($uploadPath)) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to create or write to upload directory: ' . $uploadPath]);
        }

        try {
            \Config\Services::image()
                ->withFile($imageFile)
                //->fit(1920, 1080, 'center') // Resize to 1920x1080, maintaining aspect ratio
                ->save($uploadPath . $RandomName);

            return $this->response->setJSON([
                'url' => base_url('uploads/news/content/' . $RandomName)
            ]);
        } catch (\Throwable $e) { // Catch all throwable errors
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Image processing failed: ' . $e->getMessage()]);
        }
    }

    public function NewsDelete(){
        $id = $this->request->getPost('KeyNewsid');
        // Fetch news_img and news_content
        $newsItem = $this->NewsModel->select('news_img, news_content')->where('news_id', $id)->first();

        if ($newsItem) {
            // 1. Delete cover image
            if (!empty($newsItem['news_img'])) {
                $coverImagePath = FCPATH . 'uploads/news/' . $newsItem['news_img'];
                if (file_exists($coverImagePath)) {
                    @unlink($coverImagePath);
                }
            }

            // 2. Delete embedded images from news_content
            if (!empty($newsItem['news_content'])) {
                // Use regex to parse HTML and find image URLs
                preg_match_all('/<img[^>]+src="([^"]+)"/', $newsItem['news_content'], $matches);

                foreach ($matches[1] as $imageUrl) {
                    // Convert URL to local file path
                    // Assuming images are stored in uploads/news/content/
                    $base_url_length = strlen(base_url());
                    if (substr($imageUrl, 0, $base_url_length) === base_url()) {
                        $relativePath = substr($imageUrl, $base_url_length); // e.g., uploads/news/content/some_image.jpg
                        $embeddedImagePath = FCPATH . $relativePath;

                        if (file_exists($embeddedImagePath)) {
                            @unlink($embeddedImagePath);
                        }
                    }
                }
            }

            // 3. Delete the news record from the database
            $result = $this->NewsModel->delete(['news_id' => $id]);
            echo $result;
        } else {
            echo 0; // News item not found
        }
    }

    public function deleteImage()
    {
        $this->response->setContentType('application/json');
        $input = $this->request->getJSON();
        $imageUrl = $input->imageUrl ?? null;

        if ($imageUrl) {
            // แยกชื่อไฟล์ออกจาก URL
            // ตัวอย่าง URL: http://localhost/skj2022/uploads/news/content/my_image.jpg
            // เราต้องการแค่ my_image.jpg
            $fileName = basename(parse_url($imageUrl, PHP_URL_PATH));
            $filePath = FCPATH . 'uploads/news/content/' . $fileName; // FCPATH คือ path ไปยัง public folder

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Image deleted successfully.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete image file.']);
                }
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Image file not found at: ' . $filePath]);
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid image URL.']);
    }


    public function ViewNewsFormFacebook(){
        // ดึงโพสต์จาก Facebook Graph API ถาวร
        $access_token = "EAADjhb2HZCFABO8GJfcN3oL964ZAtJUWt9WbpfvGqIgxnXroVx7OXNSb7ySYMZCOMnh20ymyXLoH6dxtQYtG9oInZAugNqMuddOdOFNtutZBpdqgA7WbvR175W5sOX4CsZACvnQbQNynPLsZAPXZCZBHaJugVxiO2P0XrCeYyVIH5XfUfiRZBLJkqNZB0X5xPg2OvEerELGhtqcWhpZCSZC4ZD";
        $page_id = "230288483730783";
        $url = "https://graph.facebook.com/v12.0/$page_id/posts?fields=id,message,created_time,full_picture,attachments&access_token=$access_token";
        
        // ตรวจสอบการดึงข้อมูล
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            // แสดงข้อความข้อผิดพลาดหากเกิดข้อผิดพลาดในการดึงข้อมูล
            echo "Error fetching data from Facebook. Please check your Access Token and Page ID.";
        } else {
            echo json_encode($response, true);

        }
    }

    public function SelectNewsFormFacebook(){

        $access_token = "EAADjhb2HZCFABO8GJfcN3oL964ZAtJUWt9WbpfvGqIgxnXroVx7OXNSb7ySYMZCOMnh20ymyXLoH6dxtQYtG9oInZAugNqMuddOdOFNtutZBpdqgA7WbvR175W5sOX4CsZACvnQbQNynPLsZAPXZCZBHaJugVxiO2P0XrCeYyVIH5XfUfiRZBLJkqNZB0X5xPg2OvEerELGhtqcWhpZCSZC4ZD";
        $page_id = $this->request->getVar('KeyNewsFB');
        $url = "https://graph.facebook.com/{$page_id}?fields=id,message,created_time,full_picture,attachments&access_token={$access_token}";

        
        // ตรวจสอบการดึงข้อมูล
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            // แสดงข้อความข้อผิดพลาดหากเกิดข้อผิดพลาดในการดึงข้อมูล
            echo "Error fetching data from Facebook. Please check your Access Token and Page ID.";
        } else {
            echo json_encode($response, true);

        }

    }

     function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
        }
        return $mixed;
    }


    function downloadFacebookImage($imageUrl, $savePath) {
        $context = stream_context_create([
            "http" => [
                "header" => "User-Agent: Mozilla/5.0" // บางกรณี Facebook จะไม่ให้โหลดถ้าไม่มี User-Agent
            ]
        ]);
        $imageContent = file_get_contents($imageUrl, false, $context);
        if ($imageContent === false) {
            return false;
        }
        return file_put_contents($savePath, $imageContent);
    }

    public function NewsAddFeacbook(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_news');
        $checkID = $builder->select('news_id')->orderBy('news_id','DESC')->get()->getRow();
        if($checkID){
            $ex = explode('_',$checkID->news_id);
            $NewsIdNew = 'news_'.@sprintf("%03d",$ex[1]+1);
        }else{
            $NewsIdNew = 'news_001';
        }
      
            $imageUrl = $this->request->getPost('news_img_facebook'); // ใส่ URL รูปภาพที่ต้องการดาวน์โหลด
            if (empty($imageUrl)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไม่พบ URL รูปภาพ'
                ]);
            }
            $randomFileName = uniqid('image_', true) . '.jpg'; 
            $savePath = 'uploads/news/'. $randomFileName; // กำหนดโฟลเดอร์และชื่อไฟล์
            
         if (copy($imageUrl, $savePath)) {
        echo "บันทึกสำเร็จ!";
        } else {
            echo "บันทึกไม่สำเร็จ!";
        }
       
        // exit();
        $data = [
            'news_id' => $NewsIdNew,
            'news_img' => $randomFileName,
            'news_facebook' => $this->request->getVar('sel_NewsFromFacebook'),
            'news_topic' =>  $this->request->getVar('news_topic_facebook'),
            'news_content' => $this->request->getVar('news_content_facebook'),
            'news_date' => $this->request->getVar('news_date_facebook'),
            'news_category' => $this->request->getVar('news_category_facebook'),
            'personnel_id' => session('AdminID')
            ];
        $save = $builder->insert($data);
       
    }

}