<?php
namespace app\common\model;
use think\Model;
class FeedbackModel extends Model
{
	protected 	$table 				= 'my_feedback';
	protected 	$pk 				= 'fid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'feedback_create_time';
	protected 	$updateTime 		= 'feedback_update_time';
	protected 	$dateFormat 		= 'Y/m/d H:i:s';
	protected 	$insert 			= ['feedback_create_time'];
	protected 	$update 			= ['feedback_update_time'];

	//数据更新
	public static function insertDatas($data)
	{

		$insertData = FeedbackModel::create($data);
		if($insertData){
			
			return ['status'=>1,'msg'=>'提交成功'];
		}
		return ['status'=>2,'msg'=>'提交失败，请稍后再试'];

	}
	// public static function insertDatas($data)
	// {
	// 	$insertDatas = NoticeModel::create($data);
	// 	if($insertDatas){
	// 		return ['status'=>1,'msg'=>'添加成功'];
	// 	}

	// 	return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	// }


}