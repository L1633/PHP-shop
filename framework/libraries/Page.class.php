<?php

class Page{
	private $total;     // 总共有多少条记录
	private $pagenum;   // 分成多少页
	private $pagesize;  // 每页多少条记录
	private $current;   // 当前所在的页数
	private $url;       // url
	private $first;	    // 首页
	private $last;	    // 末页
	private $prev;	    // 上一页
	private $next;	    // 下一页

	/**
	 * 构造函数
	 * @access public
	 * @param $total number 总的记录数
	 * @param $pagesize number 每页的记录数
	 * @param $current number 当前所在页
	 * @param $script string 当前请求的脚本名称,默认为空
	 * @param $params array url所携带的参数,默认为空
	 */
	public function __construct($total,$pagesize,$current,$script = '',$params = array()){
		$this->total = $total;
		$this->pagesize = $pagesize;
		$this->pagenum = $this->getNum();
		$this->current = $current;
		
		//设置url
		$p = array();
		foreach ($params as $k => $v) {
			$p[] = "$k=$v";
		}
		$this->url = $script . '?' . implode('&', $p) . '&page=';

		$this->first = $this->getFirst();
		$this->last = $this->getLast();
		$this->prev = $this->getPrev();
		$this->next = $this->getNext();
	}

	private function getNum(){
		return ceil($this->total / $this->pagesize);
	}

	private function getFirst(){
		if ($this->current == 1) {
			return '[首页]';
		} else {
			return "<a href='{$this->url}1'>[首页]<a/>";
		}
		
	}

	private function getLast(){
		if ($this->current == $this->pagenum) {
			return  '末页';
		} else {
			return  "<a href='{$this->url}{$this->pagenum}'>[末页]</a>";
		}
		
	}

	private function getPrev(){
		if ($this->current == 1) {
			return  '[上一页]';
		} else {
			return  "<a href='{$this->url}".($this->current - 1)."'>[上一页]</a>";
		}
		
	}

	private function getNext(){
		if ($this->current == $this->pagenum ){
			return  '[下一页]';
		} else {
			return  "<a href='{$this->url}".($this->current+1)."'>[下一页]</a>";
		}
		
	}

	/**
	 * getPage方法，得到分页信息
	 * @access public
	 * @return string 分页信息字符串
	 */
	public function showPage(){
		if ($this->pagenum > 1){
			return "共有 {$this->total} 条记录,每页显示 {$this->pagesize} 条记录， 当前为 {$this->current}/{$this->pagenum} {$this->first} {$this->prev} {$this->next} {$this->last}";
		}else{
			return "共有 {$this->total} 条记录";
		}
		
	}
}

//使用：配合mysql操作类一起使用
/*
$total = $db->total();
$pagesize = 3;

$current = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

$offset = ($current - 1) * $pagesize;
$rows = $db->getAll("SELECT * FROM category limit $offset,$pagesize" );

$page = new page($total,$pagesize,$current,'test.php',array('goods_id'=>2));

$str = "<table width='400' border='1'>";
$str .= "<tr><th>编号</th><th>名称</th><th>父编号</th></tr>";
foreach ($rows as $v) {
	$str .= '<tr>';
	$str .= "<td>{$v['cat_id']}</td>";
	$str .= "<td>{$v['cat_name']}</td>";
	$str .= "<td>{$v['parent_id']}</td>";
	$str .= '</tr>';
}
$str .= "</table>";

echo $str;

echo $page->showPage();
*/