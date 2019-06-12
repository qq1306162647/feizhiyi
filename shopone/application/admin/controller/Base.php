<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Session;
/**
* 继承类
*/
class Base extends Controller
{
	
	public function  initialize()
	{
		$adminInfo = Session::get('adminInfo');
		if(!$adminInfo){
			$this->error('请先登录！','Login/index');
		}
	}
}