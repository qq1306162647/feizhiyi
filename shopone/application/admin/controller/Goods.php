<?php
namespace app\admin\controller;
use app\common\model\GoodsModel;
use think\facade\Request;
class Goods extends Base
{
	public function dataList()
	{
		$viewData['dataList'] = GoodsModel::dataList();
		$this->assign('viewData',$viewData); 
		return $this->view->fetch();
	}

	public function addData()
	{
		$viewData['statusList'] = model('GoodsStatusModel')->select();
		$viewData['cateList'] = model('GoodsCategoryModel')->dataList();
		$viewData['plateList'] = model('PlateModel')->dataList();
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
				'goods_name|商品名称'=>[
					'require'=>'require',
				],
				'goods_new_price|商品实际价格'=>[
					'require'=>'require',
				],
				'goods_old_price|商品原价'=>[
					'require'=>'require',
				],
				'goods_seqencing|显示顺序'=>[
					'require'=>'require',
				],
				'goods_category|商品类别'=>[
					'require'=>'require',
				],

			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			if($file){
				$fileMkdir = 'uploads/goods/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(200, 200)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['goods_picture'] = $info->getSaveName();
				}else{
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}else{
				return ['status'=>2,'msg'=>'请上传商品图片'];
			}
			$cateOne = model('GoodsCategoryModel')->where('cid',$data['goods_category'])->find();
			$cateTwo = model('GoodsCategoryModel')->where('cid',$cateOne['category_path'])->find();
			$data['goods_category_path_one'] = $cateTwo['category_path'];
			$data['goods_category_path_two'] = $cateOne['category_path'];
			if(isset($data['gplate_list'])){
				$goods_plate = '';
				foreach ($data['gplate_list'] as $key => $value) {
					$goods_plate = $goods_plate.$value.'_';
				}
				$data['goods_plate'] = substr($goods_plate,0,-1);
			}
			
			return GoodsModel::insertDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

	public function setStatus()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$setStatus = GoodsModel::where('gid',$data['gid'])->setField('goods_status',$data['s']);
			if($setStatus){
				return ['status'=>1,'msg'=>'操作成功'];
			}
			return ['status'=>1,'msg'=>'操作失败，请稍后再试'];
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}


	public function setSostage()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$setStatus = GoodsModel::where('gid',$data['gid'])->setField('goods_is_postage',$data['s']);
			if($setStatus){
				return ['status'=>1,'msg'=>'操作成功'];
			}
			return ['status'=>1,'msg'=>'操作失败，请稍后再试'];
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}
	
	public function editData()
	{
		$viewData['statusList'] = model('GoodsStatusModel')->select();
		$viewData['cateList'] = model('GoodsCategoryModel')->dataList();
		$viewData['dataInfo'] = GoodsModel::dataInfo(Request::param('s'));
		$viewData['plateList'] = model('PlateModel')->dataList();
		$this->assign('viewData',$viewData);
		return $this->view->fetch();
	}

	public function updateDatas()
	{
		if(Request::isAjax()){
			$data = Request::param();
			$dataRule = [
				'goods_name|商品名称'=>[
					'require'=>'require',
				],
				'goods_new_price|售卖价'=>[
					'require'=>'require',
				],
				'goods_old_price|商品原价'=>[
					'require'=>'require',
				],
				'goods_seqencing|显示顺序'=>[
					'require'=>'require',
				],
				'goods_category|商品类别'=>[
					'require'=>'require',
				],

			];
			$dataValidate = $this->validate($data,$dataRule);

			//获取一下上传图片的信息
			$file = Request::file('picture_file');
			
			if(true !== $dataValidate){
				return ['status'=>2,'msg'=>$dataValidate];
			}
			if($file){
				$fileMkdir = 'uploads/goods/';
				$info = $file->validate([
					'size'=>10000000,
					'ext'=>'jpeg,jpg,png,gif'
				])->rule('uniqid')->move($fileMkdir);
				$image = \think\Image::open($fileMkdir.$info->getSaveName());
				$image->thumb(200, 200)->save($fileMkdir.'s_'.$info->getFilename());
				if($info){
					$data['goods_picture'] = $info->getSaveName();
				}else{
					return ['status'=>2,'msg'=>$file->getError()];
				}
			}
			$cateOne = model('GoodsCategoryModel')->where('cid',$data['goods_category'])->find();
			$cateTwo = model('GoodsCategoryModel')->where('cid',$cateOne['category_path'])->find();
			$data['goods_category_path_one'] = $cateTwo['category_path'];
			$data['goods_category_path_two'] = $cateOne['category_path'];

			if(isset($data['gplate_list'])){
				$goods_plate = '';
				foreach ($data['gplate_list'] as $key => $value) {
					$goods_plate = $goods_plate.$value.'_';
				}
				$data['goods_plate'] = substr($goods_plate,0,-1);
			}

			return GoodsModel::updateDatas($data);
		}
		return ['status'=>2,'msg'=>'请求类型错误'];
	}

}