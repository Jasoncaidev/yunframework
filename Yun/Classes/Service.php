<?php 
/*
 * @file /yun/classes/service.php
 * @project  Yun framework project
 * @package  Yun.classes.service
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription base of Service class。
 * @modify 2016-12-11
 **/
namespace Yun\Classes;

/**
 * 数据库服务类
 * Class Service
 * @package Yun\Classes
 */
abstract class Service{
    /**
     * @var null    服务默认模型
     */
    protected $model = null;
    protected $beforeLists;
    protected $afterLists;
    protected $beforeGet;
    protected $afterGet;
    protected $beforeSave;
    protected $afterSave;
    protected $beforeDelete;
    protected $afterDelete;

    /*  */
    public  function __construct(){

    }
	public function __invoke(){
		//TODO
        return get_called_class();

	}

    /**
     * 调用自定义方法
     * @param $function
     * @param $args
     * @return mixed
     */
    private function callUserFuncArray($function, $args) {
        if($function)
            return call_user_func_array($function, $args);
    }

    /**
     * 数据列表
     * @param int $page
     * @param int $pageSize
     * @param array $args
     * @return array
     */
    public function lists($args = []){
        $page = $args['page']>0?$args['page']:1;
        $page_size = $args['page_size']>0?$args['page_size']:10;
        $count = 0;
        $primary_key_name = $this->model->getKeyName();
        $builder = $this->model->newQuery();
        $this->model->getConnection()->beginTransaction();
        try {
            $builder->orderBy($primary_key_name,'DESC')->skip(($page-1)*$page_size)->take($page_size);
            $this->callUserFuncArray($this->beforeLists,[&$builder,&$args]);
            $lists = $builder->get();
            if(!empty($lists)){
                $lists = $lists->toArray();
                $count = $builder->skip(0)->count();
            }
            $this->callUserFuncArray($this->afterLists,[&$lists,&$args]);
            $this->model->getConnection()->commit();
        }catch (\Exception $e){
            $this->model->getConnection()->rollBack();
        }
//        sql();
        return compact('lists','count');
    }


    /**
     * 数据记录详细
     * @param $id
     * @param array $args
     * @return mixed
     */
    public function get($id){
        $builder = $this->model->newQuery();
        $this->model->getConnection()->beginTransaction();
        try {
            $this->callUserFuncArray($this->beforeGet,[&$builder]);
            $result = $builder->find($id);
            if(!empty($result)){
                $result = $result->toArray();
            }
            $this->callUserFuncArray($this->afterGet,[&$result]);
            $this->model->getConnection()->commit();
        }catch (\Exception $e){
            $this->model->getConnection()->rollBack();
        }
        return $result;
    }


    /**
     * 保存数据
     * @param $args
     * @return mixed
     */
    public function save($args){
        $primary_key_name = $this->model->getKeyName();
        $primary_key = !empty($args[$primary_key_name])?$args[$primary_key_name]:'';
        unset($args[$primary_key_name]);
        if($primary_key != ''){
            $this->model = $this->model->find($primary_key);
        }
        $this->model->getConnection()->beginTransaction();
        try {
            $this->callUserFuncArray($this->beforeSave,[&$this->model,&$args]);
            $result = $this->model->fill($args)->save();
            $this->callUserFuncArray($this->afterSave,[&$this->model,&$result,&$args]);

            $this->model->getConnection()->commit();
        }catch (\Exception $e){
            $this->model->getConnection()->rollBack();
        }
        return $result;
    }


    /**
     * @param $key
     * @return mixed
     */
    public function delete($key){
        $primary_key_name = $this->model->getKeyName();
        $builder = $this->model->newQuery();
        $this->model->getConnection()->beginTransaction();
        try {
            $this->callUserFuncArray($this->beforeDelete,[&$builder,&$key]);
            $result = $builder->where($primary_key_name,$key)->delete();
            $this->callUserFuncArray($this->afterDelete,[&$result,&$key]);
            $this->model->getConnection()->commit();
        }catch (\Exception $e){
            $this->model->getConnection()->rollBack();
        }
        return $result;
    }
}


