<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminControlChat extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    private function checkAuth()
    {
        if (!$this->session->get('isLoggedIn') && !$this->session->get('AdminID') && !$this->session->has('login_id') && !$this->session->has('pers_id') && !$this->session->has('admin_id') && !$this->session->has('user_id')) {
            $targetUrl = current_url(true)->__toString();
            $this->session->set('redirect_url', $targetUrl);
            return redirect()->to(base_url('Login/LoginAdmin?redirect=' . urlencode($targetUrl)));
        }
        return null;
    }

    public function index()
    {
        if ($redir = $this->checkAuth()) {
            return $redir;
        }

        $activeToken = $this->request->getGet('session') ?? '';

        $data = [
            'title'       => 'ระบบสนทนาสด (Live Chat Dashboard)',
            'description' => 'ระบบสนทนาสด Live Chat สำหรับติดต่อสอบถามข้อมูลโรงเรียน',
            'menu'        => 'live_chat',
            'activeToken' => $activeToken
        ];

        return view('Admin/PageAdminChat/AdminChatIndex', array_merge($this->data, $data));
    }

    public function getSessions()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $sessions = $this->db->table('tb_chat_sessions')
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->getResult();

        foreach ($sessions as &$s) {
            $lastMsg = $this->db->table('tb_chat_messages')
                ->where('session_id', $s->session_id)
                ->orderBy('created_at', 'DESC')
                ->limit(1)
                ->get()
                ->getRow();

            $s->last_message = $lastMsg ? $lastMsg->message : '';
            $s->last_attachment = $lastMsg ? $lastMsg->attachment_url : null;
            $s->last_sender = $lastMsg ? $lastMsg->sender_type : '';
            $s->last_message_time = $lastMsg ? $lastMsg->created_at : $s->updated_at;
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'sessions' => $sessions
        ]);
    }

    public function getSessionMessages($sessionId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session not found']);
        }

        $this->db->table('tb_chat_messages')
            ->where('session_id', $sessionId)
            ->where('sender_type', 'user')
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $now = date('Y-m-d H:i:s');
        $this->db->table('tb_chat_sessions')
            ->where('session_id', $sessionId)
            ->update([
                'unread_admin_count' => 0,
                'admin_active_at'    => $now
            ]);

        // Re-fetch updated session with fresh admin_active_at & is_bot_paused
        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();

        $messages = $this->db->table('tb_chat_messages')
            ->where('session_id', $sessionId)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResult();

        return $this->response->setJSON([
            'status'   => 'success',
            'session'  => $session,
            'messages' => $messages
        ]);
    }

    public function sendReply()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $sessionId = (int)$this->request->getPost('session_id');
        $messageText = trim($this->request->getPost('message') ?? '');
        $attachmentUrl = trim($this->request->getPost('attachment_url') ?? '');
        $attachmentType = trim($this->request->getPost('attachment_type') ?? '');

        if (!$sessionId || (empty($messageText) && empty($attachmentUrl))) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
        }

        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบห้องสนทนา']);
        }

        $adminName = 'Admin ระบบ';

        $cleanText = !empty($messageText) ? htmlspecialchars($messageText, ENT_QUOTES, 'UTF-8') : '';
        $insertMsg = [
            'session_id'      => $sessionId,
            'sender_type'     => 'admin',
            'sender_name'     => $adminName,
            'message'         => $cleanText,
            'attachment_url'  => !empty($attachmentUrl) ? $attachmentUrl : null,
            'attachment_type' => !empty($attachmentType) ? $attachmentType : null,
            'is_bot'          => 0,
            'is_read'         => 0,
            'created_at'      => date('Y-m-d H:i:s')
        ];
        $this->db->table('tb_chat_messages')->insert($insertMsg);
        $messageId = $this->db->insertID();

        $now = date('Y-m-d H:i:s');
        $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->update([
            'updated_at'          => $now,
            'unread_user_count'   => ($session->unread_user_count ?? 0) + 1,
            'status'              => 'active',
            'admin_active_at'     => $now,
            'last_admin_reply_at' => $now
        ]);

        $newMsg = $this->db->table('tb_chat_messages')->where('message_id', $messageId)->get()->getRow();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => $newMsg
        ]);
    }

    public function uploadAttachment()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบไฟล์หรือไฟล์ไม่ถูกต้อง'
            ]);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'application/pdf'];
        $mime = $file->getMimeType();
        if (!in_array($mime, $allowedMimes)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'รองรับเฉพาะไฟล์รูปภาพ (JPG, PNG, WEBP, GIF) หรือ PDF'
            ]);
        }

        if ($file->getSizeByUnit('mb') > 5) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ขนาดไฟล์เกิน 5MB'
            ]);
        }

        $uploadPath = FCPATH . 'uploads/chat';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $fileUrl = 'uploads/chat/' . $newName;
        $isImage = strpos($mime, 'image/') === 0;

        return $this->response->setJSON([
            'status'          => 'success',
            'file_url'        => $fileUrl,
            'file_name'       => $file->getClientName(),
            'attachment_type' => $isImage ? 'image' : 'document'
        ]);
    }

    public function toggleStatus($sessionId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not found']);
        }

        $newStatus = ($session->status === 'active') ? 'closed' : 'active';
        $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->update([
            'status'     => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status'     => 'success',
            'new_status' => $newStatus
        ]);
    }

    public function toggleSessionBot($sessionId)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session not found']);
        }

        $currentPaused = isset($session->is_bot_paused) ? (int)$session->is_bot_paused : 0;
        $newPaused = ($currentPaused === 1) ? 0 : 1;

        $this->db->table('tb_chat_sessions')
            ->where('session_id', $sessionId)
            ->update([
                'is_bot_paused' => $newPaused,
                'updated_at'    => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON([
            'status'        => 'success',
            'is_bot_paused' => $newPaused,
            'message'       => $newPaused ? 'พักการตอบของ AI ในห้องนี้ชั่วคราวแล้ว' : 'เปิดให้ AI ช่วยตอบในห้องนี้ตามปกติแล้ว'
        ]);
    }

    public function deleteSession($sessionId)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบห้องสนทนา']);
        }

        // Delete messages & session
        $this->db->table('tb_chat_messages')->where('session_id', $sessionId)->delete();
        $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'ลบประวัติการสนทนาเรียบร้อยแล้ว'
        ]);
    }

    public function getTelegramConfig()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $config = $this->db->table('tb_telegram_config')->where('telegram_id', 1)->get()->getRow();
        if (!$config) {
            $config = (object)[
                'telegram_bot_token'  => '',
                'telegram_chat_id'    => '',
                'telegram_chat_title' => 'SKJ Live Chat Notifications',
                'telegram_status'     => 'on'
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'config' => $config
        ]);
    }

    public function saveTelegramConfig()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $token  = trim($this->request->getPost('telegram_bot_token') ?? '');
        $chatId = trim($this->request->getPost('telegram_chat_id') ?? '');
        $title  = trim($this->request->getPost('telegram_chat_title') ?? 'SKJ Live Chat Notifications');
        $status = $this->request->getPost('telegram_status') === 'on' ? 'on' : 'off';

        $hasRow = $this->db->table('tb_telegram_config')->where('telegram_id', 1)->countAllResults();
        $data = [
            'telegram_bot_token'  => $token,
            'telegram_chat_id'    => $chatId,
            'telegram_chat_title' => $title,
            'telegram_status'     => $status,
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        if ($hasRow > 0) {
            $this->db->table('tb_telegram_config')->where('telegram_id', 1)->update($data);
        } else {
            $data['telegram_id'] = 1;
            $this->db->table('tb_telegram_config')->insert($data);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'บันทึกการตั้งค่า Telegram เรียบร้อยแล้ว'
        ]);
    }

    public function testTelegramNotification()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        $token  = trim($this->request->getPost('telegram_bot_token') ?? '');
        $chatId = trim($this->request->getPost('telegram_chat_id') ?? '');

        if (empty($token) || empty($chatId)) {
            $config = $this->db->table('tb_telegram_config')->where('telegram_id', 1)->get()->getRow();
            if ($config) {
                $token  = !empty($token) ? $token : $config->telegram_bot_token;
                $chatId = !empty($chatId) ? $chatId : $config->telegram_chat_id;
            }
        }

        if (empty($token) || empty($chatId)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'กรุณากรอก Telegram Bot Token และ Chat ID ก่อนทดสอบ'
            ]);
        }

        $msg  = "🔔 <b>ทดสอบการแจ้งเตือน Telegram (SKJ Live Chat)</b>\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "✅ <b>สถานะ:</b> ระบบเชื่อมต่อกับ Telegram สำเร็จแล้ว!\n";
        $msg .= "🕒 <b>เวลาทดสอบ:</b> " . date('d/m/Y H:i:s') . " น.\n";
        $msg .= "🏫 <b>โรงเรียน:</b> สวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "เมื่อมีนักเรียนหรือผู้ปกครองพิมพ์ข้อความเข้ามา ระบบจะส่งข้อความแจ้งเตือนมายังกลุ่มนี้ทันทีครับ 🌸✨";

        $postData = [
            'chat_id'                  => $chatId,
            'text'                     => $msg,
            'parse_mode'               => 'HTML',
            'disable_web_page_preview' => true
        ];

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        $resData = json_decode($response, true);
        if ($httpCode === 200 && isset($resData['ok']) && $resData['ok'] === true) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'ส่งข้อความทดสอบไปยัง Telegram สำเร็จแล้ว! ตรวจสอบใน Telegram ได้เลยครับ'
            ]);
        }

        $errMsg = $resData['description'] ?? ($curlErr ?: "HTTP Code: $httpCode");
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'ส่งไม่สำเร็จ: ' . $errMsg
        ]);
    }

    private function ensureAiConfigTable()
    {
        try {
            $sqlAiConfig = "CREATE TABLE IF NOT EXISTS tb_chat_ai_config (
                ai_id INT(11) NOT NULL AUTO_INCREMENT,
                ai_provider VARCHAR(50) DEFAULT 'gemini',
                ai_api_key VARCHAR(255) NULL,
                ai_model VARCHAR(100) DEFAULT 'gemini-1.5-flash',
                ai_system_prompt MEDIUMTEXT NULL,
                ai_status ENUM('on', 'off') DEFAULT 'off',
                ai_temperature FLOAT DEFAULT 0.7,
                ai_max_tokens INT(11) DEFAULT 500,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY (ai_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->query($sqlAiConfig);

            $hasAiConfig = $this->db->table('tb_chat_ai_config')->where('ai_id', 1)->countAllResults();
            if ($hasAiConfig == 0) {
                $defaultPrompt = "คุณคือ \"น้องกุหลาบ (SKJ AI Assistant)\" ผู้ช่วยประชาสัมพันธ์อัจฉริยะของโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ สังกัดองค์การบริหารส่วนจังหวัดนครสวรรค์\n"
                    . "หน้าที่ของคุณคือตอบคำถามของผู้ปกครอง นักเรียน ศิษย์เก่า และประชาชนทั่วไปอย่างสุภาพ อบอุ่น มีไมตรีจิต และถูกต้องกระชับ (ลงท้ายด้วย ครับ/ค่ะ อย่างเหมาะสม)\n\n"
                    . "ข้อมูลพื้นฐานของโรงเรียน:\n"
                    . "- ชื่อสถานศึกษา: โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์\n"
                    . "- ที่ตั้ง: 160 หมู่ 1 ตำบลนครสวรรค์ออก อำเภอเมือง จังหวัดนครสวรรค์ 60000\n"
                    . "- โทรศัพท์สำนักงาน: 056-009-667\n"
                    . "- เวลาทำการ: วันจันทร์ - ศุกร์ เวลา 08:00 - 16:30 น. (ปิดทำการวันเสาร์-อาทิตย์ และวันหยุดนักขัตฤกษ์)\n"
                    . "- สีประจำโรงเรียน: ชมพู - ฟ้า (ดอกกุหลาบสีชมพู)\n"
                    . "- คำขวัญ/อัตลักษณ์: สุภาพชน คนสวนฯ เป็นผู้นำ รักเพื่อน นับถือพี่ เคารพครู กตัญญูพ่อแม่ ดูแลน้อง สนองคุณแผ่นดิน\n\n"
                    . "ข้อมูลด้านวิชาการและการรับสมัคร:\n"
                    . "- ระดับชั้นที่เปิดสอน: มัธยมศึกษาปีที่ 1 ถึง 6\n"
                    . "- การรับสมัคร: รับสมัครช่วงกุมภาพันธ์ - มีนาคม ของทุกปี (ระดับ ม.1 และ ม.4) ทั้งระบบออนไลน์ผ่านเว็บไซต์ https://skj.ac.th และที่อาคารอำนวยการ\n"
                    . "- แผนการเรียน ม.ปลาย: วิทยาศาสตร์-คณิตศาสตร์, ศิลป์-ภาษา, ศิลป์-สังคม และเทคโนโลยีสารสนเทศ\n"
                    . "- การชำระเงิน/ค่าเทอม: ชำระผ่านระบบออนไลน์หรือที่ห้องการเงิน หากโอนแล้วสามารถแนบรูปถ่ายสลิปเข้ามาในช่องแชทนี้ได้ทันที\n\n"
                    . "กฎการตอบคำถาม:\n"
                    . "1. ตอบเป็นภาษาไทยที่สุภาพ กระชับ อ่านเข้าใจง่าย ใช้ emoji หรือ bullet point ประกอบให้อ่านสบายตา\n"
                    . "2. หากเป็นเรื่องนอกเหนือข้อมูลโรงเรียน หรือเรื่องที่ต้องให้ครู/เจ้าหน้าที่ตรวจสอบเฉพาะบุคคล (เช่น ผลการเรียนรายบุคคล, แก้เกรด, การขอใบ ปพ.) ให้แนะนำให้ติดต่อเบอร์โทร 056-009-667 ในวันและเวลาทำการ หรือพิมพ์ฝากชื่อและเบอร์โทรศัพท์ไว้ในแชทเพื่อให้เจ้าหน้าที่ติดต่อกลับ";

                $this->db->table('tb_chat_ai_config')->insert([
                    'ai_id'            => 1,
                    'ai_provider'      => 'gemini',
                    'ai_api_key'       => '',
                    'ai_model'         => 'gemini-1.5-flash',
                    'ai_system_prompt' => $defaultPrompt,
                    'ai_status'        => 'off',
                    'ai_temperature'   => 0.7,
                    'ai_max_tokens'    => 500,
                    'updated_at'       => date('Y-m-d H:i:s')
                ]);
            }
        } catch (\Throwable $e) {
            log_message('error', '[ensureAiConfigTable] ' . $e->getMessage());
        }
    }

    public function getAiConfig()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiConfigTable();

        $config = $this->db->table('tb_chat_ai_config')->where('ai_id', 1)->get()->getRow();
        if (!$config) {
            $config = (object)[
                'ai_provider'      => 'gemini',
                'ai_api_key'       => '',
                'ai_model'         => 'gemini-1.5-flash',
                'ai_system_prompt' => '',
                'ai_status'        => 'off',
                'ai_temperature'   => 0.7,
                'ai_max_tokens'    => 500
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'config' => $config
        ]);
    }

    public function saveAiConfig()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiConfigTable();

        $apiKey       = trim($this->request->getPost('ai_api_key') ?? '');
        $model        = trim($this->request->getPost('ai_model') ?? 'gemini-3.5-flash');
        $systemPrompt = trim($this->request->getPost('ai_system_prompt') ?? '');
        $status       = $this->request->getPost('ai_status') === 'on' ? 'on' : 'off';
        $temperature  = (float)($this->request->getPost('ai_temperature') ?? 0.7);
        $maxTokens    = (int)($this->request->getPost('ai_max_tokens') ?? 500);

        $allowedModels = ['gemini-3.5-flash', 'gemini-3.5-flash-lite', 'gemini-3-flash-preview', 'gemini-flash-latest', 'gemini-2.5-flash'];
        if (!in_array($model, $allowedModels)) {
            $model = 'gemini-3.5-flash';
        }

        $data = [
            'ai_provider'      => 'gemini',
            'ai_api_key'       => $apiKey,
            'ai_model'         => $model,
            'ai_system_prompt' => $systemPrompt,
            'ai_status'        => $status,
            'ai_temperature'   => $temperature,
            'ai_max_tokens'    => $maxTokens,
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        $hasRow = $this->db->table('tb_chat_ai_config')->where('ai_id', 1)->countAllResults();
        if ($hasRow > 0) {
            $this->db->table('tb_chat_ai_config')->where('ai_id', 1)->update($data);
        } else {
            $data['ai_id'] = 1;
            $this->db->table('tb_chat_ai_config')->insert($data);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'บันทึกการตั้งค่า AI Smart Chatbot เรียบร้อยแล้ว'
        ]);
    }

    public function testAiResponse()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiConfigTable();

        $testMsg      = trim($this->request->getPost('test_message') ?? '');
        $apiKey       = trim($this->request->getPost('ai_api_key') ?? '');
        $model        = trim($this->request->getPost('ai_model') ?? '');
        $systemPrompt = trim($this->request->getPost('ai_system_prompt') ?? '');

        if (empty($testMsg)) {
            $testMsg = 'โรงเรียนเปิดรับสมัคร ม.1 วันไหนบ้าง และมีสายการเรียนอะไรบ้างครับ';
        }

        if (empty($apiKey) || empty($model) || empty($systemPrompt)) {
            $config = $this->db->table('tb_chat_ai_config')->where('ai_id', 1)->get()->getRow();
            if ($config) {
                if (empty($apiKey)) $apiKey = $config->ai_api_key;
                if (empty($model)) $model = $config->ai_model;
                if (empty($systemPrompt)) $systemPrompt = $config->ai_system_prompt;
            }
        }

        if (empty($apiKey)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'กรุณากรอก Gemini API Key ก่อนทำการทดสอบครับ'
            ]);
        }

        if (empty($model)) {
            $model = 'gemini-3.5-flash';
        }

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemPrompt]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $testMsg]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature'     => 0.7,
                'maxOutputTokens' => 1200,
                'thinkingConfig'  => [
                    'thinkingBudget' => 0
                ]
            ]
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($apiKey);

        $startTime = microtime(true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);
        $elapsedTime = round((microtime(true) - $startTime) * 1000);

        if ($curlErr) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'เชื่อมต่อไปยัง Google Gemini ไม่สำเร็จ: ' . $curlErr
            ]);
        }

        $resJson = json_decode($response, true);
        if ($httpCode !== 200) {
            $errorMsg = $resJson['error']['message'] ?? "HTTP Error $httpCode: $response";
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gemini API แจ้งเตือน: ' . $errorMsg
            ]);
        }

        $aiAnswer = $resJson['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if (empty($aiAnswer)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบคำตอบจากโมเดล AI (รูปแบบข้อมูลไม่ถูกต้อง)'
            ]);
        }

        return $this->response->setJSON([
            'status'     => 'success',
            'reply'      => trim($aiAnswer),
            'model'      => $model,
            'latency_ms' => $elapsedTime,
            'message'    => 'AI ตอบกลับสำเร็จแล้ว (' . $elapsedTime . ' ms)'
        ]);
    }
}

