<?php

namespace www\Base;

use Yun\Classes\Service;
class BaseService extends Service{
    public $page = 1;
    public $pageSize = 10;
    public $data = [];
    public  function __construct(){
        if(isset($_GET['page']))
            $this->page = (int)$_GET['page'];
        if(isset($_GET['page_size']))
            $this->pageSize = (int)$_GET['page_size'];
        $this->data = $_GET;
        parent::__construct();
    }
    /**
     *
     */
    public function create($data){
        return parent::save($data);
    }

    /**
     *
     */
    public function update($data){
        return parent::save($data);
    }
    /**
     * 列表
     * @param string $name
     * @param int $limit
     * @param int $page
     * @return mixed
     */
    public function lists($page = 1, $pageSize = 20, $args = []){
        $result = parent::lists($this->page,$this->pageSize,$this->data);
        return $result;
    }
    public function get($id){
        $result = parent::get($id);
        return $result;
    }
    /**
     *
     */
    public function delete($id){
        if(is_post()){
            return parent::delete($id);
        }
        return false;
    }
}


