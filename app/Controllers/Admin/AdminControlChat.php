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

    public function discoverSiteLinks()
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $baseUrl = trim($this->request->getPost('base_url') ?? '');
        $maxLinks = (int)($this->request->getPost('max_links') ?? 30);
        if ($maxLinks < 5) $maxLinks = 5;
        if ($maxLinks > 60) $maxLinks = 60;

        if (empty($baseUrl) || !filter_var($baseUrl, FILTER_VALIDATE_URL)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'กรุณาระบุ URL เว็บไซต์ที่ถูกต้อง เช่น https://skj.ac.th']);
        }

        $parsedBase = parse_url($baseUrl);
        $baseHost = strtolower($parsedBase['host'] ?? '');
        $baseScheme = $parsedBase['scheme'] ?? 'http';
        $rootDomain = $baseScheme . '://' . $baseHost;

        // Fetch HTML of the base URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if ($curlErr || $httpCode >= 400 || empty($html)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่สามารถเชื่อมต่อเว็บไซต์เพื่อค้นหาหน้าเพจได้ (' . ($curlErr ?: "HTTP $httpCode") . ')'
            ]);
        }

        $discovered = [];
        $baseTitle = 'หน้าแรก / หน้าหลัก';
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $tm)) {
            $t = trim(html_entity_decode(strip_tags($tm[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if (!empty($t)) $baseTitle = $t;
        }
        $normalizedBaseUrl = rtrim($baseUrl, '/');
        $discovered[$normalizedBaseUrl] = [
            'url'     => $normalizedBaseUrl,
            'title'   => $baseTitle,
            'is_root' => true
        ];

        if (preg_match_all('/<a\b[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $html, $matches, PREG_SET_ORDER)) {
            $ignoredExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico', 'pdf', 'zip', 'rar', 'mp4', 'mp3', 'doc', 'docx', 'xls', 'xlsx', 'css', 'js'];

            foreach ($matches as $m) {
                if (count($discovered) >= $maxLinks) break;

                $rawHref = trim($m[1]);
                $rawText = trim(preg_replace('/\s+/', ' ', strip_tags($m[2])));

                if (empty($rawHref) || strpos($rawHref, '#') === 0 || strpos($rawHref, 'javascript:') === 0 || strpos($rawHref, 'mailto:') === 0 || strpos($rawHref, 'tel:') === 0) {
                    continue;
                }

                $absUrl = '';
                if (preg_match('/^https?:\/\//i', $rawHref)) {
                    $absUrl = $rawHref;
                } elseif (strpos($rawHref, '//') === 0) {
                    $absUrl = $baseScheme . ':' . $rawHref;
                } elseif (strpos($rawHref, '/') === 0) {
                    $absUrl = $rootDomain . $rawHref;
                } else {
                    $baseDir = rtrim(dirname($parsedBase['path'] ?? '/'), '/\\');
                    $absUrl = $rootDomain . ($baseDir ? $baseDir . '/' : '/') . $rawHref;
                }

                $urlParts = parse_url($absUrl);
                if (!$urlParts || empty($urlParts['host'])) continue;

                $targetHost = strtolower($urlParts['host']);
                if ($targetHost !== $baseHost && !str_ends_with($targetHost, '.' . $baseHost)) {
                    continue;
                }

                $cleanUrl = ($urlParts['scheme'] ?? $baseScheme) . '://' . $targetHost . ($urlParts['path'] ?? '/');
                if (!empty($urlParts['query'])) {
                    $cleanUrl .= '?' . $urlParts['query'];
                }
                $cleanUrl = rtrim($cleanUrl, '/');

                $pathOnly = parse_url($cleanUrl, PHP_URL_PATH) ?? '';
                $ext = strtolower(pathinfo($pathOnly, PATHINFO_EXTENSION));
                if (in_array($ext, $ignoredExts)) continue;

                $lowerPath = strtolower($pathOnly);
                if (preg_match('/(\/admin|\/login|\/logout|\/auth|\/register|\/wp-admin|\/cart)/i', $lowerPath)) {
                    continue;
                }

                if (!isset($discovered[$cleanUrl])) {
                    $title = !empty($rawText) && mb_strlen($rawText) > 2 ? $rawText : ($pathOnly ?: $cleanUrl);
                    if (mb_strlen($title) > 80) {
                        $title = mb_substr($title, 0, 80) . '...';
                    }
                    $discovered[$cleanUrl] = [
                        'url'     => $cleanUrl,
                        'title'   => $title,
                        'is_root' => false
                    ];
                }
            }
        }

        $this->ensureAiKnowledgeTable();
        $urlsList = array_keys($discovered);
        $existingMap = [];
        if (!empty($urlsList)) {
            $existingRows = $this->db->table('tb_chat_ai_knowledge')
                ->select('knowledge_id, source_url, status, updated_at, char_count')
                ->whereIn('source_url', $urlsList)
                ->get()
                ->getResult();
            foreach ($existingRows as $row) {
                $existingMap[$row->source_url] = $row;
            }
        }

        $items = [];
        foreach ($discovered as $url => $info) {
            $exists = isset($existingMap[$url]);
            $items[] = [
                'url'         => $url,
                'title'       => $info['title'],
                'is_root'     => $info['is_root'],
                'is_existing' => $exists,
                'char_count'  => $exists ? (int)$existingMap[$url]->char_count : 0,
                'updated_at'  => $exists ? $existingMap[$url]->updated_at : null
            ];
        }

        return $this->response->setJSON([
            'status'     => 'success',
            'base_url'   => $baseUrl,
            'count'      => count($items),
            'links'      => $items,
            'message'    => 'สแกนพบหน้าเพจภายในเว็บไซต์ทั้งหมด ' . count($items) . ' หน้า'
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

        $existing = $this->db->table('tb_chat_ai_knowledge')->where('source_url', $url)->get()->getRow();
        if ($existing) {
            $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $existing->knowledge_id)->update([
                'title'          => $title,
                'content'        => $extracted['content'],
                'char_count'     => $extracted['char_count'],
                'status'         => 'on',
                'last_synced_at' => $now,
                'updated_at'     => $now
            ]);
            $insertId = $existing->knowledge_id;
            $msg = "อัปเดตข้อมูลเว็บไซต์เรียบร้อยแล้ว ({$extracted['char_count']} ตัวอักษร)";
        } else {
            $this->db->table('tb_chat_ai_knowledge')->insert($data);
            $insertId = $this->db->insertID();
            $msg = "บันทึกข้อมูลเว็บไซต์สำเร็จ ({$extracted['char_count']} ตัวอักษร)";
        }

        return $this->response->setJSON([
            'status'       => 'success',
            'knowledge_id' => $insertId,
            'title'        => $title,
            'char_count'   => $extracted['char_count'],
            'message'      => $msg
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

        $this->ensureAiKnowledgeTable();

        $counts = [
            'about'       => 0,
            'personnel'   => 0,
            'board'       => 0,
            'academic'    => 0,
            'study_plans' => 0,
            'clubs'       => 0,
            'admission'   => 0,
            'locations'   => 0,
            'timetable'   => 0,
            'news'        => 0,
        ];

        // 1. About & News from default (skjacth_skj)
        try {
            $dbDefault = \Config\Database::connect('default');
            $counts['about'] = $dbDefault->table('tb_aboutschool')->where("about_menu != ''")->countAllResults();
            $counts['news'] = $dbDefault->table('tb_news')->countAllResults();
        } catch (\Throwable $e) {}

        // 2. Personnel & Board from personnal (skjacth_personnel)
        try {
            $dbPersonnel = \Config\Database::connect('personnal');
            $counts['personnel'] = $dbPersonnel->table('tb_personnel')->where('pers_status', 'กำลังใช้งาน')->countAllResults();
            $counts['board'] = $dbPersonnel->table('tb_board')->countAllResults();
        } catch (\Throwable $e) {}

        // 3. Academic, Study Plans, Clubs from academic (skjacth_academic)
        try {
            $dbAcademic = \Config\Database::connect('academic');
            $counts['academic'] = $dbAcademic->table('tb_subjects')->countAllResults();
            $counts['study_plans'] = $dbAcademic->table('tb_classroom_study_plans')->countAllResults();
            $counts['clubs'] = $dbAcademic->table('tb_clubs')->where("club_status = 'open' OR club_status IS NULL")->countAllResults();
        } catch (\Throwable $e) {}

        // 4. Admission from admission (skjacth_admission)
        try {
            $dbAdmission = \Config\Database::connect('admission');
            $counts['admission'] = $dbAdmission->table('tb_admission_schedule')->countAllResults();
        } catch (\Throwable $e) {}

        // 5. Locations from general (skjacth_general)
        try {
            $dbGeneral = \Config\Database::connect('general');
            $counts['locations'] = $dbGeneral->table('tb_location')->countAllResults();
        } catch (\Throwable $e) {}

        // 6. Timetable from timetable (skjacth_timetable)
        try {
            $dbTimetable = \Config\Database::connect('timetable');
            $counts['timetable'] = $dbTimetable->table('tb_timetable_config_periods')->countAllResults();
        } catch (\Throwable $e) {}

        $dbUrls = [
            'about'       => 'db://skjacth_skj/tb_aboutschool',
            'personnel'   => 'db://skjacth_personnel/tb_personnel',
            'board'       => 'db://skjacth_personnel/tb_board',
            'academic'    => 'db://skjacth_academic/tb_subjects',
            'study_plans' => 'db://skjacth_academic/tb_classroom_study_plans',
            'clubs'       => 'db://skjacth_academic/tb_clubs',
            'admission'   => 'db://skjacth_admission/tb_admission_schedule',
            'locations'   => 'db://skjacth_general/tb_location',
            'timetable'   => 'db://skjacth_timetable/tb_timetable_config_periods',
            'news'        => 'db://skjacth_skj/tb_news',
        ];

        $syncedRows = $this->db->table('tb_chat_ai_knowledge')
            ->select('knowledge_id, title, source_url, char_count, status, updated_at')
            ->whereIn('source_url', array_values($dbUrls))
            ->get()
            ->getResult();

        $syncedMap = [];
        foreach ($syncedRows as $r) {
            $syncedMap[$r->source_url] = $r;
        }

        $databases = [];
        foreach ($dbUrls as $key => $srcUrl) {
            $has = isset($syncedMap[$srcUrl]);
            $databases[$key] = [
                'exists'       => $has,
                'knowledge_id' => $has ? (int)$syncedMap[$srcUrl]->knowledge_id : null,
                'title'        => $has ? $syncedMap[$srcUrl]->title : '',
                'char_count'   => $has ? (int)$syncedMap[$srcUrl]->char_count : 0,
                'status'       => $has ? $syncedMap[$srcUrl]->status : 'off',
                'updated_at'   => $has ? $syncedMap[$srcUrl]->updated_at : null,
                'record_count' => $counts[$key] ?? 0
            ];
        }

        return $this->response->setJSON([
            'status'          => 'success',
            'personnel_count' => $counts['personnel'],
            'academic_count'  => $counts['academic'],
            'news_count'      => $counts['news'],
            'counts'          => $counts,
            'databases'       => $databases
        ]);
    }

    public function syncFromDatabase($type)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();
        $now = date('Y-m-d H:i:s');

        // =======================================================
        // 1. ABOUT SCHOOL (ประวัติ วิสัยทัศน์ อัตลักษณ์ ข้อมูลติดต่อ)
        // =======================================================
        if ($type === 'about') {
            try {
                $dbSkj = \Config\Database::connect('default');

                $aboutRows = $dbSkj->table('tb_aboutschool')
                    ->where("about_menu != ''")
                    ->orderBy('about_id', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($aboutRows)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลเกี่ยวกับโรงเรียน']);
                }

                $content = "=== ข้อมูลพื้นฐาน อัตลักษณ์ ประวัติ และโครงสร้าง โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลเว็บไซต์หลัก ณ วันที่ " . date('d/m/Y H:i') . ")\n\n";

                // Contact & Web settings
                try {
                    $settings = $dbSkj->table('tb_web_settings')->get()->getResultArray();
                    if (!empty($settings)) {
                        $content .= "【ข้อมูลการติดต่อโรงเรียน】\n";
                        foreach ($settings as $st) {
                            $k = trim($st['setting_name'] ?? $st['name'] ?? '');
                            $v = trim($st['setting_value'] ?? $st['value'] ?? '');
                            if (!empty($k) && !empty($v)) {
                                $content .= "- {$k}: {$v}\n";
                            }
                        }
                        $content .= "\n";
                    }
                } catch (\Throwable $e) {}

                foreach ($aboutRows as $ab) {
                    $menuTitle = trim($ab['about_menu']);
                    $rawText = $ab['about_detail'] ?? '';
                    // Clean HTML
                    $cleanText = strip_tags(html_entity_decode($rawText, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    $cleanText = preg_replace("/\r\n|\r/", "\n", $cleanText);
                    $cleanText = preg_replace("/\n{3,}/", "\n\n", $cleanText);
                    $cleanText = trim($cleanText);

                    // Truncate if massive (e.g. over 15000 chars)
                    if (mb_strlen($cleanText, 'UTF-8') > 15000) {
                        $cleanText = mb_substr($cleanText, 0, 15000, 'UTF-8') . "\n... (เนื้อหาขนาดยาวตัดทอนเพื่อความเหมาะสม)";
                    }

                    $content .= "========================================\n";
                    $content .= "【หัวข้อ: {$menuTitle}】\n";
                    $content .= "========================================\n";
                    $content .= $cleanText . "\n\n";
                }

                $title = "ข้อมูลพื้นฐาน ประวัติ วิสัยทัศน์ และอัตลักษณ์โรงเรียน (" . count($aboutRows) . " หมวด)";
                $sourceUrl = "db://skjacth_skj/tb_aboutschool";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($aboutRows),
                    'message'      => "ซิงค์ข้อมูลพื้นฐานโรงเรียนสำเร็จ ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลพื้นฐานโรงเรียน: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 2. PERSONNEL (คณะผู้บริหาร ครู บุคลากร)
        // =======================================================
        if ($type === 'personnel') {
            try {
                $dbPersonnel = \Config\Database::connect('personnal');
                $dbSkj = \Config\Database::connect('default');

                $learningMap = [];
                try {
                    $learnRows = $dbSkj->table('tb_learning')->get()->getResultArray();
                    foreach ($learnRows as $lr) {
                        $learningMap[$lr['lear_id']] = trim($lr['lear_namethai']);
                    }
                } catch (\Throwable $e) {}

                $posMap = [];
                try {
                    $posRows = $dbSkj->table('tb_position')->get()->getResultArray();
                    foreach ($posRows as $pr) {
                        $posMap[$pr['posi_id']] = trim($pr['posi_name']);
                    }
                } catch (\Throwable $e) {}

                $deptMap = [];
                try {
                    $deptRows = $dbSkj->table('tb_department')->get()->getResultArray();
                    foreach ($deptRows as $dr) {
                        $deptMap[$dr['depart_id']] = trim($dr['depart_name']);
                    }
                } catch (\Throwable $e) {}

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

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($teachers),
                    'message'      => "ซิงค์ข้อมูลบุคลากรสำเร็จ " . count($teachers) . " ท่าน ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูลบุคลากร: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 3. BOARD (คณะกรรมการสถานศึกษา)
        // =======================================================
        if ($type === 'board') {
            try {
                $dbPersonnel = \Config\Database::connect('personnal');
                $boards = $dbPersonnel->table('tb_board')
                    ->orderBy('board_sort', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($boards)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลคณะกรรมการสถานศึกษา']);
                }

                $content = "=== ข้อมูลคณะกรรมการสถานศึกษาขั้นพื้นฐาน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูล ณ วันที่ " . date('d/m/Y H:i') . " รวม " . count($boards) . " ท่าน)\n\n";

                $idx = 1;
                foreach ($boards as $b) {
                    $name = trim($b['board_prefix'] . $b['board_firstname'] . ' ' . $b['board_lastname']);
                    $pos = trim($b['board_position']);
                    $btype = !empty($b['board_type']) ? " ({$b['board_type']})" : '';
                    $content .= "{$idx}. {$name} - ตำแหน่ง: {$pos}{$btype}\n";
                    $idx++;
                }

                $title = "ข้อมูลคณะกรรมการสถานศึกษาขั้นพื้นฐาน (" . count($boards) . " ท่าน)";
                $sourceUrl = "db://skjacth_personnel/tb_board";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($boards),
                    'message'      => "ซิงค์คณะกรรมการสถานศึกษาสำเร็จ " . count($boards) . " ท่าน ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลคณะกรรมการ: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 4. ACADEMIC (หลักสูตรและรายวิชา ม.1 - ม.6)
        // =======================================================
        if ($type === 'academic') {
            try {
                $dbAcademic = \Config\Database::connect('academic');

                $subjects = $dbAcademic->table('tb_subjects')
                    ->select('SubjectCode, SubjectName, SubjectClass, SubjectUnit, SubjectHour, SubjectType, FirstGroup, MAX(SubjectYear) as LatestYear')
                    ->where("SubjectYear LIKE '%2567%' OR SubjectYear LIKE '%2568%'")
                    ->groupBy('SubjectCode, SubjectClass, SubjectName, SubjectUnit, SubjectHour, SubjectType, FirstGroup')
                    ->orderBy('SubjectClass', 'ASC')
                    ->orderBy('SubjectType', 'ASC')
                    ->orderBy('SubjectCode', 'ASC')
                    ->get()
                    ->getResultArray();

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

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($subjects),
                    'message'      => "ซิงค์ข้อมูลรายวิชาสำเร็จ " . count($subjects) . " วิชา ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูลรายวิชา: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 5. STUDY PLANS & CLASSROOMS (แผนการเรียนและห้องเรียน)
        // =======================================================
        if ($type === 'study_plans') {
            try {
                $dbAcademic = \Config\Database::connect('academic');

                $plans = $dbAcademic->table('tb_classroom_study_plans')
                    ->orderBy('grade_level', 'ASC')
                    ->orderBy('room', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($plans)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลแผนการเรียนห้องเรียน']);
                }

                $byGrade = [];
                foreach ($plans as $p) {
                    $g = trim($p['grade_level'] ?? 'ไม่ระบุระดับชั้น');
                    $byGrade[$g][] = $p;
                }

                $content = "=== ข้อมูลห้องเรียนและแผนการเรียน (Study Plans) โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลวิชาการ รวม " . count($plans) . " ห้องเรียน ณ วันที่ " . date('d/m/Y H:i') . ")\n\n";

                foreach ($byGrade as $grade => $rooms) {
                    $content .= "========================================\n";
                    $content .= "【ระดับชั้น {$grade}】 (จำนวน " . count($rooms) . " ห้องเรียน)\n";
                    $content .= "========================================\n";
                    foreach ($rooms as $r) {
                        $cName = trim($r['class_name'] ?? "{$grade}/{$r['room']}");
                        $sPlan = trim($r['study_plan'] ?? 'ทั่วไป');
                        $count = !empty($r['student_count']) ? " (จำนวนนักเรียน {$r['student_count']} คน)" : '';
                        $content .= "• ห้อง {$cName}: แผนการเรียน {$sPlan}{$count}\n";
                    }
                    $content .= "\n";
                }

                // Add general plan tracks if available
                try {
                    $tracks = $dbAcademic->table('tb_plans')->get()->getResultArray();
                    if (!empty($tracks)) {
                        $content .= "【สายการเรียน/แผนการเรียนระดับมัธยมศึกษาตอนปลาย】\n";
                        foreach ($tracks as $tr) {
                            $sp = trim($tr['StudentPlan'] ?? '');
                            if (!empty($sp)) $content .= "- {$sp}\n";
                        }
                    }
                } catch (\Throwable $e) {}

                $title = "ข้อมูลแผนการเรียนและห้องเรียน ม.1 - ม.6 (" . count($plans) . " ห้องเรียน)";
                $sourceUrl = "db://skjacth_academic/tb_classroom_study_plans";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($plans),
                    'message'      => "ซิงค์ข้อมูลแผนการเรียนสำเร็จ " . count($plans) . " ห้องเรียน ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลแผนการเรียน: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 6. CLUBS (กิจกรรมชุมนุมและชมรมพัฒนาผู้เรียน)
        // =======================================================
        if ($type === 'clubs') {
            try {
                $dbAcademic = \Config\Database::connect('academic');

                $clubs = $dbAcademic->table('tb_clubs')
                    ->where("club_status = 'open' OR club_status IS NULL")
                    ->orderBy('club_level', 'ASC')
                    ->orderBy('club_name', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($clubs)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลกิจกรรมชุมนุมที่เปิดรับ']);
                }

                $byLevel = [];
                foreach ($clubs as $c) {
                    $lvl = !empty($c['club_level']) ? trim($c['club_level']) : 'ทุกระดับชั้น';
                    $byLevel[$lvl][] = $c;
                }

                $content = "=== ข้อมูลกิจกรรมพัฒนาผู้เรียน / ชุมนุมนักเรียน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลชุมนุม รวม " . count($clubs) . " ชุมนุม ณ วันที่ " . date('d/m/Y H:i') . ")\n\n";

                foreach ($byLevel as $lvl => $list) {
                    $content .= "========================================\n";
                    $content .= "【กลุ่มระดับชั้น: {$lvl}】 (จำนวน " . count($list) . " ชุมนุม)\n";
                    $content .= "========================================\n";
                    foreach ($list as $cl) {
                        $cName = trim($cl['club_name']);
                        $cDesc = trim(preg_replace('/\s+/', ' ', $cl['club_description'] ?? ''));
                        $max = !empty($cl['club_max_participants']) ? " (รับสูงสุด {$cl['club_max_participants']} คน)" : '';
                        $content .= "• ชุมนุม: {$cName}{$max}\n";
                        if (!empty($cDesc)) {
                            $content .= "  รายละเอียด: {$cDesc}\n";
                        }
                    }
                    $content .= "\n";
                }

                $title = "ข้อมูลกิจกรรมชุมนุมพัฒนาผู้เรียน (" . count($clubs) . " ชุมนุม)";
                $sourceUrl = "db://skjacth_academic/tb_clubs";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($clubs),
                    'message'      => "ซิงค์ข้อมูลกิจกรรมชุมนุมสำเร็จ " . count($clubs) . " ชุมนุม ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลชุมนุม: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 7. ADMISSION (การรับสมัครนักเรียน กำหนดการ และหลักสูตร)
        // =======================================================
        if ($type === 'admission') {
            try {
                $dbAdmission = \Config\Database::connect('admission');

                $schedules = $dbAdmission->table('tb_admission_schedule')
                    ->orderBy('schedule_id', 'DESC')
                    ->get()
                    ->getResultArray();

                $courses = $dbAdmission->table('tb_course')
                    ->get()
                    ->getResultArray();

                $content = "=== ข้อมูลการรับสมัครนักเรียนใหม่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากระบบรับสมัครนักเรียน ณ วันที่ " . date('d/m/Y H:i') . ")\n\n";

                if (!empty($schedules)) {
                    $content .= "【กำหนดการและปฏิทินการรับสมัครนักเรียน (ม.1 และ ม.4)】\n";
                    foreach ($schedules as $sc) {
                        $year = trim($sc['schedule_year'] ?? '');
                        $round = trim($sc['schedule_round'] ?? '');
                        $level = trim($sc['schedule_level'] ?? '');
                        $start = !empty($sc['schedule_recruit_start']) ? date('d/m/Y H:i', strtotime($sc['schedule_recruit_start'])) : '-';
                        $end = !empty($sc['schedule_recruit_end']) ? date('d/m/Y H:i', strtotime($sc['schedule_recruit_end'])) : '-';
                        $exam = !empty($sc['schedule_exam']) ? date('d/m/Y', strtotime($sc['schedule_exam'])) : '-';
                        $announce = !empty($sc['schedule_announce']) ? date('d/m/Y', strtotime($sc['schedule_announce'])) : '-';
                        $report = !empty($sc['schedule_report']) ? date('d/m/Y', strtotime($sc['schedule_report'])) : '-';

                        $content .= "■ ปึงบประมาณ/ปีการศึกษา: {$year} | รอบ: {$round} | ระดับชั้น: {$level}\n";
                        $content .= "  - รับสมัคร: {$start} ถึง {$end}\n";
                        $content .= "  - สอบคัดเลือก: {$exam}\n";
                        $content .= "  - ประกาศผลสอบ: {$announce}\n";
                        $content .= "  - รายงานตัวและมอบตัว: {$report}\n";
                        if (!empty($sc['schedule_note'])) {
                            $content .= "  - หมายเหตุ: " . trim($sc['schedule_note']) . "\n";
                        }
                        $content .= "\n";
                    }
                }

                if (!empty($courses)) {
                    $content .= "========================================\n";
                    $content .= "【หลักสูตรและห้องเรียนพิเศษที่เปิดรับสมัคร】\n";
                    $content .= "========================================\n";
                    foreach ($courses as $c) {
                        $full = trim($c['course_fullname']);
                        $ini = !empty($c['course_initials']) ? " ({$c['course_initials']})" : '';
                        $branch = !empty($c['course_branch']) ? " | แผน: {$c['course_branch']}" : '';
                        $lvl = !empty($c['course_gradelevel']) ? " [{$c['course_gradelevel']}]" : '';
                        $content .= "• {$full}{$ini}{$branch}{$lvl}\n";
                    }
                    $content .= "\n";
                }

                // Add quota information if available
                try {
                    $quotas = $dbAdmission->table('tb_quota')->get()->getResultArray();
                    if (!empty($quotas)) {
                        $content .= "【ข้อมูลโควตาและประเภทการรับ】\n";
                        foreach ($quotas as $q) {
                            $qName = $q['quota_name'] ?? $q['name'] ?? '';
                            $qDetail = $q['quota_detail'] ?? $q['detail'] ?? '';
                            if (!empty($qName)) {
                                $content .= "- โควตา: {$qName} " . (!empty($qDetail) ? "({$qDetail})" : "") . "\n";
                            }
                        }
                    }
                } catch (\Throwable $e) {}

                $title = "ข้อมูลกำหนดการและหลักสูตรการรับสมัครนักเรียน (ม.1 และ ม.4)";
                $sourceUrl = "db://skjacth_admission/tb_admission_schedule";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($schedules) + count($courses),
                    'message'      => "ซิงค์ข้อมูลการรับสมัครนักเรียนสำเร็จ ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลการรับสมัคร: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 8. LOCATIONS (อาคาร สถานที่ ห้องประชุม และสนามกีฬา)
        // =======================================================
        if ($type === 'locations') {
            try {
                $dbGeneral = \Config\Database::connect('general');

                $locations = $dbGeneral->table('tb_location')
                    ->orderBy('location_category', 'ASC')
                    ->orderBy('location_name', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($locations)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลอาคารและสถานที่']);
                }

                $content = "=== ข้อมูลอาคาร สถานที่ ห้องประชุม และสนามกีฬา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลบริหารทั่วไป รวม " . count($locations) . " สถานที่ ณ วันที่ " . date('d/m/Y H:i') . ")\n\n";

                $byCat = [];
                foreach ($locations as $l) {
                    $cat = !empty($l['location_category']) ? trim($l['location_category']) : 'สถานที่ทั่วไป';
                    $byCat[$cat][] = $l;
                }

                foreach ($byCat as $cat => $items) {
                    $content .= "【หมวด: {$cat}】 (จำนวน " . count($items) . " แห่ง)\n";
                    foreach ($items as $loc) {
                        $lName = trim($loc['location_name']);
                        $lNum = !empty($loc['location_number']) ? " | ที่ตั้ง: {$loc['location_number']}" : '';
                        $seats = !empty($loc['location_seats']) ? " | ความจุ: {$loc['location_seats']} ที่นั่ง" : '';
                        $desc = !empty($loc['location_detail']) ? " | รายละเอียด: " . trim($loc['location_detail']) : '';
                        $content .= "• {$lName}{$lNum}{$seats}{$desc}\n";
                    }
                    $content .= "\n";
                }

                $title = "ข้อมูลอาคาร สถานที่ ห้องประชุม และสนามกีฬา (" . count($locations) . " แห่ง)";
                $sourceUrl = "db://skjacth_general/tb_location";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($locations),
                    'message'      => "ซิงค์ข้อมูลอาคารและสถานที่สำเร็จ " . count($locations) . " แห่ง ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลสถานที่: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 9. TIMETABLE (ตารางเวลาคาบเรียนและการจัดเวลา)
        // =======================================================
        if ($type === 'timetable') {
            try {
                $dbTimetable = \Config\Database::connect('timetable');

                $periods = $dbTimetable->table('tb_timetable_config_periods')
                    ->orderBy('period_number', 'ASC')
                    ->get()
                    ->getResultArray();

                if (empty($periods)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบข้อมูลตารางคาบเรียน']);
                }

                $content = "=== ข้อมูลตารางเวลาและคาบเรียนประจำวัน โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ ===\n";
                $content .= "(ข้อมูลเชื่อมโยงจากฐานข้อมูลตารางเรียน ณ วันที่ " . date('d/m/Y H:i') . ")\n\n";

                $content .= "【กำหนดการเวลาเรียนแต่ละคาบ】\n";
                foreach ($periods as $p) {
                    $num = $p['period_number'];
                    $start = substr($p['start_time'], 0, 5);
                    $end = substr($p['end_time'], 0, 5);
                    $break = !empty($p['is_break']) ? " [ช่วงพักรับประทานอาหาร/พักผ่อน]" : '';
                    $grp = !empty($p['level_group']) && $p['level_group'] !== 'ALL' ? " (เฉพาะ {$p['level_group']})" : '';
                    $content .= "• คาบที่ {$num}: เวลา {$start} - {$end} น.{$break}{$grp}\n";
                }

                $title = "ข้อมูลตารางเวลาและคาบเรียนประจำวัน (" . count($periods) . " คาบ)";
                $sourceUrl = "db://skjacth_timetable/tb_timetable_config_periods";
                $charCount = mb_strlen($content, 'UTF-8');

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($periods),
                    'message'      => "ซิงค์ข้อมูลตารางเวลาคาบเรียนสำเร็จ ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการดึงข้อมูลตารางเวลา: ' . $e->getMessage()]);
            }
        }

        // =======================================================
        // 10. NEWS (ข่าวประชาสัมพันธ์ 25 ข่าวล่าสุด)
        // =======================================================
        if ($type === 'news') {
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

                $kId = $this->saveOrUpdateKnowledgeRecord($title, 'database', $sourceUrl, $content, $charCount, $now);

                return $this->response->setJSON([
                    'status'       => 'success',
                    'knowledge_id' => $kId,
                    'title'        => $title,
                    'char_count'   => $charCount,
                    'record_count' => count($newsRows),
                    'message'      => "ซิงค์ข่าวสารสำเร็จ 25 ข่าวล่าสุด ({$charCount} ตัวอักษร)"
                ]);
            } catch (\Throwable $e) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูลข่าวสาร: ' . $e->getMessage()]);
            }
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่รู้จักประเภทฐานข้อมูลที่ระบุ']);
    }

    private function saveOrUpdateKnowledgeRecord($title, $sourceType, $sourceUrl, $content, $charCount, $timestamp)
    {
        $existing = $this->db->table('tb_chat_ai_knowledge')->where('source_url', $sourceUrl)->get()->getRow();
        if ($existing) {
            $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $existing->knowledge_id)->update([
                'title'          => $title,
                'content'        => $content,
                'char_count'     => $charCount,
                'status'         => 'on',
                'last_synced_at' => $timestamp,
                'updated_at'     => $timestamp
            ]);
            return $existing->knowledge_id;
        } else {
            $this->db->table('tb_chat_ai_knowledge')->insert([
                'title'          => $title,
                'source_type'    => $sourceType,
                'source_url'     => $sourceUrl,
                'content'        => $content,
                'char_count'     => $charCount,
                'status'         => 'on',
                'last_synced_at' => $timestamp,
                'created_at'     => $timestamp,
                'updated_at'     => $timestamp
            ]);
            return $this->db->insertID();
        }
    }

    public function deleteDatabaseKnowledge($type)
    {
        if ($redir = $this->checkAuth()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized'])->setStatusCode(401);
        }

        $this->ensureAiKnowledgeTable();

        $dbUrls = [
            'about'       => 'db://skjacth_skj/tb_aboutschool',
            'personnel'   => 'db://skjacth_personnel/tb_personnel',
            'board'       => 'db://skjacth_personnel/tb_board',
            'academic'    => 'db://skjacth_academic/tb_subjects',
            'study_plans' => 'db://skjacth_academic/tb_classroom_study_plans',
            'clubs'       => 'db://skjacth_academic/tb_clubs',
            'admission'   => 'db://skjacth_admission/tb_admission_schedule',
            'locations'   => 'db://skjacth_general/tb_location',
            'timetable'   => 'db://skjacth_timetable/tb_timetable_config_periods',
            'news'        => 'db://skjacth_skj/tb_news',
        ];

        if (!isset($dbUrls[$type])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบประเภทฐานข้อมูลที่ระบุ']);
        }

        $sourceUrl = $dbUrls[$type];
        $existing = $this->db->table('tb_chat_ai_knowledge')->where('source_url', $sourceUrl)->get()->getRow();

        if (!$existing) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลนี้ไม่ได้อยู่ในคลังความรู้ AI']);
        }

        $this->db->table('tb_chat_ai_knowledge')->where('knowledge_id', $existing->knowledge_id)->delete();

        $names = [
            'about'       => 'ข้อมูลพื้นฐานและอัตลักษณ์โรงเรียน',
            'personnel'   => 'ข้อมูลบุคลากรและคณะครู',
            'board'       => 'ข้อมูลคณะกรรมการสถานศึกษา',
            'academic'    => 'ข้อมูลหลักสูตรและรายวิชา',
            'study_plans' => 'ข้อมูลแผนการเรียนและห้องเรียน',
            'clubs'       => 'ข้อมูลกิจกรรมชุมนุมนักเรียน',
            'admission'   => 'ข้อมูลการรับสมัครนักเรียน',
            'locations'   => 'ข้อมูลอาคารและสถานที่',
            'timetable'   => 'ข้อมูลตารางเวลาคาบเรียน',
            'news'        => 'ข้อมูลข่าวประชาสัมพันธ์'
        ];
        $typeName = $names[$type] ?? 'ฐานข้อมูล';

        return $this->response->setJSON([
            'status'  => 'success',
            'type'    => $type,
            'message' => "ลบ{$typeName}ออกจากคลังความรู้ AI เรียบร้อยแล้ว (ข้อมูลจริงในระบบไม่ได้รับผลกระทบ)"
        ]);
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


