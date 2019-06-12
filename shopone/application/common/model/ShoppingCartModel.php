<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class ShoppingCartModel extends Model
{
	protected 	$table = 'my_shopping_cart';
	protected 	$pk = 'sid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'shopping_create_time';
	protected 	$updateTime 		= 'shopping_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['shopping_create_time'];
	protected 	$update 			= ['shopping_update_time'];


   

  
	//数据详情
	public static function dataInfo($id)
	{
		$dataInfo['goodsInfo'] = ShoppingCartModel::get($id);
		$dataInfo['plateInfo'] = array_flip(explode('_', $dataInfo['goodsInfo']['goods_plate']));
		return $dataInfo;
	}
	
	//新增数据
	public static function insertDatas($data)
	{
		$goods = new ShoppingCartModel;
		// 过滤post数组中的非数据表字段数据
		$insertDatas = $goods->allowField(true)->save($data);
		// $insertDatas = ShoppingCartModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}



	//获取用户购物车列表
	public static function getUserCartList($uid)
	{
		$dataList = ShoppingCartModel::where('user_id',$uid)
								->order('shopping_create_time desc')
								->join('my_goods','my_shopping_cart.goods_id = my_goods.gid')
								->select();
		return $dataList;
		
	}


	//结算中心的购物车
	public static function settleCenterShoppingCart($uid)
	{
		$where['user_id'] = $uid;
		$where['selected_status'] = 1;
		$returnData['dataList'] = ShoppingCartModel::where($where)
								->order('shopping_create_time desc')
								->join('my_goods','my_shopping_cart.goods_id = my_goods.gid')
								->select();
		$returnData['goodsTotal'] = ShoppingCartModel::where($where)->sum('shopping_goods_total_price');

		return $returnData;


	}

	//计算购物中选中商品的总价
	public static function shoppingCartSelectedTotal($uid)
	{
		$where['user_id'] = $uid;
		$where['selected_status'] = 1;
		return  ShoppingCartModel::where($where)->sum('shopping_goods_total_price');
	}

	//计算购物中选中商品的总数量
	public static function shoppingCartGoodsNumber($uid)
	{
		$where['user_id'] = $uid;
		$where['selected_status'] = 1;
		return  ShoppingCartModel::where($where)->sum('shopping_goods_number');
	}

	//提交订单的购物车
	public static function getOrderShoppingCart($uid)
	{
		$where['user_id'] = $uid;
		$where['selected_status'] = 1;
		$dataList = ShoppingCartModel::where($where)
								->order('shopping_create_time desc')
								->join('my_goods','my_shopping_cart.goods_id = my_goods.gid')
								->select();

		return $dataList;


	}

	//获取用户购物车列表数量
	public static function getUserCartGoodsNumber($uid)
	{
		$data = ShoppingCartModel::where('user_id',$uid)->sum('shopping_goods_number');
		return $data;
		
	}

	//数据更新
	public static function updateDatas($data)
	{
		$model = new ShoppingCartModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['sid' => $data['sid']]);
		if($updateDatas){
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}

	//删除数据
	public static function deleteDatas($id)
	{
		$deleteDatas = ShoppingCartModel::destroy($id);
		if($deleteDatas){
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];

	}
}