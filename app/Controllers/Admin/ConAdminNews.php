<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;

class ConAdminNews extends \App\Controllers\BaseController
{
    public function __construct(){
        $this->NewsModel = new NewsModel();
        $this->AboutModel = new AboutModel();
        $this->NewsImageModel = new \App\Models\NewsImageModel();
        
        // Ensure table exists
        $db = \Config\Database::connect();
        $db->query("CREATE TABLE IF NOT EXISTS tb_news_images (
            news_img_id INT AUTO_INCREMENT PRIMARY KEY,
            news_id VARCHAR(50) NOT NULL,
            news_img_name VARCHAR(255) NOT NULL,
            news_img_created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Ensure album directory exists
        $albumPath = FCPATH . 'uploads/news/album';
        if (!is_dir($albumPath)) {
            mkdir($albumPath, 0777, true);
        }
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
       
        $imageFile = $this->request->getFile('news_img');
        
        // ถ้ามีการอัปโหลดไฟล์มา ให้ตรวจสอบ
        if ($imageFile && $imageFile->isValid()) {
            $validateImg = $this->validate([
                'news_img' => [
                    'uploaded[news_img]',
                    'mime_in[news_img,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[news_img,4096]', // เพิ่มการเช็คขนาดไม่เกิน 4MB
                ]
            ]);

            if (!$validateImg) {           
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไฟล์รูปภาพไม่ถูกต้อง หรือขนาดใหญ่เกินไป (รองรับ jpg, jpeg, png, gif, webp)'
                ]);
            }

            // ถ้าผ่านการตรวจสอบ และไฟล์ยังไม่ได้ถูกย้าย
            if (!$imageFile->hasMoved()) {
                $RandomName = $imageFile->getRandomName();

                \Config\Services::image()
                    ->withFile($imageFile)
                    ->fit(1920, 1080, 'top')
                    ->save(FCPATH.'/uploads/news/'. $RandomName);
                
                $data = [
                   'news_id' => $NewsIdNew,
                   'news_img' => $RandomName,
                   'news_topic' =>  $this->request->getPost('news_topic'),
                   'news_content' => $this->request->getPost('news_content'),
                   'news_date' => $this->request->getPost('news_date'),
                   'news_category' => $this->request->getPost('news_category'),
                   'personnel_id' => session('AdminID')
                ];
                $builder->insert($data);
            }
        } else {
            // กรณีไม่ได้อัปโหลดรูปหน้าปกมา
            $data = [
                'news_id' => $NewsIdNew,
                'news_topic' =>  $this->request->getPost('news_topic'),
                'news_content' => $this->request->getPost('news_content'),
                'news_date' => $this->request->getPost('news_date'),
                'news_category' => $this->request->getPost('news_category'),
                'personnel_id' => session('AdminID')
            ];
            $builder->insert($data);
        }

        // --- ส่วนจัดการ Album (ทำต่อไม่ว่าจะมีรูปปกหรือไม่) ---
        $albumFiles = $this->request->getFiles();
        if (isset($albumFiles['news_album'])) {
            foreach ($albumFiles['news_album'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    try {
                        \Config\Services::image()->withFile($file)->fit(1200, 800, 'center')->save(FCPATH . '/uploads/news/album/' . $newName);
                        $this->NewsImageModel->insert([
                            'news_id' => $NewsIdNew,
                            'news_img_name' => $newName
                        ]);
                    } catch (\Exception $e) { /* จัดการ error ถ้าย่อรูปไม่ได้ */ }
                }
            }
        }

