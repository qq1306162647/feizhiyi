<?php
namespace app\admin\controller;
use think\facade\Request;
use app\common\model\NoticeModel;
/*
公告
 */
class Notice extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = NoticeModel::dataList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}
	public function addData()
	{
		return $this->view->fetch();
	}
	public function deleteDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			
			return NoticeModel::deleteDatas($data['s']);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function insertDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'notice_title|公告标题'=>[
					'require'=>'require',
				],
				'notice_content|公告内容'=>[
					'require'=>'require',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			return NoticeModel::insertDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function editData()
	{
		$viewData['dataInfo'] = NoticeModel::get(Request::param('s'));
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'notice_title|公告标题'=>[
					'require'=>'require',
				],
				'notice_content|公告内容'=>[
					'require'=>'require',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			return NoticeModel::updateDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}
}