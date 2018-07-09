<?php

class Mysql{
	protected $conn = false;  //数据库连接资源
	protected $sql;           //sql语句
	
	/**
	 * 构造函数，负责连接服务器、选择数据库、设置字符集等
	 * @param $config string 配置数组
	 */
	public function __construct($config = array()){
		$host = isset($config['host'])? $config['host'] : 'localhost';
		$user = isset($config['user'])? $config['user'] : 'root';
		$password = isset($config['password'])? $config['password'] : '';
		$dbname = isset($config['dbname'])? $config['dbname'] : '';
		$port = isset($config['port'])? $config['port'] : '3306';
		$charset = isset($config['charset'])? $config['charset'] : 'utf8';
		
		$this->conn = mysql_connect("$host:$port",$user,$password) or die('数据库连接错误');
		mysql_select_db($dbname) or die('数据库选择错误');
		$this->setChar($charset);
	}

	/**
	 * 设置字符集
	 * @access private
	 * @param $charset string 字符集
	 */
	private function setChar($charest){
		$sql = 'set names '.$charest;
		$this->query($sql);
	}

	/**
	 * 执行sql语句
	 * @access public
	 * @param $sql string 查询sql语句
	 * @return $result，成功返回资源，失败则输出错误信息，并退出
	 */
	public function query($sql){
		//写日志
		if ($GLOBALS['config']['log']) {
			$str = "[" . date("Y-m-d H:i:s") . "] ". $sql . PHP_EOL;
			file_put_contents("log.txt", $str,FILE_APPEND);
		}

		$this->sql = $sql;
		$result = mysql_query($this->sql,$this->conn);
		
		if (! $result) {
			die($this->errno().':'.$this->error().'<br />出错语句为'.$this->sql.'<br />');
		}
		return $result;
	}

	/**
	 * 获取第一条记录的第一个字段
	 * @access public
	 * @param $sql string 查询的sql语句
	 * @return 返回一个该字段的值
	 */
	public function getOne($sql){
		$result = $this->query($sql);
		$row = mysql_fetch_row($result);
		if ($row) {
			return $row[0];
		} else {
			return false;
		}
	}

	/**
	 * 获取一条记录
	 * @access public
	 * @param $sql 查询的sql语句
	 * @return array 关联数组
	 */
	public function getRow($sql){
		if ($result = $this->query($sql)) {
			$row = mysql_fetch_assoc($result);
			return $row;
		} else {
			return false;
		}
	}

	/**
	 * 获取所有的记录
	 * @access public 
	 * @param $sql 执行的sql语句
	 * @return $list 有所有记录组成的二维数组
	 */
	public function getAll($sql){
		$result = $this->query($sql);
		$list = array();
		while ($row = mysql_fetch_assoc($result)){
			$list[] = $row;
		}
		return $list;
	}

	/**
	 * 获取某一列的值
	 * @access public
	 * @param $sql string 执行的sql语句
	 * @return $list array 返回由该列的值构成的一维数组
	 */
	public function getCol($sql){
		$result = $this->query($sql);
		$list = array();
		while ($row = mysql_fetch_row($result)) {
			$list[] = $row[0];
		}
		return $list;
	}

	
	/**
	 * 获取上一步insert操作产生的id
	 */
	public function getInsertId(){
		return mysql_insert_id($this->conn);
	}
	/**
	 * 获取错误号
	 * @access private
	 * @return 错误号
	 */
	public function errno(){
		return mysql_errno($this->conn);
	}

	/**
	 * 获取错误信息
	 * @access private
	 * @return 错误private信息
	 */
	public function error(){
		return mysql_error($this->conn);
	}

}