<?php 
/* 
 * @file /public/index.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2013-2017   Yun(tm)   http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @description 程序入口文件。
 * @modify 2017-5-3
 **/
 
error_reporting(E_ERROR);
date_default_timezone_set("PRC");

/* 项目路径 */
define('APP_ROOT','/usr/webroot/www'.DIRECTORY_SEPARATOR);
/* 
* 引入框架 
* e.g:
* Linux: /www/Yun/bootstrap.php 
* Windows: C:\Yun\bootstrap.php
*/
require_once('/usr/Yun/bootstrap.php');