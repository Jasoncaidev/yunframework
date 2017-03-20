<?php 
/*
 * @file /yun/classes/view.php
 * @project  Yun framework project
 * @package  Yun.sys.core
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2013   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription view类。
 * @modify 2013-4-23
 **/
namespace Yun\Classes;
use Yun\Library\Html;
use App,Router;
class View{
	//变量
	var $vars = array();
	var $errors = array();
	//模版文件
	var $tpl;
    /*  */
    public function __construct(){
		$this->vars['page_title'] = 'Page Title';
		$this->vars['webroot'] = WEB_ROOT;
		$this->vars['VERSION'] = Config::get('app.file_version');
		$this->set("page_created_at",date('Y-m-d H:i:s',time()));
    }
    /* 
	 * @desc 变量赋值
	 * @param $name 变量名
	 * @param $value 变量值
	 * @return null
	 * 
	 */
	public function set($name,$value){
		if(is_array($name)){
			array_merge($this->vars,$name);
		}else{
			$this->vars[$name] = $value;
		}
	}
    /* 
	 * @desc 模版
	 * @param null
	 * @return null
	 * 
	 */
	public function render(){
		$this->errors = App::$errors;
		if(App::$controller->layout != ''){
			$this->layout_tpl();
		}else{
			$this->tpl();
		}


	}
    /* 
	 * @desc 加载模版
	 * @param null
	 * @return null
	 * 
	 */
	public function tpl($template = ''){
		$tpl = $template == ''?$this->tpl:$template;
		extract($this->vars,EXTR_SKIP);
		if(empty($tpl)){
			$tpl_file = APP_ROOT .'App'.DS. Router::$module.DS.'View'.DS.App::$controller->theme.DS.strtolower(App::$controllerName.DS.str_replace(DOT.YTP,'',App::$action).DOT.YTP);
		}else{
			$tpl_file = APP_ROOT .'App'.DS. Router::$module.DS.'View'.DS.App::$controller->theme.DS.strtolower(App::$controllerName.DS.str_replace(DOT.YTP,'',$tpl).DOT.YTP);;
		}
		if(!file_exists($tpl_file)){
			//TODO
			App::$errors[] = '找不到模板文件：'.$tpl_file;
			$this->errors[] ='找不到模板文件：'.$tpl_file;
			trigger_error('找不到模板文件：'.$tpl_file);
		}else{
			include $tpl_file;
		}
	}
    /* 
	 * @desc 加载layout模版
	 * @param null
	 * @return null
	 * 
	 */
	public function layout_tpl(){
        //echo "<pre>";print_r(get_declared_classes());exit;
        //(new Html)->file('css/style.css');
        //echo Html::file('1111111111');exit;
		extract($this->vars,EXTR_SKIP);
		if(!empty(App::$controller->layout)){
			$layout_tpl_file = APP_ROOT .'App'.DS. Router::$module.DS.'View'.DS.App::$controller->theme.DS.strtolower('layouts'.DS.str_replace(DOT.YTP,'',App::$controller->layout).DOT.YTP);
		}else{
			trigger_error('LAYOUT LOADING ERROR!');
		}
		if(!file_exists($layout_tpl_file)){
			//TODO
			App::$errors[] = '找不到模板文件：'.$layout_tpl_file;
			$this->errors[] ='找不到模板文件：'.$layout_tpl_file;
			trigger_error('找不到模板文件：'.$layout_tpl_file);
		}else{
			include_once $layout_tpl_file;
		}
	}
    /* 
	 * @desc 输出视图
	 * @param null
	 * @return null
	 * 
	 */
	public function display($tpl = ""){
		$this->tpl = $tpl;
		if(count(App::$errors) > 0  ){
            debug(App::$errors);exit;
		}else{
			$this->vars['yun_messages'] = App::$messages->messages();
			$this->vars['yun_successes'] = App::$messages->successes();
			$this->vars['yun_errors'] = App::$messages->errors();//错误内容
			App::$messages->clearAll();
			$this->render();
		}
	}
    /* 
	 * @desc 加载element
	 * @param $element element 名
	 * @return null
	 * 
	 */
	public function element($element){
		extract($this->vars,EXTR_SKIP);
		if(!empty($element)){
			$element_tpl_file = APP_ROOT .'App'.DS. Router::$module.DS.'View'.DS.App::$controller->theme.DS.strtolower('elements'.DS.str_replace(DOT.YTP,'',$element).DOT.YTP);
		}
		else{
			trigger_error('ELEMENT LOADING ERROR!');
		}

		if(!file_exists($element_tpl_file)){
			//TODO
			App::$errors[] = '找不到模板文件：'.$element_tpl_file;
			$this->errors[] ='找不到模板文件：'.$element_tpl_file;
			trigger_error('找不到模板文件：'.$element_tpl_file);
		}else{
			include $element_tpl_file;
		}
	}
	
}


