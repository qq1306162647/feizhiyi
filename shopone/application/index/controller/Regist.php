<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Session;
use app\common\model\UserModel;
use think\facade\Request;
class Regist extends Controller
{


	//注册
	public function index()
	{
		$data = Request::param();
		// dump($data);
		isset($data['s']) ? $viewData['code'] = $data['s'] : $viewData['code'] = '';

		$viewData['webTitle'] = '注册';
        $this->assign('viewData',$viewData);
		return $this->view->fetch('regist/regist_index');
	}

	//注册操作
	public function registAction()
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
				'recommend_code|推荐码'=>[
					'require'=>'require',
					'length'=>'1,200',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			$recommendInfo = UserModel::get($data['recommend_code']);
			$phoneInfo = UserModel::userDataInfo($data['user_phone']);
			if(!$phoneInfo){
				if($recommendInfo){
					$data['user_password']      = md5($data['password']);		//密码加密
					$data['recommend_code_two'] = $recommendInfo['recommend_code'];
					

					return UserModel::insertDatas($data);
				}else{
					return ['status'=>2,'msg'=>'推荐码错误'];
				}
			}
			return ['status'=>2,'msg'=>'手机号已经注册'];
			
			
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}



}