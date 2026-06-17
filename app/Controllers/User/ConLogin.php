<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use App\Models\LoginModel;
use App\Models\PersonnalModel;

class ConLogin extends BaseController
{
    protected $LoginModel;
    protected $PersModel;

    // ข้อมูล Client จาก Google Console (รหัสเดิมของคุณ)
    private $clientId = "29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com";
    private $clientSecret = "RSANANTRl84lnYm54Hi0icGa";

    public function __construct()
    {
        parent::__construct();
        $this->LoginModel = new LoginModel();
        $this->PersModel = new PersonnalModel();
    }

    /**
     * ส่งผู้ใช้ไปหน้า Login ของ Google (OAuth2 Redirect Flow)
     */
    public function googleLogin()
    {
        $redirectUri = base_url('SkjMain/googleCallback');
        $scope = "openid email profile";
        
        $params = [
            'response_type' => 'code',
            'client_id'     => $this->clientId,
            'redirect_uri'  => $redirectUri,
            'scope'         => $scope,
            'access_type'   => 'online',
            'prompt'        => 'select_account'
        ];
        
        $authUrl = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query($params);
        return redirect()->to($authUrl);
    }

    /**
     * รับข้อมูลกลับจาก Google และเช็คสิทธิ์โดยใช้ CURL (CURL Method)
     */
    public function googleCallback()
    {
        $code = $this->request->getGet('code');
        
        if (!$code) {
            session()->setFlashdata('msg', 'ไม่ได้รับรหัสยืนยันจาก Google');
            return redirect()->to('/Login/LoginAdmin');
        }

        // 1. นำ Code ไปแลก ID Token ผ่าน CURL
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->post("https://oauth2.googleapis.com/token", [
                'form_params' => [
                    'code'          => $code,
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'redirect_uri'  => base_url('SkjMain/googleCallback'),
                    'grant_type'    => 'authorization_code',
                ]
            ]);
            $tokenData = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            log_message('error', 'Google token exchange error: ' . $e->getMessage());
            session()->setFlashdata('msg', 'ไม่สามารถเชื่อมต่อกับ Google เพื่อแลกสิทธิ์ได้');
            return redirect()->to('/Login/LoginAdmin');
        }

        if (!isset($tokenData['id_token'])) {
            session()->setFlashdata('msg', 'ไม่ได้รับข้อมูลประจำตัวจาก Google');
            return redirect()->to('/Login/LoginAdmin');
        }

        // 2. ตรวจสอบข้อมูลจาก ID Token โดยตรง (JWT Payload)
        // หมายเหตุ: ID Token คือ JWT ที่มีข้อมูลผู้ใช้อยู่ในส่วนที่ 2 (Base64 Encoded)
        $idTokenParts = explode('.', $tokenData['id_token']);
        if (count($idTokenParts) < 2) {
            session()->setFlashdata('msg', 'รูปแบบข้อมูลจาก Google ไม่ถูกต้อง');
            return redirect()->to('/Login/LoginAdmin');
        }
        
        // ถอดรหัส Base64 URL Safe ด้วยคำสั่งมาตรฐาน
        $idTokenPayload = $idTokenParts[1];
        $idTokenPayload = str_replace(['-', '_'], ['+', '/'], $idTokenPayload);
        $idTokenPayload = str_pad($idTokenPayload, strlen($idTokenPayload) % 4, '=', STR_PAD_RIGHT);
        $payload = json_decode(base64_decode($idTokenPayload), true);

        if (!$payload) {
            session()->setFlashdata('msg', 'ไม่สามารถอ่านข้อมูลผู้ใช้จาก Google ได้');
            return redirect()->to('/Login/LoginAdmin');
        }

        if (!$payload || isset($payload['error'])) {
            session()->setFlashdata('msg', 'ข้อมูลผู้ใช้จาก Google ไม่ถูกต้อง');
            return redirect()->to('/Login/LoginAdmin');
        }

        // --- เริ่มขั้นตอนการตรวจสอบสิทธิ์ในฐานข้อมูล (เฉพาะ tb_admin เท่านั้นที่มีสิทธิ์เข้าระบบหลังบ้าน) ---
        $userEmail = $payload['email'];

        $db = \Config\Database::connect();
        $personnelDb = \Config\Database::connect('personnal');

        // ตรวจสอบข้อมูลในฐานข้อมูลแอดมินปกติ (tb_admin)
        $adminUser = $db->table('tb_admin')->where('admin_username', $userEmail)->get()->getRowArray();

