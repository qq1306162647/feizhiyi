<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class WithdrawalModel extends Model
{
	protected 	$table = 'my_withdrawal_log';
	protected 	$pk = 'wid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'withdrawal_create_time';
	protected 	$updateTime 		= 'withdrawal_update_time';
	protected 	$dateFormat 		= 'Y/m/d H:i:s';
	protected 	$insert 			= ['withdrawal_create_time'];
	protected 	$update 			= ['withdrawal_update_time'];


	//新增数据
	public static function insertDatas($data)
	{
		$model = new WithdrawalModel;
		// 过滤post数组中的非数据表字段数据
		$insertDatas = $model->allowField(true)->create($data);
		// $insertDatas = UserModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'操作成功'];
		}

		return ['status'=>2,'msg'=>'操作失败'];
	}



	//提现列表
	public static function withdrawalList()
	{
		$dataList = WithdrawalModel::order('wid desc')
						->join('my_user','my_withdrawal_log.withdrawal_user_id = my_user.uid')
						->paginate(20);

		return $dataList;
	}

	//修改状态
	public static function updateDataStatus($data)
	{
		$data['withdrawal_status'] = 2;
		$updateDatas = WithdrawalModel::where('wid',$data['wid'])->update($data);
		if($updateDatas){
			$WithdrawalData = where('wid',$data['wid'])->find();
			$messageData['message_taitle'] = '提现已打款';
			$messageData['message_content'] = '您的提现申请已通过，工作人员已经打款，请注意查收';
			$messageData['message_user_id'] = $WithdrawalData['withdrawal_user_id'];
			$messageData['message_cate'] = 2;
			$messageData['message_status'] = 1;
			model('MessageModel')->create($messageData);
			return ['status'=>1,'msg'=>'提现状态已修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
	}


	
}