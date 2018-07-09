<?php
class AttributeModel extends Model{
    
    public function getAttrs($type_id,$offset,$limit){
        //获取指定类型下的属性，需要连表获取类型名称
        //获取类型表的表的表名字
        $type_table = $GLOBALS['config']['prefix'].'goods_type';
        $sql = "SELECT * FROM {$this->table} AS a INNER JOIN $type_table AS b ON a.type_id=b.type_id WHERE a.type_id= $type_id LIMIT $offset,$limit";
        return $attrs = $this->db->getAll($sql); 
    }

    public function getAttrsForm($type_id){
        //查询数据
        $sql = "SELECT * FROM {$this->table} WHERE type_id = $type_id";
        $attrs = $this->db->getAll($sql);
        //返回数据， 拼接成HTML格式返回
        $res = "<table width='100%' id='attrTable'>";
        foreach ($attrs as $attr) {
			$res .= "<tr>";
			$res .= "<td class='label'>{$attr['attr_name']}</td>";
			$res .= "<td>";
			$res .= "<input type='hidden' name='attr_id_list[]' value='{$attr['attr_id']}'>";
			switch ($attr['attr_input_type']) {
				case 0: #文本框
					$res .= "<input name='attr_value_list[]' type='text' size='40'>";
					break;
				case 1: #下拉列表
					$res .= "<select name='attr_value_list[]'>";
					$res .= "<option value=''>请选择...</option>";
					$opts = explode(PHP_EOL, $attr['attr_value']);
					foreach ($opts as $opt) {
						$res .= "<option value='$opt'>$opt</option>";
					}
					$res .= "</select>";
					break;
				case 2: #文本域
					$res .= "<textarea name='attr_value_list[]'></textarea>";
					break;
			}
			$res .= "<input type='hidden' name='attr_price_list[]' value='0'>";
			$res .= "</td>";
			$res .= "</tr>";
		}
		$res .= "</table>";
		return $res;
    }

}