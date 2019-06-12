<?php
namespace app\admin\controller;
use think\facade\Request;
use app\common\model\RewardModel;
class Reward extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = RewardModel::dataList();
		$this->assign('viewData',$viewData);
		// dump($viewData['dataList']);
		return $this->view->fetch();
	}

	public function withdrawalList()
	{
		$viewData['dataList'] = RewardModel::withdrawalList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	//修改状态
	public function updateDataStatus()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return RewardModel::updateDataStatus($data);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}

	//删除
	public function deleteData()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return RewardModel::deleteData($data);
		}
		return ['status'=>2,'mgs'=>'请求类型错误'];
	}

}