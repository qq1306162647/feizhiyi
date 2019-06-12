<?php
namespace app\admin\controller;
use think\facade\Request;
use app\common\model\plateModel;
/*
板块
 */
class Plate extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = plateModel::dataList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}
	public function addData()
	{
		return $this->view->fetch();
	}
	public function deleteDatas()
	{
		if(Request::isAjax()){

		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function insertDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'plate_name|板块名称'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			//获取一下上传图片的信息
			// $file = Request::file('picture_file');
			
			// if(true !== $dataValidate){
			// 	return ['status'=>2,'msg'=>$dataValidate];
			// }
			// if($file){
			// 	$fileMkdir = 'uploads/plate/';
			// 	$info = $file->validate([
			// 		'size'=>10000000,
			// 		'ext'=>'jpeg,jpg,png,gif'
			// 	])->rule('uniqid')->move($fileMkdir);
			// 	$image = \think\Image::open($fileMkdir.$info->getSaveName());
			// 	$image->thumb(720, 150)->save($fileMkdir.'s_'.$info->getFilename());
			// 	if($info){
			// 		$data['plate_picture'] = $info->getSaveName();
			// 	}else{
			// 		$this->error($file->getError());
			// 		return ['status'=>2,'msg'=>$file->getError()];
			// 	}
			// }else{
			// 	return ['status'=>2,'msg'=>'请上传商品图片'];
			// }
			return plateModel::insertDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function editData()
	{
		$viewData['dataInfo'] = plateModel::get(Request::param('s'));
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'plate_name|板块名称'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			// $file = Request::file('picture_file');
			// if(true !== $dataValidate){
			// 	return ['status'=>2,'msg'=>$dataValidate];
			// }
			// if($file){
			// 	$fileMkdir = 'uploads/plate/';
			// 	$info = $file->validate([
			// 		'size'=>10000000,
			// 		'ext'=>'jpeg,jpg,png,gif'
			// 	])->rule('uniqid')->move($fileMkdir);
			// 	$image = \think\Image::open($fileMkdir.$info->getSaveName());
			// 	$image->thumb(720, 150)->save($fileMkdir.'s_'.$info->getFilename());
			// 	if($info){
			// 		$data['plate_picture'] = $info->getSaveName();
			// 	}else{
			// 		$this->error($file->getError());
			// 		return ['status'=>2,'msg'=>$file->getError()];
			// 	}
			// }
			return plateModel::updateDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}
}