<?php
/*
 * @file /yun/libary/db.php
 * @project  Yun framework project
 * @package  Yun.libary.core
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2014   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription db类。
 * @modify 2014-04-11
 **/
namespace Yun\Library;
class db
{
	var $tablepre = '';
	var $connection = null;
	var $version = '';
	var $querynum = 0;
	var $slaveid = 1;

    public function db($id = 0){
		$this->connect();
    }

	function connect($dbconfig = array()) {
		if(empty($dbconfig)){
			$dbconfig = DatabaseConfig::$default;
		}
		if($dbconfig['enabledatabase']=='yes'){ 
			$dsn = $dbconfig['driver'].":host=".$dbconfig['host'].";dbname=".$dbconfig['database'];
			$this->connection = new PDO($dsn, $dbconfig['user'], $dbconfig['password']);
			$this->tablepre = $dbconfig['prefix'];
		}
	}

    /* 
	 * @desc 获取数据库表全名
	 * @param $tablename 目标表
	 * @return 表全名
	 * 
	 *  */
	function table_name($tablename) {
		
		return $this->tablepre.$tablename;
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->curlink);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function fetch_first($sql) {
		return $this->fetch_array($this->query($sql));
	}

	function result_first($sql) {
		return $this->result($this->query($sql), 0);
	}

	public function query($sql) {
		$this->connection->prepare($sql);
		$rs = $this->connection->query($sql);
		if($rs)
			$rs->setFetchMode(PDO::FETCH_ASSOC);
		else{
			die('Error ocurs with query string "'.$sql.'"');
		}
		return $rs->fetchAll();
	}

	function affected_rows() {
		return mysql_affected_rows($this->curlink);
	}

	function error() {
		return (($this->curlink) ? mysql_error($this->curlink) : mysql_error());
	}

	function errno() {
		return intval(($this->curlink) ? mysql_errno($this->curlink) : mysql_errno());
	}

	function result($query, $row = 0) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->curlink)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		if(empty($this->version)) {
			$this->version = mysql_get_server_info($this->curlink);
		}
		return $this->version;
	}

	function close() {
		return mysql_close($this->curlink);
	}

	function halt($message = '', $code = 0, $sql = '') {
		throw new DbException($message, $code, $sql);
	}

}

?>