<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PersonnalModel;

class RoleController extends \App\Controllers\BaseController
{
    public function index()
    {
        $roleModel = new RoleModel();
        $personnalModel = new PersonnalModel();
        $db = \Config\Database::connect();

        // Fetch all admin users with their role and personnel info
        $builder = $db->table('tb_admin');
        $builder->select('tb_admin.admin_id, tb_admin.admin_username, tb_roles.role_name, tb_personnel.pers_firstname, tb_personnel.pers_lastname');
        $builder->join('tb_roles', 'tb_roles.role_id = tb_admin.role_id', 'left');
        $builder->join('skjacth_personnel.tb_personnel', 'skjacth_personnel.tb_personnel.pers_id = tb_admin.pers_id', 'left');
        $data['admin_users'] = $builder->get()->getResultArray();

        // Fetch all roles
        $data['roles'] = $roleModel->findAll();

        // Fetch all active personnel for the add user form
        $data['personnel'] = $personnalModel->where('pers_status', 'กำลังใช้งาน')->findAll();

        // Load view
        $data['title'] = 'จัดการผู้ดูแลระบบและสิทธิ์';
        $data['description'] = 'เพิ่ม ลบ และจัดการสิทธิ์การเข้าใช้งานสำหรับผู้ดูแลระบบ';
        
        return view('Admin/PageAdminRoles/index', array_merge($this->data, $data));
    }

    public function addUser()
    {
        $rules = [
            'pers_id' => 'required',
            'admin_username' => 'required|valid_email|is_unique[tb_admin.admin_username]',
            'role_id' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tb_admin');

        $data = [
            'pers_id' => $this->request->getPost('pers_id'),
            'admin_username' => $this->request->getPost('admin_username'),
            'role_id' => $this->request->getPost('role_id'),
            'admin_password' => null, // Set password to null as it's not provided
        ];

        if ($builder->insert($data)) {
            return redirect()->to('Admin/roles')->with('success', 'เพิ่มผู้ดูแลระบบเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->withInput()->with('error', 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
        }
    }

    public function deleteUser($id)
    {
        if ($id == session('AdminID')) {
            return redirect()->to('Admin/roles')->with('error', 'คุณไม่สามารถลบบัญชีของตัวเองได้');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tb_admin');
        
        if ($builder->where('admin_id', $id)->delete()) {
            return redirect()->to('Admin/roles')->with('success', 'ลบผู้ดูแลระบบเรียบร้อยแล้ว');
        } else {
            return redirect()->to('Admin/roles')->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
        }
    }
}

