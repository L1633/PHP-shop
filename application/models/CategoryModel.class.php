<?php
class CategoryModel extends Model{
    //获取所有分类
    public function getCats(){
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        //对获取的分类进行重新排序
        return $this->tree($cats);
    }
    
    //对给定的数组进行重新排序
    //默认pid 为顶级  0
    public function tree($arr,$pid=0,$level=0){
        static $res = array();
        foreach ($arr as $v) {
            //如果数组内的元素的parent_id和顶层相同
            if($v['parent_id'] == $pid){
                //找到，先保存
                $v['level'] = $level;
                $res[] = $v;
                //改变条件，递归查找
                //是否该元素还有子类
                $this->tree($arr,$v['cat_id'],$level+1);
            }
        }
        return $res;
    }

    //指定一个cat_id ，获取其后代所有分类的cat_id
    public function getSubIds($cat_id){
        $sql = "SELECT * FROM {$this->table}";
        //获取所有的数据
        $cats = $this->db->getAll($sql);
        //获取当前所有后代
        $cats = $this->tree($cats,$cat_id);
        $ids = array();
        //将后代的cat_id放入一个数组
        foreach ($cats as $cat) {
            $ids[] = $cat['cat_id'];
        }
        //将自己也放入数组
        $ids[] = $cat_id;
        return $ids;
    }

    //将平行的二维数组，转成包含关系的多维数组
    public function child($arr,$pid=0){
        $res = array();
        foreach ($arr as $v) {
            if($v['parent_id'] == $pid){
                //找到了，递归接着找
                $v['child'] = $this->child($arr,$v['cat_id']);
                $res[] = $v;
            }
        }
        return $res;
    }

    //获取前台分类
    public function forntCats(){
        $sql = "SELECT * FROM {$this->table}";
		$cats = $this->db->getAll($sql);
		return $this->child($cats);
    }






}

