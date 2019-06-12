<?php
namespace app\common\model;
use think\Model;
class GoodsCategoryModel extends Model
{
	protected 	$table = 'my_goods_category';
	protected 	$pk = 'cid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'category_create_time';
	protected 	$updateTime 		= 'category_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['category_create_time'];
	protected 	$update 			= ['category_update_time'];
	
	//数据列表
	public static function dataList()
	{
		$dataListOne = GoodsCategoryModel::where('category_path',0)->order('category_sequence asc,category_create_time desc')->select();
		$dataList = '';
		foreach ($dataListOne as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['twoList'] = GoodsCategoryModel::where('category_path',$value['cid'])->order('category_sequence asc,category_create_time desc')->select();
			foreach ($dataList[$key]['twoList'] as $keys => $values) {
				$dataList[$key]['twoList'][$keys]['threeList'] = GoodsCategoryModel::where('category_path',$values['cid'])->order('category_sequence asc,category_create_time desc')->select();
			}
		}
		return $dataList;
	}

}