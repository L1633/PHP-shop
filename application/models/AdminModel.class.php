<?php
//后台管理员模型
class AdminModel extends Model{
    //获取所有管理员
    public function getAdmins(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->getAll($sql);
    }

    public function checkUser($username,$password){
        $sql = "SELECT * FROM {$this->table} WHERE 
		       admin_name = '$username' AND password = '$password'
		       LIMIT 1";
        return $this->db->getRow($sql);
        // return $sql;
    }
}