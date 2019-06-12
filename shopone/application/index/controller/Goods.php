<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class Goods extends Base
{

    public function index()
    {
    	
    }

    //搜索展示商品页面
    public function searchGoodsList()
    {
        $viewData['webTitle'] = '商品列表';

        $viewData['goodsOrderText'][1]    =   array('order_name'=>'goods_seqencing','order_text'=>'默认排序');
        $viewData['goodsOrderText'][2]  =   array('order_name'=>'goods_sell_number','order_text'=>'销量排序');
        $viewData['goodsOrderText'][3]    =   array('order_name'=>'goods_new_price','order_text'=>'价格排序');
        $goodsOrder = Session::has('plateGoodsOrder') ? Session::get('plateGoodsOrder') : 'goods_seqencing';
        $searchText = Session::get('searchKeywords');
        $searchWhere[] = ['goods_name','like',"%{$searchText}%"];
        $searchWhere[] = ['goods_status','=',1];
        $orderTest = $goodsOrder.' asc';
        $viewData['dataList'] = model('GoodsModel')->whereGoodsListTwo($searchWhere,$orderTest);
        $this->assign('viewData',$viewData);

        return $this->view->fetch('goods/search_goods_list');
    }

    

    //商品详情
    public function details()
    {
        $viewData['webTitle'] = '商品详情';
        $viewData['dataInfo'] = model('GoodsModel')->get(Request::param('s'));
        $viewData['cartGoodsNumber'] = model('ShoppingCartModel')->getUserCartGoodsNumber(Session::get('userInfo.uid'));

        $this->assign('viewData',$viewData);

        return $this->view->fetch('goods/goods_details');

    }

    //商品列表
    public function dataList()
    {
        $data = Request::param();
        $goodsCategory = isset($data['s']) ? $data['s'] : '';
        if($goodsCategory){
            $categoryInfoOne = model('GoodsCategoryModel')->get($data['s']);

            $goodsWhere[0] = array('goods_category','=',$categoryInfoOne['cid']);
            

            if($categoryInfoOne['category_path'] != 0){

                $categoryInfoTwo = model('GoodsCategoryModel')->get($categoryInfoOne['category_path']);
                $goodsWhere[0] = array('goods_category_path_two','=',$categoryInfoTwo['cid']);

                if($categoryInfoTwo['category_path'] != 0){

                    $categoryInfoThree = model('GoodsCategoryModel')->get($categoryInfoTwo['category_path']);
                    $goodsWhere[0] = array('goods_category','=',$categoryInfoOne['cid']);
                 
                }else{
                    $goodsWhere[0] = array('goods_category_path_two','=',$categoryInfoOne['cid']);
                }
            }else{
                $goodsWhere[0] = array('goods_category_path_one','=',$categoryInfoOne['cid']);
            }


        }else{
            $categoryInfoOne = model('GoodsCategoryModel')->order('category_sequence asc,cid asc')->find();
            $goodsWhere[0] = array('goods_category','=',$categoryInfoOne['cid']);
        }

        
        // $goodsWhere[] = array('goods_category','=',19);

        // dump($goodsWhere);
        $viewData['categoryInfo'] = $categoryInfoOne;
        $goodsOrder = Session::has('plateGoodsOrder') ? Session::get('plateGoodsOrder') : 'goods_seqencing';

        $viewData['goodsOrderText'][1]      =   array('order_name'=>'goods_seqencing','order_text'=>'默认排序');
        $viewData['goodsOrderText'][2]      =   array('order_name'=>'goods_sell_number','order_text'=>'销量排序');
        $viewData['goodsOrderText'][3]      =   array('order_name'=>'goods_new_price','order_text'=>'价格排序');


        $viewData['webTitle'] = $viewData['categoryInfo']['category_name'];
        $viewData['dataList'] = model('GoodsModel')->where($goodsWhere)->order("{$goodsOrder} asc,gid asc")->limit(20)->select();
        // echo model('GoodsModel')->getLastSql();
        // $viewData['webTitle'] = '商品列表';
        // $viewData['dataList'] = model('GoodsModel')->select(); 
        $this->assign('viewData',$viewData);
        return $this->view->fetch('goods/goods_list');
    }

    //某个板块的数据列表
    public function plateGoods()
    {
        $data = Request::param();
        if($data){
            $viewData['dataInfo'] = model('PlateModel')->where('pid',$data['s'])->find();
        }else{
            $viewData['dataInfo'] = model('PlateModel')->order('pid asc')->find();
        }
        $goodsOrder = Session::has('plateGoodsOrder') ? Session::get('plateGoodsOrder') : 'goods_seqencing';


        $viewData['goodsOrderText'][1]    =   array('order_name'=>'goods_seqencing','order_text'=>'默认排序');
        $viewData['goodsOrderText'][2]  =   array('order_name'=>'goods_sell_number','order_text'=>'销量排序');
        $viewData['goodsOrderText'][3]    =   array('order_name'=>'goods_new_price','order_text'=>'价格排序');


        $viewData['webTitle'] = $viewData['dataInfo']['plate_name'];

        $searchWhere[] = ['goods_plate','like',"%{$viewData['dataInfo']['pid']}%"];
        $searchWhere[] = ['goods_status','=',1];
        $viewData['dataList'] = model('GoodsModel')->where($searchWhere)->order("{$goodsOrder} asc,gid asc")->limit(20)->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch('goods/plate_goods');
    }


    //修改排序条件
    public function setOrderWhere()
    {
        if(Request::isAjax()){
            $data = Request::param();
            Session::set('plateGoodsOrder',$data['s']);
            if(Session::has('plateGoodsOrder')){
                return ['status'=>1,'msg'=>'Success'];
            }
            return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

}