        $newData = $builder->where('news_id', $NewsIdNew)->get()->getRowArray();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'บันทึกข่าวสำเร็จ!',
            'data' => $newData
        ]);
    }

    public function NewsEdit(){
        $KeyNewsid = $this->request->getPost('KeyNewsid');
        $EditNews = $this->NewsModel->select('*,CAST(news_date AS DATE) AS news_dateNews')->where('news_id',$KeyNewsid)->get()->getResult();
        
        // Check if image physical file exists
        foreach ($EditNews as $news) {
            // ใช้ / นำหน้าเพื่อความชัวร์ (Double slash ไม่มีผลเสีย แต่ missing slash หาไฟล์ไม่เจอ)
            if ($news->news_img && !file_exists(FCPATH . '/uploads/news/' . $news->news_img)) {
                // $news->news_img = ''; // comment ออกชั่วคราวเพื่อให้เห็นชื่อไฟล์แม้หาไม่เจอ (debug) หรือเปิดไว้ถ้าต้องการ logic เดิม
                // แต่ถ้าไฟล์มีอยู่จริงแต่ code หาไม่เจอ การ comment บรรทัดนี้จะช่วยให้รูปยังโชว์ได้ถ้ารูป URL ถูก
            }
        }

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
        
        // --- DEBUG LOG START ---
        // เช็คว่าเจอ URL อะไรบ้าง (ดูใน Log File)
        log_message('error', 'OLD URLs (' . count($oldImageUrls) . '): ' . print_r($oldImageUrls, true));
        log_message('error', 'NEW URLs (' . count($newImageUrls) . '): ' . print_r($newImageUrls, true));
        log_message('error', 'TO DELETE (' . count($imagesToDelete) . '): ' . print_r($imagesToDelete, true));
        // --- DEBUG LOG END ---

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
                    'mime_in[edit_news_img,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[edit_news_img,4096]',
                ]
            ]);

            if (!$validateImg) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไฟล์รูปภาพไม่ถูกต้อง หรือขนาดใหญ่เกินไป (รองรับ jpg, jpeg, png, gif, webp)'
                ]);
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

        // Handle Album Images
        $albumFiles = $this->request->getFiles();
        if (isset($albumFiles['news_album'])) {
            foreach ($albumFiles['news_album'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    \Config\Services::image()->withFile($file)->fit(1200, 800, 'center')->save(FCPATH . '/uploads/news/album/' . $newName);
                    $this->NewsImageModel->insert([
                        'news_id' => $id,
                        'news_img_name' => $newName
                    ]);
                }
            }
        }

        $updatedData = $builder->where('news_id', $id)->get()->getRowArray();

        return $this->response->setJSON([
            'status' => $save ? true : false,
            'message' => $save ? 'อัปเดตข่าวสำเร็จ!' : 'อัปเดตข่าวไม่สำเร็จ!',
            'data' => $updatedData
        ]);
    }

    // Helper function to extract image URLs from HTML content
    private function extractImageUrls($htmlContent)
    {
        $urls = [];
        // ปรับ Regex ให้รองรับทั้ง " และ '
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $htmlContent, $matches);
        foreach ($matches[1] as $imageUrl) {
            // Decode URL เพื่อให้เปรียบเทียบได้ถูกต้อง (แก้ปัญหา %20 หรือภาษาไทย)
            $decodedUrl = urldecode($imageUrl);
            
            // ครอบคลุมรูปภาพทั้งหมดที่อยู่ใน uploads/news/ ไม่ว่าจะใน subfolder ไหนก็ตาม
            if (strpos($decodedUrl, 'uploads/news/') !== false) {
                $urls[] = $decodedUrl;
            }
        }
        return $urls;
    }

    // Helper function to delete image file from server given its URL
    private function deleteImageFile($imageUrl)
    {
        // 1. Decode URL เพื่อให้เป็น text ปกติ (แก้ %20 etc.)
        $imageUrl = urldecode($imageUrl);
        
        // 2. มองหาจุดเริ่มต้นของ folder uploads/news/
        $keyword = 'uploads/news/';
        $pos = strpos($imageUrl, $keyword);
        
        if ($pos !== false) {
            // 3. ตัดเอาเฉพาะ Path ตั้งแต่ uploads/news/ เป็นต้นไป
            $relativePath = substr($imageUrl, $pos); // เช่น uploads/news/content/abc.jpg
            
            // 4. ลบ Query string ทิ้ง (ถ้ามี เช่น ?v=1)
            $relativePath = explode('?', $relativePath)[0];
            $relativePath = explode('#', $relativePath)[0];
            
            // 5. ปรับ Slash ให้ตรงกับ Windows/Linux
            if (DIRECTORY_SEPARATOR === '\\') {
                $relativePath = str_replace('/', '\\', $relativePath);
            }
            
            // 6. เตรียม Path ที่เป็นไปได้ทั้ง 2 แบบ (Public หรือ Root)
            $pathsToCheck = [
                FCPATH . $relativePath,     // D:\SkjSystem\skj2025\public\uploads\news\...
                ROOTPATH . $relativePath    // D:\SkjSystem\skj2025\uploads\news\...
            ];
            
            $deleted = false;
            foreach ($pathsToCheck as $fullPath) {
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                    $deleted = true;
                    log_message('error', 'Deleted File at: ' . $fullPath);
                    break; // เจอและลบแล้ว จบเลย
                }
            }
            
            if (!$deleted) {
                log_message('error', 'File not found in FCPATH or ROOTPATH: ' . $relativePath);
            }
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

            // 3. Delete Album images
            $albumImages = $this->NewsImageModel->where('news_id', $id)->findAll();
            foreach ($albumImages as $img) {
                if (file_exists(FCPATH . 'uploads/news/album/' . $img['news_img_name'])) {
                    @unlink(FCPATH . 'uploads/news/album/' . $img['news_img_name']);
                }
            }
            $this->NewsImageModel->where('news_id', $id)->delete();

            // 4. Delete the news record from the database
            $result = $this->NewsModel->delete(['news_id' => $id]);
            return $this->response->setJSON([
                'status' => $result ? true : false,
                'message' => $result ? 'ลบข่าวสำเร็จ!' : 'ลบข่าวไม่สำเร็จ!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ไม่พบข้อมูลข่าว'
            ]);
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
        $url = "https://graph.facebook.com/v18.0/$page_id/posts?fields=id,message,created_time,full_picture,attachments&access_token=$access_token";
        
        // ตรวจสอบการดึงข้อมูล
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            // ส่ง JSON error กลับไปแทนการ echo ข้อความ เพื่อให้ JS จัดการได้
            return $this->response->setJSON([
                'error' => 'Error fetching data from Facebook. Please check your Access Token and Page ID.'
            ]);
        } else {
            // $response เป็น JSON String จาก Facebook
            // เพื่อความปลอดภัยและ Compatibility สูงสุด ให้ decode เป็น array ก่อนแล้วให้ CI4 encode กลับเป็น JSON
            // วิธีนี้ช่วยจัดการ header และ charset ให้ถูกต้องอัตโนมัติ
            $data = json_decode($response, true);
            return $this->response->setJSON($data);
        }
    }

    public function SelectNewsFormFacebook(){

        $access_token = "EAADjhb2HZCFABO8GJfcN3oL964ZAtJUWt9WbpfvGqIgxnXroVx7OXNSb7ySYMZCOMnh20ymyXLoH6dxtQYtG9oInZAugNqMuddOdOFNtutZBpdqgA7WbvR175W5sOX4CsZACvnQbQNynPLsZAPXZCZBHaJugVxiO2P0XrCeYyVIH5XfUfiRZBLJkqNZB0X5xPg2OvEerELGhtqcWhpZCSZC4ZD";
        $page_id = $this->request->getVar('KeyNewsFB');
        $url = "https://graph.facebook.com/v18.0/{$page_id}?fields=id,message,created_time,full_picture,attachments&access_token={$access_token}";

        
        // ตรวจสอบการดึงข้อมูล
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            // ส่ง JSON error กลับไปแทนการ echo ข้อความ
            return $this->response->setJSON([
                'error' => 'Error fetching data from Facebook. Please check your Access Token and Page ID.'
            ]);
        } else {
             // Decode ก่อนแล้วส่งผ่าน setJSON
             $data = json_decode($response, true);
             return $this->response->setJSON($data);
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
        
        $randomFileName = uniqid('fb_', true) . '.jpg'; 
        $savePath = FCPATH . 'uploads/news/'. $randomFileName; // ใช้ FCPATH เพื่อความชัวร์
            
        // ใช้ helper function ที่มี context header เพื่อโหลดรูปจาก FB
        $downloadSuccess = $this->downloadFacebookImage($imageUrl, $savePath);

        if (!$downloadSuccess) {
             // ถ้าโหลดไม่ได้ ให้ลองใช้ copy ธรรมดาเป็น fallback เผื่อไว้
             if (!@copy($imageUrl, $savePath)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไม่สามารถบันทึกรูปภาพจาก Facebook ได้'
                ]);
             }
        }
       
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
        
        $builder->insert($data);
        $newData = $builder->where('news_id', $NewsIdNew)->get()->getRowArray();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'ดึงข้อมูลจาก Facebook และบันทึกสำเร็จ!',
            'data' => $newData
        ]);
    }

    // ฟังก์ชันล้างรูปภาพขยะ (ไฟล์ที่ไม่ได้ถูกใช้งานใน Database)
    public function CleanUnusedImages()
    {
        // 1. รวบรวมรายชื่อไฟล์รูปที่ "ถูกใช้งานจริง" จาก Database
        $usedFiles = [];
        $newsList = $this->NewsModel->findAll(); // ดึงข่าวทั้งหมด
        $newsImagesList = $this->NewsImageModel->findAll(); // ดึงอัลบั้มทั้งหมด

        foreach ($newsList as $news) {
            // 1.1 รูปปก
            if (!empty($news['news_img'])) {
                $usedFiles[] = $news['news_img']; 
            }
            
            // 1.2 รูปในเนื้อหาข่าว (HTML Content)
            if (!empty($news['news_content'])) {
                // regex หา src="..."
                preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $news['news_content'], $matches);
                foreach ($matches[1] as $url) {
                    $decodedUrl = urldecode($url);
                    // extract filename
                    $pathParts = explode('/', $decodedUrl);
                    $filename = end($pathParts); // เอาตัวสุดท้ายหลัง /
                    // ลบ query string ถ้ามี
                    $filename = explode('?', $filename)[0];
                    $filename = urldecode($filename);
                    
                    if ($filename) {
                        $usedFiles[] = $filename;
                    }
                }
            }
        }

        // 1.3 รูปในอัลบั้ม
        foreach ($newsImagesList as $albumImg) {
            if (!empty($albumImg['news_img_name'])) {
                $usedFiles[] = $albumImg['news_img_name'];
            }
        }
        
        $usedFiles = array_unique($usedFiles);

        // 2. โฟลเดอร์เป้าหมาย
        $scanDirs = [
            FCPATH . 'uploads/news/', 
            FCPATH . 'uploads/news/content/',
            FCPATH . 'uploads/news/album/'
        ];

        $deletedCount = 0;
        $deletedSize = 0;

        foreach ($scanDirs as $dir) {
            if (!is_dir($dir)) continue;

            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                if (is_dir($dir . $file)) continue;

                // 3. ถ้าไม่อยู่ใน Used List = ขยะ
                if (!in_array($file, $usedFiles)) {
                    $filePath = $dir . $file;
                    $fileSize = filesize($filePath);
                    
                    if (@unlink($filePath)) {
                        $deletedCount++;
                        $deletedSize += $fileSize;
                    }
                }
            }
        }
        
        $sizeFormatted = number_format($deletedSize / 1024 / 1024, 2) . ' MB';

        return $this->response->setJSON([
            'status' => true,
            'message' => "ลบไฟล์ขยะเสร็จสิ้น! จำนวน $deletedCount ไฟล์ (ขนาด $sizeFormatted)"
        ]);
    }

    public function NewsAlbumGet()
    {
        $news_id = $this->request->getPost('news_id');
        $images = $this->NewsImageModel->where('news_id', $news_id)->orderBy('news_img_id', 'DESC')->findAll();
        
        // Filter only existing files
        $existingImages = array_filter($images, function($img) {
            return file_exists(FCPATH . 'uploads/news/album/' . $img['news_img_name']);
        });

        return $this->response->setJSON(array_values($existingImages));
    }

    public function NewsAlbumDelete()
    {
        $id = $this->request->getPost('img_id');
        $img = $this->NewsImageModel->find($id);
        if ($img) {
            if (file_exists(FCPATH . 'uploads/news/album/' . $img['news_img_name'])) {
                @unlink(FCPATH . 'uploads/news/album/' . $img['news_img_name']);
            }
            $this->NewsImageModel->delete($id);
            return $this->response->setJSON(['status' => true, 'message' => 'ลบรูปภาพสำเร็จ']);
        }
        return $this->response->setJSON(['status' => false, 'message' => 'ไม่พบรูปภาพ']);
    }

}