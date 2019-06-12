<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class RechargeModel extends Model
{
	protected 	$table = 'my_recharge';
	protected 	$pk = 'rid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'recharge_create_time';
	protected 	$updateTime 		= 'recharge_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['recharge_create_time'];
	protected 	$update 			= ['recharge_update_time'];

	
	
}