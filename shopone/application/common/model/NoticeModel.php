<?php
namespace app\common\model;
use think\Model;
class NoticeModel extends Model
{
	protected 	$table 				= 'my_notice';
	protected 	$pk 				= 'nid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'notice_create_time';
	protected 	$updateTime 		= 'notice_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['notice_create_time'];
	protected 	$update 			= ['notice_update_time'];
	//数据列表
	public static function dataList()
	{
		return NoticeModel::order('notice_order asc,nid desc')->paginate(10);
	}
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = NoticeModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}

	//数据更新
	public static function updateDatas($data)
	{
		$model = new NoticeModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['nid' => $data['nid']]);
		if($updateDatas){
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}

	//删除数据
	public static function deleteDatas($id)
	{
		$deleteDatas = NoticeModel::destroy($id);
		if($deleteDatas){
			return ['status'=>1,'msg'=>'删除成功'];
		}
		return ['status'=>2,'msg'=>'删除失败，请稍后再试'];

	}
}