<?php 
/* 
 * @file /www/app/config/routes.php
 * @project  Yun framework project
 * @package  Yun.app.config
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 路由设置。
 * @modify 2016-08-04
 *
 **/
use Yun\Core\Router;
class Routes{
	//设置默认APP目录
	public static $defaultModule = 'App';
    /* 
	 * @desc 设置路由重写，可以为固定字符串或者正则表达式，规则从上到下匹配，以第一条匹配为准，所以请按优先级高低书写
	 * 		  默认路由规则为：/cn/app/controller/action?xxx 形式，set方法第一个参数可以为字符串或正则
	 * @param null
	 * @return null
	 * 
	 *  */
	public static function setRoutes(){
			/*为程序设置一个url后缀，默认空*/
			//Router::setExt('.shtml');
			Router::set('/',array('module'=>'Home','controller'=>'default','action'=>'index'));
			Router::set(array('/admin','/admin/'),array('module'=>'Admin','controller'=>'Dashboard','action'=>'index'));
			Router::set('/\/([a-z]{2})\/admin\/?$/',array('lang'=>'{1}','module'=>'Admin','controller'=>'Dashboard','action'=>'index'));
			Router::set('/^\/([a-z]{2})\/?$/',array('lang'=>'{1}','module'=>'App','controller'=>'Index','action'=>'index'));
	}
	
}




