<?php
if(!defined('APP_ROOT')) die('access denied');
/* 
 * @file /yun/bootstrap.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2017   Yun(tm) http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @description 引导文件
 * @modify 2017-2-2
 **/
define('YTP','tpl');
define('EXT','php');
define('DOT','.');
define('YUNFRAMEWORK_VERSION','Yunframework 0.2.1');
define('WEBSITE_YUNFRAMEWORK','http://www.yunframework.com');

session_start();
if(!defined('DS'))
    define('DS',DIRECTORY_SEPARATOR);

//echo dirname(realpath(__FILE__));exit;
define('YUN_ROOT',dirname(realpath(__FILE__)).DS);

//$wr = dirname(__FILE__);
$wr = getcwd();
$fa = explode('/', $_SERVER['REQUEST_URI']);
$f = $fa[1];
$webroot_uri = preg_replace("/(.*)$f/", '/'.$f, $wr);
if($webroot_uri == $wr){
    $webroot_uri = '';
}else{
    $webroot_uri = trim(str_replace('\\', '/', $webroot_uri),'.');
    $webroot_uri = preg_replace('/\/{2,}/','',$webroot_uri);
}
/* URL根目录，兼容子文件夹安装的情况 */
define('WEB_ROOT',$webroot_uri.'/');

if(function_exists('ini_set')){
    ini_set('include_path',YUN_ROOT . PATH_SEPARATOR . ini_get('include_path'));
}else{

}
//print_r([YUN_ROOT,APP_ROOT,WEB_ROOT]);exit;

include_once 'basic.php';
require_once 'Core' . DS . 'Yun.php';

require_once 'Core' . DS . 'App.php';
class_alias(Yun\Core\App::class,'App');

include_once 'vendor'.DS.'illuminate'.DS.'support'.DS.'helpers.php';

/*初始化程序*/
App::init();

//开始脚本
App::launch();



