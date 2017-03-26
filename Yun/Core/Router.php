<?php
/* 
 * @file /yun/core/router.php
 * @project  Yun framework project
 * @package  Yun.core
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 路由类。
 * @modify 2016-08-04
 **/
namespace Yun\Core;
use Yun\Classes\Config;
abstract class Router{
    
    public static $init = FALSE;
    public static $routes = array(

	);
	//当前语言
	public static $lang = '';
	//当前Module
	public static $module = '';
	//控制器
	public static $controller = "Default";
	//action
	public static $action = 'index';
	//默认Module
	public static $defaultModule = 'App';
	public static $params = array();
	public static $match = null;
	//URL格式
	public static $url_format = 'PATH_INFO';
	//URL后缀
	public static $ext = '';

	/*初始化路由*/
	public static function init(){
		if(!self::$init){
            self::setDefaultModule(\Routes::$defaultModule);
            self::__defaultRoute();//默认路由
			\Routes::setRoutes();//读取路由规则
            self::$module = self::$defaultModule;
			//self::setDefaultLang();//默认语言
			self::routeRequest();
			self::$init = TRUE;
		}

	}
	
    /* 
	 * @desc 添加路由规则
	 * @param $uri 路径
	 * @param $rule 执行地址
	 * @return null
	 * 
	 *  */
    public static function set($uri,$rule = [],$_request_params = []){
        $route = array();
        $route['uri'] = $uri;
        $route['rule'] = $rule;
        $route['_request_params'] = $_request_params;//参数
        //保留最新
        foreach(self::$routes as $key => $val){
            if($val['uri'] == $uri){
                unset(self::$routes[$key]);
            }
        }
        array_unshift(self::$routes,$route);
    }
	/*
	 * 设置默认Module
	 * */
	public static function setDefaultModule($module = "App"){
        if(!empty($module))
            self::$defaultModule = $module;
	}

	/*
	 * 设置默认语言
	 * */
	/*public static function setDefaultLang($lang = "cn"){
		self::$lang = $lang;
	}*/

    /* 
	 * @desc 得到当前路由
	 * @param null
	 * @return null
	 * 
	 *  */
	protected static function routeRequest(){
		
		if(isset($_SERVER['PATH_INFO'])){
			App::$request->here = $_SERVER['PATH_INFO'];
		}elseif(isset($_SERVER['REQUEST_URI'])){
            App::$request->here = $_SERVER['REQUEST_URI'];
		}else{
            App::$request->here = '/';
        }

		//遍历路由规则
		foreach(self::$routes as $rule){
			if(self::_route($rule['uri'],$rule['rule'],$rule['_request_params'])){
				//TODO
				break;
			}
		}

//		debug(self::$routes);
//		debug(self::$match);
        if(is_null(self::$match)){
            self::$lang = App::$request->get['lang'];
            self::$module = App::$request->get['m'];
            self::$controller = App::$request->get['c'];
            self::$action = App::$request->get['a'];
        }
//		debug(self::$lang.'-'.self::$module.'-'.self::$controller.'-'.self::$action);
		if(empty(self::$module)){
			throw new \Exception('模块未找到！', 404);
		}elseif(empty(self::$controller)){
			throw new \Exception('控制器未找到！', 404);
		}elseif(empty(self::$action)){
			throw new \Exception('Action未找到！', 404);
		}
		if(!is_dir(APP_ROOT.'Apps/'.self::$module)){
			throw new \Exception('不存在此模块：'.self::$module, 404);
		}
	}

