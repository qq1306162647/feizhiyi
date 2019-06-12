<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class CommissionModel extends Model
{
	protected 	$table = 'my_commission_log';
	protected 	$pk = 'cid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'commission_create_time';
	protected 	$updateTime 		= 'commission_update_time';
	protected 	$dateFormat 		= 'Y/m/d H:i:s';
	protected 	$insert 			= ['commission_create_time'];
	protected 	$update 			= ['commission_update_time'];

	//个人用户的佣金列表
	public static function userCommissionList($id)
	{
		$where['user_id'] = $id;
        $where['commission_cate'] = 1;
		return CommissionModel::where($where)->join('my_user','my_commission_log.user_id = my_user.uid')->select();
	}

	//全部的佣金列表
	public static function allCommissionList($where)
	{
		// $where['commission_cate'] = 1;
		$dataList = CommissionModel::order('cid desc')
						->where($where)
						->join('my_user','my_commission_log.user_id = my_user.uid')
						->paginate(20);

		return $dataList;
	}
	//发放奖励
	public static function provideCommission($id)
	{
		$monesInfo = model('UserMoneyLogModel')->get($id);
		$actionUser = model('UserModel')->get($monesInfo['user_id']);
		$rewardUser[0] = model('UserModel')->where('uid',$actionUser['recommend_code'])->join('my_user_level','my_user.user_level = my_user_level.lid')->find();
		$rewardUser[1] = model('UserModel')->where('uid',$rewardUser[0]['recommend_code'])->join('my_user_level','my_user.user_level = my_user_level.lid')->find();



		foreach ($rewardUser as $key => $value) {
			if($value){
				if($key == 0){
					$rewardData['commission_value'] = $monesInfo['action_money_value'] * 0.01 * $value['one_reward'];
				}else{
					$rewardData['commission_value'] = $monesInfo['action_money_value'] * 0.01 * $value['two_reward'];
				}

				$rewardData['user_id'] = $value['uid'];
				$rewardData['money_id'] = $monesInfo['mid'];
				$rewardData['recharge_money_value'] = $monesInfo['action_money_value'];
				$rewardData['recharge_user_id'] = $monesInfo['user_id'];
				$rewardData['commission_cate'] = 1;

				$insertLogs = CommissionModel::create($rewardData);

				$setUserData = model('UserModel')->where('uid',$value['uid'])->setInc('user_commission',$rewardData['commission_value']);
			}
			

			
		}




	}


	//新增扣除佣金记录
	public static function insertCommissionDeduction()
	{
		
	} 


	
}