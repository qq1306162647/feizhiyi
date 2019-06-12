<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class MessageModel extends Model
{
	protected 	$table = 'my_message';
	protected 	$pk = 'mid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'message_create_time';
	protected 	$updateTime 		= 'message_update_time';
	protected 	$dateFormat 		= 'Y/m/d H:i:s';
	protected 	$insert 			= ['message_create_time'];
	protected 	$update 			= ['message_update_time'];

	//数据详情
	public static function dataInfo($id)
	{
		return MessageModel::get($id);
		
	}
	
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = MessageModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}



	//数据列表
	public static function dataList()
	{
		return MessageModel::order('article_seqencing asc,aid desc')->paginate(10);
	}

	//用户的数据列表
	public static function userDataList($id)
	{
		return MessageModel::where('message_user_id',$id)->order('mid desc')->select();
	}

}