<?php
/*
 * @file /www/Apps/Controller/DefaultController.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2016-2017  Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 。
 * @modify 2017-3-24
 **/
namespace www\Apps\App\Controller;

class IndexController extends AppController {

	public function __construct()
	{
		parent::__construct();
		$this->layout = "default";
	}
	public function index(){
		$this->set("page_title","Default HomePage - welcome to use the php rapid framework Yun");

		return $this->display();
	}

}
