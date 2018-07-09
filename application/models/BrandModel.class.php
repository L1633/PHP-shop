<?php
class BrandModel extends Model{
    
    //获取所有分类
    public function getbrands(){
        $sql = "SELECT * FROM {$this->table}";
        return $brands = $this->db->getAll($sql);
        
    }
    








}