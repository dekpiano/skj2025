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

        $this->db->table('tb_chat_sessions')
            ->where('session_id', $sessionId)
            ->update(['unread_admin_count' => 0]);

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

        $this->db->table('tb_chat_sessions')->where('session_id', $sessionId)->update([
            'updated_at'        => date('Y-m-d H:i:s'),
            'unread_user_count' => ($session->unread_user_count ?? 0) + 1,
            'status'            => 'active'
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
}

