<?php
/*
 * @file /www/Apps/Controller/DefaultController.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016  Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 。
 * @modify 2017-3-24
 **/
namespace www\Apps\App\Controller;
use www\Apps\App\Model\User;
use www\Apps\App\Model\Post;

class DefaultController extends AppController {

	public function __construct()
	{
		parent::__construct();
		$this->cacheSeconds = 60;
		$this->layout = "default";
	}
	public function index(){
		$this->set("page_title","Default Page");

		return $this->display();
	}

}
