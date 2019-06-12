<?php
namespace app\admin\controller;
use think\facade\Request;
class GoodsCategory extends Base
{
	public function dataList()
	{
		$dataList = model('GoodsCategoryModel')->where("category_path",0)->order('category_sequence asc,cid desc')->select();
		foreach ($dataList as $key => $value) {
			$viewData['dataList'][$key] = $value;
			$viewData['dataList'][$key]['twoList'] = model('GoodsCategoryModel')->where("category_path",$value['cid'])->order('category_sequence asc,cid desc')->select();
			foreach ($viewData['dataList'][$key]['twoList'] as $keys => $values) {
				$viewData['dataList'][$key]['twoList'][$keys]['threeList'] = model('GoodsCategoryModel')->where("category_path",$values['cid'])->order('category_sequence asc,cid desc')->select();
			}
		}
		// dump($viewData);
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function addData()
	{
		$dataList = model('GoodsCategoryModel')->where("category_path",0)->order('category_sequence asc,cid desc')->select();
		foreach ($dataList as $key => $value) {
			$viewData['dataList'][$key] = $value;
			$viewData['dataList'][$key]['twoList'] = model('GoodsCategoryModel')->where("category_path",$value['cid'])->order('category_sequence asc,cid desc')->select();
			foreach ($viewData['dataList'][$key]['twoList'] as $keys => $values) {
				$viewData['dataList'][$key]['threeList'] = model('GoodsCategoryModel')->where("category_path",$values['cid'])->order('category_sequence asc,cid desc')->select();
			}
		}
		$this->assign('viewData',$viewData);
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
				'category_name|分类名称'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
				'category_sequence|排序值'=>[
					'require'=>'require',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			if($file){
				$fileMkdir = 'uploads/goods_category/';
				$info = $file->validate(['size'=>10000000,'ext'=>'jpeg,jpg,png,gif'])->rule('uniqid')->move($fileMkdir);
				// $image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(200, 200)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['category_picture'] = $info->getSaveName();
				}else{
					// $this->error($file->getError());
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}

			
			$insertDatas = model('GoodsCategoryModel')->create($data);
			if($insertDatas){
				return ['status'=>1,'msg'=>'添加成功'];
			}
			return ['status'=>2,'msg'=>'添加失败请稍后再试'];
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function editData()
	{
		$dataList = model('GoodsCategoryModel')->where("category_path",0)->order('category_sequence asc,cid desc')->select();
		foreach ($dataList as $key => $value) {
			$viewData['dataList'][$key] = $value;
			$viewData['dataList'][$key]['twoList'] = model('GoodsCategoryModel')->where("category_path",$value['cid'])->order('category_sequence asc,cid desc')->select();
		}
		// dump($viewData['dataList']);
		$viewData['dataInfo'] = model('GoodsCategoryModel')->where("cid",Request::param('s'))->find();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'category_name|分类名称'=>[
					'require'=>'require',
					'length'=>'1,20',
				],
				'category_sequence|排序值'=>[
					'require'=>'require',
				],
			];
			$dataValidate = $this->validate($data,$dataRule);
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			if($file){
				$fileMkdir = 'uploads/goods_category/';
				$info = $file->validate(['size'=>10000000,'ext'=>'jpeg,jpg,png,gif'])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(200, 200)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['category_picture'] = $info->getSaveName();
				}else{
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}
			$dataInfo = model('GoodsCategoryModel')->where('cid',$data['cid'])->find();
			$updateDatas = model('GoodsCategoryModel')->where('cid',$data['cid'])->update($data);
			if($updateDatas){
				if(isset($data['category_picture'])){
					$file1='uploads/goods_category/'.$dataInfo['category_picture'];
					$file2='uploads/goods_category/s_'.$dataInfo['category_picture'];
					if(is_file($file1)){
						unlink($file1);
					}
					if(is_file($file2)){
						unlink($file2);
					}
					
				}
				return ['status'=>1,'msg'=>'修改成功'];
			}
			return ['status'=>2,'msg'=>'修改失败请稍后再试'];
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

}