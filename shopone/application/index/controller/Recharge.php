<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class Recharge extends Base
{

    
    public function index()
    {
       
    }

    //提交充值信息
    public function getRecharge()
    {
    	if(Request::isAjax()){
    		$data = Request::param();
    		// return $data;
    		$dataRule = [
				'recharge_id|充值额度'=>[
					'require'=>'require',
				],

			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			if($file){
				$fileMkdir = 'uploads/voucher/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(200, 200)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$addData['pay_voucher'] = $info->getSaveName();
				}else{
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}else{
				return ['status'=>2,'msg'=>'请上传支付凭证'];
			}




    		$rechargeInfo = model('RechargeModel')->get($data['recharge_id']);

    		$addData['action_money_value'] = $rechargeInfo['recharge_value'];
    		$addData['user_id'] = Session::get('userInfo.uid');
    		$addData['log_types'] = 2;
    		$addData['audit_state'] = 1;

    		$insertData = model('UserMoneyLogModel')->create($addData);
    		if($insertData){
    			return ['status'=>1,'msg'=>'充值信息提交成功，等待后台审核'];
    		}
    		return ['status'=>2,'msg'=>'充值信息提交失败，请稍后再试'];

    		// $setUserData  = model('UserModel')->where('uid',Session::get('userInfo.uid'))->setInc('user_money',$addData['action_money_value']);
    	}

    	return ['status'=>2,'msg'=>'请求类型错误'];
    }
}
