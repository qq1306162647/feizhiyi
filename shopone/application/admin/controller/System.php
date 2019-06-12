<?php
namespace app\admin\controller;
use think\facade\Request;
use app\common\model\SystemModel;
/*
轮播图控制器
 */
class System extends Base
{

	public function editData()
	{
		$viewData['dataInfo'] = SystemModel::get(1);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			return SystemModel::updateDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}
}