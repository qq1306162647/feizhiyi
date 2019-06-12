<?php
namespace app\admin\controller;
use think\facade\Request;
use app\common\model\AdminModel;
use think\facade\Session;
class Admin extends Base
{
	public function setPassword()
	{
		return $this->view->fetch();
	}

	public function setPasswordAction()
	{
		if(Request::isAjax())
		{
			$dataRule = [
				'old_password|原密码'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
				'new_password|新密码'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
			];
			$data = Request::param();
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			$result = AdminModel::get(function($query) use ($data){
                $query->where('aid',Session::get('adminInfo.aid'))
                      ->where('admin_pwd',md5($data['old_password']));
            });

            if($result){
            	$getData['aid'] = Session::get('adminInfo.aid');
            	$getData['admin_pwd'] = md5($data['new_password']);
            	return AdminModel::setPassword($getData);
            }

            return ['status'=>2,'msg'=>'旧密码错误，请核对后重新输入'];


		}

		return ['status'=>2,'msg'=>'请求类型错误'];
	}
}