<?php
namespace app\common\model;
use think\Model;

class CouponModel extends Model
{
	protected 	$table 				= 'my_coupon';
	protected 	$pk 				= 'cid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'coupon_create_time';
	protected 	$updateTime 		= 'coupon_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['coupon_create_time'];
	protected 	$update 			= ['coupon_update_time'];
	//个人用户的代金券
	public static function userCoupon($id)
	{
		$where['user_id'] = $id;
		$where['use_status'] = 1;
		return CouponModel::where($where)->find();
	}

	//数据详情
	public static function dataInfo($id)
	{
		return CouponModel::get($id);
	}

	//修改代金券使用状态
	public static function setUseStatus($id)
	{
		CouponModel::where('cid', $id)->update(['use_status' => 2]);
	}

	//赠送代金券
	public static function giveCoupon($id)
	{
		// $data['user_id'] = $id;
		$model = new CouponModel;

		$list = [
		    ['user_id'=>$id,'coupon_value'=>100,'use_status'=>1],
		    ['user_id'=>$id,'coupon_value'=>100,'use_status'=>1],
		    ['user_id'=>$id,'coupon_value'=>100,'use_status'=>1],
		    ['user_id'=>$id,'coupon_value'=>100,'use_status'=>1],
		    ['user_id'=>$id,'coupon_value'=>100,'use_status'=>1],
		    
		];
		return $model->saveAll($list);
	}
}