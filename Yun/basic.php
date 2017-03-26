<?php
if(!defined('YUN_ROOT')) die('access denied');
/* 
 * @file /yun/basic.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2017   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 基础方法。
 * @modify 2016-08-13
 **/

/**
 * @param $data
 */
function applog($data){
    file_put_contents(APP_ROOT.'storage/logs/debug.log', $data,FILE_APPEND);
}

/**
 * 写日志
 * @param $file
 * @param $content
 * @return mixed
 */
function gg($file, $content){
    return Log::put($file,$content);
}

/**
 * 系统日志
 * @param $content
 * @return mixed
 */
function systemlog($content){
    return Log::system($content);
}

/**
 * 按语言返回
 * @param $key
 * @param bool|false $echo
 * @return mixed
 */
function __($key, $echo = false){
    if($echo)
        echo Lang::get($key);
    else
        return Lang::get($key);
}
/**
 * 按语言输出
 * @param $key
 * @param bool|true $echo
 * @return mixed
 */
function ___($key, $echo = true){
    if($echo)
        echo Lang::get($key);
    else
        return Lang::get($key);
}

/**
 * @return mixed
 */
function request(){
    return App::$request;
}

/**
 * @return mixed
 */
function response(){
    return App::$response;
}

/**
 * @return mixed
 */
function messages(){
    return App::$messages;
}

/**
 * 是否为POST请求
 * @return bool
 */
function is_post(){
    return App::$request->method=='POST'?true:false;
}
/**
 * 是否调试模式
 * @return bool
 */
function is_debug(){
    return Config::get('app.debug');
}
/**
 * 跳转到目标地址
 * @param $url
 */
function redirect($url){
    header("Location:".$url);
    exit;
}

/**
 * 输出调试信息
 * @param $var  信息内容
 * @param bool|true $exit   是否结束并退出
 * @param int $mode
 */
function debug($var, $exit = true, $mode = 0){
    if(Config::get('app.debug')){
        $debug = debug_backtrace();
        echo '<pre class="yun-debug" style="background:#F9F3C5;padding:10px;text-align:left;">';
        echo '<div class="file" style="color:#f00;">',$debug[0]['file'],'    ',$debug[0]['line'],PHP_EOL,'</div>';
        switch($mode){
            case 0: print_r($var); break;
            case 1: var_dump($var); break;
            default: print_r($var);
        }
        echo '</pre>';
        if($exit)
            exit;
    }

}

/**
 * 打印SQL
 */
function sql(){
    debug(DB::getQueryLog(),false);
}

/**
 * @param $msg
 * @param string $class
 */
function message($msg, $class=''){
    echo '<div class="yun-message '.$class.'" style="background:#ee0;color:#f00;padding:10px;">'.$msg.'</div>';
}

/**
 * @param $key
 * @param null $default
 * @return null
 */
function env($key, $default = null){
    return $default===null?$key:$default;
}

/**
 * 日志路径
 * @return string
 */
function log_path(){
    return storage_path().'logs'.DS;
}

/**
 * 存储路径
 * @return string
 */
function storage_path(){
    return APP_ROOT.'storage'.DS;
}

/**
 *
 * @return string
 */
//function base_path(){
//    return dirname(YUN_ROOT);
//}

/**
 * 生成链接地址
 * @param string $path
 * @param array $params
 * @param string $lang
 * @param boolean $output
 * @return string
 */
function url($path, $params = [], $lang = '',$output = false){
    return Html::url($path, $params, $lang ,$output);
}

