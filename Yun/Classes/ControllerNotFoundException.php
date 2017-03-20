<?php 
/*
 * @file /yun/classes/exception.php
 * @project  Yun framework project
 * @package  Yun.sys.class
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 错误异常类。
 * @modify 2016-03-10
 **/

namespace Yun\Classes;
use \Exception;


class ControllerNotFoundException extends Exception{
	function __construct($message,$file='',$type='',$line=''){
		$this->message = $message;
	}
}

