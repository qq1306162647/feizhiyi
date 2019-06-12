<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Request;
use think\facade\Session;
class Withdrawal extends Base
{

	public function index()
	{

		$viewData['webTitle'] = '佣金提现';
        $this->assign('viewData',$viewData);
        return $this->view->fetch('withdrawal/withdrawal_index'); 
	}

	//提现操作
	public function withdrawalAction()
	{
		if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'action_money|提现金额'=>[
                    'require'=>'require',
                ],
                'alnumber|支付宝账号'=>[
                    'require'=>'require',
                    'length'=>'1,200',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            // $a = $data['reward_money'];
            // if (!!($a % 10) && $a){
            //      return ['status'=>2,'msg'=>'提现金额必须是10的倍数，如：10，20，30，110，260等等...'];
            // }
    
            $userInfo = model('UserModel')->where('uid',Session::get('userInfo.uid'))->find();

            if($data['action_money'] > $userInfo['user_commission']){
                return ['status'=>2,'msg'=>'提现金额不得大于佣金余额！'];
            }


            $withdrawalData['withdrawal_user_id'] = $userInfo['uid'];
            $withdrawalData['alipay_number'] = $data['alnumber'];
            $withdrawalData['withdrawal_value'] = $data['action_money'];
            // $withdrawalData['service_money'] = round($data['action_money'] * 0.03,2);
            // $withdrawalData['payment_value'] =$data['action_money'] - $withdrawalData['service_money'];


            //新增奖励记录
            $insertReward = model('WithdrawalModel')->insertDatas($withdrawalData);
            if($insertReward['status'] == 1){
                //修改用户佣金
                model('UserModel')->where('uid',$userInfo['uid'])->setDec('user_commission',$withdrawalData['withdrawal_value']);

                //新增记录

                $commissionData['user_id'] = $userInfo['uid'];
				$commissionData['commission_value'] = $withdrawalData['withdrawal_value'];
				$commissionData['commission_cate'] = 2;
				model('CommissionModel')->create($commissionData);
                return ['status'=>1,'msg'=>'提现申请已经成功提交！'];
            }
        }
        return ['status'=>2,'msg'=>'请求类型错误'];
	}
	


}