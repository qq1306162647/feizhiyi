<?php
namespace app\admin\controller;
use think\facade\Request;
use think\facade\Session;
class Agent extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = model('UserModel')->angenList(Session::get('levelWhere'));
		$viewData['levelList'] = model('UserLevelModel')->dataList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function ceoList()
	{
		$viewData['dataList'] = model('UserModel')->ceoList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function wages()
	{
		// Session::delete('ceoWagesTime');
		if(!Session::has('ceoWagesTime')){
			$startTime = date('Y-m-01', strtotime(date("Y-m-d")));
			$endTime = date('Y-m-d', strtotime("$startTime +1 month -1 day"));
			Session::set('ceoWagesTime.startTime',strtotime($startTime));
			Session::set('ceoWagesTime.endTime',strtotime($endTime));

			
		}
		$getWhereData['startTime'] = Session::get('ceoWagesTime.startTime');
		$getWhereData['endTime'] = Session::get('ceoWagesTime.endTime');
		// $map[] = ['create_time','>=',Session::get('ceoWagesTime.startTime')];
		// $map[] = ['create_time','<',Session::get('ceoWagesTime.endTime')]; 
		// $map[] = ['reward_cate','=',3]; 
		$viewData['dataList'] = model('UserModel')->ceoWages($getWhereData);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function getWagesWhere()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$startTime = date('Y-m-01', strtotime($data['wagesWhereTime']));
			$endTime = date('Y-m-d', strtotime("$startTime +1 month -1 day"));
			Session::set('ceoWagesTime.startTime',strtotime($startTime));
			Session::set('ceoWagesTime.endTime',strtotime($endTime));
			if(Session::has('ceoWagesTime')){
				return ['status'=>1,'msg'=>'Success'];
			}
			return ['status'=>1,'msg'=>'Error'];
		}

		return ['status'=>1,'msg'=>'请求类型错误'];
	}

	public function youList()
	{
		$viewData['dataList'] = model('UserModel')->youAngenList(Request::param('u'),Request::param('l'));
		$viewData['dataInfo'] = model('UserModel')->get(Request::param('u'));
		$viewData['levelInfo'] = model('UserLevelModel')->get(Request::param('l'));
		$viewData['resultsInfo'] = model('UserModel')->userAngenResults(Request::param('u'),Request::param('l'));
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

	public function getwhere()
	{
		if(Request::isAjax()){
			Session::set('levelWhere',Request::param('s'));
			if(Session::has('levelWhere')){
				return ['status'=>1,'msg'=>'Success'];
			}
			return ['status'=>1,'msg'=>'Error'];
		}

		return ['status'=>1,'msg'=>'请求类型错误'];
	}
}