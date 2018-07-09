<?php
class TypeModel extends Model{
    //获取所有类型
     public function gettypes(){
        $sql = "SELECT * FROM {$this->table}";
        return $types = $this->db->getAll($sql);
    }

    //分页获取商品类型
    public function getPageTypes($offset,$limit){
        $sql  = "SELECT * FROM {$this->table} ORDER BY type_id DESC LIMIT $offset,$limit";
        return $this->db->getAll($sql);
    }


}