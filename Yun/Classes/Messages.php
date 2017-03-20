<?php 
/*
 * @file /yun/classes/messages.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)	http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 错误消息处理
 * @modify 2016-08-20
 **/
namespace Yun\Classes;
class Messages{



    /**
     * Messages constructor.
     */
    public function __construct()
    {
        if(!isset($_SESSION['yun']) || !is_array($_SESSION['yun']))
            $_SESSION['yun'] = [];
        if(!isset($_SESSION['yun']['messages']) || !is_array($_SESSION['yun']['messages']))
            $_SESSION['yun']['messages'] = [];
        if(!isset($_SESSION['yun']['successes']) || !is_array($_SESSION['yun']['successes']))
            $_SESSION['yun']['success'] = [];
        if(!isset($_SESSION['yun']['errors']) || !is_array($_SESSION['yun']['errors']))
            $_SESSION['yun']['errors'] = [];
    }

    /**
     * @param $message 信息内容
     */
    public function message($message){
        array_push($_SESSION['yun']['messages'],$message);
    }
    /**
     * @param $message 信息内容
     */
    public function success($message){
        array_push($_SESSION['yun']['successes'],$message);
    }
    /**
     * @param $error 错误内容
     */
    public function error($error){
        array_push($_SESSION['yun']['errors'],$error);
    }

    /**
     * @return mixed 返回一条普通信息
     */
    public function getMessage(){
        if(count($_SESSION['yun']['messages'])>0)
            return array_pop($_SESSION['yun']['messages']);
    }

    /**
     * @return mixed 返回所有普通信息
     */
    public function messages(){
        return $_SESSION['yun']['messages'];
    }
    /**
     * @return mixed 返回所有普通信息
     */
    public function successes(){
        return $_SESSION['yun']['successes'];
    }
    /**
     * @return mixed 获取错误消息
     */
    public function getError(){
        if(count($_SESSION['yun']['errors'])>0)
            return array_pop($_SESSION['yun']['errors']);
    }

    /**
     * @return mixed 获取全部错误消息
     */
    public function errors(){
        return $_SESSION['yun']['errors'];
    }

    /**
     * @return bool 检查消息
     */
    public function checkMessage(){
        if(count($_SESSION['yun']['messages'])>0)
            return true;
        else
            return false;
    }

    /**
     * @return bool 检查错误
     */
    public function checkError(){
        if(count($_SESSION['yun']['errors'])>0)
            return true;
        else
            return false;
    }
    /**
     * @return mixed 清空消息
     */
    public function clearAll(){
        $_SESSION['yun'] = [];
    }

}



