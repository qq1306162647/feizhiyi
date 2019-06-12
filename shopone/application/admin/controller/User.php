<?php
namespace app\admin\controller;
use app\common\model\UserModel;
use think\facade\Request;
use think\facade\Session;
class User extends Base
{
	
	public function dataList()
	{
		$data = Request::post();
		if($data){
			Session::set('searchPhoneNumber',$data['searchPhoneNumber']);
			$where[] = ['user_phone','like','%'.Session::get('searchPhoneNumber').'%'];
			
			$viewData['dataList'] = UserModel::whereDataList($where);
		}else{
			$viewData['dataList'] = UserModel::dataList();
		}
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}


	public function dataListOne()
	{
		$data = Request::param();
		$viewData['dataInfo'] = UserModel::get($data['s']);
		$where['recommend_code'] = $data['s'];
		$viewData['dataList'] = UserModel::whereDataList($where);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function userCommissionList()
	{
		// $where['commission_cate'] = 1;
		$where['user_id'] = Request::param('s');
		$viewData['dataList'] = model('CommissionModel')->allCommissionList($where);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function userMoneyList()
	{
		$where['audit_state'] = 2;
		$where['user_id'] = Request::param('s');
		$viewData['dataList'] = model('UserMoneyLogModel')->userRechargeList($where);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//设置为运营商
	public function setUserLevel()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'uid|会员ID'=>[
					'require'=>'require',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			return UserModel::setUserLevel($data);
			
			
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	//推荐人列表
	public function recommendedList()
	{
		$data = Request::param();

		$where['recommend_1'] = Session::get('uid');
		$viewData['dataList'] = UserModel::whereDataList($where);
		$viewData['dataInfo'] = UserModel::get(Session::get('uid'));
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
		
	}


	// 更换推荐人
	public function setRecommended(){
		if(Request::isAjax()){
			return model('UserModel')->setRecommended(Request::param());
		}

		return ['status'=>1,'msg'=>'请求类型错误'];
	}
}