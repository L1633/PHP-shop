<?php
    class GoodsModel extends Model{
        public function getBestGoods(){
            //select 不写*为了节省资源 提高效率
            $sql = "SELECT goods_id,goods_name,shop_price,goods_img FROM {$this->table}
                    ORDER BY goods_id DESC
                    LIMIT 4";
            return $this->db->getAll($sql);
        }
    }