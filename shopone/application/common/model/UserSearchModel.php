<?php
namespace app\common\model;
use think\Model;
class UserSearchModel extends Model
{
	protected 	$table 				= 'my_user_search';
	protected 	$pk 				= 'sid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'search_create_time';
	protected 	$updateTime 		= 'search_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['search_create_time'];
	protected 	$update 			= ['search_update_time'];
	//数据列表
	public static function userDataList($uid)
	{
		return UserSearchModel::where('user_id',$uid)->order('sid desc')->select();
	}

	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = UserSearchModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}

	//数据更新
	public static function updateDatas($data)
	{
		$model = new UserSearchModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['sid' => $data['sid']]);
		if($updateDatas){
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}

	//清楚记录
	public static function delAllData($uid)
	{
		$deleteDatas = UserSearchModel::where('user_id',$uid)->delete();
		if($deleteDatas){
			return ['status'=>1,'msg'=>'清除成功'];
		}
		return ['status'=>2,'msg'=>'清除失败，请稍后再试'];
	}

	//删除数据
	public static function deleteDatas($id)
	{
		$deleteDatas = UserSearchModel::destroy($id);
		if($deleteDatas){
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];

	}
}