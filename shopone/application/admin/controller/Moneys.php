<?php
namespace app\admin\controller;
use think\facade\Request;
use app\common\model\UserMoneyLogModel;
class Moneys extends Base
{

	//全部的充值记录
	public function allRechargeList()
	{
		$viewData['dataList'] = UserMoneyLogModel::allRechargeList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//佣金比例
	public function commissionProportion()
	{
		$viewData['dataList'] = model('UserLevelModel')->dataList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//编辑佣金比例
	public function editProportion()
	{
		$viewData['dataInfo'] = model('UserLevelModel')->where("lid",Request::param('s'))->find();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//修改佣金比例
	public function updateProportion()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'one_reward|一级佣金'=>[
					'require'=>'require',
					'between'=>'0,100'
				],
				'two_reward|二级级佣金'=>[
					'require'=>'require',
					'between'=>'0,100'

				],
			];
			$dataValidate = $this->validate($data,$dataRule);

			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			
			$updateData = model('UserLevelModel')->where('lid',$data['lid'])->update($data);
			if($updateData){
				return ['status'=>1,'msg'=>'修改成功'];
			}

			return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	//充值审核通过
	public function auditApproval()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return UserMoneyLogModel::auditApproval($data['s']);
		}

		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	//佣金管理
	public function commissionList()
	{
		$where['commission_cate'] = 1;
		$viewData['dataList'] = model('CommissionModel')->allCommissionList($where);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//提现列表
	public function withdrawalList()
	{
		$viewData['dataList'] = model("WithdrawalModel")->withdrawalList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//修改状态
	public function updateDataStatus()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return model("WithdrawalModel")->updateDataStatus($data);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}

	//删除
	public function deleteData()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return UserMoneyLogModel::deleteData($data['s']);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}


	//充值审核不通过
	public function noPassage()
	{
		if(Request::isAjax()){
			$data = Request::param();

			$setDataInfo = UserMoneyLogModel::where('mid',$data['mid'])->setField('audit_state',3);
			if($setDataInfo){
				$messageData['message_taitle'] = '充值信息审核不通过';
				$messageData['message_content'] = $data['content_text'];
				$messageData['message_user_id'] = $data['message_user_id'];
				$messageData['message_cate'] = 1;
				$messageData['message_status'] = 1;

				model('MessageModel')->create($messageData);
				return ['status'=>1,'msg'=>'操作成功'];
			}

			return ['status'=>2,'mgs'=>'操作失败，请稍后再试'];
			// return UserMoneyLogModel::deleteData($data['s']);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}

}