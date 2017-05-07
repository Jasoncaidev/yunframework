<?php
/*
 * @file /Yun/Core/App.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2013-2017   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription App类。
 * @modify 2016-08-08
 **/
namespace Yun\Core;
use Yun\Network\Request;
use Yun\Network\Response;
use Illuminate\Database\Connectors\ConnectionFactory;
use Yun\Classes\View;
use Yun\Classes\Messages;
use Config;
use Cache;
use DB,Router;

abstract class App{
    public static $configs;
    //请求
    public static $request;
    //应答
    public static $response;
    //模块
    public static $module;
    //控制器
    public static $controller;
    //控制器名称
    public static $controllerName;
    //控制器全名
    public static $controllerFullName;
    //当前action
    public static $action ;
    public static $view;
    //数据库连接
    public static $connection;
    public static $params;
    public static $errorhandler;
    //错误信息数组
    public static $errors;
    //消息数组
    public static $messages;
    //路由地址
    public static $here = '/';
    //当前语言
    public static $language = 'cn';
    //已加载的语言包
    public static $langs;

    //初始化程序
    public static function init(){
        /*初始化框架*/
        Yun::init();
        self::$request = new Request();
        self::$response = new Response();
        self::$messages = new Messages();
        self::init_database();
        self::loadConfig();
        self::$view = new View();
        Router::init();
        self::$language = !empty(Router::$lang)?Router::$lang:Config::get('app.lang');
        define('YUN_LANG',self::$language);

        self::dispatch();
    }
    /*启动程序
     *
     * @params null
     * @return null
     * */
    public static function launch(){
//        debug(self::$controller);
        return self::$controller->doAction(self::$action);
    }
    /*加载配置
     *
     * @params null
     * @return null
     * */
    public static function loadConfig(){
        if(Config::get('app.debug')){
            DB::enableQueryLog();
        }

    }

    /*
     * 初始化数据库
     * @params null
     * @return null
     * */
    public static function init_database(){
        $db_factory  = new ConnectionFactory();
        self::$connection = $db_factory->make(Config::get("database.connections")[Config::get("database.default")]);
        DB::swap(self::$connection);
    }
    /**
     * 分发
     * @params
     * @return null
     *  */
    public static function dispatch(){
        if(!empty(Router::$module) && !empty(Router::$controller) && !empty(Router::$action)) {
            self::$module =  Router::$module;
            self::$controllerName =  Router::$controller;
            self::$controllerFullName =  'www\Apps\\'.Router::$module . '\\Controller\\' . Router::$controller .'Controller';
//            debug(self::$controllerFullName);
            self::$action = Router::$action;
            define('YUN_MODULE',self::$module);
            define('YUN_CONTROLLER',self::$controllerName);
            define('YUN_ACTION',self::$action);

            try{
                $class =  new \ReflectionClass(self::$controllerFullName);
                //实例化控制器
                self::$controller = $class->newInstance();
            }catch(\ReflectionException $e){
                //self::$errors[] = $e->getMessage();
                throw new \Exception($e->getMessage(),404);
            }
            self::$params = Router::$params;
        }else{
            throw new \Exception('404错误，访问的页面不存在！',404);
        }
    }


}


