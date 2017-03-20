<?php 
/*
 * @file /yun/classes/cache.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 缓存类。
 * @modify 2016-08-13
 **/
namespace Yun\Classes;
use Yun\Classes\Config;
abstract class Cache{
    public static $driver = 'file';
	//获取缓存
    public static function get($key){
        if(Config::get('cache.cache') != true){
            return false;
        }else{
            $cache_root = storage_path().'cache'.DS;
            $filename = md5($key);
            $cache_dir = $cache_root.$filename[0].DS.$filename[1].DS.$filename[2].DS;

            $cache_file = $cache_dir.$filename.'.cache';
            $cache_array_file = $cache_dir.$filename.'.array.cache';
            $cache_object_file = $cache_dir.$filename.'.object.cache';
            if(file_exists($cache_file))
                return file_get_contents($cache_file);
            elseif(file_exists($cache_array_file))
                return json_decode(file_get_contents($cache_array_file),true);
            elseif(file_exists($cache_object_file))
                return json_decode(file_get_contents($cache_object_file),false);
            else
                return false;
        }

    }
    //保存缓存
    public static function set($key,$value){
        if(Config::get('cache.cache') != true){
            return false;
        }
        $extra = '';
        if(is_array($value)){
            $extra = '.array';
            $value = json_encode($value);
        }elseif(is_object($value)){
            $extra = '.object';
            $value = json_encode($value);
        }
        $cache_root = storage_path().'cache'.DS;
        $filename = md5($key);
        $cache_dir = $cache_root.$filename[0].DS.$filename[1].DS.$filename[2].DS;
        $cache_file = $cache_dir.$filename.$extra.'.cache';
        try{
            if(!is_dir($cache_dir))
                mkdir($cache_dir,0777,true);
            return file_put_contents($cache_file,$value);
        }catch (\Exception $e){
//            echo $e->getMessage();exit;
            throw new \Exception($e);
        }

    }

    /**
     * 删除指定缓存
     * @param $key
     * @throws \Exception
     */
    public function clear($key){
        $cache_root = storage_path().'cache'.DS;
        $filename = md5($key);
        $cache_dir = $cache_root.$filename[0].DS.$filename[1].DS.$filename[2].DS;
        $cache_file = $cache_dir.$filename.'.cache';
        $cache_array_file = $cache_dir.$filename.'.array.cache';
        $cache_object_file = $cache_dir.$filename.'.object.cache';
        try{
            if(file_exists($cache_file))
                unlink($cache_file);
            elseif(file_exists($cache_array_file))
                unlink($cache_array_file);
            elseif(file_exists($cache_object_file))
                unlink($cache_object_file);
        }catch (\Exception $e){
//            echo $e->getMessage();exit;
            throw new \Exception($e);
        }
    }

    /**
     * 删除全部缓存
     * @param $key
     * @throws \Exception
     */
    public function clearAll(){
        $cache_root = storage_path().'cache'.DS;
        try{
                unlink($cache_root);

        }catch (\Exception $e){
//            echo $e->getMessage();exit;
            throw new \Exception($e);
        }
    }
    /**
     * 获取页面缓存文件
     * @param $key MD5
     * @return string
     */
    public static function getHtmlCacheFile($key){
        if(Config::get('cache.cache') != true){
            return '';
        }else{
            $cache_root = storage_path().'pages'.DS;
            $filename = $key;
            $cache_dir = $cache_root.$filename[0].DS.$filename[1].DS.$filename[2].DS;
            if(is_dir($cache_dir)){
                $handle = scandir($cache_dir);
                foreach($handle as $file){
                    if(preg_match('/([a-z0-9]+)\-(\d+)/',$file,$matches)){
                        if(isset($matches[2])){
                            if($matches[2] > time()){
                                return $cache_dir.$file;
                            }else{
                                unlink($cache_dir.$file);
                            }
                        }
                    }
                }
            }
            return '';
        }

    }
    /**
     * 获取页面缓存
     * @param $file string
     * @return string
     */
    public static function getHtmlCache($file){
        return include $file;
    }
    /**
     * 缓存页面
     * @param $key MD5
     * @return string
     */
    public static function saveHtmlCache($key,$value,$time = 0){
        if(Config::get('cache.cache') != true){
            return false;
        }
        $cache_root = storage_path().'pages'.DS;
        $filename = $key;
        $cache_dir = $cache_root.$filename[0].DS.$filename[1].DS.$filename[2].DS;
        $cache_file = $cache_dir.$filename.'-'.intval($time).'.view.php';

        try{
            if(!is_dir($cache_dir))
                mkdir($cache_dir,0777,true);
            return file_put_contents($cache_file,$value);
        }catch (\Exception $e){
            throw new \Exception($e);
        }

    }
}



