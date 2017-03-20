<?php

namespace App\Home\Controller;
use Yun\Classes\Controller;
use Yun\Core\App;
class AppController extends Controller{

    public  function __construct(){
        parent::__construct();
        $this->cacheSeconds = 600;
    }

}


