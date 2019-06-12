<?php
namespace app\common\model;
use think\Model;
class SystemModel extends Model
{
	protected 	$table 				= 'my_system';
	protected 	$pk 				= 'sid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'create_time';
	protected 	$updateTime 		= 'update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['create_time'];
	protected 	$update 			= ['update_time'];

	//数据更新
	public static function updateDatas($data)
	{
		$model = new SystemModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['sid' => $data['sid']]);
		if($updateDatas){
			
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}

}