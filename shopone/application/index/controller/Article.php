<?php
namespace app\index\controller;
use think\facade\Session;
use app\common\model\ArticleModel;
use think\facade\Request;
class Article extends Base
{
  
    public function index()
    {
    	$viewData['webTitle'] = '产品案例';
        $viewData['dataList'] = ArticleModel::allDataList();
       	$this->assign('viewData',$viewData);
       	return $this->view->fetch();
    }

    public function details()
    {
        $viewData['webTitle'] = '案例详情';
        $viewData['dataInfo'] = ArticleModel::dataInfo(Request::param('s'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch();

    }
}
