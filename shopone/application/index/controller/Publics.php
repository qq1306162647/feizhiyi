<?php
namespace app\index\controller;
use think\Controller;
class Publics extends Controller
{

	public function download()
	{

		$viewData['webTitle'] = '易洗宝APP下载';
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
	}
	


}