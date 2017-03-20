<?php 
/*
 * @file /yun/classes/model.php
 * @project  Yun framework project
 * @package  Yun.classes.model
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription model父类。
 * @modify 2016-08-07
 **/
namespace Yun\Classes;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Yun\Core\App;

abstract class Model extends EloquentModel{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /*  */
    public  function __construct(){

        $this->connection = App::$connection;
    }
    public function findFirst() {

        return $this->query('select * from '.$this->database.'.'.$this->table.' limit 1');
    }
    public function queryRaw($sql) {
    	debug($sql);
        return $this->db->execute($sql);
    }
	
}


