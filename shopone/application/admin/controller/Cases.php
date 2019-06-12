<?php
namespace app\admin\controller;
use app\common\model\CasesModel;
use think\facade\Request;
class Cases extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = CasesModel::dataList();
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
			return CasesModel::deleteDatas(Request::param('s'));
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function insertDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'case_name|案例名称'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			if($file){
				$fileMkdir = 'uploads/case/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(720, 150)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['case_picture'] = $info->getSaveName();
				}else{
					$this->error($file->getError());
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}else{
				return ['status'=>2,'msg'=>'请上传案例图片'];
			}
			return CasesModel::insertDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function editData()
	{
		$viewData['dataInfo'] = CasesModel::get(Request::param('s'));
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'case_name|公告标题'=>[
					'require'=>'require',
					'length'=>'1,254',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			if($file){
				$fileMkdir = 'uploads/case/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(720, 150)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['case_picture'] = $info->getSaveName();
				}else{
					$this->error($file->getError());
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}
			return CasesModel::updateDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

}