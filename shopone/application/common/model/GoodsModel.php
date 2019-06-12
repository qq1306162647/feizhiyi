<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class GoodsModel extends Model
{
	protected 	$table = 'my_goods';
	protected 	$pk = 'gid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'goods_create_time';
	protected 	$updateTime 		= 'goods_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['goods_create_time'];
	protected 	$update 			= ['goods_update_time'];


   

  
	//数据详情
	public static function dataInfo($id)
	{
		$dataInfo['goodsInfo'] = GoodsModel::get($id);
		$dataInfo['plateInfo'] = array_flip(explode('_', $dataInfo['goodsInfo']['goods_plate']));
		return $dataInfo;
	}

	//带条件的商品列表
	public static function whereGoodsList($where,$orders)
	{
		$where['goods_status'] = 1;
		$dataList = GoodsModel::order($orders)->where($where)->paginate(10);
		// return GoodsModel::getLastSql();
		return $dataList;
	}

	//带条件的商品列表2
	public static function whereGoodsListTwo($where,$orders)
	{
		// $where['goods_status'] = 1;
		$dataList = GoodsModel::order($orders)->where($where)->select();
		// return GoodsModel::getLastSql();
		return $dataList;
	}
	
	//新增数据
	public static function insertDatas($data)
	{
		$goods = new GoodsModel;
		// 过滤post数组中的非数据表字段数据
		$insertDatas = $goods->allowField(true)->save($data);
		// $insertDatas = GoodsModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}



	//数据列表
	public static function dataList()
	{
		$dataList = GoodsModel::order('goods_seqencing asc,gid desc')
								->join('my_goods_category','my_goods.goods_category = my_goods_category.cid')
								->paginate(10);
		return $dataList;
		
	}

	//数据更新
	public static function updateDatas($data)
	{
		$dataInfo = GoodsModel::get($data['gid']);
		$model = new GoodsModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['gid' => $data['gid']]);
		if($updateDatas){
			if(isset($data['goods_picture'])){
				$file1='uploads/goods/'.$dataInfo['goods_picture'];
				$file2='uploads/goods/s_'.$dataInfo['goods_picture'];
				if(is_file($file1)){
					unlink($file1);
				}
				if(is_file($file2)){
					unlink($file2);
				}
				
			}
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}

	//删除数据
	public static function deleteDatas($id)
	{
		$dataInfo = GoodsModel::get($id);
		$deleteDatas = GoodsModel::destroy($id);
		if($deleteDatas){
			if(isset($dataInfo['goods_picture'])){
				$file1='uploads/goods/'.$dataInfo['goods_picture'];
				$file2='uploads/goods/s_'.$dataInfo['goods_picture'];
				if(is_file($file1)){
					unlink($file1);
				}
				if(is_file($file2)){
					unlink($file2);
				}
				
			}
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];

	}
}