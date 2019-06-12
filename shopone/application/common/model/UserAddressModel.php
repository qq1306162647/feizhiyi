<?php
namespace app\common\model;
use think\Model;
class UserAddressModel extends Model
{
	protected 	$table 				= 'my_user_address';
	protected 	$pk 				= 'aid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'address_create_time';
	protected 	$updateTime 		= 'address_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['address_create_time'];
	protected 	$update 			= ['address_update_time'];
	//数据列表
	public static function dataList($uid)
	{
		return UserAddressModel::where('user_id',$uid)->order('selected_status desc,aid desc')->select();
	}
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = UserAddressModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}

	//设为默认地址
	public static function defauleAddress($data)
	{
		$allWhere['user_id'] = $data['user_id'];
		$allWhere['selected_status'] = 1;
		$setAllStatus = UserAddressModel::where($allWhere)->setField('selected_status',0);
		if($setAllStatus){
			$setOneStatus = UserAddressModel::where('aid',$data['aid'])->setField('selected_status',1);
			if($setOneStatus){
				return ['status'=>1,'msg'=>'Succcess','ss'=>UserAddressModel::getLastSql()];
			}
			return ['status'=>2,'msg'=>'操作失败，请稍后再试'];

		}
		return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
	}

	//数据更新
	public static function updateDatas($data)
	{
		$model = new UserAddressModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['aid' => $data['aid']]);
		if($updateDatas){
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}

	//删除数据
	public static function deleteDatas($id)
	{
		$deleteDatas = UserAddressModel::destroy($id);
		if($deleteDatas){
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];

	}
}