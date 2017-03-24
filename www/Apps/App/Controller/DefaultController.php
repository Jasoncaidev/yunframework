<?php
/*
 * @file /www/Apps/Controller/DefaultController.php
 * @project  Yun framework project
 * @package  Yun.app.controller
 * @author  Yunframework team
 * @contact  yunframework@gmail.com
 * @copyright  Copyright 2012-2016  Yun(tm)    http://www.yunframework.com
 * @license  GPL 2.0
 * @version   0.1.0
 * @decription 。
 * @modify 2017-3-24
 **/
namespace www\Apps\App\Controller;
use www\Apps\App\Model\User;
use www\Apps\App\Model\Post;

class DefaultController extends AppController {

	public function __construct()
	{
		parent::__construct();
		$this->cacheSeconds = 60;
		$this->layout = "default";
	}
	public function index(){
		$this->actionCacheSeconds = 0;
		$this->set("page_title","Default Page");
		$this->set("page_created_at",date('Y-m-d H:i:s',time()));

		return $this->display();
	}
	public function adduser(){
		$user = new User();
		$user->getConnection()->beginTransaction();
		try {
			$user->username = "newuser";
			$user->password = "**********";
			$user->group_id = 1;
			$user->level = 1;
			$user->status = 1;
			$user->save();
			$user->getConnection()->commit();
		}catch (\Exception $e){
			$user->getConnection()->rollBack();
		}
		$this->set("page_title","Default Page");
		echo "user added";
	}
	public function userposts(){
		$user = new User();
		$user->getConnection()->beginTransaction();

		$users = $user->where('id',1)->with('posts')->get()->toArray();
		debug($users);

		$this->set("page_title","Default Page");
		echo "posts of user";
	}
	public function post(){
		$post = new Post();
		$post->getConnection()->beginTransaction();
		try {
			$post->title = "new post";
			$post->content = "posts content";
			$post->user_id = 1;
			$post->save();
			$post->getConnection()->commit();
		}catch (\Exception $e){
			$post->getConnection()->rollBack();
		}
		$this->set("page_title","Default Page");
		echo "post saved";
	}
	public function update(){
		$user = new User();
		$user->getConnection()->beginTransaction();
		try {
			$user->where('id','<=',10)->update(['created_at'=>null,'updated_at'=>null]);
			$user->getConnection()->commit();
		}catch (\Exception $e){
			$user->getConnection()->rollBack();
		}
		return $this->display('index.tpl');
	}

}
