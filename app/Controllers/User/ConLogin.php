<?php

namespace App\Controllers\User;
use App\Controllers\BaseController;
use CodeIgniter\Controller;
use App\Models\LoginModel;
use App\Models\PersonnalModel;

require_once SHARED_LIB_PATH . 'google_sheet/vendor/autoload.php';
use Google_Client;
use Google_Service_Oauth2;

class ConLogin extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->LoginModel = new LoginModel();
        $this->PersModel = new PersonnalModel();
    }

    public function googleLogin()
    {
        $client = new Google_Client();
        $client->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
        $client->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
        $client->setRedirectUri(base_url('SkjMain/googleCallback'));
        $client->addScope('email');
        $client->addScope('profile');

        // สร้าง URL สำหรับให้ผู้ใช้ล็อกอิน
        $loginUrl = $client->createAuthUrl();
        return redirect()->to($loginUrl); // เปลี่ยนเส้นทางไปยัง URL ของ Google OAuth
    }

    public function googleCallback()
    {
        $client = new Google_Client();
        $client->setClientId('29638025169-aeobhq04v0lvimcjd27osmhlpua380gl.apps.googleusercontent.com');
        $client->setClientSecret('RSANANTRl84lnYm54Hi0icGa');
        $client->setRedirectUri(base_url('SkjMain/googleCallback'));

        if ($this->request->getGet('code')) {
            try {
                $token = $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));

                if (isset($token['error'])) {
                    log_message('error', 'Google login error: ' . json_encode($token));
                    session()->setFlashdata('msg', 'เกิดข้อผิดพลาดในการยืนยันตัวตนกับ Google (token error)');
                    return redirect()->to('/');
                }

                $client->setAccessToken($token);

                $googleService = new Google_Service_Oauth2($client);
                $userData = $googleService->userinfo->get();

                $db = \Config\Database::connect();
                $personnelDb = \Config\Database::connect('personnal');

                // 1. ตรวจสอบจากตารางบุคลากรโดยตรงสำหรับระดับผู้อำนวยการและรองฯ (posi_001, posi_002)
                $personnelData = $personnelDb->table('tb_personnel')
                    ->groupStart()
                        ->where('pers_username', $userData->email)
                        ->orWhere('login_oauth_uid', $userData->id)
                    ->groupEnd()
                    ->where('pers_status', 'กำลังใช้งาน')
                    ->get()->getRowArray();
                
                // ขยายสิทธิ์ให้ผู้บริหารสถานศึกษา (posi_001, posi_002 และตำแหน่งผู้บริหารอื่นๆ ถ้ามี)
                $executivePositions = ['posi_001', 'posi_002'];
                if ($personnelData && in_array($personnelData['pers_position'], $executivePositions)) {
                    session()->set([
                        'AdminID'       => 'P' . $personnelData['pers_id'],
                        'AdminFullname' => $personnelData['pers_firstname'] . ' ' . $personnelData['pers_lastname'],
                        'AdminUsername' => $userData->email,
                        'AdminImage'    => $personnelData['pers_img'] ?? '',
                        'isLoggedIn'    => true,
                        'roles'         => ['Manager', 'ผู้บริหาร'],
                        'personnel'     => $personnelData
                    ]);
                    return redirect()->to('/Manager/Dashboard');
                }

                // 2. ถ้าไม่ใช่ผู้บริหารระดับสูง ให้ตรวจสอบตามสิทธิ์ใน tb_admin ปกติ
                $adminUser = $db->table('tb_admin')->where('admin_username', $userData->email)->get()->getRowArray();

                if($adminUser){
                    // Get Role
                    $role = $db->table('tb_roles')->where('role_id', $adminUser['role_id'])->get()->getRowArray();
                    
                    // Get Personnel Data (already fetched above but we need to ensure it matches admin entry)
                    $personnelData = $personnelDb->table('tb_personnel')->where('pers_id', $adminUser['pers_id'])->get()->getRowArray();

                    if (!$role || !$personnelData) {
                        session()->setFlashdata('msg', 'บัญชีผู้ดูแลระบบยังไม่ได้ตั้งค่าสิทธิ์หรือข้อมูลบุคลากรอย่างสมบูรณ์');
                        return redirect()->to('/');
                    }

                    session()->set([
                        'AdminID'       => $adminUser['admin_id'],
                        'AdminFullname' => $personnelData['pers_firstname'] . ' ' . $personnelData['pers_lastname'],
                        'AdminUsername' => $adminUser['admin_username'],
                        'AdminImage'    => $personnelData['pers_img'] ?? '',
                        'isLoggedIn'    => true,
                        'roles'         => [$role['role_name']],
                        'personnel'     => $personnelData
                    ]);
        
                    // Redirect based on Role
                    if ($role['role_name'] === 'Super Admin') {
                        // Super Admin can access both systems - redirect to selection
                        return redirect()->to('/SelectSystem');
                    } elseif (in_array($role['role_name'], ['Manager', 'ผู้บริหาร', 'Executive', 'Executive View', 'ผู้อำนวยการ', 'รองผู้อำนวยการ'])) {
                        return redirect()->to('/Manager/Dashboard');
                    }

                    return redirect()->to('/Admin/Dashboard'); // เปลี่ยนเส้นทางหลังจากล็อกอินสำเร็จ
                }else{
                    session()->setFlashdata('msg', 'ไม่พบบัญชีผู้ใช้นี้ในระบบ หรือ ไม่เป็นผู้ดูแลระบบ');
                    return redirect()->to('/');
                }
            } catch (\Exception $e) {
                log_message('error', 'Google login exception: ' . $e->getMessage());
                session()->setFlashdata('msg', 'เกิดข้อผิดพลาดในการเชื่อมต่อกับ Google.');
                return redirect()->to('/');
            }
        } else {
            return redirect()->to('/auth/googleLogin');
        }
    }

    public function LoginAdmin(){
        $session = session();
        
        // ถ้าไม่ใช่ POST ให้แสดงหน้า Login (รองรับ Google Login)
        if ($this->request->getMethod() !== 'post') {
            return view('User/PageLogin');
        }

        $username = $this->request->getVar('Username');
        $password = $this->request->getVar('Password');
        $pass = $this->LoginModel->where('admin_username', $username)->first();
        $personnelDb = \Config\Database::connect('personnal');

        // ถ้าไม่พบใน tb_admin ให้ตรวจสอบใน tb_personnel สำหรับกลุ่มผู้บริหาร (Director/Deputy)
        if (!$pass) {
            $personnelData = $personnelDb->table('tb_personnel')
                ->where('pers_username', $username)
                ->where('pers_status', 'กำลังใช้งาน')
                ->get()->getRowArray();
                
            // ขยายสิทธิ์ให้ผู้บริหารสถานศึกษา (posi_001, posi_002 และตำแหน่งผู้บริหารอื่นๆ ถ้ามี)
            $executivePositions = ['posi_001', 'posi_002', 'posi_003', 'posi_004', 'posi_005']; // รวมตำแหน่งผู้บริหาร/สายงานหลัก
            if ($personnelData && in_array($personnelData['pers_position'], $executivePositions)) {
                // ตรวจสอบรหัสผ่านจากตารางบุคลากร (ถ้ามีการตั้งไว้)
                if (password_verify($password, $personnelData['pers_password'])) {
                    $session->set([
                        'AdminID'       => 'P' . $personnelData['pers_id'],
                        'AdminFullname' => $personnelData['pers_firstname'] . ' ' . $personnelData['pers_lastname'],
                        'AdminUsername' => $username,
                        'AdminImage'    => $personnelData['pers_img'] ?? '',
                        'isLoggedIn'    => true,
                        'roles'         => ['Manager', 'ผู้บริหาร'],
                        'personnel'     => $personnelData
                    ]);
                    return redirect()->to('/Manager/Dashboard');
                }
            }
            
            $session->setFlashdata('msg', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
            return redirect()->to('/');
        }

        $authenticatePassword = password_verify($password, $pass['admin_password']);
        if($authenticatePassword){
            $db = \Config\Database::connect();
            
            // Get Role
            $role = $db->table('tb_roles')->where('role_id', $pass['role_id'])->get()->getRowArray();
            
            // Get Personnel Data
            $personnelData = $personnelDb->table('tb_personnel')->where('pers_id', $pass['pers_id'])->get()->getRowArray();

            if (!$role || !$personnelData) {
                $session->setFlashdata('msg', 'บัญชีผู้ดูแลระบบยังไม่ได้ตั้งค่าสิทธิ์หรือข้อมูลบุคลากรอย่างสมบูรณ์');
                return redirect()->to('/');
            }

            $set_data = [
                'AdminID'       => $pass['admin_id'],
                'AdminFullname' => $personnelData['pers_firstname'] . ' ' . $personnelData['pers_lastname'],
                'AdminUsername' => $pass['admin_username'],
                'AdminImage'    => $personnelData['pers_img'] ?? '',
                'isLoggedIn'    => true,
                'roles'         => [$role['role_name']],
                'personnel'     => $personnelData
            ];
            $session->set($set_data);

            // Redirect based on Role
            if ($role['role_name'] === 'Super Admin') {
                // Super Admin can access both systems - redirect to selection
                return redirect()->to('/SelectSystem');
            } elseif (in_array($role['role_name'], ['Manager', 'ผู้บริหาร', 'Executive', 'Executive View', 'ผู้อำนวยการ', 'รองผู้อำนวยการ'])) {
                return redirect()->to('/Manager/Dashboard');
            }
            
            return redirect()->to('/Admin/Dashboard');
        }else{
            $session->setFlashdata('msg', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
            return redirect()->to('/');
        }
    }

    public function LogoutAdmin()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function selectSystem()
    {
        // Check if logged in
        if (!session('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        // Check if Super Admin
        $roles = session('roles') ?? [];
        if (!in_array('Super Admin', $roles)) {
            return redirect()->to('/Admin/Dashboard');
        }
        
        return view('User/UserSelectSystem/PageSelectSystem', [
            'title' => 'เลือกระบบ',
            'description' => 'เลือกระบบที่ต้องการเข้าใช้งาน',
            'userName' => session('AdminFullname')
        ]);
    }

}
