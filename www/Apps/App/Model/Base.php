<?php
/*
 * @file /www/Apps/App/Model/Base.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription Model父类。
 * @modify 2016-08-08
 **/
namespace www\Apps\App\Model;
use Yun\Classes\Model;
abstract class Base extends Model {

    public function __construct()
    {
        parent::__construct();
    }


}
