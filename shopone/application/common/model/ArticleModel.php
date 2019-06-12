<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class ArticleModel extends Model
{
	protected 	$table = 'my_article';
	protected 	$pk = 'aid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'create_time';
	protected 	$updateTime 		= 'update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['create_time'];
	protected 	$update 			= ['update_time'];

	//数据详情
	public static function dataInfo($id)
	{
		return ArticleModel::get($id);
		
	}
	
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = ArticleModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}



	//数据列表
	public static function dataList()
	{
		return ArticleModel::order('article_seqencing asc,aid desc')->paginate(10);
	}

	public static function allDataList()
	{
		return ArticleModel::order('article_seqencing asc,aid desc')->select();
	}

	//数据更新
	public static function updateDatas($data)
	{
		$dataInfo = ArticleModel::get($data['aid']);
		$model = new ArticleModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['aid' => $data['aid']]);
		if($updateDatas){
			if(isset($data['article_picture'])){
				$file1='uploads/article/'.$dataInfo['article_picture'];
				$file2='uploads/article/s_'.$dataInfo['article_picture'];
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
		$dataInfo = ArticleModel::get($id);
		$deleteDatas = ArticleModel::destroy($id);
		if($deleteDatas){
			if(isset($dataInfo['article_picture'])){
				$file1='uploads/article/'.$dataInfo['article_picture'];
				$file2='uploads/article/s_'.$dataInfo['article_picture'];
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