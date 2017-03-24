<?php
/*
 * @file /yun/core/yun.php
 * @project  Yun framework project
 * @package  Yun.sys.core
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2013   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 全局Yun类，组织框架。
 * @modify 2016-08-02
 **/
namespace Yun\Core;
use Yun\Classes\YUNException;
use Yun\Classes\Cache;
use Router;
abstract class Yun{

    /*  */
    const NAME = 'yun framework';
    //版本
    const VERSION = YUNFRAMEWORK_VERSION;

    public static $init = false;

    public static $charset = 'utf-8';

    public static $shutdown_errors = array();

    public static $exit = false;

    /*
     * 自动加载类
     * */
    public static function autoload($className){

        $file = self::findFile($className);
        if($file!==false){
            require_once $file;
        }else{
//            debug($className);
            //throw new ClassNotFoundException('找不到类：'.$className);
//            App::$errors[] = '找不到类：'.$className;
        }

    }

    /*
     * 查找文件,文件名=类名
     * 查找顺序：框架>框架类>项目文件
     * */
    public static function findFile($className){
        // echo $className.'<br />';
        //$className = strtolower($className);
        $classArr = explode('\\',$className);
        $classPath = implode(DS,$classArr);
        //查找框架文件
        $file = dirname(YUN_ROOT).DS.$classPath.DOT.EXT;
        if(file_exists($file)){
            return $file;
        }elseif(file_exists(strtolower($file))){
            return strtolower($file);
        }
        //查找框架类库文件
        $file = YUN_ROOT.'Classes'.DS.$classPath.DOT.EXT;
        if(file_exists($file)){
            return $file;
        }elseif(file_exists(strtolower($file))){
            return strtolower($file);
        }
        /*根据驼峰命名查找类*/
        /*        preg_match_all('/((?:^|[A-Z])[a-z0-9_]+)/',$className,$matches);
                $matches[0] = array_reverse($matches[0]);
                $file = strtolower(YUN_ROOT . DS . 'classes' . DS . strtolower(implode(DS, $matches[0])) . DOT . EXT);*/
        /*查找框架类库*/
        /*        if(file_exists($file)){
                       return $file;
                }
                $file = strtolower(YUN_ROOT . DS . 'library' . DS . strtolower(implode(DS, $matches[0])) . DOT . EXT);*/
        /*查找框架额外的类库*/
        /*        if(file_exists($file)){
                       return $file;
                }*/
        /*在项目文件中查找*/
        $file = APP_ROOT . $classPath . DOT . EXT;
        if(file_exists($file)){
            //echo $file."<br />";
            return $file;
        }elseif(file_exists(strtolower($file))){
            return strtolower($file);
        }
        /*第三方库*/
        $classArr[0] = strtolower($classArr[0]);
        $classArr[1] = strtolower($classArr[1]);
        $classPath = implode(DS,$classArr);
        $file = YUN_ROOT.'vendor'.DS.$classPath.DOT.EXT;
        //echo $file."<br />";
        if(file_exists($file)){
            return $file;
        }
        return FALSE;
    }
    /*
     *
     * @params null
     * @return null
     * */
    public static function set_alias(){
        class_alias(\Illuminate\Support\Facades\DB::class,'DB');
        class_alias('Yun\Core\App','App');
        class_alias('Yun\Core\Router','Router');
        class_alias('Yun\Classes\Session','Session');
        class_alias('Yun\Classes\Cache','Cache');
        class_alias('Yun\Classes\Config','Config');
        class_alias('Yun\Classes\Lang','Lang');
        class_alias('Yun\Library\Log','Log');
        class_alias('Yun\Library\Html','Html');
    }
    /*
     * shutdown
     * */
    public static function shutdown(){
        if(!Yun::$init) return FALSE;

        if (App::$errors AND $error = error_get_last() AND in_array($error['type'], Yun::$shutdown_errors))
        {
            // 清除OB
            ob_get_level() and ob_clean();

            // 抛出异常
//            Yun::exceptionHandler(new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));

            // 关闭
            exit(1);
        }
    }
    /*
     * 错误处理
     * */
    public static function errorHandler($code, $error, $file = NULL, $line = NULL){
//        debug(func_get_args(),0);
		if( in_array($code,[E_ERROR,E_USER_ERROR,E_USER_NOTICE]) ){
			systemlog(func_get_args());
			if ( ! headers_sent()){
				header("HTTP/1.1 500 Internal Server Error");
			}
			if(is_debug()){
				debug(func_get_args());
			}
			die('A system error occurred!');
		}

        if (error_reporting() & $code)
        {
            //throw new YUNException($error, $code, 0, $file, $line);
        }

        return TRUE;
    }
    /*
     * 异常处理
     * */
    public static function exceptionHandler(\Exception $e){
        if(is_debug()){
            debug($e);
        }
        try
        {
            // 获取异常信息
            $type    = get_class($e);
            $code    = $e->getCode();
            $message = $e->getMessage();
            $file    = $e->getFile();
            $line    = $e->getLine();
            // 
            $trace = $e->getTrace();
            if ( ! headers_sent())
            {
                header('Content-Type: text/html; charset='.Yun::$charset, TRUE, 500);
                if($code>=400 && $code<500) {
                    header("HTTP/1.1 404 Not Found");
                }else{
                    header("HTTP/1.1 500 Internal Server Error");
                }
                if(class_exists('\App\\'.strtolower(App::$module).'\Controller\ErrorController')){
                    header('Location: '.url('/error/index'));
                }else{
                    header('Location: '.url('/'.strtolower(Router::$defaultModule).'/error/index'));
                }
                exit;
            }



//            if(class_exists('\App\\'.App::$module.'\Controller\ErrorController')){
//                $class = new \ReflectionClass('\App\\'.self::$module.'\Controller\ErrorController');
//            }else{
////                $class = new \ReflectionClass('\App\\'.Router::$defaultModule.'\Controller\ErrorController');
//                $class = new \ReflectionClass('\App\Admin\Controller\ErrorController');
//                App::$module = Router::$defaultModule;
//            }
//            debug($class);
//            App::$controller = $class->newInstance();
//            App::$action = 'c404';
//            define('YUN_MODULE',App::$module);
//            define('YUN_CONTROLLER','Error');
//            define('YUN_ACTION',App::$action);
//            debug(self::$controller);
//            App::launch();


            echo '<pre class="yun-exception" style="background:#888;padding:10px;">';
            echo '<div class="file" style="color:#f00;">',$file,'    ',$line,PHP_EOL,'</div>';
            echo '<div class="messgae" style="color:#fff;">',$message,'    ',$line,PHP_EOL,'</div>';
            echo '</pre>';

            return TRUE;
        }
        catch (\Exception $e)
        {
            // Clean the output buffer if one exists
            ob_get_level() and ob_clean();

            // Display the exception text
            echo $e->getMessage(),PHP_EOL;

            // Exit with an error status
            // exit(1);
        }
    }
    /*
     * 初始化框架
     * 
     * */
    public static function init(){
        if(self::$init){
            return;
        }
        spl_autoload_register(array(__CLASS__,'autoload'));
        /* */
        self::set_alias();
        register_shutdown_function(array(self::class,'shutdown'));
        set_error_handler(array(self::class,'errorHandler'));
        set_exception_handler(array(self::class,'exceptionHandler'));
        self::$init = TRUE;
    }
}


