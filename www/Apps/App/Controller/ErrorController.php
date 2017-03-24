<?php

namespace www\Apps\App\Controller;
class ErrorController extends AppController {

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        return $this->display();
    }


}
