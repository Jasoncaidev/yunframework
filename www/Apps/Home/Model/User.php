<?php
/*
 * @file /www/Apps/Home/Model/User.php
 * @project  Yun framework project
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2013   Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription user 模型。
 * @modify 2017-3-24
 **/
namespace www\Apps\Home\Model;
class User extends Base {
		public $table = "users";
		public  $timestamps = false;

	public function posts(){
		return $this->hasMany(Post::class,'user_id','id');
	}

}
