<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ConAdminStudent extends BaseController
{
    public function index()
    {
        $db_academic = \Config\Database::connect('academic');

        // Fetch current schoolyear and get last 2 digits
        $schoolyear = $db_academic->table('tb_schoolyear')->orderBy('schyear_id', 'DESC')->get()->getRowArray();
        $fullYear = $schoolyear['schyear_year'] ?? '2568';
        $currentYearStr = preg_replace('/[^0-9]/', '', substr($fullYear, -4));
        if (strlen($currentYearStr) < 4) {
            $currentYearStr = date('Y') + 543;
        }
        $yearTwoDigits = substr($currentYearStr, -2);

        // Fetch distinct classes for filter dropdown
        $classes = $db_academic->table('tb_students')
            ->select('StudentClass')
            ->where('StudentStatus', '1/ปกติ')
            ->groupBy('StudentClass')
            ->orderBy('StudentClass', 'ASC')
            ->get()->getResultArray();

        $selectedClass = $this->request->getGet('class');

        // Query students with normal status
        $builder = $db_academic->table('tb_students')
            ->select('StudentID, StudentCode, StudentPrefix, StudentFirstName, StudentLastName, StudentClass, StudentNumber, StudentStatus, StudentStudyLine, StudentDateBirth')
            ->where('StudentStatus', '1/ปกติ');

        if (!empty($selectedClass)) {
            $builder->where('StudentClass', $selectedClass);
        }

        $students = $builder->orderBy('StudentClass', 'ASC')
            ->orderBy('StudentNumber', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title' => "รายชื่อนักเรียน",
            'description' => "ข้อมูลรายชื่อนักเรียนที่มีสถานะปกติเพื่อส่งออกไฟล์",
            'classes' => array_column($classes, 'StudentClass'),
            'selectedClass' => $selectedClass,
            'students' => $students,
            'yearTwoDigits' => $yearTwoDigits
        ];

        return view('Admin/PageAdminStudent/PageAdminStudent', array_merge($this->data, $data));
    }
}
