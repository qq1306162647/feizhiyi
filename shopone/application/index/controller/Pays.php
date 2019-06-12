<?php
namespace app\index\controller;
use think\Controller;
class Pays extends Controller
{

	public function index()
	{

		$viewData['webTitle'] = '支付成功';
        $this->assign('viewData',$viewData);
        return $this->view->fetch('pays/pays_index'); 
	}
	

	public function paysPwd()
	{
		$viewData['webTitle'] = '请输入支付密码';
        $this->assign('viewData',$viewData);
        return $this->view->fetch('pays/pays_index'); 	
	}


}