<?php 
/* 
 * @file /public/index.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)   http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @description 程序入口文件。
 * @modify 2017年2月19日
 **/
 
error_reporting(E_ERROR);
date_default_timezone_set("PRC");
session_start();
if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);

/* 当前项目路径，可填写绝对路径 */
define('APP_ROOT',realpath(dirname(dirname(__FILE__))).DS.'www'.DS);
//define('APP_ROOT','C:\www'.DS);
/* 框架路径，可填写绝对路径 */
define('YUN_ROOT',realpath(dirname(dirname(__FILE__))).DS.'Yun'.DS);
//define('YUN_ROOT','C:\Yun'.DS);

$wr = dirname(__FILE__);
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
//引入框架
require YUN_ROOT.DS.'bootstrap.php';

//开始脚本
App::launch();
