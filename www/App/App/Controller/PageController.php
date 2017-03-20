<?php

namespace App\App\Controller;
class PageController extends AppController {

	
	public function index(){
		$this->layout = 'default';
		echo 'page index';
	}

	public function about(){
		$this->layout = 'default';
		echo 'page about';
	}
}
