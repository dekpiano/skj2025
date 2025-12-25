<?php 
namespace App\Models;
use CodeIgniter\Model;


class StudentModels extends Model
{
    // protected $DBGroup = 'academic'; // default database group

    // protected $table = 'tb_students';
    // protected $primaryKey = 'StudentID';
    
    // protected $allowedFields = ['StudentCode'];

    public function CountStudentAll() {
        $DBacademic = \Config\Database::connect('academic');
        $Conn = $DBacademic->table('tb_students');
        
        return $Conn
        ->select('COUNT(StudentCode) AS C_ALL_Stu')
        ->where('StudentStatus','1/ปกติ')
        ->get()->getResult();
      
    }

}

?>