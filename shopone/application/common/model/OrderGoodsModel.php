<?php
namespace app\common\model;
use think\Model;
use app\index\controller\Wx;
class OrderGoodsModel extends Model
{
	protected 	$table = 'my_order_goods';
	protected 	$pk = 'ogid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'order_goods_create_time';
	protected 	$updateTime 		= 'order_goods_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['order_goods_create_time'];
	protected 	$update 			= ['order_goods_update_time'];

	

	
	//新增数据
	public static function insertDatas($data)
	{	
		
		$insertDatas = OrderGoodsModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'下单成功','ogid'=>$insertDatas->ogid];
		}

		return ['status'=>2,'msg'=>'下单失败，请稍后再试'];
	}


	//获取某个订单的商品列表
	public static function getOrderGoodsList($oid)
	{
		return OrderGoodsModel::where('order_id',$oid)->join('my_goods','my_order_goods.goods_id = my_goods.gid')->select();
	}




	
}