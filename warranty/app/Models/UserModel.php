<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'employee_enrollment';
    protected $primaryKey = 'id';
    protected $allowedFields = ['f_name', 'email', 'password'];

    public function check($email,$password){
        $data = $this->db->table('employee_enrollment')->select('user_id,f_name,email')->where('email',$email)->get()->getRow();
        if(!empty($data)){
            return $data;
        }else{
            return 0;
        }
    }

    public function updatepass($email,$password){
        $this->db->table('employee_enrollment')->where('email',$email)->set('password',$password)->update();
        // $affectedRows = $this->db->affected_rows();
        // print_r($affectedRows);exit;
        // if($affectedRows > 0){
        //     return true;
        // }else{
        //     return false;
        // }
        return true;
    }
}
