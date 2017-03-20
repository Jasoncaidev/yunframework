<?php 
/*
 * @file /yun/library/log.php
 * @project  Yun framework project
 * @package  Yun.library
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2016-2017   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription log
 * @modify 2017-2-18
 **/
namespace Yun\Library;
/**
 * 日志操作类
 * Class Log
 * @package Yun\Library
 */
class Log {

    /**
     * 系统日志
     * @param $content
     * @return int
     */
    public static function system($content){
        $file = 'yun.log';
        return file_put_contents(log_path().$file,date('Y-m-d H:i:s',time())."\r\n".$_SERVER['REQUEST_URI']."\r\n".print_r($content,true)."\r\n\r\n",FILE_APPEND);
    }

    /**
     * 写入文件
     * @param $file
     * @param $content
     * @return int
     */
    public static function put($file, $content){
        return file_put_contents(log_path().$file,date('Y-m-d H:i:s',time())."\r\n".print_r($content,true)."\r\n\r\n",FILE_APPEND);
    }

}


