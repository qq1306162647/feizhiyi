<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class Sing extends Base
{

    
    public function index()
    {
       	$viewData['webTitle'] = '签到';

       	//月初时间
       	$monthStart = date('Y-m-01', strtotime(date("Y-m-d")));

       	// 月末时间
       	$monthEnd   = date('Y-m-d', strtotime("$monthStart +1 month -1 day"));
       	// dump(strtotime($monthEnd));
       	// $where[''] = strtotime($monthStart);
       	// $where['end'] = strtotime($monthEnd);

       	$where[] = ['sing_date_time','>=',strtotime($monthStart)];
		$where[] = ['sing_date_time','<=',strtotime($monthEnd)];
		$where[] = ['user_id','=',Session::get('userInfo.uid')];
       	$dataList = model('UserSingLogModel')->where($where)->select();
       	$jsonArray = array();
       	foreach ($dataList as $key => $value) {
       		$jsonArray[$key]['signDay'] = date('d',$value['sing_date_time']);
       	}
       	$viewData['jonsString'] = json_encode($jsonArray);
        $this->assign('viewData',$viewData);
        return $this->view->fetch('sing/sing_index');
    }

    //签到操作
    public function singAction()
    {
    	if(Request::isAjax()){
    		$thisTime = time();
    		$thisTimeStr = date('Y-m-d',$thisTime);
    		$dataTime['start'] = strtotime($thisTimeStr);
			$dataTime['end'] = strtotime($thisTimeStr."+1 day");
    	
    		$where[] = ['sing_date_time','>=',$dataTime['start']];
    		$where[] = ['sing_date_time','<=',$dataTime['end']];
    		$where[] = ['user_id','=',Session::get('userInfo.uid')];

    		$singLog = model('UserSingLogModel')->where($where)->find();
    		if(!$singLog){
    			$insertData['sing_date_time'] = $thisTime;
    			$insertData['user_id'] = Session::get('userInfo.uid');

    			$insertLogData = model('UserSingLogModel')->create($insertData);
    			if($insertLogData){
    				return ['status'=>1,'msg'=>'签到成功'];
    			}
    			return ['status'=>2,'msg'=>'签到失败，请稍后再试'];
    			
    		}
    		return ['status'=>2,'msg'=>'您今天已经签到！'];

    	}

    	return ['status'=>2,'msg'=>'请求类型错误'];
    }
}
