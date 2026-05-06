<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class ConBotanyLogin extends BaseController
{
    public function index()
    {
        if (session()->get('botany_logged_in')) {
            return redirect()->to(base_url('Admin/Botany'));
        }

        $data['title'] = 'เข้าสู่ระบบ - งานสวนพฤกษศาสตร์โรงเรียน';
        return view('User/Botany/PageLogin', array_merge($this->data, $data));
    }

    public function auth()
    {
        $session = session();
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $db->table('tb_botany_users')->where('username', $username)->where('status', 'active')->get()->getRow();

        if ($user) {
            if (password_verify($password, $user->password)) {
                $ses_data = [
                    'botany_user_id'   => $user->user_id,
                    'botany_username'  => $user->username,
                    'botany_fullname'  => $user->fullname,
                    'botany_logged_in' => TRUE
                ];
                $session->set($ses_data);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['status' => true, 'message' => 'เข้าสู่ระบบสำเร็จ']);
                }
                return redirect()->to(base_url('Admin/Botany'));
            } else {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['status' => false, 'message' => 'รหัสผ่านไม่ถูกต้อง']);
                }
                return redirect()->back()->with('error', 'รหัสผ่านไม่ถูกต้อง');
            }
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => false, 'message' => 'ไม่พบชื่อผู้ใช้งานนี้']);
            }
            return redirect()->back()->with('error', 'ไม่พบชื่อผู้ใช้งานนี้');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('Botany'));
    }

    public function create_default_user()
    {
        $db = \Config\Database::connect();
        $db->table('tb_botany_users')->where('username', 'botany_admin')->delete();
        $data = [
            'username' => 'botany_admin',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'fullname' => 'ผู้ดูแลงานสวนพฤกษศาสตร์',
            'status'   => 'active'
        ];
        $db->table('tb_botany_users')->insert($data);
        echo "Reset successful: botany_admin / password123";
    }
}
