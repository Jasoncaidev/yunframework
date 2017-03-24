<?php

namespace www\Apps\Home\Controller;
class PageController extends AppController {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index(){
		$this->layout = 'default';
		echo 'page index';
	}

	public function about(){
		$this->layout = 'default';
		echo 'page about';
	}
}
