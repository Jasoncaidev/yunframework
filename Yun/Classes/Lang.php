<?php 
/*
 * @file /yun/classes/lang.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 配置类。
 * @modify 2017-2-21
 **/
namespace Yun\Classes;
use Yun\Core\App;
use Yun\Core\Router;

/**
 * 多语言翻译
 * Class Lang
 * @package Yun\Classes
 */
abstract class Lang{

    /**
     * 获取语言内容
     * @example:name    class.name      school.class.name
     * @param $key
     * @return mixed
     */
    public static function get($key){
        $lang_path = explode('.',$key);
        //language name
        $key_last = array_pop($lang_path);
        //language file
        $file_name = array_shift($lang_path);
        $file_name = empty($file_name)?'common':$file_name;

        if(isset(App::$langs[$file_name])){
            $file_langs = App::$langs[$file_name];
        }else{
            $file_path = $file_name.'.php';
            $file_langs_module = APP_ROOT.'App/'.Router::$module.'/Lang/'.App::$language.'/'.$file_path;
            if(file_exists($file_langs_module)){
                $file_langs = include_once $file_langs_module;
                $file_langs = array_change_key_case($file_langs,CASE_LOWER);
            }else{
                $file_langs = include_once APP_ROOT.'lang'.DS.App::$language.DS.$file_path;
                $file_langs = array_change_key_case($file_langs,CASE_LOWER);
            }
            App::$langs[$file_name] = $file_langs;
        }
        array_push($lang_path,$key_last);
        return self::c_array($file_langs,$lang_path);
    }

    /**
     * @param $array
     * @param $keys
     * @return mixed
     */
    public static function c_array($array, $keys){
        $key_name = array_shift($keys);
        if(count($keys)>0){
            if(!isset($array[strtolower($key_name)]) || empty($array[strtolower($key_name)]))
                return $key_name;
            else
                return self::c_array($array[$key_name],$keys);
        }else{
            return (isset($array[strtolower($key_name)]) && !empty($array[strtolower($key_name)]))?$array[strtolower($key_name)]:$key_name;
        }

    }
}



