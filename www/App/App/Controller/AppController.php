<?php
/* 
 * @file /yun/app/controllers/controller.php
 * @project  Yun framework project
 * @package  Yun.app.controller
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2013   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription app控制器父类。
 * @modify 2016-08-02
 **/
namespace App\App\Controller;
use Yun\Classes\Controller;
use App;
class AppController extends Controller{

    public  function __construct(){
        parent::__construct();
        $this->cacheSeconds = 600;
    }

}


