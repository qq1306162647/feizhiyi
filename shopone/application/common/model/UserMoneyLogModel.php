<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class UserMoneyLogModel extends Model
{
	protected 	$table = 'my_user_money_log';
	protected 	$pk = 'mid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'money_create_time';
	protected 	$updateTime 		= 'money_update_time';
	protected 	$dateFormat 		= 'Y/m/d H:i:s';
	protected 	$insert 			= ['money_create_time'];
	protected 	$update 			= ['money_update_time'];

	
	//审核通过
	public static function auditApproval($id)
	{
		$setMonesStatus = UserMoneyLogModel::where('mid',$id)->setField('audit_state',2);
		if($setMonesStatus){
			$monesInfo = UserMoneyLogModel::get($id);
			$setUserData = model('UserModel')->where('uid',$monesInfo['user_id'])->setInc('user_money',$monesInfo['action_money_value']);
			$userInfo = model('UserModel')->get($monesInfo['user_id']);
			if($setUserData){

				//佣金奖励
				model('CommissionModel')->provideCommission($id);

				//级别调整
				$levelList = model('UserLevelModel')->select();
				foreach ($levelList as $key => $value) {
					if($userInfo['user_level'] < $value['lid'] and $monesInfo['action_money_value'] >= $value['up_level_where']){

						//用户升级操作
						model('UserModel')->where('uid',$userInfo['uid'])->setField('user_level',$value['lid']);
					}
				}
				return ['status'=>1,'msg'=>'修改成功'];
			}
			return ['status'=>2,'msg'=>'操作失败'];

		}

		return ['status'=>2,'msg'=>'操作失败'];
	} 


	



	//全部的充值记录
	public static function allRechargeList()
	{
		$where['log_types'] = 2;
		return UserMoneyLogModel::where($where)
							->order('mid desc')
							->join('my_user','my_user_money_log.user_id = my_user.uid')
							->join('my_recharge_status','my_user_money_log.audit_state =  my_recharge_status.sid')
							->paginate(20);
	}


	//用户的积分记录不分页的那种
	public static function userLog($uid)
	{
		$where['user_id'] = $uid;
		$where['audit_state'] = 2;
		return UserMoneyLogModel::where($where)
							->join('my_user','my_user_money_log.user_id = my_user.uid')
							->order('mid desc')
							->select();
	}

	// 用户的积分明细
	public static function userRechargeList($where)
	{
		return UserMoneyLogModel::where($where)
							->order('mid desc')
							->join('my_user','my_user_money_log.user_id = my_user.uid')
							->join('my_recharge_status','my_user_money_log.audit_state =  my_recharge_status.sid')
							->paginate(20);
	}

	public static function deleteData($id)
	{
		$dataInfo = UserMoneyLogModel::get($id);
		$deleteDatas = UserMoneyLogModel::destroy($id);
		if($deleteDatas){
			$file1='uploads/voucher/'.$dataInfo['pay_voucher'];
			$file2='uploads/voucher/s_'.$dataInfo['pay_voucher'];
			if(is_file($file1)){
				unlink($file1);
			}
			if(is_file($file2)){
				unlink($file2);
			}
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];
	}

	
	
}