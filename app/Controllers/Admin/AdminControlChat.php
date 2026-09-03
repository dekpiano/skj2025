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
        $this->ensureAiKnowledgeTable();

        $apiKey       = trim($this->request->getPost('ai_api_key') ?? '');
        $model        = trim($this->request->getPost('ai_model') ?? 'gemini-2.0-flash');
        $systemPrompt = trim($this->request->getPost('ai_system_prompt') ?? '');
        $status       = $this->request->getPost('ai_status') === 'on' ? 'on' : 'off';
        $temperature  = (float)($this->request->getPost('ai_temperature') ?? 0.4);
        $maxTokens    = (int)($this->request->getPost('ai_max_tokens') ?? 2500);
        if ($maxTokens < 1000) $maxTokens = 2500;

        $allowedModels = ['gemini-3.6-flash', 'gemini-3.1-flash-lite', 'gemini-3-flash-preview', 'gemini-3.5-flash', 'gemini-flash-latest'];
        if (!in_array($model, $allowedModels) || $model === 'gemini-2.0-flash') {
            $model = 'gemini-3.6-flash';
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
        $this->ensureAiKnowledgeTable();

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

        if (empty($model) || $model === 'gemini-2.0-flash') {
            $model = 'gemini-3.6-flash';
        }

        // Fetch active knowledge items from tb_chat_ai_knowledge
        $activeKnowledge = $this->db->table('tb_chat_ai_knowledge')
            ->where('status', 'on')
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->getResult();

        $knowledgeContext = "";
        $knowledgeUsedCount = count($activeKnowledge);
        if ($knowledgeUsedCount > 0) {
            $sections = [];
            foreach ($activeKnowledge as $k) {
                $srcDesc = ($k->source_type === 'url') ? "ลิงก์เว็บไซต์: {$k->source_url}" : (($k->source_type === 'file') ? "ไฟล์เอกสาร: {$k->file_name}" : "ข้อความ/ประกาศโรงเรียน");
                $snippet = mb_substr($k->content, 0, 10000);
                $sections[] = "=== [แหล่งข้อมูล: {$k->title} ({$srcDesc})] ===\n{$snippet}";
            }
            $knowledgeContext = "\n\n--- คลังข้อมูลอ้างอิงของโรงเรียน (SKJ KNOWLEDGE BASE) ---\n"
                . "คำสั่งพิเศษ: จงใช้ข้อมูลจาก 'คลังข้อมูลอ้างอิงของโรงเรียน' ด้านล่างนี้เป็นฐานความรู้หลักในการตอบคำถาม หากมีข้อมูลที่ตรงกับคำถาม ให้ตอบตามเนื้อหานั้นอย่างถูกต้อง สุภาพ อ่านง่าย หากมีลิงก์เว็บไซต์ประกอบ ให้อ้างอิงหรือแนะนำลิงก์ให้ผู้ใช้ด้วย:\n\n"
                . implode("\n\n", $sections)
                . "\n--- สิ้นสุดคลังข้อมูลอ้างอิง ---\n";
        }

        $formatRule = "\n\nกฎสำคัญ: จงตอบเฉพาะข้อความสุดท้ายที่จะส่งให้ผู้ใช้เป็นภาษาไทยที่สุภาพเท่านั้น ห้ามพิมพ์กระบวนการคิด (Thinking/Chain of thought) หรือข้อความประเภท 'Check guidelines' ออกมาโดยเด็ดขาด\n";
        $fullPrompt = $systemPrompt . $knowledgeContext . $formatRule;

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $fullPrompt]
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
                'temperature'     => 0.4,
                'maxOutputTokens' => 2500
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

        $parts = $resJson['candidates'][0]['content']['parts'] ?? [];
        $aiAnswer = '';
        foreach ($parts as $p) {
            if (!empty($p['thought'])) continue;
            if (!empty($p['text'])) $aiAnswer .= $p['text'];
        }
        if (empty(trim($aiAnswer)) && !empty($parts[0]['text'])) {
            $aiAnswer = $parts[0]['text'];
        }

        // Guard against internal reasoning leaks (e.g. "* Check guidelines:")
        if (preg_match('/^\s*\**\s*\*\s*Check guidelines:/is', $aiAnswer)) {
            $cleaned = preg_replace('/^\s*\**\s*\*\s*Check guidelines:.*?(?=(\n\n|\n[^\*\s]|$))/is', '', $aiAnswer);
            if (!empty(trim($cleaned))) {
                $aiAnswer = trim($cleaned);
            }
        }

        $aiAnswer = trim($aiAnswer);
        if (empty($aiAnswer)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบคำตอบจากโมเดล AI (รูปแบบข้อมูลไม่ถูกต้อง)'
            ]);
        }

        return $this->response->setJSON([
            'status'          => 'success',
            'reply'           => trim($aiAnswer),
            'model'           => $model,
            'latency_ms'      => $elapsedTime,
            'knowledge_count' => $knowledgeUsedCount,
            'message'         => 'AI ตอบกลับสำเร็จแล้ว (' . $elapsedTime . ' ms)' . ($knowledgeUsedCount > 0 ? " [อ้างอิงจาก {$knowledgeUsedCount} แหล่งข้อมูล]" : "")
        ]);
    }

    // ==========================================
    // AI KNOWLEDGE BASE MANAGEMENT METHODS
    // ==========================================

    public function ensureAiKnowledgeTable()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS tb_chat_ai_knowledge (
                knowledge_id INT(11) NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                source_type VARCHAR(20) NOT NULL DEFAULT 'url',
                source_url VARCHAR(500) NULL,
                file_path VARCHAR(255) NULL,
                file_name VARCHAR(255) NULL,
                file_type VARCHAR(50) NULL,
                file_size INT(11) DEFAULT 0,
                content MEDIUMTEXT NOT NULL,
                char_count INT(11) DEFAULT 0,
                status ENUM('on', 'off') DEFAULT 'on',
                last_synced_at DATETIME NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY (knowledge_id),
                INDEX idx_status (status),
                INDEX idx_source (source_type)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->query($sql);
        } catch (\Throwable $e) {
            log_message('error', '[ensureAiKnowledgeTable] ' . $e->getMessage());
        }
    }

    public function getKnowledgeList()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();

        $items = $this->db->table('tb_chat_ai_knowledge')
            ->select('knowledge_id, title, source_type, source_url, file_name, file_type, file_size, char_count, status, last_synced_at, created_at, updated_at')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();

        $totalActive = 0;
        $totalChars = 0;
        foreach ($items as $item) {
            if ($item->status === 'on') $totalActive++;
            $totalChars += (int)$item->char_count;
        }

        return $this->response->setJSON([
            'status'       => 'success',
            'items'        => $items,
            'total_count'  => count($items),
            'active_count' => $totalActive,
            'total_chars'  => $totalChars
        ]);
    }

    public function fetchUrlPreview()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $url = trim($this->request->getPost('url') ?? '');
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'รูปแบบ URL ไม่ถูกต้อง']);
        }

        $extracted = $this->extractUrlContent($url);
        if (!$extracted['success']) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $extracted['message'] ?? 'ไม่สามารถดึงข้อมูลจากเว็บไซต์ได้'
            ]);
        }

        return $this->response->setJSON([
            'status'     => 'success',
            'title'      => $extracted['title'],
            'preview'    => mb_substr($extracted['content'], 0, 800),
            'char_count' => $extracted['char_count']
        ]);
    }

    public function saveKnowledgeUrl()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();

        $url = trim($this->request->getPost('url') ?? '');
        $customTitle = trim($this->request->getPost('title') ?? '');

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุ URL เว็บไซต์ที่ถูกต้อง']);
        }

        $extracted = $this->extractUrlContent($url);
        if (!$extracted['success']) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $extracted['message'] ?? 'ดึงข้อมูลไม่สำเร็จ'
            ]);
        }

        $title = !empty($customTitle) ? $customTitle : $extracted['title'];
        $now = date('Y-m-d H:i:s');

        $data = [
            'title'          => $title,
            'source_type'    => 'url',
            'source_url'     => $url,
            'content'        => $extracted['content'],
            'char_count'     => $extracted['char_count'],
            'status'         => 'on',
            'last_synced_at' => $now,
            'created_at'     => $now,
            'updated_at'     => $now
        ];

        $this->db->table('tb_chat_ai_knowledge')->insert($data);
        $insertId = $this->db->insertID();

        return $this->response->setJSON([
            'status'       => 'success',
            'knowledge_id' => $insertId,
            'title'        => $title,
            'char_count'   => $extracted['char_count'],
            'message'      => "บันทึกข้อมูลเว็บไซต์สำเร็จ ({$extracted['char_count']} ตัวอักษร)"
        ]);
    }

    public function uploadKnowledgeFile()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();

        $file = $this->request->getFile('file');
        $customTitle = trim($this->request->getPost('title') ?? '');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบไฟล์หรือไฟล์ไม่ถูกต้อง: ' . ($file ? $file->getErrorString() : '')
            ]);
        }

        $ext = strtolower($file->getClientExtension());
        $allowedExts = ['pdf', 'docx', 'txt', 'csv', 'md', 'json'];
        if (!in_array($ext, $allowedExts)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'รองรับเฉพาะไฟล์เอกสาร .pdf, .docx, .txt, .csv, .md, .json เท่านั้น'
            ]);
        }

        if ($file->getSizeByUnit('mb') > 15) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ขนาดไฟล์ต้องไม่เกิน 15MB'
            ]);
        }

        $uploadDir = FCPATH . 'uploads/knowledge/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $originalName = $file->getClientName();
        $newName = $file->getRandomName();
        $file->move($uploadDir, $newName);
        $savedPath = $uploadDir . $newName;

        // Extract text
        $extractedText = $this->extractFileContent($savedPath, $ext);
        $charCount = mb_strlen($extractedText);

        if ($charCount < 5) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่สามารถอ่านข้อความจากไฟล์นี้ได้ หรือไฟล์ไม่มีเนื้อหาข้อความ (หากเป็น PDF รูปภาพสแกน แนะนำให้ใช้ไฟล์ข้อความหรือ DOCX)'
            ]);
        }

        $title = !empty($customTitle) ? $customTitle : pathinfo($originalName, PATHINFO_FILENAME);
        $now = date('Y-m-d H:i:s');

        $data = [
            'title'          => $title,
            'source_type'    => 'file',
            'file_path'      => 'uploads/knowledge/' . $newName,
            'file_name'      => $originalName,
            'file_type'      => $ext,
            'file_size'      => filesize($savedPath),
            'content'        => $extractedText,
            'char_count'     => $charCount,
            'status'         => 'on',
            'last_synced_at' => $now,
            'created_at'     => $now,
            'updated_at'     => $now
        ];

        $this->db->table('tb_chat_ai_knowledge')->insert($data);
        $insertId = $this->db->insertID();

        return $this->response->setJSON([
            'status'       => 'success',
            'knowledge_id' => $insertId,
            'title'        => $title,
            'char_count'   => $charCount,
            'message'      => "อัปโหลดและสกัดข้อความสำเร็จ ({$charCount} ตัวอักษร)"
        ]);
    }

    public function saveKnowledgeText()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();

        $title = trim($this->request->getPost('title') ?? '');
        $content = trim($this->request->getPost('content') ?? '');

        if (empty($title) || empty($content)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกหัวข้อและเนื้อหาข้อความ']);
        }

        $charCount = mb_strlen($content);
        $now = date('Y-m-d H:i:s');

        $data = [
            'title'          => $title,
            'source_type'    => 'text',
            'content'        => $content,
            'char_count'     => $charCount,
            'status'         => 'on',
            'last_synced_at' => $now,
            'created_at'     => $now,
            'updated_at'     => $now
        ];

        $this->db->table('tb_chat_ai_knowledge')->insert($data);
        $insertId = $this->db->insertID();

        return $this->response->setJSON([
            'status'       => 'success',
            'knowledge_id' => $insertId,
            'title'        => $title,
            'char_count'   => $charCount,
            'message'      => 'บันทึกข้อมูลข้อความสำเร็จ'
        ]);
    }

    public function toggleKnowledgeStatus($id)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $item = $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->get()->getRow();
        if (!$item) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);
        }

        $newStatus = ($item->status === 'on') ? 'off' : 'on';
        $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->update([
            'status'     => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status'     => 'success',
            'new_status' => $newStatus,
            'message'    => $newStatus === 'on' ? 'เปิดใช้งานคลังความรู้นี้แล้ว' : 'ปิดใช้งานคลังความรู้นี้ชั่วคราวแล้ว'
        ]);
    }

    public function syncKnowledgeUrl($id)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $item = $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->get()->getRow();
        if (!$item) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);
        }

        // Support database source_type re-sync
        if ($item->source_type === 'database') {
            if (strpos($item->source_url, 'tb_personnel') !== false) {
                return $this->syncFromDatabase('personnel');
            } elseif (strpos($item->source_url, 'tb_subjects') !== false) {
                return $this->syncFromDatabase('academic');
            } elseif (strpos($item->source_url, 'tb_news') !== false) {
                return $this->syncFromDatabase('news');
            }
        }

        if ($item->source_type !== 'url' || empty($item->source_url)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'สามารถซิงค์ได้เฉพาะรายการประเภทเว็บไซต์หรือฐานข้อมูล']);
        }

        $extracted = $this->extractUrlContent($item->source_url);
        if (!$extracted['success']) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $extracted['message'] ?? 'ซิงค์ไม่สำเร็จ'
            ]);
        }

        $now = date('Y-m-d H:i:s');
        $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->update([
            'content'        => $extracted['content'],
            'char_count'     => $extracted['char_count'],
            'last_synced_at' => $now,
            'updated_at'     => $now
        ]);

        return $this->response->setJSON([
            'status'         => 'success',
            'char_count'     => $extracted['char_count'],
            'last_synced_at' => $now,
            'message'        => "ซิงค์ดึงเนื้อหาล่าสุดเรียบร้อยแล้ว ({$extracted['char_count']} ตัวอักษร)"
        ]);
    }

    public function getDatabaseStats()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        try {
            $dbPersonnel = \Config\Database::connect('personnal');
            $personnelCount = $dbPersonnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->countAllResults();
        } catch (\Throwable $e) {
            $personnelCount = 0;
        }

        try {
            $dbAcademic = \Config\Database::connect('academic');
            $academicCount = $dbAcademic->table('tb_subjects')->countAllResults();
        } catch (\Throwable $e) {
            $academicCount = 0;
        }

        try {
            $dbDefault = \Config\Database::connect('default');
            $newsCount = $dbDefault->table('tb_news')->countAllResults();
        } catch (\Throwable $e) {
            $newsCount = 0;
        }

        return $this->response->setJSON([
            'status'          => 'success',
            'personnel_count' => $personnelCount,
            'academic_count'  => $academicCount,
            'news_count'      => $newsCount
        ]);
    }

    public function syncFromDatabase($type)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();
        $now = date('Y-m-d H:i:s');

        if ($type === 'personnel') {
            try {
                $dbPersonnel = \Config\Database::connect('personnal');
                $dbSkj = \Config\Database::connect('default');

                // Map learnings
                $learningMap = [];
                $learnRows = $dbSkj->table('tb_learning')->get()->getResultArray();
                foreach ($learnRows as $lr) {
                    $learningMap[$lr['lear_id']] = trim($lr['lear_namethai']);
                }

                // Map positions
                $posMap = [];
                $posRows = $dbSkj->table('tb_position')->get()->getResultArray();
                foreach ($posRows as $pr) {
                    $posMap[$pr['posi_id']] = trim($pr['posi_name']);
                }

                // Map departments
                $deptMap = [];
                $deptRows = $dbSkj->table('tb_department')->get()->getResultArray();
                foreach ($deptRows as $dr) {
                    $deptMap[$dr['depart_id']] = trim($dr['depart_name']);
                }

                // Active personnel
                $teachers = $dbPersonnel->table('tb_personnel')
                    ->where('pers_status', 'กำลังใช้งาน')
                    ->orderBy('pers_numberGroup', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($teachers)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลบุคลากรที่กำลังปฏิบัติงาน']);
                }

                $executives = [];
                $byLearning = [];
                $supportStaff = [];

                foreach ($teachers as $t) {
                    $name = trim($t['pers_prefix'] . $t['pers_firstname'] . ' ' . $t['pers_lastname']);
                    $nick = !empty($t['pers_nickname']) ? " (ครู{$t['pers_nickname']})" : '';
                    $pos = $posMap[$t['pers_position']] ?? $t['pers_position'] ?? 'ครู';
                    $lead = !empty($t['pers_groupleade']) ? " [{$t['pers_groupleade']}]" : '';
                    $dept = !empty($t['pers_faction']) ? $t['pers_faction'] : ($deptMap[$t['pers_department']] ?? '');

                    $itemDesc = "- {$name}{$nick} | ตำแหน่ง: {$pos}{$lead}" . (!empty($dept) ? " | ฝ่าย: {$dept}" : "");

                    if (in_array($t['pers_position'], ['posi_001', 'posi_002'])) {
                        $executives[] = $itemDesc;
                    } elseif (!empty($t['pers_learning']) && isset($learningMap[$t['pers_learning']])) {
                        $learnName = $learningMap[$t['pers_learning']];
                        $byLearning[$learnName][] = $itemDesc;
                    } else {
                        $supportStaff[] = $itemDesc;
                    }
                }

                $content = "=== ข้อมูลคณะผู้บริหาร ครู และบุคลากรทางการศึกษา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลบุคลากร ณ วันที่ " . date('d/m/Y H:i') . " จำนวนรวม " . count($teachers) . " ท่าน)\n\n";

                if (!empty($executives)) {
                    $content .= "[1. คณะผู้บริหารสถานศึกษา]\n";
                    $content .= implode("\n", $executives) . "\n\n";
                }

                if (!empty($byLearning)) {
                    $content .= "[2. คณะครูผู้สอนแยกตามกลุ่มสาระการเรียนรู้]\n";
                    foreach ($byLearning as $groupName => $members) {
                        $content .= "■ กลุ่มสาระการเรียนรู้{$groupName} (จำนวน " . count($members) . " ท่าน):\n";
                        $content .= implode("\n", $members) . "\n\n";
                    }
                }

                if (!empty($supportStaff)) {
                    $content .= "[3. บุคลากรสายสนับสนุน / เจ้าหน้าที่ / พนักงาน]\n";
                    $content .= implode("\n", $supportStaff) . "\n\n";
                }

                $title = "ข้อมูลคณะผู้บริหาร ครู และบุคลากรทางการศึกษา (" . count($teachers) . " ท่าน)";
                $sourceUrl = "db://skjacth_personnel/tb_personnel";
                $charCount = mb_strlen($content, 'UTF-8');

                $existing = $this->db->table('tb_chat_ai_knowledge')->where('source_url', $sourceUrl)->get()->getRow();
                if ($existing) {
                    $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $existing->knowledge_id)->update([
                        'title'          => $title,
                        'content'        => $content,
                        'char_count'     => $charCount,
                        'status'         => 'on',
                        'last_synced_at' => $now,
                        'updated_at'     => $now
                    ]);
                    $kId = $existing->knowledge_id;
                } else {
                    $this->db->table('tb_chat_ai_knowledge')->insert([
                        'title'          => $title,
                        'source_type'    => 'database',
                        'source_url'     => $sourceUrl,
                        'content'        => $content,
                        'char_count'     => $charCount,
                        'status'         => 'on',
                        'last_synced_at' => $now,
                        'created_at'     => $now,
                        'updated_at'     => $now
                    ]);
                    $kId = $this->db->insertID();
                }

                return $this->response->setJSON([
                    'status'         => 'success',
                    'knowledge_id'   => $kId,
                    'title'          => $title,
                    'char_count'     => $charCount,
                    'record_count'   => count($teachers),
                    'message'        => "ซิงค์ข้อมูลบุคลากรสำเร็จ " . count($teachers) . " ท่าน ({$charCount} ตัวอักษร)"
                ]);

            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูลบุคลากร: ' . $e->getMessage()]);
            }
        } elseif ($type === 'academic') {
            try {
                $dbAcademic = \Config\Database::connect('academic');

                // Query subjects active in recent years (2567, 2568)
                $subjects = $dbAcademic->table('tb_subjects')
                    ->select('SubjectCode, SubjectName, SubjectClass, SubjectUnit, SubjectHour, SubjectType, FirstGroup, MAX(SubjectYear) as LatestYear')
                    ->where("SubjectYear LIKE '%2567%' OR SubjectYear LIKE '%2568%'")
                    ->groupBy('SubjectCode, SubjectClass, SubjectName, SubjectUnit, SubjectHour, SubjectType, FirstGroup')
                    ->orderBy('SubjectClass', 'ASC')
                    ->orderBy('SubjectType', 'ASC')
                    ->orderBy('SubjectCode', 'ASC')
                    ->get()
                    ->getResultArray();

                // If empty fallback to all
                if (empty($subjects)) {
                    $subjects = $dbAcademic->table('tb_subjects')
                        ->select('SubjectCode, SubjectName, SubjectClass, SubjectUnit, SubjectHour, SubjectType, FirstGroup, MAX(SubjectYear) as LatestYear')
                        ->groupBy('SubjectCode, SubjectClass, SubjectName, SubjectUnit, SubjectHour, SubjectType, FirstGroup')
                        ->orderBy('SubjectClass', 'ASC')
                        ->orderBy('SubjectType', 'ASC')
                        ->orderBy('SubjectCode', 'ASC')
                        ->get()
                        ->getResultArray();
                }

                if (empty($subjects)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลรายวิชาในฐานข้อมูล']);
                }

                // Group by Class (ม.1 ถึง ม.6)
                $byClass = [];
                foreach ($subjects as $s) {
                    $c = !empty($s['SubjectClass']) ? $s['SubjectClass'] : 'วิชาทั่วไป';
                    $byClass[$c][] = $s;
                }

                $content = "=== ข้อมูลหลักสูตรและรายวิชาที่เปิดสอน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลวิชาการ รวม " . count($subjects) . " รายวิชา อัปเดตเมื่อ " . date('d/m/Y H:i') . ")\n\n";

                foreach ($byClass as $classLevel => $classList) {
                    $content .= "========================================\n";
                    $content .= "【ระดับชั้น {$classLevel}】 (จำนวน " . count($classList) . " รายวิชา)\n";
                    $content .= "========================================\n";

                    $basics = [];
                    $additionals = [];
                    $others = [];

                    foreach ($classList as $sub) {
                        $code = trim($sub['SubjectCode']);
                        $name = trim($sub['SubjectName']);
                        $unit = trim($sub['SubjectUnit']);
                        $hour = trim($sub['SubjectHour']);
                        $grp = !empty($sub['FirstGroup']) ? " (" . preg_replace('/^\d+\//', '', $sub['FirstGroup']) . ")" : '';

                        $line = "• [{$code}] {$name}{$grp} - {$unit} หน่วยกิต ({$hour} ชั่วโมง)";
                        $st = strtolower($sub['SubjectType'] ?? '');
                        if (strpos($st, 'พื้นฐาน') !== false) {
                            $basics[] = $line;
                        } elseif (strpos($st, 'เพิ่มเติม') !== false) {
                            $additionals[] = $line;
                        } else {
                            $others[] = $line;
                        }
                    }

                    if (!empty($basics)) {
                        $content .= "▶ รายวิชาพื้นฐาน:\n" . implode("\n", $basics) . "\n\n";
                    }
                    if (!empty($additionals)) {
                        $content .= "▶ รายวิชาเพิ่มเติม:\n" . implode("\n", $additionals) . "\n\n";
                    }
                    if (!empty($others)) {
                        $content .= "▶ กิจกรรมพัฒนาผู้เรียน/อื่นๆ:\n" . implode("\n", $others) . "\n\n";
                    }
                }

                $title = "ข้อมูลหลักสูตรและรายวิชาที่เปิดสอน ม.1 - ม.6 (" . count($subjects) . " วิชา)";
                $sourceUrl = "db://skjacth_academic/tb_subjects";
                $charCount = mb_strlen($content, 'UTF-8');

                $existing = $this->db->table('tb_chat_ai_knowledge')->where('source_url', $sourceUrl)->get()->getRow();
                if ($existing) {
                    $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $existing->knowledge_id)->update([
                        'title'          => $title,
                        'content'        => $content,
                        'char_count'     => $charCount,
                        'status'         => 'on',
                        'last_synced_at' => $now,
                        'updated_at'     => $now
                    ]);
                    $kId = $existing->knowledge_id;
                } else {
                    $this->db->table('tb_chat_ai_knowledge')->insert([
                        'title'          => $title,
                        'source_type'    => 'database',
                        'source_url'     => $sourceUrl,
                        'content'        => $content,
                        'char_count'     => $charCount,
                        'status'         => 'on',
                        'last_synced_at' => $now,
                        'created_at'     => $now,
                        'updated_at'     => $now
                    ]);
                    $kId = $this->db->insertID();
                }

                return $this->response->setJSON([
                    'status'         => 'success',
                    'knowledge_id'   => $kId,
                    'title'          => $title,
                    'char_count'     => $charCount,
                    'record_count'   => count($subjects),
                    'message'        => "ซิงค์ข้อมูลรายวิชาสำเร็จ " . count($subjects) . " วิชา ({$charCount} ตัวอักษร)"
                ]);

            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูลรายวิชา: ' . $e->getMessage()]);
            }
        } elseif ($type === 'news') {
            try {
                $dbDefault = \Config\Database::connect('default');

                $newsRows = $dbDefault->table('tb_news')
                    ->select('news_id, news_topic, news_category, news_content, news_date')
                    ->orderBy('news_date', 'DESC')
                    ->limit(25)
                    ->get()
                    ->getResultArray();

                if (empty($newsRows)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลข่าวสารในฐานข้อมูล']);
                }

                $content = "=== ข่าวประชาสัมพันธ์ ประกาศ และกิจกรรมล่าสุด โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(อัปเดต 25 ข่าวล่าสุดจากฐานข้อมูลเว็บไซต์โรงเรียน เมื่อ " . date('d/m/Y H:i') . ")\n\n";

                $idx = 1;
                foreach ($newsRows as $n) {
                    $topic = trim($n['news_topic']);
                    $cat = trim($n['news_category'] ?? 'ข่าวประชาสัมพันธ์');
                    $dateStr = !empty($n['news_date']) ? date('d/m/Y', strtotime($n['news_date'])) : '-';
                    $body = trim(strip_tags($n['news_content'] ?? ''));
                    if (mb_strlen($body, 'UTF-8') > 250) {
                        $body = mb_substr($body, 0, 250, 'UTF-8') . '...';
                    }

                    $content .= "[ข่าวที่ {$idx}] วันที่: {$dateStr} | หมวดหมู่: {$cat}\n";
                    $content .= "หัวข้อ: {$topic}\n";
                    if (!empty($body)) {
                        $content .= "เนื้อหาสรุป: {$body}\n";
                    }
                    $content .= "--------------------------------------------------\n";
                    $idx++;
                }

                $title = "ข่าวประชาสัมพันธ์และประกาศล่าสุดของโรงเรียน (25 ข่าวล่าสุด)";
                $sourceUrl = "db://skjacth_skj/tb_news";
                $charCount = mb_strlen($content, 'UTF-8');

                $existing = $this->db->table('tb_chat_ai_knowledge')->where('source_url', $sourceUrl)->get()->getRow();
                if ($existing) {
                    $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $existing->knowledge_id)->update([
                        'title'          => $title,
                        'content'        => $content,
                        'char_count'     => $charCount,
                        'status'         => 'on',
                        'last_synced_at' => $now,
                        'updated_at'     => $now
                    ]);
                    $kId = $existing->knowledge_id;
                } else {
                    $this->db->table('tb_chat_ai_knowledge')->insert([
                        'title'          => $title,
                        'source_type'    => 'database',
                        'source_url'     => $sourceUrl,
                        'content'        => $content,
                        'char_count'     => $charCount,
                        'status'         => 'on',
                        'last_synced_at' => $now,
                        'created_at'     => $now,
                        'updated_at'     => $now
                    ]);
                    $kId = $this->db->insertID();
                }

                return $this->response->setJSON([
                    'status'         => 'success',
                    'knowledge_id'   => $kId,
                    'title'          => $title,
                    'char_count'     => $charCount,
                    'record_count'   => count($newsRows),
                    'message'        => "ซิงค์ข่าวสารสำเร็จ 25 ข่าวล่าสุด ({$charCount} ตัวอักษร)"
                ]);

            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูลข่าวสาร: ' . $e->getMessage()]);
            }
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่รู้จักประเภทฐานข้อมูลที่ระบุ']);
    }


    public function deleteKnowledge($id)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $item = $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->get()->getRow();
        if (!$item) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);
        }

        if (!empty($item->file_path)) {
            $fullPath = FCPATH . $item->file_path;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'ลบรายการคลังความรู้เรียบร้อยแล้ว'
        ]);
    }

    public function getKnowledgeDetail($id)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $item = $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->get()->getRow();
        if (!$item) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูล']);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'item'   => $item
        ]);
    }

    public function updateKnowledgeDetail($id)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $title = trim($this->request->getPost('title') ?? '');
        $content = trim($this->request->getPost('content') ?? '');

        if (empty($title) || empty($content)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณากรอกหัวข้อและเนื้อหา']);
        }

        $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $id)->update([
            'title'      => $title,
            'content'    => $content,
            'char_count' => mb_strlen($content),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'อัปเดตข้อมูลสำเร็จ'
        ]);
    }

    // ==========================================
    // CONTENT EXTRACTION ENGINE
    // ==========================================

    private function extractUrlContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: th,en-US;q=0.9,en;q=0.8'
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if ($curlErr || $httpCode >= 400 || empty($html)) {
            return [
                'success' => false,
                'message' => 'ไม่สามารถดึงข้อมูลจากเว็บไซต์ได้ (' . ($curlErr ?: "HTTP Code $httpCode") . ')'
            ];
        }

        // Extract Title
        $title = '';
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $m)) {
            $title = trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        }
        if (empty($title)) {
            $title = parse_url($url, PHP_URL_HOST) ?? 'ข้อมูลจากเว็บไซต์';
        }

        // Clean HTML
        $clean = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $clean = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $clean);
        $clean = preg_replace('/<svg\b[^>]*>(.*?)<\/svg>/is', '', $clean);
        $clean = preg_replace('/<noscript\b[^>]*>(.*?)<\/noscript>/is', '', $clean);
        $clean = preg_replace('/<header\b[^>]*>(.*?)<\/header>/is', '', $clean);
        $clean = preg_replace('/<footer\b[^>]*>(.*?)<\/footer>/is', '', $clean);
        $clean = preg_replace('/<nav\b[^>]*>(.*?)<\/nav>/is', '', $clean);
        $clean = preg_replace('/<!--(.*?)-->/s', '', $clean);

        // Format headers and block elements with newlines
        $clean = preg_replace('/<\/(h[1-6]|p|div|tr|li|blockquote)>/i', "\n", $clean);
        $clean = preg_replace('/<(br|hr)\s*\/?>/i', "\n", $clean);
        $clean = preg_replace('/<td[^>]*>/i', '  ', $clean);

        $text = strip_tags($clean);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Clean multiple spaces and blank lines
        $lines = explode("\n", $text);
        $cleanedLines = [];
        foreach ($lines as $line) {
            $trimmed = trim(preg_replace('/[ \t\xc2\xa0]+/u', ' ', $line));
            if (!empty($trimmed) && mb_strlen($trimmed) > 1) {
                $cleanedLines[] = $trimmed;
            }
        }
        $finalText = implode("\n", $cleanedLines);

        return [
            'success'    => true,
            'title'      => $title,
            'content'    => $finalText,
            'char_count' => mb_strlen($finalText)
        ];
    }

    private function extractFileContent($filePath, $ext)
    {
        if (!file_exists($filePath)) return '';

        switch ($ext) {
            case 'txt':
            case 'csv':
            case 'md':
            case 'json':
                $raw = @file_get_contents($filePath);
                if ($raw === false) return '';
                // Check encoding
                if (!mb_check_encoding($raw, 'UTF-8')) {
                    $raw = mb_convert_encoding($raw, 'UTF-8', 'TIS-620, ISO-8859-11, Windows-874, auto');
                }
                return trim($raw);

            case 'docx':
                return $this->extractDocxText($filePath);

            case 'pdf':
                return $this->extractPdfText($filePath);

            default:
                $raw = @file_get_contents($filePath);
                return $raw ? trim(strip_tags($raw)) : '';
        }
    }

    private function extractDocxText($filePath)
    {
        if (!class_exists('\ZipArchive')) {
            return '';
        }
        $zip = new \ZipArchive();
        if ($zip->open($filePath) === true) {
            $xmlIndex = $zip->locateName('word/document.xml');
            if ($xmlIndex !== false) {
                $xmlData = $zip->getFromIndex($xmlIndex);
                $zip->close();

                $xmlData = preg_replace('/<\/w:p>/i', "\n", $xmlData);
                $xmlData = preg_replace('/<w:tab\/>/i', "\t", $xmlData);
                $xmlData = preg_replace('/<w:br\/>/i', "\n", $xmlData);
                $text = strip_tags($xmlData);
                $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $text = preg_replace('/[ \t]+/', ' ', $text);
                $text = preg_replace('/\n\s*\n+/', "\n\n", $text);
                return trim($text);
            }
            $zip->close();
        }
        return '';
    }

    private function extractPdfText($filePath)
    {
        if (!file_exists($filePath)) return '';
        $content = @file_get_contents($filePath);
        if (empty($content)) return '';

        $resultText = '';

        // Search for all streams
        if (preg_match_all('/stream[\r\n]+(.*?)[\r\n]+endstream/s', $content, $streamMatches)) {
            foreach ($streamMatches[1] as $stream) {
                $data = $stream;
                $uncompressed = @gzuncompress($data);
                if ($uncompressed === false) {
                    $uncompressed = @gzinflate($data);
                }
                if ($uncompressed === false && strlen($data) > 2) {
                    $uncompressed = @gzinflate(substr($data, 2));
                }
                if ($uncompressed !== false) {
                    $data = $uncompressed;
                }

                // Look for text blocks BT ... ET
                if (preg_match_all('/BT[\r\n]+(.*?)[\r\n]+ET/s', $data, $btMatches)) {
                    foreach ($btMatches[1] as $block) {
                        // (string) Tj
                        if (preg_match_all('/\((.*?)\)\s*Tj/s', $block, $tjMatches)) {
                            foreach ($tjMatches[1] as $str) {
                                $resultText .= $this->cleanPdfString($str) . ' ';
                            }
                        }
                        // [(string) 120 (string)] TJ
                        if (preg_match_all('/\[(.*?)\]\s*TJ/s', $block, $tjArrayMatches)) {
                            foreach ($tjArrayMatches[1] as $arr) {
                                if (preg_match_all('/\((.*?)\)/s', $arr, $subMatches)) {
                                    foreach ($subMatches[1] as $subStr) {
                                        $resultText .= $this->cleanPdfString($subStr);
                                    }
                                    $resultText .= ' ';
                                }
                            }
                        }
                        $resultText .= "\n";
                    }
                }
            }
        }

        // Fallback for direct plain ASCII/UTF-8 strings
        if (mb_strlen(trim($resultText)) < 30) {
            if (preg_match_all('/\(([^\)\\\\]{3,})\)/', $content, $rawMatches)) {
                $rawStrings = [];
                foreach ($rawMatches[1] as $s) {
                    $cleaned = trim($s);
                    if (mb_strlen($cleaned) > 2 && preg_match('/[a-zA-Z\x{0E00}-\x{0E7F}]/u', $cleaned)) {
                        $rawStrings[] = $cleaned;
                    }
                }
                if (!empty($rawStrings)) {
                    $resultText .= implode(' ', $rawStrings);
                }
            }
        }

        $resultText = preg_replace('/[ \t]+/', ' ', $resultText);
        $resultText = preg_replace('/\n\s*\n+/', "\n\n", $resultText);
        return trim($resultText);
    }

    private function cleanPdfString($str)
    {
        $str = str_replace(['\\(', '\\)', '\\\\'], ['(', ')', '\\'], $str);
        $str = preg_replace_callback('/\\\\([0-7]{1,3})/', function($m) {
            return chr(octdec($m[1]));
        }, $str);
        return $str;
    }
}


