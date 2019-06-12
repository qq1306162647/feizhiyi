<?php
namespace app\index\controller;
use think\facade\Session;
use app\common\model\GoodsModel;
use think\facade\Request;
class Categorys extends Base
{

    public function index()
    {
        $viewData['webTitle'] = '分类';
        $viewData['dataListOne'] = model('GoodsCategoryModel')->where('category_path',0)->order('category_sequence asc,cid desc')->select();
        // $viewData['dataListTwo'] = model('GoodsCategoryModel')->where('category_path',0)->order('category_sequence asc,cid desc')->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch('categorys/cate_index');
    }

    public function getCateList()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $cateList = model('GoodsCategoryModel')->where('category_path',$data['s'])->order('category_sequence asc,cid desc')->select();
            $dataList = '';
            foreach ($cateList as $key => $value) {
                $dataList[$key] = $value;
                $dataList[$key]['threeList'] = model('GoodsCategoryModel')->where('category_path',$value['cid'])->order('category_sequence asc,cid desc')->select();
            }
            if($dataList){
                return ['status'=>1,'msg'=>'Success','dataList'=>$dataList];
            }

            return ['status'=>2,'msg'=>'此类别下暂无数据'];
            
        }
        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    

}
