<?php
namespace app\index\controller;
use think\facade\Session;
use app\common\model\GoodsModel;
use think\facade\Request;
class Notice extends Base
{

    public function index()
    {
    	$viewData['webTitle'] = '公告详情';
        $data = Request::param();
        if($data){
            $viewData['dataInfo'] = model('NoticeModel')->where('nid',$data['s'])->find();  
        }else{
            $viewData['dataInfo'] = model('NoticeModel')->order('notice_order asc,nid desc')->find();
        }
        $this->assign('viewData',$viewData);
        return $this->view->fetch('notice/notice_details');
    }
}
