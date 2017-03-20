<?php
/*
 * @file /www/App/Model/User.php
 * @project  Yun framework project
 * @package  Yun.app.model
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2013   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription user 模型。
 * @modify 2016-08-08
 **/
namespace App\App\Model;
class User extends App {
		public $table = "users";
		public  $timestamps = false;

	public function posts(){
		return $this->hasMany(Post::class,'user_id','id');
	}

}
