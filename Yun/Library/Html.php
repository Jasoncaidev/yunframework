<?php 
namespace Yun\Library;
use Config,Router;

/**
 * Class Html
 * @file /yun/library/html.php
 * @project  Yun framework project
 * @package  Yun.library
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription html类。
 * @modify 2016-10-31
 * @package Yun\Library
 */
class Html{

    /**
     * 加载CSS文件
     * @param $css_file
     */
    public static function css($css_file){
        echo '<link href="'.self::load($css_file).'" rel="stylesheet" type="text/css" />'.PHP_EOL;

	}

    /**
     * 加载脚本文件
     * @param $script_file
     */
    public static function script($script_file){
        echo '<script src="'.self::load($script_file).'" type="text/javascript"></script>'.PHP_EOL;
    }

    /**
     * 加载图片文件
     * @param $img_file
     */
    public static function img($img_file){
        echo '<img src="'.self::load($img_file).'"  border=0 />'.PHP_EOL;
//        echo self::load($img_file);
    }

    /**
     * 加载文件
     * @param $file
     */
    public static function file($file){
        echo self::load($file);
    }

    /**
     * 生成文件地址
     * @param $file
     */
    public static  function load($file){
        if(strpos($file,'http:') === 0 || strpos($file,'https:') === 0 || strpos($file,'ftp:') === 0 )
            return $file;
        $config = Config::get('app.resource');
        $suffix = '';
        if(strpos($file,'?')===false)
            $suffix = '?'.Config::get('app.file_version');
        if($config['type'] == 'host'){
            return $config['host'].$file.$suffix;
        }else{
            return WEB_ROOT.$file.$suffix;
        }
    }

    /**
     * 生成URL
     * @param string $path
     * @param array $params
     * @param string $lang
     * @param boolean $output
     * @return string
     */
    public static function url($path, $params = [], $lang = '',$output = true){
        if(!defined('YUN_MODULE')){
            $url = strtolower($path);
            if($output)
                echo $url;
            else
                return $url;
        }
        $url = "/";
        $path_url_array = parse_url($path);
        //
        if($path{0} == '/'){
            $path_info = explode('/',trim($path,'/'));
            switch(count($path_info)){
                case 1:
                    // /index
                    $url = $path;
                    break;
                case 2:
                    // /index/index
                     if(YUN_MODULE == Router::$defaultModule){
                         $url = $path;
                     }else{
                         $url = '/'.YUN_MODULE.$path;
                     }
                    break;
                case 3:
                    // /admin/index/index
                    $url = $path;
                    break;
                default:
                    $url = $path;
            }
        }elseif(empty($path_url_array['scheme'])){
            // index/index
            $url = '/'.YUN_MODULE.'/'.YUN_CONTROLLER.'/'.$path;

        }else{
            // http://www.example.com
            $url = $path;
        }
        $url_array = parse_url($url);
        $query_string = http_build_query($params);
        if(!empty($url_array['query']))
            $url_array['query'] .= '&'.$query_string;
        else
            $url_array['query'] = $query_string;

        $url = self::http_build_url($url_array);
        if(!empty(Router::$lang))
            $lang = Router::$lang;

        //specify language
        if(!empty($lang) && empty($url_array['host'])){
            $url = '/'.$lang . $url;
        }
         $url = strtolower($url);
        if($output)
            echo $url;
        else
            return $url;
    }

    /**
     * 按parse_url格式生成url
     * @param array $arr
     *        eg:[
     *            [scheme] => http
     *            [host] => www.yunframework.com
     *            [port] => 80
     *            [path] => /page/about
     *            [query] => name=yun&tag=php
     *            [fragment] => contact
     *        ]
     */
    public static function http_build_url($url_array){
        $url_string = '';
        if(!empty($url_array['host'])){
            $url_string = (!empty($url_array['scheme'])?$url_array['scheme']:'http') . "://".$url_array['host'];
        }
        if(!empty($url_array['port'])){
            $url_string .= ":".$url_array['port'];
        }
        if(!empty($url_array['path'])){
            $url_string .= $url_array['path'];
        }
        if(!empty($url_array['query'])){
            $url_string .= "?" . $url_array['query'];
        }
        if(!empty($url_array['fragment'])){
            $url_string .= "#" . $url_array['fragment'];
        }
        return $url_string;

    }

    /**
     * 表单提交按钮
     * @param string $class
     */
    public static function submit($class = 'success'){
        echo '<button type="submit" class="btn btn-'.$class.'" name="submit"  >'.__('submit').'</button>';
    }
}


