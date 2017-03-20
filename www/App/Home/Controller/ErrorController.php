<?php

namespace App\Home\Controller;
class errorController extends AppController {
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        return $this->display();
    }


}
