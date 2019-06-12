<?php
namespace app\admin\controller;
use think\facade\Request;
use think\facade\Session;
class Index extends Base
{
	//后台管理首页
	public function index()
	{

		return $this->view->fetch();
	}

	public function main()
	{
		//用户统计
		$levelList = model('UserLevelModel')->order('lid asc')->select();
		foreach ($levelList as $key => $value) {
			$viewData['levelList'][$key] = $value;
			$viewData['levelList'][$key]['userNumber'] = model('UserModel')->where('user_level',$value['lid'])->count('uid');  
		}
		$viewData['userSum'] = model('UserModel')->count('uid'); 

		//业绩统计
		$viewData['orderTurnover'] = model('OrderModel')->where('order_status','>',1)->sum('order_total_price'); //订单营业额
		$viewData['orderCount'] = model('OrderModel')->where('order_status','>',1)->count('oid'); //成交单量
		// dump($viewData);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}


	//数据统计
	public function dataStatistics()
	{
		$viewData['orderTurnover'] = model('OrderModel')->where('order_status','>',1)->sum('order_total_price'); //订单营业额


		//今日收入
		$thisTime = time();
		$strTime = date('Y-m-d',$thisTime);
		$dataTime['start'] = strtotime($strTime);
		$dataTime['end'] = strtotime($strTime."+1 day");
		$whereOne[] = ['order_update_time','>=',$dataTime['start']];
		$whereOne[] = ['order_update_time','<=',$dataTime['end']];
		$whereOne[] = ['order_status','>=',2];
		$viewData['oneData'] = model('OrderModel')->where($whereOne)->sum('order_total_price');
		$viewData['twoData'] = model('OrderModel')->where($whereOne)->count('oid');

		//今日充值信息
		$whereTwo[] = ['money_update_time','>=',$dataTime['start']];
		$whereTwo[] = ['money_update_time','<=',$dataTime['end']];
		$whereTwo[] = ['log_types','=',2];
		$whereTwo[] = ['audit_state','=',2];
		$viewData['threeData'] = model('UserMoneyLogModel')->where($whereTwo)->sum('action_money_value');
		$viewData['fourData'] = model('UserMoneyLogModel')->where($whereTwo)->count('mid');


		//今日提现信息
		$whereThree[] = ['withdrawal_update_time','>=',$dataTime['start']];
		$whereThree[] = ['withdrawal_update_time','<=',$dataTime['end']];
		$whereThree[] = ['withdrawal_status','=',2];
		$viewData['tiveData'] = model('WithdrawalModel')->where($whereThree)->sum('withdrawal_value');
		$viewData['sixData'] = model('WithdrawalModel')->where($whereThree)->count('wid');

		//今日分销佣金
		$whereFour[] = ['commission_update_time','>=',$dataTime['start']];
		$whereFour[] = ['commission_update_time','<=',$dataTime['end']];
		$whereFour[] = ['commission_cate','=',1];
		$viewData['sevenData'] = model('CommissionModel')->where($whereFour)->sum('commission_value');
		$viewData['eightData'] = model('CommissionModel')->where($whereFour)->count('cid');

		// 充值已审核总金额
		$rechargeWhere['log_types'] = 2;
		$rechargeWhere['audit_state'] = 2;
		$viewData['rechargeTotal'] = model('UserMoneyLogModel')->where($rechargeWhere)->sum('action_money_value');

		// 充值未审核总金额
		$rechargeWhere['log_types'] = 2;
		$rechargeWhere['audit_state'] = 1;
		$viewData['notRechargeTotal'] = model('UserMoneyLogModel')->where($rechargeWhere)->sum('action_money_value');

		//订单总金额
		$orderWhere['order_status'] = 2;
		$viewData['orderTotal'] = model('OrderModel')->where($orderWhere)->sum('order_total_price');

		//未提现佣金
		$viewData['notCommission'] = model('UserModel')->sum('user_commission');

		//提现已打款佣金
		$viewData['yesCommission'] = model('WithdrawalModel')->where('withdrawal_status',2)->sum('withdrawal_value');

		//提现未打款佣金
		$viewData['unpaidCommission'] = model('WithdrawalModel')->where('withdrawal_status',1)->sum('withdrawal_value');

		//用户统计
		$levelList = model('UserLevelModel')->order('lid asc')->select();
		foreach ($levelList as $key => $value) {
			$viewData['levelList'][$key] = $value;
			$viewData['levelList'][$key]['userNumber'] = model('UserModel')->where('user_level',$value['lid'])->count('uid');  
		}
		$viewData['userSum'] = model('UserModel')->count('uid'); 

		
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function getwhere()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataTime['start'] = strtotime($data['startDate']);
			$dataTime['end'] = strtotime($data['endDate']."+1 day");
			Session::set('orderDataWhere',$dataTime);
			Session::set('orderDataWhere2',$data);
			if(Session::has('orderDataWhere')){
				return ['status'=>1,'msg'=>'Success'];
			}
			return ['status'=>1,'msg'=>'Error'];
		}

		return ['status'=>1,'msg'=>'请求类型错误'];
	}
}