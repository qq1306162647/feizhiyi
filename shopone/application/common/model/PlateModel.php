<?php
namespace app\common\model;
use think\Model;
class PlateModel extends Model
{
	protected 	$table 				= 'my_plate';
	protected 	$pk 				= 'pid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'plate_create_time';
	protected 	$updateTime 		= 'plate_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['plate_create_time'];
	protected 	$update 			= ['plate_update_time'];
	//数据列表
	public static function dataList()
	{
		return PlateModel::order('plate_order asc,pid desc')->select();
	}
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = PlateModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}

	//数据更新
	public static function updateDatas($data)
	{
		$dataInfo = PlateModel::get($data['pid']);
		$model = new PlateModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['pid' => $data['pid']]);
		if($updateDatas){
			if(isset($data['plate_picture'])){
				$file1='uploads/plate/'.$dataInfo['plate_picture'];
				$file2='uploads/plate/s_'.$dataInfo['plate_picture'];
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
		$dataInfo = PlateModel::get($id);
		$deleteDatas = PlateModel::destroy($id);
		if($deleteDatas){
			$file1='uploads/plate/'.$dataInfo['plate_picture'];
			$file2='uploads/plate/s_'.$dataInfo['plate_picture'];
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