<?php
namespace app\common\model;
use think\Model;
use app\index\controller\Wx;
class OrderModel extends Model
{
	protected 	$table = 'my_order';
	protected 	$pk = 'oid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'order_create_time';
	protected 	$updateTime 		= 'order_update_time';
	protected 	$dateFormat 		= 'Y/m/d H:i:s';
	protected 	$insert 			= ['order_create_time'];
	protected 	$update 			= ['order_update_time'];

	//数据详情
	public static function dataInfo($id)
	{
		$dataInfo = OrderModel::get($id);
		$dataInfo['priceList'] = model('GoodsPriceModel')->dataList($id);
		return $dataInfo;
	}

	//订单详情
	public static function orderDetails($id)
	{
		return OrderModel::where('oid',$id)
							->join("my_user",'my_order.user_id = my_user.uid')
							->find();
	}


	//修改订单信息
	public static function setOrderInfo($data)
	{
		$setOrderInfo = OrderModel::where('oid',$data['oid'])->update($data);
		if($setOrderInfo){
			$dataInfo = OrderModel::where('oid',$data['oid'])->find();
			$messageData['message_taitle'] = '订单已发货';
			$messageData['message_content'] = '您的订单已经发货，快递公司：'.$dataInfo['express_name'].',快递编号：'.$dataInfo['express_number'].',请注意查收快递！';
			$messageData['message_user_id'] = $dataInfo['user_id'];
			$messageData['message_cate'] = 3;
			$messageData['message_status'] = 1;
			model('MessageModel')->create($messageData);


			return ['status'=>1,'msg'=>'操作成功'];
		}

		return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
	}

	//查询最大的订单
	public static function maxDataInfo($id)
	{
		return OrderModel::where('user_id',$id)->max('order_number');
	}
	
	//新增数据
	public static function insertDatas($data)
	{	
		
		$insertDatas = OrderModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'下单成功','oid'=>$insertDatas->oid];
		}

		return ['status'=>2,'msg'=>'下单失败，请稍后再试'];
	}


	public static function deleteData($id)
	{	
		$deleteData = OrderModel::destroy($id);
		if($deleteData){
			return ['status'=>1,'msg'=>'删除成功'];
		}

		return ['status'=>2,'msg'=>'下单失败，请稍后再试'];
	}


	//用户订单列表
	public static function userDataList($whereData)
	{
		$orderList = OrderModel::where($whereData)
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->join("my_user",'my_order.user_id = my_user.uid')
							->order('oid desc')
							->select();
		$dataList=array();
		foreach ($orderList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['goodsList'] = model('OrderGoodsModel')->getOrderGoodsList($value['oid']);
		}

		return $dataList;
	}
	//报表
	public static function reportForm($getwhere)
	{
		// $getwhere['order_types'] = 1;
		$returnData['dataList'] = OrderModel::order('oid desc')
							->where($getwhere)
							->join("my_user",'my_order.user_id = my_user.uid')
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->paginate(20);
		$returnData['moenyValue']  = OrderModel::where($getwhere)->sum('order_total');
		$returnData['orderCount']  = OrderModel::where($getwhere)->count('oid');

		return $returnData;
	}

	

	//数据列表
	public static function dataList($where)
	{
		// $where['order_types'] = 1;
		$orderList =  OrderModel::order('oid desc')
							->join("my_user",'my_order.user_id = my_user.uid')
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->where($where)
							->paginate(20);

		foreach ($orderList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['goodsList'] = model('OrderGoodsModel')->getOrderGoodsList($value['oid']);
			// $dataList[$key]['addressInfo'] = model('UserAddressModel')->get($value['order_address_id']);
		}

		return $orderList;
	}




	//单个人的数据列表
	public static function youDataList($id)
	{
		return OrderModel::order('oid desc')
							->where('user_id',$id)
							->join("my_user",'my_order.user_id = my_user.uid')
							->join("my_goods",'my_order.goods_id = my_goods.gid')
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->paginate(20);
	}

	//未发货订单
	public static function orderOne()
	{
		$where['order_types'] = 1;
		$where['order_status'] = 1;
		$orderList =  OrderModel::order('oid desc')
							->join("my_user",'my_order.user_id = my_user.uid')
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->where($where)
							->paginate(20);

		foreach ($orderList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['goodsList'] = model('OrderGoodsModel')->getOrderGoodsList($value['oid']);
		}

		return $orderList;
	}

	//已发货订单
	public static function orderTwo()
	{
		$where['order_types'] = 1;
		$where['order_status'] = 2;
		$orderList =  OrderModel::order('oid desc')
							->join("my_user",'my_order.user_id = my_user.uid')
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->where($where)
							->paginate(20);

		foreach ($orderList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['goodsList'] = model('OrderGoodsModel')->getOrderGoodsList($value['oid']);
		}

		return $orderList;
	}

	//已完成订单
	public static function orderThree()
	{
		$where['order_types'] = 1;
		$where['order_status'] = 3;
		$orderList =  OrderModel::order('oid desc')
							->join("my_user",'my_order.user_id = my_user.uid')
							->join("my_order_status",'my_order.order_status = my_order_status.sid')
							->where($where)
							->paginate(20);

		foreach ($orderList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['goodsList'] = model('OrderGoodsModel')->getOrderGoodsList($value['oid']);
		}

		return $orderList;
	}






	//修改订单状态
	public static function updateDataStatus($data)
	{
		$data['order_status'] = 4;
		
		$updateDatas = OrderModel::where('oid',$data['oid'])->update($data);
		if($updateDatas){
			
			return ['status'=>1,'msg'=>'订单完成'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
	}

	
}