        if ($adminUser) {
            $role = $db->table('tb_roles')->where('role_id', $adminUser['role_id'])->get()->getRowArray();
            $personnelData = $personnelDb->table('tb_personnel')->where('pers_id', $adminUser['pers_id'])->get()->getRowArray();

            if (!$role || !$personnelData) {
                session()->setFlashdata('msg', 'บัญชีผู้ดูแลระบบยังไม่ได้ตั้งค่าสิทธิ์หรือข้อมูลบุคลากรอย่างสมบูรณ์');
                return redirect()->to('/Login/LoginAdmin');
            }

            session()->set([
                'AdminID'       => $adminUser['admin_id'],
                'AdminFullname' => $personnelData['pers_firstname'] . ' ' . $personnelData['pers_lastname'],
                'AdminUsername' => $adminUser['admin_username'],
                'AdminImage'    => $personnelData['pers_img'] ?? ($payload['picture'] ?? ''),
                'isLoggedIn'    => true,
                'roles'         => [$role['role_name']],
                'personnel'     => $personnelData
            ]);

            if ($role['role_name'] === 'Super Admin') {
                return redirect()->to('/SelectSystem');
            } elseif (in_array($role['role_name'], ['Manager', 'ผู้บริหาร', 'ผู้บริหารสถานศึกษา', 'Executive', 'Executive View', 'ผู้อำนวยการ', 'รองผู้อำนวยการ'])) {
                return redirect()->to('/Manager/Dashboard');
            } elseif (in_array($role['role_name'], ['Support', 'ฝ่ายสนับสนุน', 'บุคลากรฝ่ายสนับสนุน'])) {
                return redirect()->to('/Support/Dashboard');
            }

            return redirect()->to('/Admin/Dashboard');
        } else {
            session()->setFlashdata('msg', "ไม่พบบัญชีผู้ใช้ $userEmail ในระบบ หรือ คุณไม่ได้รับสิทธิ์ให้เข้าถึงหน้าจัดการ");
            return redirect()->to('/Login/LoginAdmin');
        }
    }

    public function LoginAdmin(){
        $session = session();
        if (strtolower($this->request->getMethod()) !== 'post') {
            return view('User/PageLogin');
        }

        $username = $this->request->getVar('Username');
        $password = $this->request->getVar('Password');
        $pass = $this->LoginModel->where('admin_username', $username)->first();
        $personnelDb = \Config\Database::connect('personnal');

        if (!$pass) {
            $session->setFlashdata('msg', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
            return redirect()->to('/Login/LoginAdmin');
        }

        if(password_verify($password, $pass['admin_password'] ?? '')){
            $db = \Config\Database::connect();
            $role = $db->table('tb_roles')->where('role_id', $pass['role_id'])->get()->getRowArray();
            $personnelData = $personnelDb->table('tb_personnel')->where('pers_id', $pass['pers_id'])->get()->getRowArray();

            if (!$role || !$personnelData) {
                $session->setFlashdata('msg', 'บัญชีผู้ดูแลระบบยังไม่ได้ตั้งค่าสิทธิ์หรือข้อมูลบุคลากรอย่างสมบูรณ์');
                return redirect()->to('/Login/LoginAdmin');
            }

            $session->set([
                'AdminID'       => $pass['admin_id'],
                'AdminFullname' => $personnelData['pers_firstname'] . ' ' . $personnelData['pers_lastname'],
                'AdminUsername' => $pass['admin_username'],
                'AdminImage'    => $personnelData['pers_img'] ?? '',
                'isLoggedIn'    => true,
                'roles'         => [$role['role_name']],
                'personnel'     => $personnelData
            ]);
            if ($role['role_name'] === 'Super Admin') return redirect()->to('/SelectSystem');
            if (in_array($role['role_name'], ['Manager', 'ผู้บริหาร', 'ผู้บริหารสถานศึกษา', 'Executive', 'Executive View', 'ผู้อำนวยการ', 'รองผู้อำนวยการ'])) return redirect()->to('/Manager/Dashboard');
            if (in_array($role['role_name'], ['Support', 'ฝ่ายสนับสนุน', 'บุคลากรฝ่ายสนับสนุน'])) return redirect()->to('/Support/Dashboard');
            return redirect()->to('/Admin/Dashboard');
        }else{
            $session->setFlashdata('msg', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
            return redirect()->to('/Login/LoginAdmin');
        }
    }

    public function LogoutAdmin() {
        session()->destroy();
        return redirect()->to('/');
    }

    public function selectSystem() {
        if (!session('isLoggedIn')) return redirect()->to('/');
        $roles = session('roles') ?? [];
        if (!in_array('Super Admin', $roles)) return redirect()->to('/Admin/Dashboard');
        return view('User/UserSelectSystem/PageSelectSystem', [
            'title' => 'เลือกระบบ',
            'description' => 'เลือกระบบที่ต้องการเข้าใช้งาน',
            'userName' => session('AdminFullname')
        ]);
    }
}
