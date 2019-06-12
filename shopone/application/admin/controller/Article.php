<?php
namespace app\admin\controller;
use app\common\model\ArticleModel;
use think\facade\Request;
class Article extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = ArticleModel::dataList();
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
			return ArticleModel::deleteDatas(Request::param('s'));
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function insertDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'article_title|标题'=>[
					'require'=>'require',
					'length'=>'1,200',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			if($file){
				$fileMkdir = 'uploads/article/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(720, 150)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['article_picture'] = $info->getSaveName();
				}else{
					$this->error($file->getError());
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}else{
				return ['status'=>2,'msg'=>'请上传案例图片'];
			}
			return ArticleModel::insertDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function editData()
	{
		$viewData['dataInfo'] = ArticleModel::get(Request::param('s'));
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'article_title|案例名称'=>[
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
				$fileMkdir = 'uploads/article/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(720, 150)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['article_picture'] = $info->getSaveName();
				}else{
					$this->error($file->getError());
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}
			return ArticleModel::updateDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

}