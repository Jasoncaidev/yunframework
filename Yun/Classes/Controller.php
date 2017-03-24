<?php 
/*
 * @file /yun/class/controller.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription controller父类。
 * @modify 2016-08-02
 **/
namespace Yun\Classes;
use Yun\Classes\Cache;
use Yun\Core\App;
use Yun\Core\Router;
abstract class Controller{
	var $template;
	//主题
	var $theme;
    //布局文件
    var $layout;
	//
	var $action;
	//设置当前控制器的缓存时间（秒）
	var $cacheSeconds;
	//设置当前action的缓存时间（秒）
	var $actionCacheSeconds;
    /*  */
    public  function __construct(){
        $this->theme = 'default';
        $this->layout = 'default';
        $this->cacheSeconds = null;
        $this->actionCacheSeconds = null;
    }
	public function __invoke(){
		//TODO
		echo get_called_class();
		
	}
	public function display($tpl = ""){
		return App::$view->display($tpl);
	}
	public function set($name,$value){
		return App::$view->set($name,$value);
	}

	public function doAction($action){
		if(is_callable([$this,$action])){
			//页面缓存
			$action_cache_key = $this->getHtmlCacheFile();
			if(!empty($action_cache_key)){
				return Cache::getHtmlCache($action_cache_key);
			}else{
				//ob_start('ob_gzhandler');
				ob_start();
				$this->$action();
				$ob_content = ob_get_clean();
				$this->saveHtmlCache($ob_content);
                //debug($ob_content);
				echo $ob_content;
			}
		}else{
			throw new \Exception("The action is not callable:".$action,404);
		}
	}
	//获取缓存文件
	protected function getHtmlCacheFile(){

		if(App::$request->method!='GET'){
			return '';
		}else{
			$cache_target = Router::$module.DS.Router::$controller.DS.Router::$action.DS.App::$request->queryString;
			//debug($cache_target);
			return Cache::getHtmlCacheFile(md5($cache_target));
		}

	}
	//保存缓存文件
	protected function saveHtmlCache($content){

		if(App::$request->method!='GET'){
			return '';
		}else{
			$cache_target = Router::$module.DS.Router::$controller.DS.Router::$action.DS.App::$request->queryString;
			$now = time();
			$timeout = $now + (($this->actionCacheSeconds >= 0) ? $this->actionCacheSeconds : $this->cacheSeconds);
			if($timeout > $now)
				return Cache::saveHtmlCache(md5($cache_target),$content,$timeout);
		}

	}

}


