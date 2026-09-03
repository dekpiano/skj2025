<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class ChatApi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->setCorsHeaders();
        $this->ensureChatTablesExist();
    }

    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization, X-CSRF-TOKEN');
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
            exit(0);
        }
    }

    public function optionsHandler()
    {
        $this->setCorsHeaders();
        return $this->response->setStatusCode(200)->setBody('OK');
    }

    private function ensureChatTablesExist()
    {
        try {
            $sqlSessions = "CREATE TABLE IF NOT EXISTS tb_chat_sessions (
                session_id INT(11) NOT NULL AUTO_INCREMENT,
                session_token VARCHAR(64) NOT NULL UNIQUE,
                user_name VARCHAR(150) NOT NULL,
                user_tel VARCHAR(50) NULL,
                user_ip VARCHAR(45) NULL,
                user_agent TEXT NULL,
                telegram_last_msg_id VARCHAR(50) NULL,
                status ENUM('active', 'closed') DEFAULT 'active',
                unread_user_count INT(11) DEFAULT 0,
                unread_admin_count INT(11) DEFAULT 0,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY (session_id),
                INDEX idx_token (session_token),
                INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->query($sqlSessions);

            $sqlMessages = "CREATE TABLE IF NOT EXISTS tb_chat_messages (
                message_id INT(11) NOT NULL AUTO_INCREMENT,
                session_id INT(11) NOT NULL,
                sender_type ENUM('user', 'admin', 'system') NOT NULL,
                sender_name VARCHAR(150) NULL,
                message TEXT NOT NULL,
                attachment_url VARCHAR(255) NULL,
                attachment_type VARCHAR(50) NULL,
                is_bot TINYINT(1) DEFAULT 0,
                telegram_msg_id VARCHAR(50) NULL,
                is_read TINYINT(1) DEFAULT 0,
                created_at DATETIME NOT NULL,
                PRIMARY KEY (message_id),
                INDEX idx_session (session_id),
                INDEX idx_sender (sender_type),
                INDEX idx_created (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->query($sqlMessages);

            // Check if column attachment_url exists in tb_chat_messages
            $columns = $this->db->getFieldNames('tb_chat_messages');
            if (!in_array('attachment_url', $columns)) {
                $this->db->query("ALTER TABLE tb_chat_messages ADD COLUMN attachment_url VARCHAR(255) NULL AFTER message");
            }
            if (!in_array('attachment_type', $columns)) {
                $this->db->query("ALTER TABLE tb_chat_messages ADD COLUMN attachment_type VARCHAR(50) NULL AFTER attachment_url");
            }

            // Ensure columns in tb_chat_sessions
            $sessionCols = $this->db->getFieldNames('tb_chat_sessions');
            if (!in_array('admin_active_at', $sessionCols)) {
                $this->db->query("ALTER TABLE tb_chat_sessions ADD COLUMN admin_active_at DATETIME NULL DEFAULT NULL AFTER unread_admin_count");
            }
            if (!in_array('last_admin_reply_at', $sessionCols)) {
                $this->db->query("ALTER TABLE tb_chat_sessions ADD COLUMN last_admin_reply_at DATETIME NULL DEFAULT NULL AFTER admin_active_at");
            }
            if (!in_array('is_bot_paused', $sessionCols)) {
                $this->db->query("ALTER TABLE tb_chat_sessions ADD COLUMN is_bot_paused TINYINT(1) NOT NULL DEFAULT 0 AFTER last_admin_reply_at");
            }
            // Ensure tb_telegram_config exists
            $sqlTelegram = "CREATE TABLE IF NOT EXISTS tb_telegram_config (
                telegram_id INT(11) NOT NULL AUTO_INCREMENT,
                telegram_bot_token VARCHAR(255) NULL,
                telegram_chat_id VARCHAR(100) NULL,
                telegram_chat_title VARCHAR(255) NULL,
                telegram_status ENUM('on', 'off') DEFAULT 'on',
                updated_at DATETIME NOT NULL,
                PRIMARY KEY (telegram_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $this->db->query($sqlTelegram);

            $hasConfig = $this->db->table('tb_telegram_config')->where('telegram_id', 1)->countAllResults();
            if ($hasConfig == 0) {
                $this->db->table('tb_telegram_config')->insert([
                    'telegram_id'        => 1,
                    'telegram_bot_token' => '',
                    'telegram_chat_id'   => '',
                    'telegram_chat_title'=> 'SKJ Live Chat Notifications',
                    'telegram_status'    => 'on',
                    'updated_at'         => date('Y-m-d H:i:s')
                ]);
            }

            // Ensure tb_chat_ai_config exists for Google Gemini AI Chatbot
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
            log_message('error', '[ensureChatTablesExist] ' . $e->getMessage());
        }
    }

    public function initSession()
    {
        $this->setCorsHeaders();

        $token = trim($this->request->getPost('session_token') ?? '');
        $name = trim($this->request->getPost('user_name') ?? '');
        $tel = trim($this->request->getPost('user_tel') ?? '');

        if (!empty($token)) {
            $session = $this->db->table('tb_chat_sessions')->where('session_token', $token)->get()->getRow();
            if ($session) {
                if (!empty($name) && $name !== $session->user_name) {
                    $this->db->table('tb_chat_sessions')->where('session_id', $session->session_id)->update([
                        'user_name'  => $name,
                        'user_tel'   => !empty($tel) ? $tel : $session->user_tel,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $session->user_name = $name;
                }

                $messages = $this->db->table('tb_chat_messages')
                    ->where('session_id', $session->session_id)
                    ->orderBy('created_at', 'ASC')
                    ->get()
                    ->getResult();

                return $this->response->setJSON([
                    'status'   => 'success',
                    'session'  => $session,
                    'messages' => $messages
                ]);
            }
        }

        if (empty($name)) {
            $name = 'ผู้ติดต่อทั่วไป';
        }

        $newToken = bin2hex(random_bytes(16));
        $insertData = [
            'session_token'       => $newToken,
            'user_name'           => $name,
            'user_tel'            => $tel,
            'user_ip'             => $this->request->getIPAddress(),
            'user_agent'          => substr($this->request->getUserAgent()->getAgentString(), 0, 500),
            'status'              => 'active',
            'unread_user_count'   => 0,
            'unread_admin_count'  => 0,
            'created_at'          => date('Y-m-d H:i:s'),
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        $this->db->table('tb_chat_sessions')->insert($insertData);
        $sessionId = $this->db->insertID();

        $greeting = [
            'session_id'      => $sessionId,
            'sender_type'     => 'system',
            'sender_name'     => 'ระบบตอบรับอัตโนมัติ SKJ',
            'message'         => "สวัสดีครับ ยินดีต้อนรับสู่โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ 🌸\nท่านสามารถพิมพ์ข้อความ แนบรูปภาพ หรือเลือกหัวข้อคำถามพบบ่อยด้านล่างได้เลยครับ เจ้าหน้าที่พร้อมให้คำแนะนำและบริการครับ ✨",
            'attachment_url'  => null,
            'attachment_type' => null,
            'is_bot'          => 1,
            'is_read'         => 1,
            'created_at'      => date('Y-m-d H:i:s')
        ];
        $this->db->table('tb_chat_messages')->insert($greeting);

        $session = $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->get()->getRow();
        $messages = $this->db->table('tb_chat_messages')->where('session_id', $sessionId)->orderBy('created_at', 'ASC')->get()->getResult();

        return $this->response->setJSON([
            'status'   => 'success',
            'session'  => $session,
            'messages' => $messages
        ]);
    }

    public function uploadAttachment()
    {
        $this->setCorsHeaders();

        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ไม่พบไฟล์หรือไฟล์ไม่ถูกต้อง: ' . ($file ? $file->getErrorString() : '')
            ]);
        }

        // Validate MIME type
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'application/pdf'];
        $mime = $file->getMimeType();
        if (!in_array($mime, $allowedMimes)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'รองรับเฉพาะไฟล์รูปภาพ (JPG, PNG, WEBP, GIF) หรือ PDF เท่านั้น'
            ]);
        }

        // Max 5MB
        if ($file->getSizeByUnit('mb') > 5) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ขนาดไฟล์เกิน 5MB กรุณาเลือกไฟล์ที่มีขนาดเล็กลง'
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

    public function sendMessage()
    {
        $this->setCorsHeaders();

        $token = trim($this->request->getPost('session_token') ?? '');
        $messageText = trim($this->request->getPost('message') ?? '');
        $attachmentUrl = trim($this->request->getPost('attachment_url') ?? '');
        $attachmentType = trim($this->request->getPost('attachment_type') ?? '');
        $name = trim($this->request->getPost('user_name') ?? '');
        $tel = trim($this->request->getPost('user_tel') ?? '');

        if (empty($token) || (empty($messageText) && empty($attachmentUrl))) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
        }

        $session = $this->db->table('tb_chat_sessions')->where('session_token', $token)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ไม่พบประวัติการสนทนา']);
        }

        $updateSession = [
            'updated_at'         => date('Y-m-d H:i:s'),
            'unread_admin_count' => ($session->unread_admin_count ?? 0) + 1,
            'status'             => 'active'
        ];
        if (!empty($name)) $updateSession['user_name'] = $name;
        if (!empty($tel))  $updateSession['user_tel'] = $tel;
        $this->db->table('tb_chat_sessions')->where('session_id', $session->session_id)->update($updateSession);

        $cleanText = !empty($messageText) ? htmlspecialchars($messageText, ENT_QUOTES, 'UTF-8') : '';
        $insertMsg = [
            'session_id'      => $session->session_id,
            'sender_type'     => 'user',
            'sender_name'     => !empty($name) ? $name : $session->user_name,
            'message'         => $cleanText,
            'attachment_url'  => !empty($attachmentUrl) ? $attachmentUrl : null,
            'attachment_type' => !empty($attachmentType) ? $attachmentType : null,
            'is_bot'          => 0,
            'is_read'         => 0,
            'created_at'      => date('Y-m-d H:i:s')
        ];
        $this->db->table('tb_chat_messages')->insert($insertMsg);
        $messageId = $this->db->insertID();

        // Forward to Telegram
        $telegramResult = $this->forwardToTelegram($session, $insertMsg['sender_name'], $messageText, $attachmentUrl);
        if ($telegramResult['success'] && !empty($telegramResult['telegram_msg_id'])) {
            $this->db->table('tb_chat_messages')->where('message_id', $messageId)->update([
                'telegram_msg_id' => $telegramResult['telegram_msg_id']
            ]);
            $this->db->table('tb_chat_sessions')->where('session_id', $session->session_id)->update([
                'telegram_last_msg_id' => $telegramResult['telegram_msg_id']
            ]);
        }

        $newMsg = $this->db->table('tb_chat_messages')->where('message_id', $messageId)->get()->getRow();

        // Check if Human Staff / Admin is currently active in this room or bot is paused
        $isStaffActive = $this->isStaffActiveInSession($session);

        $botReply = null;
        if (!$isStaffActive) {
            // 1. Try Gemini AI Auto Reply first (if enabled and configured)
            $botReply = $this->getAiAutoReply($session, $messageText);

            // 2. Fallback to Local Smart FAQ Matcher if AI is disabled, unconfigured, or timed out
            if (!$botReply) {
                $botReply = $this->checkSmartAutoReply($session, $messageText);
            }
        } else {
            log_message('info', "[ChatApi] AI Auto-reply skipped for session #{$session->session_id} (Staff is active in room or bot paused).");
        }

        return $this->response->setJSON([
            'status'    => 'success',
            'message'   => $newMsg,
            'bot_reply' => $botReply
        ]);
    }

    public function getMessages()
    {
        $this->setCorsHeaders();

        $token = trim($this->request->getGet('session_token') ?? '');
        $lastId = (int)($this->request->getGet('last_message_id') ?? 0);

        if (empty($token)) {
            return $this->response->setJSON(['status' => 'error', 'messages' => []]);
        }

        $this->syncTelegramUpdates();

        $session = $this->db->table('tb_chat_sessions')->where('session_token', $token)->get()->getRow();
        if (!$session) {
            return $this->response->setJSON(['status' => 'error', 'messages' => []]);
        }

        $builder = $this->db->table('tb_chat_messages')
            ->where('session_id', $session->session_id);

        if ($lastId > 0) {
            $builder->where('message_id >', $lastId);
        }

        $messages = $builder->orderBy('created_at', 'ASC')->get()->getResult();

        if (!empty($messages)) {
            $this->db->table('tb_chat_messages')
                ->where('session_id', $session->session_id)
                ->whereIn('sender_type', ['admin', 'system'])
                ->where('is_read', 0)
                ->update(['is_read' => 1]);

            $this->db->table('tb_chat_sessions')
                ->where('session_id', $session->session_id)
                ->update(['unread_user_count' => 0]);
        }

        return $this->response->setJSON([
            'status'   => 'success',
            'messages' => $messages
        ]);
    }

    /**
     * Check if human staff / admin is currently active, conversing, or paused bot for this session
     */
    private function isStaffActiveInSession($session)
    {
        if (!$session) return false;

        // Fresh fetch to get latest status
        $freshSession = $this->db->table('tb_chat_sessions')->where('session_id', $session->session_id)->get()->getRow();
        if ($freshSession) {
            $session = $freshSession;
        }

        // 1. Manually paused by staff
        if (isset($session->is_bot_paused) && (int)$session->is_bot_paused === 1) {
            return true;
        }

        $now = time();

        // 2. Staff is actively viewing this room in Admin panel (admin_active_at within last 25 seconds)
        if (!empty($session->admin_active_at)) {
            $diffSec = $now - strtotime($session->admin_active_at);
            if ($diffSec >= 0 && $diffSec <= 25) {
                return true;
            }
        }

        // 3. Staff replied recently (last_admin_reply_at within last 300 seconds / 5 mins)
        if (!empty($session->last_admin_reply_at)) {
            $diffReply = $now - strtotime($session->last_admin_reply_at);
            if ($diffReply >= 0 && $diffReply <= 300) {
                return true;
            }
        }

        // 4. Double check tb_chat_messages for any recent admin message within last 5 mins
        $recentAdminCount = $this->db->table('tb_chat_messages')
            ->where('session_id', $session->session_id)
            ->where('sender_type', 'admin')
            ->where('created_at >=', date('Y-m-d H:i:s', $now - 300))
            ->countAllResults();

        if ($recentAdminCount > 0) {
            return true;
        }

        return false;
    }

    private function getAiAutoReply($session, $userText)
    {
        if (empty($userText)) return null;

        try {
            $aiConfig = $this->db->table('tb_chat_ai_config')->where('ai_id', 1)->get()->getRow();
            if (!$aiConfig || $aiConfig->ai_status !== 'on' || empty($aiConfig->ai_api_key)) {
                return null;
            }

            $apiKey = trim($aiConfig->ai_api_key);
            $model = !empty($aiConfig->ai_model) ? trim($aiConfig->ai_model) : 'gemini-3.5-flash';
            $systemPrompt = !empty($aiConfig->ai_system_prompt) ? trim($aiConfig->ai_system_prompt) : '';
            $temperature = isset($aiConfig->ai_temperature) ? (float)$aiConfig->ai_temperature : 0.7;
            $maxTokens = isset($aiConfig->ai_max_tokens) ? (int)$aiConfig->ai_max_tokens : 500;

            // Fetch last 3-4 recent messages for conversational context
            $recentMsgs = $this->db->table('tb_chat_messages')
                ->where('session_id', $session->session_id)
                ->orderBy('created_at', 'DESC')
                ->limit(4)
                ->get()
                ->getResult();

            $contextSummary = "";
            if (!empty($recentMsgs)) {
                $recentMsgs = array_reverse($recentMsgs);
                $historyLines = [];
                foreach ($recentMsgs as $rm) {
                    $who = ($rm->sender_type === 'user') ? 'ผู้ใช้' : 'บอท/เจ้าหน้าที่';
                    $msgPreview = mb_substr(strip_tags($rm->message), 0, 150);
                    if (!empty($msgPreview)) {
                        $historyLines[] = "{$who}: {$msgPreview}";
                    }
                }
                if (!empty($historyLines)) {
                    $contextSummary = "บทสนทนาก่อนหน้านี้:\n" . implode("\n", $historyLines) . "\n\n";
                }
            }

            $userPrompt = (!empty($contextSummary) ? $contextSummary : "") . "ข้อความล่าสุดจากผู้ใช้: " . trim($userText);

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
                            ['text' => $userPrompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'     => $temperature,
                    'maxOutputTokens' => 1200,
                    'thinkingConfig'  => [
                        'thinkingBudget' => 0
                    ]
                ]
            ];

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($apiKey);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($curlError || $httpCode !== 200 || empty($response)) {
                log_message('warning', "[ChatApi::getAiAutoReply] Gemini API call failed (HTTP {$httpCode}): " . ($curlError ?: $response));
                return null;
            }

            $resJson = json_decode($response, true);
            $aiAnswer = $resJson['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (empty($aiAnswer)) {
                return null;
            }

            $aiAnswer = trim($aiAnswer);

            $botMsg = [
                'session_id'      => $session->session_id,
                'sender_type'     => 'system',
                'sender_name'     => '🤖 น้องกุหลาบ (SKJ AI Assistant)',
                'message'         => $aiAnswer,
                'attachment_url'  => null,
                'attachment_type' => null,
                'is_bot'          => 1,
                'is_read'         => 0,
                'created_at'      => date('Y-m-d H:i:s')
            ];
            $this->db->table('tb_chat_messages')->insert($botMsg);
            $botMsg['message_id'] = $this->db->insertID();

            $this->db->table('tb_chat_sessions')->where('session_id', $session->session_id)->update([
                'updated_at'        => date('Y-m-d H:i:s'),
                'unread_user_count' => ($session->unread_user_count ?? 0) + 1
            ]);

            return (object)$botMsg;

        } catch (\Throwable $e) {
            log_message('error', '[ChatApi::getAiAutoReply] Exception: ' . $e->getMessage());
            return null;
        }
    }

    private function checkSmartAutoReply($session, $userText)
    {
        if (empty($userText)) return null;

        $text = mb_strtolower(trim($userText), 'UTF-8');
        $answer = null;

        // Smart FAQ Matcher
        if (preg_match('/(สมัคร|รับสมัคร|มอบตัว|สอบเข้า|ม\.1|ม\.4|โควตา|admission)/ui', $text)) {
            $answer = "📋 **ข้อมูลการรับสมัครนักเรียน (ม.1 และ ม.4)**\n• โรงเรียนเปิดรับสมัครผ่านระบบออนไลน์และที่อาคารอำนวยการ\n• เอกสารที่ต้องใช้: สำเนา ปพ.1, สำเนาทะเบียนบ้าน, สำเนาบัตรประชาชน\n• สามารถดูรายละเอียดระเบียบการได้ที่หน้าเว็บไซต์หลัก หรือพิมพ์ฝากคำถามไว้ได้เลยครับ เจ้าหน้าที่จะติดต่อกลับครับ ✨";
        } elseif (preg_match('/(ติดต่อ|เบอร์โทร|โทรศัพท์|ที่อยู่|แผนที่|ตำแหน่ง|เดินทาง)/ui', $text)) {
            $answer = "📞 **ข้อมูลการติดต่อโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์**\n• เบอร์โทรศัพท์สำนักงาน: 056-009-667\n• ที่อยู่: 160 ม.1 ต.นครสวรรค์ออก อ.เมือง จ.นครสวรรค์ 60000\n• แผนที่: ตั้งอยู่ใกล้ค่ายจิรประวัติ สามารถเปิดดูผ่าน Google Maps ได้ครับ 📍";
        } elseif (preg_match('/(เวลาทำการ|เปิดกี่โมง|ปิดกี่โมง|วันทำการ|ติดต่อได้ตอนไหน)/ui', $text)) {
            $answer = "⏰ **เวลาทำการของโรงเรียน**\n• วันจันทร์ - วันศุกร์: 08:00 - 16:30 น. (เว้นวันหยุดราชการและวันหยุดนักขัตฤกษ์)\n• ท่านสามารถพิมพ์ข้อความทิ้งไว้ได้ตลอด 24 ชม. เจ้าหน้าที่จะตอบกลับโดยเร็วที่สุดครับ";
        } elseif (preg_match('/(หลักสูตร|ห้องเรียน|วิทย์-คณิต|ศิลป์|แผนการเรียน|ep|mep|smte)/ui', $text)) {
            $answer = "📚 **แผนการเรียนและหลักสูตร**\n• ระดับ ม.ต้น: ห้องเรียนทั่วไป และโครงการห้องเรียนพิเศษ\n• ระดับ ม.ปลาย: แผนการเรียนวิทยาศาสตร์-คณิตศาสตร์, ภาษา-สังคม, ภาษาต่างประเทศ และเทคโนโลยี\n• สนใจแผนการเรียนใดเป็นพิเศษ พิมพ์สอบถามเพิ่มเติมได้เลยครับ 🌸";
        } elseif (preg_match('/(ปฏิทิน|กิจกรรม|เปิดเทอม|ปิดเทอม|สอบ)/ui', $text)) {
            $answer = "📅 **ปฏิทินการศึกษาและกิจกรรม**\n• สามารถติดตามกำหนดการเปิด-ปิดภาคเรียน และวันสอบวัดผลได้ทางหน้าปฏิทินกิจกรรมบนเว็บไซต์หลัก หรือสอบถามงานวิชาการได้โดยตรงครับ";
        } elseif (preg_match('/(ค่าเทอม|ค่าธรรมเนียม|ค่าใช้จ่าย|สลิป|ชำระเงิน)/ui', $text)) {
            $answer = "💳 **ค่าธรรมเนียมการศึกษา**\n• การชำระเงินสามารถดำเนินการผ่านระบบออนไลน์หรือที่ฝ่ายการเงินของโรงเรียน\n• หากท่านได้โอนชำระเงินแล้ว สามารถกดปุ่มแนบรูปภาพส่งสลิปหลักฐานในช่องแชทนี้ได้เลยครับ";
        }

        if ($answer) {
            $botMsg = [
                'session_id'      => $session->session_id,
                'sender_type'     => 'system',
                'sender_name'     => 'ระบบตอบกลับอัตโนมัติ (SKJ FAQ)',
                'message'         => $answer,
                'attachment_url'  => null,
                'attachment_type' => null,
                'is_bot'          => 1,
                'is_read'         => 0,
                'created_at'      => date('Y-m-d H:i:s')
            ];
            $this->db->table('tb_chat_messages')->insert($botMsg);
            $botMsg['message_id'] = $this->db->insertID();

            $this->db->table('tb_chat_sessions')->where('session_id', $session->session_id)->update([
                'updated_at'        => date('Y-m-d H:i:s'),
                'unread_user_count' => ($session->unread_user_count ?? 0) + 1
            ]);

            return (object)$botMsg;
        }

        return null;
    }

    private function syncTelegramUpdates()
    {
        try {
            $config = $this->db->table('tb_telegram_config')->where('telegram_id', 1)->get()->getRow();
            if (!$config || $config->telegram_status !== 'on' || empty($config->telegram_bot_token)) {
                return;
            }

            $cache = \Config\Services::cache();
            $lastUpdateId = (int)($cache->get('tg_main_last_update_id') ?? 0);

            $url = "https://api.telegram.org/bot{$config->telegram_bot_token}/getUpdates?offset=" . ($lastUpdateId + 1) . "&limit=10&timeout=0";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || empty($response)) {
                return;
            }

            $data = json_decode($response, true);
            if (!isset($data['ok']) || $data['ok'] !== true || empty($data['result'])) {
                return;
            }

            $maxUpdateId = $lastUpdateId;
            foreach ($data['result'] as $update) {
                $updateId = $update['update_id'] ?? 0;
                if ($updateId > $maxUpdateId) {
                    $maxUpdateId = $updateId;
                }

                $msg = $update['message'] ?? null;
                if (!$msg) continue;

                $replyTo = $msg['reply_to_message'] ?? null;
                $replyText = trim($msg['text'] ?? '');
                $fromAdmin = $msg['from']['first_name'] ?? 'เจ้าหน้าที่ (Telegram)';

                if (!$replyTo || empty($replyText)) continue;

                $targetTelegramMsgId = $replyTo['message_id'] ?? null;
                if (!$targetTelegramMsgId) continue;

                $session = $this->db->table('tb_chat_sessions')
                    ->where('telegram_last_msg_id', $targetTelegramMsgId)
                    ->get()->getRow();

                if (!$session) {
                    $matchedMsg = $this->db->table('tb_chat_messages')
                        ->where('telegram_msg_id', $targetTelegramMsgId)
                        ->get()->getRow();
                    if ($matchedMsg) {
                        $session = $this->db->table('tb_chat_sessions')
                            ->where('session_id', $matchedMsg->session_id)
                            ->get()->getRow();
                    }
                }

                if ($session) {
                    $existing = $this->db->table('tb_chat_messages')
                        ->where('telegram_msg_id', $msg['message_id'])
                        ->countAllResults();

                    if ($existing == 0) {
                        $this->db->table('tb_chat_messages')->insert([
                            'session_id'      => $session->session_id,
                            'sender_type'     => 'admin',
                            'sender_name'     => $fromAdmin,
                            'message'         => htmlspecialchars($replyText, ENT_QUOTES, 'UTF-8'),
                            'attachment_url'  => null,
                            'attachment_type' => null,
                            'is_bot'          => 0,
                            'telegram_msg_id' => $msg['message_id'],
                            'is_read'         => 0,
                            'created_at'      => date('Y-m-d H:i:s')
                        ]);

                        $this->db->table('tb_chat_sessions')
                            ->where('session_id', $session->session_id)
                            ->update([
                                'updated_at'        => date('Y-m-d H:i:s'),
                                'unread_user_count' => ($session->unread_user_count ?? 0) + 1,
                                'status'            => 'active'
                            ]);
                    }
                }
            }

            if ($maxUpdateId > $lastUpdateId) {
                $cache->save('tg_main_last_update_id', $maxUpdateId, 86400);
            }
        } catch (\Throwable $e) {
            log_message('error', '[syncTelegramUpdates] ' . $e->getMessage());
        }
    }

    private function forwardToTelegram($session, $senderName, $text, $attachmentUrl = null)
    {
        try {
            $config = $this->db->table('tb_telegram_config')->where('telegram_id', 1)->get()->getRow();
            if (!$config || $config->telegram_status !== 'on' || empty($config->telegram_bot_token) || empty($config->telegram_chat_id)) {
                return ['success' => false, 'message' => 'Telegram not configured'];
            }

            $shortToken = substr($session->session_token, 0, 8);
            $tel = !empty($session->user_tel) ? $session->user_tel : '-';

            $adminChatUrl = site_url('admin/live-chat?session=' . $session->session_token);
            $tgChatUrl = str_replace('://localhost', '://127.0.0.1', $adminChatUrl);

            $msg = "💬 <b>มีข้อความแชทใหม่จากเว็บหลักโรงเรียน SKJ!</b>\n";
            $msg .= "━━━━━━━━━━━━━━━━━━━\n";
            $msg .= "👤 <b>ผู้ติดต่อ:</b> " . htmlspecialchars($senderName, ENT_QUOTES, 'UTF-8') . "\n";
            $msg .= "📱 <b>เบอร์โทร:</b> <code>{$tel}</code>\n";
            $msg .= "🆔 <b>รหัสห้อง:</b> <code>#CHAT_{$shortToken}</code>\n";
            $msg .= "🕒 <b>เวลา:</b> " . date('d/m/Y H:i:s') . " น.\n";
            $msg .= "━━━━━━━━━━━━━━━━━━━\n";
            if (!empty($text)) {
                $msg .= "💬 <b>ข้อความ:</b>\n" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "\n";
            }
            if (!empty($attachmentUrl)) {
                $fullFileUrl = base_url($attachmentUrl);
                $msg .= "📎 <b>ไฟล์แนบ/รูปภาพ:</b> <a href=\"{$fullFileUrl}\">เปิดดูรูปภาพ</a>\n";
            }
            $msg .= "━━━━━━━━━━━━━━━━━━━\n";
            $msg .= "👉 <i>กด <b>Reply</b> เพื่อตอบกลับใน Telegram หรือ</i>\n";
            $msg .= "🖥️ <b>เปิดหน้าเว็บตอบแชท:</b>\n<a href=\"{$tgChatUrl}\">{$tgChatUrl}</a>";

            $postData = [
                'chat_id'                  => $config->telegram_chat_id,
                'text'                     => $msg,
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => false
            ];

            $url = "https://api.telegram.org/bot{$config->telegram_bot_token}/sendMessage";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $resData = json_decode($response, true);
            if ($httpCode === 200 && isset($resData['ok']) && $resData['ok'] === true) {
                $tgMsgId = $resData['result']['message_id'] ?? null;
                return ['success' => true, 'telegram_msg_id' => $tgMsgId];
            }

            return ['success' => false, 'error' => "HTTP $httpCode"];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
