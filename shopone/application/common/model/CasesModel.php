<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class CasesModel extends Model
{
	protected 	$table = 'my_cases';
	protected 	$pk = 'cid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'create_time';
	protected 	$updateTime 		= 'update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['create_time'];
	protected 	$update 			= ['update_time'];

	//数据详情
	public static function dataInfo($id)
	{
		return CasesModel::get($id);
		
	}
	
	//新增数据
	public static function insertDatas($data)
	{
		$insertDatas = CasesModel::create($data);
		if($insertDatas){
			return ['status'=>1,'msg'=>'添加成功'];
		}

		return ['status'=>2,'msg'=>'添加失败，请稍后再试'];
	}



	//数据列表
	public static function dataList()
	{
		return CasesModel::order('case_seqencing asc,cid desc')->paginate(10);
	}

	public static function allDataList()
	{
		return CasesModel::order('case_seqencing asc,cid desc')->select();
	}

	//数据更新
	public static function updateDatas($data)
	{
		$dataInfo = CasesModel::get($data['cid']);
		$model = new CasesModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['cid' => $data['cid']]);
		// $updateDatas = CasesModel::where('cid',$data['cid'])->update($data);
		if($updateDatas){
			if(isset($data['case_picture'])){
				$file1='uploads/case/'.$dataInfo['case_picture'];
				$file2='uploads/case/s_'.$dataInfo['case_picture'];
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
		$dataInfo = CasesModel::get($id);
		$deleteDatas = CasesModel::destroy($id);
		if($deleteDatas){
			if(isset($dataInfo['case_picture'])){
				$file1='uploads/case/'.$dataInfo['case_picture'];
				$file2='uploads/case/s_'.$dataInfo['case_picture'];
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