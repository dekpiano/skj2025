<?php
namespace App\Controllers\Admin;
use App\Models\NewsModel;
use App\Models\AboutModel;
use App\Services\RemoteUploadService;

class ConAdminNews extends \App\Controllers\BaseController
{
    protected $NewsModel;
    protected $AboutModel;
    protected $NewsImageModel;

    public function __construct()
    {
        parent::__construct();
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

    /**
     * Optimize an image (resize + compress with quality 88 for crisp sharpness and small size)
     */
    private function optimizeImage(string $sourcePath, string $destinationPath, string $type = 'cover', int $quality = 88): bool
    {
        if (!file_exists($sourcePath) || filesize($sourcePath) === 0) {
            return false;
        }

        try {
            $imageService = \Config\Services::image();
            $image = $imageService->withFile($sourcePath);

            $origWidth  = (int) $image->getWidth();
            $origHeight = (int) $image->getHeight();

            if ($type === 'cover') {
                if ($origWidth >= $origHeight && $origWidth > 0 && $origHeight > 0) {
                    $image->fit(1920, 1080, 'center');
                } else {
                    $image->resize(1200, 1200, true, 'auto');
                }
            } elseif ($type === 'album') {
                if ($origWidth > 1600 || $origHeight > 1600) {
                    $image->resize(1600, 1600, true, 'auto');
                }
            } elseif ($type === 'content') {
                if ($origWidth > 1600) {
                    $image->resize(1600, 1600, true, 'width');
                }
            }

            $image->save($destinationPath, $quality);
            return file_exists($destinationPath) && filesize($destinationPath) > 0;
        } catch (\Throwable $e) {
            log_message('warning', 'Image optimization notice: ' . $e->getMessage());
            return @copy($sourcePath, $destinationPath);
        }
    }

    /**
     * Upload optimized file to remote server, falling back to local storage on failure
     */
    private function uploadFileToRemoteOrLocal(string $tempFilePath, string $remoteSubPath, string $filename, string $localFallbackDir): bool
    {
        if (!file_exists($tempFilePath)) {
            return false;
        }

        $remoteUpload = new RemoteUploadService();
        $res = $remoteUpload->uploadLocalFile($tempFilePath, $remoteSubPath, $filename);

        if (($res['status'] ?? '') === 'success') {
            return true;
        }

        // Fallback to local storage if remote server is unreachable
        log_message('warning', "Remote upload failed for {$filename}: " . ($res['message'] ?? 'Unknown error') . ". Saving to local fallback: {$localFallbackDir}");
        if (!is_dir($localFallbackDir)) {
            @mkdir($localFallbackDir, 0777, true);
        }
        return @copy($tempFilePath, rtrim($localFallbackDir, '/\\') . DIRECTORY_SEPARATOR . $filename);
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
            $suffix = isset($ex[1]) ? (int)$ex[1] : 0;
            $NewsIdNew = 'news_'.sprintf("%03d", $suffix + 1);
        }else{
            $NewsIdNew = 'news_001';
        }
       
        $imageFile = $this->request->getFile('news_img');
        $RandomName = null;
        
        // ถ้ามีการอัปโหลดไฟล์มา ให้ตรวจสอบ
        if ($imageFile && $imageFile->isValid()) {
            $validateImg = $this->validate([
                'news_img' => [
                    'uploaded[news_img]',
                    'mime_in[news_img,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[news_img,15360]', // รองรับไฟล์ภาพต้นฉบับถึง 15MB ก่อนนำมาบีบอัด
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
                $tempPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $RandomName;

                // 1. บีบอัดรูปภาพหน้าปกให้แจ่ม คมชัด (quality 88)
                $this->optimizeImage($imageFile->getTempName(), $tempPath, 'cover', 88);

                // 2. อัปโหลดขึ้น remote server โฟลเดอร์ 'news'
                $this->uploadFileToRemoteOrLocal($tempPath, 'news', $RandomName, FCPATH . 'uploads/news/');
                @unlink($tempPath);
            }
        }

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

        // --- ส่วนจัดการ Album ---
        $albumFiles = $this->request->getFiles();
        if (isset($albumFiles['news_album'])) {
            foreach ($albumFiles['news_album'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $tempAlbPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newName;
                    try {
                        // บีบอัดรูปภาพอัลบั้มให้สวย คมชัด สมส่วน (quality 88)
                        $this->optimizeImage($file->getTempName(), $tempAlbPath, 'album', 88);

                        // อัปโหลดขึ้น remote server 'news/album'
                        $this->uploadFileToRemoteOrLocal($tempAlbPath, 'news/album', $newName, FCPATH . 'uploads/news/album/');
                        @unlink($tempAlbPath);

                        $this->NewsImageModel->insert([
                            'news_id' => $NewsIdNew,
                            'news_img_name' => $newName
                        ]);
                    } catch (\Throwable $e) {
                        @unlink($tempAlbPath);
                    }
                }
            }
        }

        $newData = $builder->where('news_id', $NewsIdNew)->get()->getRowArray();
        if ($newData) {
            $newData['news_img_url'] = news_image_url($newData['news_img'] ?? '', 'cover');
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'บันทึกข่าวสำเร็จ!',
            'data' => $newData
        ]);
    }

    public function NewsEdit(){
        $KeyNewsid = $this->request->getPost('KeyNewsid');
        $EditNews = $this->NewsModel->select('*,CAST(news_date AS DATE) AS news_dateNews')->where('news_id',$KeyNewsid)->get()->getResult();
        
        foreach ($EditNews as $news) {
            $news->news_img_url = news_image_url($news->news_img, 'cover');
        }

        return $this->response->setJSON($EditNews);
    }

    public function NewsUpdate(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_news');
        
        $id = $this->request->getPost('edit_news_id');
        $imageFile = $this->request->getFile('edit_news_img');
        $newContent = $this->request->getPost('edit_news_content');

        // Fetch old news content to compare images
        $oldNewsItem = $this->NewsModel->select('news_content, news_img')->where('news_id', $id)->first();
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
            $validateImg = $this->validate([
                'edit_news_img' => [
                    'uploaded[edit_news_img]',
                    'mime_in[edit_news_img,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                    'max_size[edit_news_img,15360]',
                ]
            ]);

            if (!$validateImg) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไฟล์รูปภาพไม่ถูกต้อง หรือขนาดใหญ่เกินไป (รองรับ jpg, jpeg, png, gif, webp)'
                ]);
            }

            // Delete the old cover image (remote + local)
            $oldCoverImage = $this->request->getPost('original_news_img') ?: ($oldNewsItem['news_img'] ?? '');
            if ($oldCoverImage) {
                $remoteUpload = new RemoteUploadService();
                $remoteUpload->deleteFile('news/' . $oldCoverImage);
                if (file_exists(FCPATH . 'uploads/news/' . $oldCoverImage)) {
                    @unlink(FCPATH . 'uploads/news/' . $oldCoverImage);
                }
            }

            // Process, compress and save new cover image
            $RandomName = $imageFile->getRandomName();
            $tempPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $RandomName;

            $this->optimizeImage($imageFile->getTempName(), $tempPath, 'cover', 88);
            $this->uploadFileToRemoteOrLocal($tempPath, 'news', $RandomName, FCPATH . 'uploads/news/');
            @unlink($tempPath);

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
                    $tempAlbPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newName;
                    try {
                        $this->optimizeImage($file->getTempName(), $tempAlbPath, 'album', 88);
                        $this->uploadFileToRemoteOrLocal($tempAlbPath, 'news/album', $newName, FCPATH . 'uploads/news/album/');
                        @unlink($tempAlbPath);

                        $this->NewsImageModel->insert([
                            'news_id' => $id,
                            'news_img_name' => $newName
                        ]);
                    } catch (\Throwable $e) {
                        @unlink($tempAlbPath);
                    }
                }
            }
        }

        $updatedData = $builder->where('news_id', $id)->get()->getRowArray();
        if ($updatedData) {
            $updatedData['news_img_url'] = news_image_url($updatedData['news_img'] ?? '', 'cover');
        }

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
        if (empty($htmlContent)) {
            return $urls;
        }
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/', $htmlContent, $matches);
        $remoteBase = (function_exists('env') ? env('upload.server.baseurl') : '') ?: 'https://skj.nsnpao.go.th/uploads/';
        $remoteBaseClean = rtrim($remoteBase, '/');

        foreach ($matches[1] as $imageUrl) {
            $decodedUrl = urldecode($imageUrl);
            if (strpos($decodedUrl, 'uploads/news/') !== false || strpos($decodedUrl, $remoteBaseClean) !== false) {
                $urls[] = $decodedUrl;
            }
        }
        return array_unique($urls);
    }

    // Helper function to delete image file from server given its URL
    private function deleteImageFile($imageUrl)
    {
        $imageUrl = urldecode($imageUrl);
        $remoteBase = (function_exists('env') ? env('upload.server.baseurl') : '') ?: 'https://skj.nsnpao.go.th/uploads/';
        $remoteBaseClean = rtrim($remoteBase, '/');

        // 1. Delete from remote server
        if (str_starts_with($imageUrl, $remoteBaseClean)) {
            $relativePath = ltrim(substr($imageUrl, strlen($remoteBaseClean)), '/');
            $relativePath = explode('?', $relativePath)[0];
            $relativePath = explode('#', $relativePath)[0];
            $remoteService = new RemoteUploadService();
            $remoteService->deleteFile($relativePath);
            return;
        }

        // 2. Delete from local disk
        $keyword = 'uploads/news/';
        $pos = strpos($imageUrl, $keyword);
        if ($pos !== false) {
            $relativePath = substr($imageUrl, $pos);
            $relativePath = explode('?', $relativePath)[0];
            $relativePath = explode('#', $relativePath)[0];
            
            $pathsToCheck = [
                FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath),
                ROOTPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath)
            ];
            foreach ($pathsToCheck as $fullPath) {
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                    break;
                }
            }
        }
    }

    public function uploadImage()
    {
        $imageFile = $this->request->getFile('image');

        if ($imageFile === null) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'No file was uploaded.']);
        }

        if (!$imageFile->isValid()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid file: ' . $imageFile->getErrorString()]);
        }

        if ($imageFile->hasMoved()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'File has already been moved']);
        }

        $RandomName = $imageFile->getRandomName();
        $tempPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $RandomName;

        try {
            // บีบอัดรูปภาพให้คมชัด สมบูรณ์ (แจ่มเหมือนเดิม)
            $this->optimizeImage($imageFile->getTempName(), $tempPath, 'content', 88);

            // อัปโหลดขึ้น remote server ในโฟลเดอร์ news/content
            $remoteUpload = new RemoteUploadService();
            $uploadRes = $remoteUpload->uploadLocalFile($tempPath, 'news/content', $RandomName);

            if (($uploadRes['status'] ?? '') === 'success') {
                @unlink($tempPath);
                return $this->response->setJSON([
                    'url' => $uploadRes['fullUrl']
                ]);
            }

            // Fallback ไปยังเครื่องตัวเองถ้า remote server ไม่สำเร็จ
            $uploadPath = rtrim(FCPATH, '/') . '/uploads/news/content/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            @copy($tempPath, $uploadPath . $RandomName);
            @unlink($tempPath);

            return $this->response->setJSON([
                'url' => base_url('uploads/news/content/' . $RandomName)
            ]);
        } catch (\Throwable $e) {
            @unlink($tempPath);
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Image processing failed: ' . $e->getMessage()]);
        }
    }

    public function NewsDelete(){
        $id = $this->request->getPost('KeyNewsid');
        if (empty($id)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ไม่ระบุรหัสข่าวที่ต้องการลบ'
            ]);
        }

        $newsItem = $this->NewsModel->select('news_img, news_content')->where('news_id', $id)->first();

        if ($newsItem) {
            $remoteUpload = new RemoteUploadService();

            // 1. Delete cover image (remote + local)
            if (!empty($newsItem['news_img'])) {
                $cleanCover = basename($newsItem['news_img']);
                $remoteUpload->deleteFile('news/' . $cleanCover);
                $coverImagePath = FCPATH . 'uploads/news/' . $cleanCover;
                if (file_exists($coverImagePath)) {
                    @unlink($coverImagePath);
                }
            }

            // 2. Delete embedded images from news_content
            if (!empty($newsItem['news_content'])) {
                $contentUrls = $this->extractImageUrls($newsItem['news_content']);
                foreach ($contentUrls as $cUrl) {
                    $this->deleteImageFile($cUrl);
                }
            }

            // 3. Delete Album images (remote + local)
            $albumImages = $this->NewsImageModel->where('news_id', $id)->findAll();
            if (!empty($albumImages)) {
                foreach ($albumImages as $img) {
                    $imgName = basename($img['news_img_name']);
                    $remoteUpload->deleteFile('news/album/' . $imgName);
                    $albumPath = FCPATH . 'uploads/news/album/' . $imgName;
                    if (file_exists($albumPath)) {
                        @unlink($albumPath);
                    }
                }
                $this->NewsImageModel->where('news_id', $id)->delete();
            }

            // 4. Delete the news record from the database
            $result = $this->NewsModel->where('news_id', $id)->delete();
            return $this->response->setJSON([
                'status' => $result ? true : false,
                'message' => $result ? 'ลบข่าวสำเร็จ!' : 'ลบข่าวไม่สำเร็จ!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ไม่พบข้อมูลข่าวที่ต้องการลบ'
            ]);
        }
    }

    public function deleteImage()
    {
        $this->response->setContentType('application/json');
        $input = $this->request->getJSON();
        $imageUrl = $input->imageUrl ?? null;

        if ($imageUrl) {
            $this->deleteImageFile($imageUrl);
            return $this->response->setJSON(['success' => true, 'message' => 'Image deleted successfully.']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid image URL.']);
    }


    /**
     * Execute robust cURL request to Facebook API or CDN
     * Enforces IPv4 (fixes Docker connection timeout/hang), SSL tolerances, and User-Agent
     */
    private function execFacebookCurl(string $url, array $extraOptions = []): array
    {
        $userAgent = strpos($url, 'lookaside.fbsbx.com') !== false
            ? 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'
            : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if (defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        foreach ($extraOptions as $opt => $val) {
            curl_setopt($ch, $opt, $val);
        }

        $response    = curl_exec($ch);
        $httpCode    = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $curlError   = curl_error($ch);
        $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);

        return [
            'response'      => $response,
            'http_code'     => $httpCode,
            'content_type'  => $contentType,
            'error'         => $curlError,
            'effective_url' => $effectiveUrl,
        ];
    }

    public function ViewNewsFormFacebook(){
        $access_token = trim((string)env('facebook.access_token'));
        $page_id = trim((string)env('facebook.page_id'));

        if (empty($access_token) || empty($page_id)) {
            return $this->response->setJSON([
                'error' => 'กรุณาระบุ facebook.access_token และ facebook.page_id ในไฟล์ .env'
            ]);
        }

        $url = "https://graph.facebook.com/v18.0/{$page_id}/posts?fields=id,message,created_time,full_picture,attachments&access_token={$access_token}";
        $res = $this->execFacebookCurl($url);
        $http_code = $res['http_code'];
        $response = $res['response'];

        if ($http_code !== 200 || empty($response)) {
            $error_data = json_decode((string)$response, true);
            $fb_error = $error_data['error']['message'] ?? ($res['error'] ?: 'Network Error');
            log_message('error', 'ViewNewsFormFacebook error: ' . $fb_error . ' (HTTP ' . $http_code . ', cURL: ' . $res['error'] . ')');
            return $this->response->setJSON([
                'error' => 'Facebook API Error: ' . $fb_error . ' (HTTP ' . $http_code . '). Please check your Access Token and Page ID.'
            ]);
        }
        
        $fb_data = json_decode($response, true);
        
        // check existing posts in database
        if (isset($fb_data['data']) && is_array($fb_data['data'])) {
            $db = \Config\Database::connect();
            $existing_ids = $db->table('tb_news')->select('news_facebook')->where('news_facebook !=', null)->get()->getResultArray();
            $saved_ids = array_column($existing_ids, 'news_facebook');
            
            foreach ($fb_data['data'] as &$item) {
                $item['is_saved'] = in_array($item['id'], $saved_ids);
            }
        }
        
        return $this->response->setJSON($fb_data);
    }

    public function SelectNewsFormFacebook(){
        $access_token = trim((string)env('facebook.access_token'));
        $page_id = trim((string)$this->request->getVar('KeyNewsFB'));
        $url = "https://graph.facebook.com/v18.0/{$page_id}?fields=id,message,created_time,full_picture,attachments{media,subattachments}&access_token={$access_token}";

        $res = $this->execFacebookCurl($url);
        $http_code = $res['http_code'];
        $response = $res['response'];
        
        if ($http_code !== 200 || empty($response)) {
            $error_data = json_decode((string)$response, true);
            $fb_error = $error_data['error']['message'] ?? ($res['error'] ?: 'Network Error');
            return $this->response->setJSON([
                'error' => 'Facebook API Error: ' . $fb_error . ' (HTTP ' . $http_code . ').'
            ]);
        }

        $decoded = json_decode($response, true);
        
        // Extract album images if available
        $albumImages = [];
        if (!empty($decoded['attachments']['data'])) {
            foreach ($decoded['attachments']['data'] as $att) {
                if (!empty($att['subattachments']['data'])) {
                    foreach ($att['subattachments']['data'] as $sub) {
                        if (!empty($sub['media']['image']['src'])) {
                            $albumImages[] = $sub['media']['image']['src'];
                        }
                    }
                } elseif (!empty($att['media']['image']['src'])) {
                    $albumImages[] = $att['media']['image']['src'];
                }
            }
        }
        $decoded['album_images'] = array_values(array_unique($albumImages));

        return $this->response->setJSON($decoded);
    }

    public function FetchFacebookByUrl()
    {
        $rawUrl = trim($this->request->getVar('url') ?? '');
        if (empty($rawUrl)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'กรุณากรอกลิงก์โพสต์ Facebook'
            ]);
        }

        // 1. Resolve redirect for share / mobile / shortened links
        $url = $this->resolveFacebookUrl($rawUrl);

        // 2. Extract Post ID & Page ID & Page Slug & Photo/Album ID
        $extracted = $this->extractFacebookPostDetails($url);
        $postId = $extracted['post_id'] ?? null;
        $photoId = $extracted['photo_id'] ?? null;
        $albumId = $extracted['album_id'] ?? null;
        $pageSlug = $extracted['page_slug'] ?? null;
        $envPageId = env('facebook.page_id');
        $accessToken = env('facebook.access_token');

        $fbData = null;
        $topic = '';
        $message = '';
        $createdTime = date('Y-m-d H:i:s');
        $coverImage = '';
        $albumImages = [];

        // --- METHOD 1: Try Graph API (Node query with compound ID) ---
        if (!empty($accessToken) && !empty($postId)) {
            $candidates = [];
            if (strpos($postId, '_') !== false) {
                $candidates[] = $postId;
            } else {
                if (!empty($pageSlug) && !in_array($pageSlug, ['pages', 'permalink.php', 'watch', 'share', 'photo.php', 'photo'])) {
                    $candidates[] = "{$pageSlug}_{$postId}";
                }
                if (!empty($envPageId) && $envPageId !== $pageSlug) {
                    $candidates[] = "{$envPageId}_{$postId}";
                }
            }

            foreach ($candidates as $targetId) {
                $apiUrl = "https://graph.facebook.com/v18.0/{$targetId}?fields=id,message,created_time,full_picture,attachments.limit(100){media,subattachments.limit(100),target,type}&access_token={$accessToken}";
                $res = $this->execFacebookCurl($apiUrl);

                if ($res['http_code'] === 200 && !empty($res['response'])) {
                    $decoded = json_decode($res['response'], true);
                    if (!empty($decoded) && empty($decoded['error'])) {
                        $fbData = $decoded;
                        break;
                    }
                }
            }
        }

        if ($fbData) {
            $message = $fbData['message'] ?? '';
            $createdTime = $fbData['created_time'] ?? date('Y-m-d H:i:s');
            $coverImage = $fbData['full_picture'] ?? '';
            $postId = $fbData['id'] ?? $postId;

            if (!empty($fbData['attachments']['data'])) {
                foreach ($fbData['attachments']['data'] as $att) {
                    if (!empty($att['subattachments']['data'])) {
                        foreach ($att['subattachments']['data'] as $sub) {
                            if (!empty($sub['media']['image']['src'])) {
                                $albumImages[] = $sub['media']['image']['src'];
                            }
                        }
                    }
                    if (!empty($att['media']['image']['src'])) {
                        $albumImages[] = $att['media']['image']['src'];
                    }

                    // If attachment points to an album target, fetch all photos in that album
                    if (!empty($att['target']['id']) && !empty($att['type']) && strpos(strtolower($att['type']), 'album') !== false) {
                        $targetAlbId = $att['target']['id'];
                        $albRes = $this->execFacebookCurl("https://graph.facebook.com/v18.0/{$targetAlbId}/photos?fields=images&limit=100&access_token={$accessToken}");
                        if (!empty($albRes['response'])) {
                            $albDec = json_decode($albRes['response'], true);
                            if (!empty($albDec['data'])) {
                                foreach ($albDec['data'] as $albPhoto) {
                                    if (!empty($albPhoto['images'][0]['source'])) {
                                        $albumImages[] = $albPhoto['images'][0]['source'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // --- METHOD 1.5: If album_id is detected from URL (set=a.XXX), fetch all photos from album ---
        if (!empty($albumId) && !empty($accessToken)) {
            $aRes = $this->execFacebookCurl("https://graph.facebook.com/v18.0/{$albumId}/photos?fields=images,name&limit=100&access_token={$accessToken}");
            if (!empty($aRes['response'])) {
                $aDecoded = json_decode($aRes['response'], true);
                if (!empty($aDecoded['data'])) {
                    foreach ($aDecoded['data'] as $pItem) {
                        if (!empty($pItem['images'][0]['source'])) {
                            $albumImages[] = $pItem['images'][0]['source'];
                        }
                    }
                    if (empty($coverImage) && !empty($albumImages[0])) {
                        $coverImage = $albumImages[0];
                    }
                }
            }
        }

        // --- METHOD 1.6: If photo_id or media_id is detected, query Photo node with album photos ---
        $lookupPhotoId = $photoId ?: (empty($albumImages) ? $postId : null);
        if (!empty($lookupPhotoId) && !empty($accessToken) && count($albumImages) <= 1) {
            $photoCandidates = [$lookupPhotoId];
            if (!empty($pageSlug)) {
                $photoCandidates[] = "{$pageSlug}_{$lookupPhotoId}";
            }
            foreach ($photoCandidates as $pTarget) {
                $photoApiUrl = "https://graph.facebook.com/v18.0/{$pTarget}?fields=id,name,images,created_time,album{id,name,photos.limit(100){images}}&access_token={$accessToken}";
                $pRes = $this->execFacebookCurl($photoApiUrl);

                if ($pRes['http_code'] === 200 && !empty($pRes['response'])) {
                    $pDecoded = json_decode($pRes['response'], true);
                    if (!empty($pDecoded['images'][0]['source'])) {
                        if (empty($coverImage)) {
                            $coverImage = $pDecoded['images'][0]['source'];
                        }
                        $albumImages[] = $pDecoded['images'][0]['source'];
                    }
                    // Extract all other photos from the album this photo belongs to!
                    if (!empty($pDecoded['album']['photos']['data'])) {
                        foreach ($pDecoded['album']['photos']['data'] as $albItem) {
                            if (!empty($albItem['images'][0]['source'])) {
                                $albumImages[] = $albItem['images'][0]['source'];
                            }
                        }
                    }
                    if (empty($message) && !empty($pDecoded['name'])) {
                        $message = $pDecoded['name'];
                    }
                    if (empty($createdTime) && !empty($pDecoded['created_time'])) {
                        $createdTime = $pDecoded['created_time'];
                    }
                    break;
                }
            }
        }

        // --- METHOD 2: Try Facebook oEmbed API if Method 1 did not get content ---
        if (empty($message) && !empty($accessToken)) {
            $targetOembedUrl = !empty($postId) && !empty($envPageId) ? "https://www.facebook.com/{$envPageId}/posts/{$postId}" : $url;
            $oembedUrl = "https://graph.facebook.com/v18.0/oembed_post?url=" . urlencode($targetOembedUrl) . "&access_token={$accessToken}";
            $oembedRes = $this->execFacebookCurl($oembedUrl);

            if ($oembedRes['http_code'] === 200 && !empty($oembedRes['response'])) {
                $oembed = json_decode($oembedRes['response'], true);
                if (!empty($oembed['html'])) {
                    if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $oembed['html'], $pm)) {
                        $message = trim(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $pm[1])));
                    }
                }
            }
        }

        // --- METHOD 3: OpenGraph & Facebook Crawler / Plugin Scraper ---
        if (empty($message) || empty($coverImage)) {
            $ogData = $this->fetchFacebookOpenGraph($url);
            if ($ogData) {
                if (empty($message) && !empty($ogData['description'])) {
                    $message = $ogData['description'];
                }
                if (empty($topic) && !empty($ogData['title'])) {
                    $topic = $ogData['title'];
                }
                if (empty($coverImage) && !empty($ogData['image'])) {
                    $coverImage = $ogData['image'];
                }
                if (!empty($ogData['album_images'])) {
                    $albumImages = array_merge($albumImages, $ogData['album_images']);
                }
            }

            // Also try plugin embed if text is still empty
            if (empty($message)) {
                $pluginData = $this->fetchFacebookPluginEmbed($url);
                if ($pluginData) {
                    if (!empty($pluginData['message'])) {
                        $message = $pluginData['message'];
                    }
                    if (!empty($pluginData['images'])) {
                        if (empty($coverImage) && !empty($pluginData['images'][0])) {
                            $coverImage = $pluginData['images'][0];
                        }
                        $albumImages = array_merge($albumImages, $pluginData['images']);
                    }
                }
            }
        }

        // If after all methods, we still have no content or images
        if (empty($message) && empty($coverImage)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจากลิงก์ Facebook นี้ได้โดยอัตโนมัติ (อาจเนื่องจากเป็นโพสต์ส่วนตัว ถูกจำกัดสิทธิ์ หรือโครงสร้างลิงก์ไม่รองรับ)'
            ]);
        }

        $albumImages = array_values(array_unique(array_filter($albumImages)));

        if (empty($topic)) {
            $lines = preg_split('/\r\n|\r|\n/', trim($message));
            $firstLine = !empty($lines[0]) ? $lines[0] : '';
            $topic = !empty($firstLine) ? mb_substr($firstLine, 0, 100, 'UTF-8') : 'ข่าวประชาสัมพันธ์จาก Facebook';
        }

        // Check if already saved
        $db = \Config\Database::connect();
        $isSaved = false;
        if (!empty($postId)) {
            $isSaved = $db->table('tb_news')
                          ->where('news_facebook', $postId)
                          ->countAllResults() > 0;
        }

        // If coverImage or albumImages have crawler lookaside URL, resolve to direct CDN image
        if (!empty($coverImage)) {
            $coverImage = $this->resolveFacebookMediaUrl($coverImage, $accessToken);
        }
        foreach ($albumImages as &$albUrl) {
            $albUrl = $this->resolveFacebookMediaUrl($albUrl, $accessToken);
        }
        $albumImages = array_values(array_unique(array_filter($albumImages)));

        return $this->response->setJSON([
            'status' => true,
            'data' => [
                'id' => $postId ?: uniqid('fb_post_'),
                'topic' => $topic,
                'message' => $message,
                'created_time' => $createdTime,
                'cover_image' => $coverImage ?: (!empty($albumImages[0]) ? $albumImages[0] : ''),
                'album_images' => $albumImages,
                'is_saved' => $isSaved
            ]
        ]);
    }

    protected function resolveFacebookMediaUrl($imgUrl, $accessToken)
    {
        if (empty($imgUrl)) {
            return $imgUrl;
        }

        // If it's a lookaside crawler URL with media_id
        if (preg_match('/media_id=([0-9]+)/i', $imgUrl, $mId)) {
            $mediaId = $mId[1];
            if (!empty($accessToken)) {
                $res = $this->execFacebookCurl("https://graph.facebook.com/v18.0/{$mediaId}?fields=images&access_token={$accessToken}");
                if ($res['http_code'] === 200 && !empty($res['response'])) {
                    $dec = json_decode($res['response'], true);
                    if (!empty($dec['images'][0]['source'])) {
                        return $dec['images'][0]['source'];
                    }
                }
            }
        }

        return $imgUrl;
    }

    protected function fetchFacebookOpenGraph($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $html = curl_exec($ch);
        curl_close($ch);

        if (empty($html)) {
            return null;
        }

        $data = [];
        $albumImages = [];

        // Parse ALL <meta> tags to extract og:title, og:description, og:image regardless of attribute order
        if (preg_match_all('/<meta\s+([^>]+)>/is', $html, $matches)) {
            foreach ($matches[1] as $metaAttr) {
                $property = '';
                $content = '';
                if (preg_match('/(?:property|name)=["\']([^"\']+)["\']/i', $metaAttr, $pm)) {
                    $property = strtolower(trim($pm[1]));
                }
                if (preg_match('/content=["\']([^"\']+)["\']/i', $metaAttr, $cm)) {
                    $content = html_entity_decode(trim($cm[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
                if ($property && $content) {
                    if ($property === 'og:title' && empty($data['title'])) {
                        $data['title'] = $content;
                    } elseif (($property === 'og:description' || $property === 'description') && empty($data['description'])) {
                        $data['description'] = $content;
                    } elseif ($property === 'og:image' || $property === 'og:image:url' || $property === 'twitter:image') {
                        $albumImages[] = $content;
                        if (empty($data['image'])) {
                            $data['image'] = $content;
                        }
                    }
                }
            }
        }

        // Also check if high-res image URL is inside JSON-LD in HTML
        if (preg_match_all('/"image"\s*:\s*\[?["\'](https?:\/\/[^"\']+)["\']/i', $html, $jsonImgs)) {
            foreach ($jsonImgs[1] as $jImg) {
                $jImgClean = stripslashes($jImg);
                $albumImages[] = $jImgClean;
                if (empty($data['image'])) {
                    $data['image'] = $jImgClean;
                }
            }
        }

        $data['album_images'] = array_values(array_unique(array_filter($albumImages)));

        return (!empty($data['description']) || !empty($data['title']) || !empty($data['image'])) ? $data : null;
    }

    protected function fetchFacebookPluginEmbed($url)
    {
        $embedUrl = "https://www.facebook.com/plugins/post.php?href=" . urlencode($url) . "&show_text=true";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $embedUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $html = curl_exec($ch);
        curl_close($ch);

        if (empty($html)) {
            return null;
        }

        $data = [];
        if (preg_match('/<div[^>]*class="[^"]*userContent[^"]*"[^>]*>(.*?)<\/div>/is', $html, $m)) {
            $data['message'] = trim(strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $m[1])));
        } elseif (preg_match('/<div[^>]*data-ad-preview="message"[^>]*>(.*?)<\/div>/is', $html, $m)) {
            $data['message'] = trim(strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $m[1])));
        }

        if (preg_match_all('/<img[^>]*class="[^"]*(?:scaledImageFitWidth|scaledImageFitHeight|scaledImage)[^"]*"[^>]*src="([^"]+)"/is', $html, $imgMatches)) {
            $images = [];
            foreach ($imgMatches[1] as $imgSrc) {
                $images[] = html_entity_decode($imgSrc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
            $data['images'] = array_values(array_unique($images));
        }

        // Also extract any fbcdn image links from the embed
        if (empty($data['images']) && preg_match_all('/https?:\/\/[a-zA-Z0-9\.\_\-]*fbcdn\.net\/[^\s"\'<>&]+(?:\.jpg|\.png|\.webp|\.jpeg)[^\s"\'<>]*/i', $html, $allFbImgs)) {
            $images = [];
            foreach ($allFbImgs[0] as $imgSrc) {
                if (!preg_match('/[sp][0-9]{2}x[0-9]{2}/i', $imgSrc)) {
                    $images[] = html_entity_decode($imgSrc, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
            if (!empty($images)) {
                $data['images'] = array_values(array_unique($images));
            }
        }

        return (!empty($data['message']) || !empty($data['images'])) ? $data : null;
    }

    protected function resolveFacebookUrl($url)
    {
        if (preg_match('/facebook\.com\/share\/[a-zA-Z]\/|fb\.watch\//i', $url)) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            $content = curl_exec($ch);
            $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);

            if (!empty($effectiveUrl) && $effectiveUrl !== $url && strpos($effectiveUrl, '/login') === false) {
                $url = $effectiveUrl;
            }

            if (!empty($content) && preg_match('/<link\s+rel="canonical"\s+href="([^"]+)"/i', $content, $match)) {
                $url = html_entity_decode($match[1]);
            }
        }
        return $url;
    }

    protected function extractFacebookPostDetails($url)
    {
        $postId = null;
        $photoId = null;
        $albumId = null;
        $pageId = null;
        $pageSlug = null;

        $queryStr = parse_url($url, PHP_URL_QUERY);
        if ($queryStr) {
            parse_str($queryStr, $params);
            
            // Check for set parameter: pcb (parent post with all photos) or a (album)
            if (!empty($params['set'])) {
                if (preg_match('/pcb\.([0-9]+)/i', $params['set'], $sm)) {
                    $postId = $sm[1]; // Container post ID containing all photos
                } elseif (preg_match('/a\.([0-9]+)/i', $params['set'], $sm)) {
                    $albumId = $sm[1]; // Album ID
                }
            }

            if (!empty($params['story_fbid'])) {
                $postId = $params['story_fbid'];
            } elseif (!empty($params['fbid'])) {
                $photoId = $params['fbid'];
                if (empty($postId)) {
                    $postId = $params['fbid'];
                }
            }

            if (!empty($params['id'])) {
                $pageId = $params['id'];
                $pageSlug = $params['id'];
            }
        }

        $path = parse_url($url, PHP_URL_PATH);
        if ($path) {
            if (preg_match('/\/([^\/\?]+)\/posts\/([a-zA-Z0-9_\.]+)/i', $path, $m)) {
                $pageSlug = $m[1];
                $postId = $m[2];
            } elseif (preg_match('/\/share\/[a-zA-Z]\/([a-zA-Z0-9_\.]+)/i', $path, $m)) {
                $postId = $m[1];
            } elseif (preg_match('/\/photos\/(?:[^\/]+\/)?([0-9]+)/i', $path, $m)) {
                $photoId = $m[1];
                if (empty($postId)) $postId = $m[1];
            } elseif (preg_match('/\/videos\/([0-9]+)/i', $path, $m)) {
                $postId = $m[1];
            } elseif (preg_match('/\/([^\/\?]+)\/photos\/([0-9]+)/i', $path, $m)) {
                $pageSlug = $m[1];
                $photoId = $m[2];
                if (empty($postId)) $postId = $m[2];
            } elseif (preg_match('/\/posts\/([a-zA-Z0-9_\.]+)/i', $path, $m)) {
                $postId = $m[1];
            }
        }

        return [
            'post_id' => $postId,
            'photo_id' => $photoId,
            'album_id' => $albumId,
            'page_id' => $pageId,
            'page_slug' => $pageSlug
        ];
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


    public function ImageProxy()
    {
        $url = $this->request->getVar('url');
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return redirect()->to('https://placehold.co/600x400/1877F2/ffffff?text=Invalid+Image+URL');
        }

        $accessToken = trim((string)env('facebook.access_token'));
        $url = $this->resolveFacebookMediaUrl($url, $accessToken);

        $res = $this->execFacebookCurl($url);
        $content = $res['response'];
        $contentType = $res['content_type'];
        $httpCode = $res['http_code'];

        $isImage = false;
        if (!empty($content) && strlen($content) > 100) {
            $magic = substr($content, 0, 4);
            if (substr($magic, 0, 3) === "\xFF\xD8\xFF") {
                $isImage = true;
                $contentType = 'image/jpeg';
            } elseif (substr($magic, 0, 4) === "\x89PNG") {
                $isImage = true;
                $contentType = 'image/png';
            } elseif (substr($magic, 0, 3) === "GIF") {
                $isImage = true;
                $contentType = 'image/gif';
            } elseif (substr($magic, 0, 4) === "RIFF") {
                $isImage = true;
                $contentType = 'image/webp';
            } elseif (strpos((string)$contentType, 'image/') !== false) {
                $isImage = true;
            }
        }

        // If not image and has media_id, fallback to graph picture endpoint
        if (!$isImage && preg_match('/media_id=([0-9]+)/i', $url, $mId) && !empty($accessToken)) {
            $picUrl = "https://graph.facebook.com/v18.0/{$mId[1]}/picture?type=large&access_token={$accessToken}";
            $picRes = $this->execFacebookCurl($picUrl);
            if ($picRes['http_code'] === 200 && !empty($picRes['response']) && strlen($picRes['response']) > 100) {
                $content = $picRes['response'];
                $isImage = true;
                $contentType = 'image/jpeg';
                $httpCode = 200;
            }
        }

        if ($httpCode === 200 && $isImage && !empty($content)) {
            return $this->response
                ->setHeader('Content-Type', $contentType ?: 'image/jpeg')
                ->setHeader('Cache-Control', 'public, max-age=86400')
                ->setBody($content);
        }

        // Return a clean placeholder instead of 404 error
        return redirect()->to('https://placehold.co/600x400/1877F2/ffffff?text=Facebook+Photo');
    }

    function downloadFacebookImage($imageUrl, $savePath) {
        $accessToken = trim((string)env('facebook.access_token'));
        $imageUrl = $this->resolveFacebookMediaUrl($imageUrl, $accessToken);

        $res = $this->execFacebookCurl($imageUrl);
        $imageContent = $res['response'];
        $httpCode = $res['http_code'];

        if ($httpCode === 200 && !empty($imageContent) && strlen($imageContent) > 100) {
            $magic = substr($imageContent, 0, 4);
            if (substr($magic, 0, 3) === "\xFF\xD8\xFF" || substr($magic, 0, 4) === "\x89PNG" || substr($magic, 0, 3) === "GIF" || substr($magic, 0, 4) === "RIFF" || strpos($magic, '<') === false) {
                return file_put_contents($savePath, $imageContent) !== false;
            }
        }

        // Fallback: If lookaside media_id, try graph /picture
        if (preg_match('/media_id=([0-9]+)/i', $imageUrl, $mId) && !empty($accessToken)) {
            $picUrl = "https://graph.facebook.com/v18.0/{$mId[1]}/picture?type=large&access_token={$accessToken}";
            $picRes = $this->execFacebookCurl($picUrl);
            if ($picRes['http_code'] === 200 && !empty($picRes['response']) && strlen($picRes['response']) > 100) {
                return file_put_contents($savePath, $picRes['response']) !== false;
            }
        }

        return false;
    }

    public function NewsAddFacebook(){
        $database = \Config\Database::connect();
        $builder = $database->table('tb_news');
        $checkID = $builder->select('news_id')->orderBy('news_id','DESC')->get()->getRow();
        if($checkID){
            $ex = explode('_',$checkID->news_id);
            $suffix = isset($ex[1]) ? (int)$ex[1] : 0;
            $NewsIdNew = 'news_'.sprintf("%03d", $suffix + 1);
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
        $tempDlCover = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . uniqid('fb_dl_', true) . '.jpg';
        $tempOptCover = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $randomFileName;
            
        // ดาวน์โหลดรูปภาพจาก Facebook มาเก็บที่ temp ชั่วคราว
        $downloadSuccess = $this->downloadFacebookImage($imageUrl, $tempDlCover);
        if (!$downloadSuccess) {
            if (!@copy($imageUrl, $tempDlCover)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ไม่สามารถบันทึกรูปภาพจาก Facebook ได้'
                ]);
            }
        }

        // 1. บีบอัดรูปภาพหน้าปกให้แจ่ม คมชัด (quality 88)
        $this->optimizeImage($tempDlCover, $tempOptCover, 'cover', 88);
        @unlink($tempDlCover);

        // 2. อัปโหลดขึ้น remote server โฟลเดอร์ 'news'
        $this->uploadFileToRemoteOrLocal($tempOptCover, 'news', $randomFileName, FCPATH . 'uploads/news/');
        @unlink($tempOptCover);
       
        $fbPostId = $this->request->getVar('news_facebook_id') ?: $this->request->getVar('sel_NewsFromFacebook');

        $data = [
            'news_id' => $NewsIdNew,
            'news_img' => $randomFileName,
            'news_facebook' => $fbPostId,
            'news_topic' =>  $this->request->getVar('news_topic_facebook'),
            'news_content' => $this->request->getVar('news_content_facebook'),
            'news_date' => $this->request->getVar('news_date_facebook'),
            'news_category' => $this->request->getVar('news_category_facebook'),
            'personnel_id' => session('AdminID')
        ];
        
        $builder->insert($data);

        // จัดการรูปภาพอัลบั้มเพิ่มเติมจากโพสต์ Facebook (ถ้ามี)
        $albumImages = $this->request->getVar('news_album_images_facebook');
        if (!empty($albumImages)) {
            if (is_string($albumImages)) {
                $decoded = json_decode($albumImages, true);
                if (is_array($decoded)) {
                    $albumImages = $decoded;
                } else {
                    $albumImages = [$albumImages];
                }
            }

            if (is_array($albumImages)) {
                foreach ($albumImages as $albImgUrl) {
                    if (empty($albImgUrl) || $albImgUrl === $imageUrl) {
                        continue; // ข้ามรูปที่เป็นรูปปกไปแล้ว
                    }
                    $albFileName = uniqid('fb_alb_', true) . '.jpg';
                    $tempDlAlb = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . uniqid('fb_dl_alb_', true) . '.jpg';
                    $tempOptAlb = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $albFileName;

                    $dlOk = $this->downloadFacebookImage($albImgUrl, $tempDlAlb);
                    if (!$dlOk) {
                        @copy($albImgUrl, $tempDlAlb);
                    }

                    if (file_exists($tempDlAlb) && filesize($tempDlAlb) > 0) {
                        // บีบอัดรูปภาพอัลบั้มให้คมชัด และอัปโหลดไปยัง 'news/album' บนเซิร์ฟเวอร์
                        $this->optimizeImage($tempDlAlb, $tempOptAlb, 'album', 88);
                        @unlink($tempDlAlb);

                        $this->uploadFileToRemoteOrLocal($tempOptAlb, 'news/album', $albFileName, FCPATH . 'uploads/news/album/');
                        @unlink($tempOptAlb);

                        $this->NewsImageModel->insert([
                            'news_id' => $NewsIdNew,
                            'news_img_name' => $albFileName,
                            'news_img_created_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
        }

        $newData = $builder->where('news_id', $NewsIdNew)->get()->getRowArray();
        if ($newData) {
            $newData['news_img_url'] = news_image_url($newData['news_img'] ?? '', 'cover');
        }

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
        
        // Add full URL for each album image (supports both local and remote)
        foreach ($images as &$img) {
            $img['img_url'] = news_image_url($img['news_img_name'], 'album');
        }

        return $this->response->setJSON($images);
    }

    public function NewsAlbumDelete()
    {
        $id = $this->request->getPost('img_id');
        $img = $this->NewsImageModel->find($id);
        if ($img) {
            $remoteUpload = new RemoteUploadService();
            $remoteUpload->deleteFile('news/album/' . $img['news_img_name']);

            if (file_exists(FCPATH . 'uploads/news/album/' . $img['news_img_name'])) {
                @unlink(FCPATH . 'uploads/news/album/' . $img['news_img_name']);
            }
            $this->NewsImageModel->delete($id);
            return $this->response->setJSON(['status' => true, 'message' => 'ลบรูปภาพสำเร็จ']);
        }
        return $this->response->setJSON(['status' => false, 'message' => 'ไม่พบรูปภาพ']);
    }

    /**
     * Scan local uploads/news directory recursively for image files
     * 
     * @return array List of relative paths under uploads/news/
     */
    private function scanLocalNewsImages(): array
    {
        $baseDir = rtrim(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'news', DIRECTORY_SEPARATOR);
        if (!is_dir($baseDir)) {
            return [];
        }

        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $files = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($baseDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $ext = strtolower($fileInfo->getExtension());
                if (in_array($ext, $allowedExts, true)) {
                    $realPath = $fileInfo->getRealPath();
                    $relPath = ltrim(substr($realPath, strlen($baseDir)), DIRECTORY_SEPARATOR);
                    $relPath = str_replace(DIRECTORY_SEPARATOR, '/', $relPath);
                    $files[] = $relPath;
                }
            }
        }

        return $files;
    }

    /**
     * Get status of local news images needing sync to remote server
     */
    public function SyncImagesStatus()
    {
        $files = $this->scanLocalNewsImages();
        $totalFiles = count($files);
        $totalBytes = 0;
        $baseDir = rtrim(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'news', DIRECTORY_SEPARATOR);

        foreach ($files as $f) {
            $full = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $f);
            if (is_file($full)) {
                $totalBytes += filesize($full);
            }
        }

        return $this->response->setJSON([
            'status'        => true,
            'total_files'   => $totalFiles,
            'total_size_mb' => round($totalBytes / (1024 * 1024), 2),
            'files'         => $files,
        ]);
    }

    /**
     * Batch sync local news images to remote server and optionally delete local copy
     */
    public function SyncImagesBatch()
    {
        $batch = $this->request->getPost('files');
        if (is_string($batch)) {
            $batch = json_decode($batch, true);
        }
        if (empty($batch) || !is_array($batch)) {
            $all = $this->scanLocalNewsImages();
            $batch = array_slice($all, 0, 10);
        }

        $deleteLocal = filter_var($this->request->getPost('delete_local') ?? true, FILTER_VALIDATE_BOOLEAN);
        $remoteUpload = new RemoteUploadService();
        $baseDir = rtrim(FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'news', DIRECTORY_SEPARATOR);

        $successCount = 0;
        $failCount    = 0;
        $freedBytes   = 0;
        $results      = [];

        foreach ($batch as $relPath) {
            $cleanRel = ltrim($relPath, '/\\');
            $fullPath = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanRel);

            if (!is_file($fullPath)) {
                $results[] = [
                    'file'    => $cleanRel,
                    'status'  => 'skipped',
                    'message' => 'ไฟล์ไม่อยู่ในเครื่องแล้ว',
                ];
                continue;
            }

            $fileSize = filesize($fullPath);
            $pathParts = pathinfo($cleanRel);
            $filename  = $pathParts['basename'];
            $dir       = ($pathParts['dirname'] !== '.' && $pathParts['dirname'] !== '') ? $pathParts['dirname'] : '';

            $remoteSubPath = 'news' . ($dir !== '' ? '/' . str_replace('\\', '/', $dir) : '');

            $res = $remoteUpload->uploadLocalFile($fullPath, $remoteSubPath, $filename);

            if (($res['status'] ?? '') === 'success') {
                $successCount++;
                if ($deleteLocal) {
                    @unlink($fullPath);
                    $freedBytes += $fileSize;

                    // Clean empty parent folder if applicable
                    $parentDir = dirname($fullPath);
                    if ($parentDir !== $baseDir && is_dir($parentDir)) {
                        $remainingInDir = array_diff(scandir($parentDir), ['.', '..']);
                        if (empty($remainingInDir)) {
                            @rmdir($parentDir);
                        }
                    }
                }
                $results[] = [
                    'file'   => $cleanRel,
                    'status' => 'success',
                ];
            } else {
                $failCount++;
                $results[] = [
                    'file'    => $cleanRel,
                    'status'  => 'error',
                    'message' => $res['message'] ?? 'Upload failed',
                ];
            }
        }

        $remainingFiles = count($this->scanLocalNewsImages());

        return $this->response->setJSON([
            'status'          => true,
            'processed'       => count($batch),
            'success_count'   => $successCount,
            'fail_count'      => $failCount,
            'freed_bytes'     => $freedBytes,
            'freed_mb'        => round($freedBytes / (1024 * 1024), 2),
            'remaining_files' => $remainingFiles,
            'results'         => $results,
        ]);
    }

}