    /* 
	 * @desc 设置路由
	 * @param $url 请求地址
	 * @param $route 响应路由
	 * @param $_request_params url请求参数
	 * @return null
	 * 
	 *  */
	protected static function _route($uri,$route,$_request_params = []){
//        debug($uri,false);
		//多个地址
		if(is_array($uri) && in_array(App::$request->here,$uri)){
			self::$module = ucfirst($route['module']);
			self::$controller =ucfirst( $route['controller']);
			self::$action = $route['action'];
			self::$match = array('uri'=>$uri,'rule'=>$uri);
			return true;
		}elseif(App::$request->here == $uri){//如果相等
			self::$module = ucfirst($route['module']);
			self::$controller =ucfirst( $route['controller']);
			self::$action = $route['action'];
			self::$match = array('uri'=>$uri,'rule'=>$uri);
			return true;
		}elseif(!is_array($uri) && preg_match('/^\/.*\/$/',$uri)){
			//如果为正则字符串
			//如果匹配
			if(preg_match($uri,App::$request->here)){
//				debug(func_get_args(),0);
				self::$match = array('uri'=>$uri,'rule'=>$route);
				preg_match_all($uri,App::$request->here,$uri_matches);
				if(empty($route['lang']))
					$route['lang'] = self::$lang;
				//如果是{1}格式
				if(preg_match('{\d+}',$route['lang'])){
					preg_match('{(\d+)}',$route['lang'],$a_match);
					$lang_offset = $a_match[1];
					self::$lang = strtolower($uri_matches[$lang_offset][0]);
				}else{
					//普通字符串
					self::$lang = strtolower($route['lang']);
				}
				//如果是{1}格式
				if(preg_match('{\d+}',$route['module'])){
					preg_match('{(\d+)}',$route['module'],$a_match);
					$module_offset = $a_match[1];
					self::$module = ucfirst($uri_matches[$module_offset][0]);
				}else{
					//普通字符串
					self::$module = ucfirst($route['module']);
				}
				//如果是{1}格式
				if(preg_match('{\d+}',$route['controller'])){
					preg_match('{(\d+)}',$route['controller'],$a_match);
					//debug($a_match);
					$controller_offset = $a_match[1];
					self::$controller = ucfirst($uri_matches[$controller_offset][0]);
				}else{
					//普通字符串
					self::$controller = ucfirst($route['controller']);
				}
				//如果是{1}格式
				if(preg_match('{\d+}',$route['action'])){
					preg_match('{(\d+)}',$route['action'],$a_match);
					//debug($a_match);
					$action_offset = $a_match[1];
					self::$action = $uri_matches[$action_offset][0];
				}else{
					//普通字符串
					self::$action = $route['action'];
				}

                //URL请求参数
                if(!empty($_request_params)){
                    foreach($_request_params as $name => $offset){
                        preg_match('{(\d+)}',$offset,$param_match);
                        App::$request->get[$name] = $_GET[$name] = $uri_matches[$param_match[1]][0];
                    }

                }
//                debug(self::$lang);
				return true;

			}
		}
		return false;
	}
    /* 
	 * @desc 设置URL后缀（eg:html,php,xhtml）
	 * @param $url 请求地址
	 * @param $route 响应路由
	 * @return null
	 * 
	 *  */
	public static function setExt($ext = '.php'){
		self::$ext = $ext;
	}
    /* 
	 * @desc 默认路由,格式为 /module/controller/action
	 * @param null
	 * @return null
	 * 
	 *  */
	public static function __defaultRoute(){
        array_push(self::$routes,array('uri'=>'/',
                'rule'=>array('module'=>'App','controller'=>'page','action'=>'index'))
        );
		if(empty(self::$ext)){
            //模块路由
            foreach(\Routes::$enableModules as $module){
                $module = strtolower($module);
                // /cn/app/page/index
                array_push(self::$routes,array('uri'=>'/^\/([a-z]{2})\/'.$module.'\/([A-Za-z]+)\/([A-Za-z0-9]+).*$/',
                        'rule'=>array('lang'=>'{1}','module'=>$module,'controller'=>'{2}','action'=>'{3}'))
                );

                // /app/page/index
                array_push(self::$routes,array('uri'=>'/^\/'.$module.'\/([A-Za-z0-9]+)\/([A-Za-z0-9]+).*$/',
                        'rule'=>array('lang'=>'','module'=>$module,'controller'=>'{1}','action'=>'{2}'))
                );
            }

			// /en/page/index
			array_push(self::$routes,array('uri'=>'/^\/([a-z]{2})\/([A-Za-z0-9]+)\/([A-Za-z0-9]+).*$/',
							'rule'=>array('lang'=>'{1}','module'=>self::$defaultModule,'controller'=>'{2}','action'=>'{3}'))
			);
			// /page/index
			array_push(self::$routes,array('uri'=>'/^\/([A-Za-z0-9]+)\/([A-Za-z0-9]+).*$/',
							'rule'=>array('lang'=>'','module'=>self::$defaultModule,'controller'=>'{1}','action'=>'{2}'))
			);
		}else {
            //模块路由
            foreach(\Routes::$enableModules as $module){
                $module = strtolower($module);
                // /cn/app/page/index.html
                array_push(self::$routes,array('uri'=>'/^\/([a-z]{2})\/'.$module.'\/([A-Za-z0-9]+)\/([A-Za-z0-9]+)'.self::$ext.'$/',
                        'rule'=>array('lang'=>'{1}','module'=>$module,'controller'=>'{2}','action'=>'{3}'))
                );

                // /app/page/index.html
                array_push(self::$routes,array('uri'=>'/^\/'.$module.'\/([A-Za-z0-9]+)\/([A-Za-z0-9]+)'.self::$ext.'$/',
                        'rule'=>array('lang'=>'','module'=>$module,'controller'=>'{1}','action'=>'{2}'))
                );
            }

			// /en/page/index.html
			array_push(self::$routes,array('uri'=>'/^\/([A-Za-z]+)\/([A-Za-z0-9]+)\/([A-Za-z0-9]+)'.self::$ext.'$/',
							'rule'=>array('lang'=>'{1}','module'=>self::$defaultModule,'controller'=>'{2}','action'=>'{3}'))
			);

			// /page/index.html
			array_push(self::$routes,array('uri'=>'/^\/([A-Za-z0-9]+)\/([A-Za-z0-9]+)'.self::$ext.'$/',
							'rule'=>array('lang'=>'','module'=>self::$defaultModule,'controller'=>'{1}','action'=>'{2}'))
			);
		}

		
	}
}


