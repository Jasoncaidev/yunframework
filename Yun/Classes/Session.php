<?php 
/*
 * @file /yun/classes/session.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription SESSION
 * @modify 2016-08-28
 **/
namespace Yun\Classes;
use Yun\Classes\Config;
abstract class Session{
    public static $driver = 'file';
	//获取
    public static function get($key){
		return $_SESSION[$key];

    }
    //保存
    public static function set($key,$value){
		return $_SESSION[$key] = $value;

    }
    /**
     * 销毁指定会话
     * @param $file string
     * @return bool
     */
    public static function distroy($key){
        return $_SESSION[$key] = null;
    }
    /**
     * 销毁会话
     * @return null
     */
    public static function clear(){
        foreach($_SESSION as $key => $value){
			self::distroy($key);
		}
    }
}



