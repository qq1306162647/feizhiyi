<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Session;
use app\common\model\UserModel;
use think\facade\Request;
class Login extends Controller
{

	//找回密码
	public function retrievePassword()
	{
		$viewData['webTitle'] = '找回密码';
        $this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//找回密码操作
	public function passwordAction()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'user_name|姓名'=>[
					'require'=>'require',
					'length'=>'1,200',
				],
				'user_phone|手机号'=>[
					'require'=>'require',
					'mobile'=>'mobile',
					'length'=>'1,11',
				],
				'password|密码'=>[
					'require'=>'require',
					'length'=>'1,200',
				],
				'password_confirm|确认密码'=>[
					'require'=>'require',
					'confirm'=>'password',
					'length'=>'1,200',
				],
				
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			$userWhere['user_name'] = $data['user_name'];
			$userWhere['user_phone'] = $data['user_phone'];
			$userInfo = UserModel::where($userWhere)->find();
			if($userInfo){
				$setData['password'] = $data['password'];
				$setData['uid'] = $userInfo['uid'];
				return UserModel::setPassword($setData);
			}
			return ['status'=>2,'msg'=>'姓名或手机号错误'];
			
			
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}
	//登录
	public function index()
	{
		$viewData['webTitle'] = '登录';
        $this->assign('viewData',$viewData);
		return $this->view->fetch('login/login_index');
	}

	//登录操作
	public function loginAction()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'user_phone|手机号'=>[
					'require'=>'require',
					'mobile'=>'mobile',
					'length'=>'1,11',
				],
				'password|密码'=>[
					'require'=>'require',
					'length'=>'1,200',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			return UserModel::userLogin($data);
			
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}



}