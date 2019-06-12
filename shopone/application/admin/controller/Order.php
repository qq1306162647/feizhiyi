<?php
namespace app\admin\controller;
use app\common\model\OrderModel;
use think\facade\Request;
use think\facade\Session;
class Order extends Base
{
	public function dataList()
	{
		$where['order_cancel_status'] = 1;
		$data = Request::param();
		if(count($data)>=1){
			$where['order_status'] = $data['s'];
		}
		$viewData['dataList'] = OrderModel::dataList($where);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	// 报表管理
	public function reportForm()
	{
		
		$data = Request::post();
		if(Session::has('orderDataWhere.start')){
			$map[] = ['order_create_time','>=',Session::get('orderDataWhere.start')];
			$map[] = ['order_create_time','<',Session::get('orderDataWhere.end')]; 
			
		}

		$map[] = ['order_types','=',1]; 
		$modelData = OrderModel::reportForm($map);
		$viewData['dataList'] = $modelData['dataList'];
		$viewData['moenyValue'] = $modelData['moenyValue'];
		$viewData['orderCount'] = $modelData['orderCount'];
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function getwhere()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataTime['start'] = strtotime($data['searchOrderStartDate']);
			$dataTime['end'] = strtotime($data['searchOrderEndDate']."+1 day");
			Session::set('orderDataWhere',$dataTime);
			Session::set('orderDataWhere2',$data);
			if(Session::has('orderDataWhere')){
				return ['status'=>1,'msg'=>'Success'];
			}
			return ['status'=>1,'msg'=>'Error'];
		}

		return ['status'=>1,'msg'=>'请求类型错误'];
	}




	public function setDataInfo()
	{
		if(Request::isAjax()){
			$data = Request::param();
			
			return OrderModel::setOrderInfo($data);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}

	public function youDataList()
	{
		$viewData['dataInfo'] = model('UserModel')->get(Request::param('s'));
		$viewData['dataList'] = OrderModel::youDataList($viewData['dataInfo']['uid']);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//未发货订单
	public function orderOne()
	{
		$viewData['dataList'] = OrderModel::orderOne();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//已发货订单
	public function orderTwo()
	{
		$viewData['dataList'] = OrderModel::orderTwo();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//已完成订单
	public function orderThree()
	{
		$viewData['dataList'] = OrderModel::orderThree();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//赠品订单
	public function giftDataList()
	{
		$viewData['dataList'] = OrderModel::giftDataList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//修改订单状态
	public function updateDataStatus()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return OrderModel::updateDataStatus($data);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}

	//删除订单
	public function deleteData()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return OrderModel::deleteData($data);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}
}