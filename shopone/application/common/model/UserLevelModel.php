<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class UserLevelModel extends Model
{
	protected 	$table = 'my_user_level';
	protected 	$pk = 'lid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'level_create_time';
	protected 	$updateTime 		= 'level_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['level_create_time'];
	protected 	$update 			= ['level_update_time'];


	//数据列表
	public static function dataList()
	{
		return UserLevelModel::order('lid asc')->select();
	}

	//获取详情信息
	public static function dataDetails($where)
	{
		return UserLevelModel::where($where)->find();
	}
	
}