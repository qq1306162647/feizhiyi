<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class Message extends Base
{
  
    public function index()
    {
        
    	$viewData['webTitle'] = '消息通知';
        $viewData['dataList'] = model('MessageModel')->userDataList(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
       	return $this->view->fetch('message/message_index');
    }

    public function details()
    {
        $viewData['webTitle'] = '订单详情';
        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }
}
