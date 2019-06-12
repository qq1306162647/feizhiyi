<?php
namespace app\index\controller;
use think\Controller;
use think\Facade\Request;
use think\Facade\Session;
class Feedback extends Controller
{

	public function index()
	{

		$viewData['webTitle'] = '意见反馈';
        $this->assign('viewData',$viewData);
        return $this->view->fetch('feedback/feedback_index'); 
	}

	//提交意见反馈
	public function getData()
	{
		if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'feedback_text|反馈内容'=>[
                    'require'=>'require',
                    'length'=>'1,254',
                ],
            
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            $data['user_id'] = Session::get('userInfo.uid');
            return  model('FeedbackModel')->insertDatas($data);


        }

        return ['status'=>2,'msg'=>'请求类型错误'];
	}
	


}