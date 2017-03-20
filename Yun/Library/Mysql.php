<?php 
/*
 * @file /yun/library/mysql.php
 * @project  Yun framework project
 * @package  Yun.library
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription mysql操作类。
 * @modify 2016-03-10
 **/
namespace Yun\Library;
class Mysql {
	var $connection = false;
    /*  */
    public function __construct(){
        
    }
    /*  */
    public function __destruct(){
        
    }
    
	public function connect(){
		$this->connection = mysql_connect(DatabaseConfig::$default['host'],DatabaseConfig::$default['login'],DatabaseConfig::$default['password']);
		
		if ($this->connection===false)
		  {
			die('Mysql无法建立连接: ' . mysql_error());
		  }
		$db_selected = mysql_select_db(DatabaseConfig::$default['database'], $this->connection);
		if (!$db_selected)
		  {
			die ('Mysql选择库"'.DatabaseConfig::$default['database'].'"失败 : ' . mysql_error());
		  }
		mysql_query('SET NAMES '.DatabaseConfig::$default['encoding']);
		
	}
	
	public function execute($sql){
		$this->connect();
		$results = array();
		$resource = mysql_query($sql,$this->connection);
		while($row = mysql_fetch_assoc($resource)){
			$results[] = $row;
		}
		mysql_close($this->connection);
		return $results;
		
	}
}


