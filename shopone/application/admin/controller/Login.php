<?php
namespace app\admin\controller;
use think\Controller;
use think\facade\Request;
use think\facade\Session;
use app\common\model\AdminModel;

class Login extends Controller
{
	public function index()
	{
		return $this->view->fetch();
	}
	public function login()
	{
		if(Request::isAjax()) {
    		//验证数据
    		$data = Request::param();
    		$rule = 'app\common\validate\AdminValidate';
    		$res = $this->validate($data,$rule);
    		if(true !== $res){
    			return ['status'=>-1,'msg'=>$res];
    		}else{

                //执行查询  用闭包来做
                $result = AdminModel::get(function($query) use ($data){
                    $query->where('admin_number',$data['admin_name'])
                          ->where('admin_password',md5($data['admin_pwd']));
                });
                if(null == $result){
                    return ['status'=>0,'msg'=>'账号或者密码不正确'];
                    
                }else{
                    // 登陆成功将用户数据写入到session当中
                    Session::set('adminInfo',$result);
                    return ['status'=>1,'msg'=>'登陆成功'];
                }

    		}
    	}
		
		return ['status'=>2,'msg'=>'请求类型错误'];
	}
}