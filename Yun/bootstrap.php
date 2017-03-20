<?php
if(!defined('YUN_ROOT')) die('access denied');
/* 
 * @file /yun/bootstrap.php
 * @project  Yun framework project
 * @package  Yun.sys
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


include_once 'basic.php';
require_once 'Core' . DS . 'Yun.php';

require_once 'Core' . DS . 'App.php';
class_alias(Yun\Core\App::class,'App');

include_once 'vendor'.DS.'illuminate'.DS.'support'.DS.'helpers.php';
/*初始化程序*/
App::init();




