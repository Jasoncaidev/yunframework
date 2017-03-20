<?php 
/*
 * @file /yun/classes/config.php
 * @project  Yun framework project
 * @package  Yun.sys.config
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 配置类。
 * @modify 2016-08-07
 **/
namespace Yun\Classes;
use Yun\Core\App;
class Config{

	//获取配置
    public static function get($key){
        $config_path = explode('.',$key);
        //config name
        $key_last = array_pop($config_path);
        //config file
        $file_name = array_shift($config_path);
        $file_name = empty($file_name)?'default':$file_name;
        if(isset(App::$configs[$file_name])){
            $file_configs = App::$configs[$file_name];
        }else{
            $file_path = $file_name.'.php';
            $file_configs = include APP_ROOT.'config'.DS.$file_path;
            App::$configs[$file_name] = $file_configs;
        }
        array_push($config_path,$key_last);
        return self::c_array($file_configs,$config_path);
    }

    //
    public static function c_array($array,$keys){
        $key_name = array_shift($keys);
        if(count($keys)>0){
            return self::c_array($array[$key_name],$keys);
        }else{
            return $array[$key_name];
        }

    }
}



