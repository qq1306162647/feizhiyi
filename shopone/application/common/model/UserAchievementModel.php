<?php
namespace app\common\model;
use think\Model;
use app\index\controller\Wx;
class UserAchievementModel extends Model
{
	protected 	$table = 'my_user_achievement';
	protected 	$pk = 'aid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'achievement_create_time';
	protected 	$updateTime 		= 'achievement_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['achievement_create_time'];
	protected 	$update 			= ['achievement_update_time'];



	//CEO当月20层的订单数量
	public static function ceoMonthOrderNumber($uid)
	{
		$thisOrderTime= date('Y-m',time());
        $startDate=strtotime($thisOrderTime);
        $endDate=strtotime($thisOrderTime." +1 month");
        $where[0] = ['achievement_create_time','>=',$startDate];
        $where[1] = ['achievement_create_time','<',$endDate]; 
        $where[2] = ['achievement_user_id','=',$uid]; 
        $where[3] = ['achievement_order_types','=',1]; 

		$dataInfo['ceoMonthOrderNumber'] =  UserAchievementModel::where($where)->count();
		// $dataInfo['ceoMonthOrderNumber'] =  model('UserAchievementModel')->getLastSql();
		$dataInfo['ceoMonthOrderTotal'] =  UserAchievementModel::where($where)->sum('achievement_money');
		return $dataInfo;
	}
	





	
}