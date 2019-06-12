<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class RewardModel extends Model
{
	protected 	$table = 'my_reward';
	protected 	$pk = 'rid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'reward_create_time';
	protected 	$updateTime 		= 'reward_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['reward_create_time'];
	protected 	$update 			= ['reward_update_time'];

	//删除数据
	public static function deleteData($id)
	{	
		$deleteData = RewardModel::destroy($id);
		if($deleteData){
			return ['status'=>1,'msg'=>'删除成功'];
		}

		return ['status'=>2,'msg'=>'下单失败，请稍后再试'];
	}
	
	//数据详情
	public static function dataInfo($id)
	{
		return  RewardModel::where("rid",$id)
							->join('my_reward_cate','my_reward.reward_cate = my_reward_cate.cid')
							->join('my_user','my_reward.user_id = my_user.uid')
							->find();
	}

	//新增数据
	public static function insertDatas($data)
	{
		

		$insertDatas = RewardModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'操作成功'];
		}

		return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
	}

	//修改状态
	public static function updateDataStatus($data)
	{
		$data['reward_status'] = 2;
		$updateDatas = RewardModel::where('rid',$data['rid'])->update($data);
		if($updateDatas){
			return ['status'=>1,'msg'=>'奖励状态已修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
	}

	//数据列表
	public static function dataList()
	{
		$rewardList = RewardModel::order("rid desc")
							->where('reward_cate','=',1)
							->join('my_reward_cate','my_reward.reward_cate = my_reward_cate.cid')
							->join('my_user','my_reward.user_id = my_user.uid')
							->paginate(20);

		foreach ($rewardList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['satisfyUser'] = model('UserModel')->get($value['satisfy_user_id']);
		}
		return $rewardList;

	}


	//提现列表
	public static function withdrawalList()
	{
		$rewardList = RewardModel::order("rid desc")
							->where('reward_cate','=',2)
							->join('my_reward_cate','my_reward.reward_cate = my_reward_cate.cid')
							->join('my_reward_status','my_reward.reward_status = my_reward_status.sid')
							->join('my_user','my_reward.user_id = my_user.uid')
							->field('rid,user_name,user_phone,reward_money,alnumber,status_name,reward_status,my_reward.reward_create_time,satisfy_user_id')
							->paginate(20);

		foreach ($rewardList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['satisfyUser'] = model('UserModel')->get($value['satisfy_user_id']);
		}
		return $rewardList;

	}



	//奖励明细
	public static function rewardDetailed($id)
	{
		$rewardList = RewardModel::order("rid desc")
							->where('user_id',$id)
							->join('my_reward_cate','my_reward.reward_cate = my_reward_cate.cid')
							->join('my_reward_status','my_reward.reward_status = my_reward_status.sid')
							->join('my_user','my_reward.user_id = my_user.uid')
							->field('reward_cate,reward_money,status_name,my_reward.reward_create_time')
							->paginate(20);

		return $rewardList;
	}

	//用户奖励列表
	public static function userRewardList($id)
	{
		$rewardList = RewardModel::order("rid desc")
							->where('user_id',$id)
							->join('my_reward_cate','my_reward.reward_cate = my_reward_cate.cid')
							->join('my_user','my_reward.user_id = my_user.uid')
							->paginate(20);

		foreach ($rewardList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['satisfyUser'] = model('UserModel')->get($value['satisfy_user_id']);
		}
		return $rewardList;
	}

	

	


	
}