<?php
namespace app\common\model;
use think\Model;
class BannerModel extends Model
{
	protected 	$table 				= 'my_banner';
	protected 	$pk 				= 'bid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'banner_create_time';
	protected 	$updateTime 		= 'banner_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['banner_create_time'];
	protected 	$update 			= ['banner_update_time'];
	//数据列表
	public static function dataList()
	{
		return BannerModel::order('banner_sequence asc,bid desc')->select();
	}
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = BannerModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}

	//数据更新
	public static function updateDatas($data)
	{
		$dataInfo = BannerModel::get($data['bid']);
		$model = new BannerModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['bid' => $data['bid']]);
		if($updateDatas){
			if(isset($data['banner_picture'])){
				$file1='uploads/banner/'.$dataInfo['banner_picture'];
				$file2='uploads/banner/s_'.$dataInfo['banner_picture'];
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
		$dataInfo = BannerModel::get($id);
		$deleteDatas = BannerModel::destroy($id);
		if($deleteDatas){
			$file1='uploads/banner/'.$dataInfo['banner_picture'];
			$file2='uploads/banner/s_'.$dataInfo['banner_picture'];
			if(is_file($file1)){
				unlink($file1);
			}
			if(is_file($file2)){
				unlink($file2);
			}
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];

	}
}