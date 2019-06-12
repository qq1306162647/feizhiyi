<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class ShoppingCart extends Base
{

    
    public function index()
    {
        $viewData['webTitle'] = '购物车';
        $viewData['dataList'] = model('ShoppingCartModel')->getUserCartList(Session::get('userInfo.uid'));

        //计算购物车总价

        $priceWhere['user_id'] = Session::get('userInfo.uid');
        $priceWhere['selected_status'] = 1;
        $viewData['shoppingSumPrice'] = model('ShoppingCartModel')->where($priceWhere)->sum('shopping_goods_total_price');
        $this->assign('viewData',$viewData);
        return $this->view->fetch('shopping_cart/shopping_cart_index');
    }

    //加数量
    public function plusNumber()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $shoppingInfo = model('ShoppingCartModel')->get($data['s']);
            $goodsInfo = model('GoodsModel')->get($shoppingInfo['goods_id']);
            $setData['shopping_goods_number'] =  $shoppingInfo['shopping_goods_number'] + 1;
            $setData['shopping_goods_total_price'] =  $setData['shopping_goods_number'] * $goodsInfo['goods_new_price'];

            $setData['selected_status'] = 1;

            $plusNumber = model('ShoppingCartModel')->where('sid',$data['s'])->update($setData);
            if($plusNumber){
                $priceWhere['user_id'] = Session::get('userInfo.uid');
                $priceWhere['selected_status'] = 1;
                $shoppingTotalPrice = model('ShoppingCartModel')->where($priceWhere)->sum('shopping_goods_total_price');
                return ['status'=>1,'msg'=>'Success','shoppingTotalPrice'=>$shoppingTotalPrice,'newNumber'=>$setData['shopping_goods_number']];
            }
            return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //减数量
    public function reduceNumber()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $shoppingInfo = model('ShoppingCartModel')->get($data['s']);

            if($shoppingInfo['shopping_goods_number'] == 1){
                $delData = model('ShoppingCartModel')->destroy($data['s']);
                if($delData){
                    $priceWhere['user_id'] = Session::get('userInfo.uid');
                    $priceWhere['selected_status'] = 1;
                    $shoppingTotalPrice = model('ShoppingCartModel')->where($priceWhere)->sum('shopping_goods_total_price');
                    return ['status'=>1,'msg'=>'Success','delStatus'=>1,'shoppingTotalPrice'=>$shoppingTotalPrice];
                }
                return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
            }

            $goodsInfo = model('GoodsModel')->get($shoppingInfo['goods_id']);
            $setData['shopping_goods_number'] =  $shoppingInfo['shopping_goods_number'] - 1;
            $setData['shopping_goods_total_price'] =  $setData['shopping_goods_number'] * $goodsInfo['goods_new_price'];

            $setData['selected_status'] = 1;

            $plusNumber = model('ShoppingCartModel')->where('sid',$data['s'])->update($setData);
            if($plusNumber){
                $priceWhere['user_id'] = Session::get('userInfo.uid');
                $priceWhere['selected_status'] = 1;
                $shoppingTotalPrice = model('ShoppingCartModel')->where($priceWhere)->sum('shopping_goods_total_price');
                return ['status'=>1,'msg'=>'Success','shoppingTotalPrice'=>$shoppingTotalPrice,'newNumber'=>$setData['shopping_goods_number'],'delStatus'=>0];
            }
            return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //修改选择状态
    public function setSelectStatus()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $shoppingInfo = model('ShoppingCartModel')->get($data['s']);

            if($shoppingInfo['selected_status'] == 1){
                $setValue = 2;
            }else{
                $setValue = 1;
            }
            $setSelectStatus = model('ShoppingCartModel')->where('sid',$data['s'])->setField('selected_status',$setValue);
            if($setSelectStatus){
                $priceWhere['user_id'] = Session::get('userInfo.uid');
                $priceWhere['selected_status'] = 1;
                $shoppingTotalPrice = model('ShoppingCartModel')->where($priceWhere)->sum('shopping_goods_total_price');
                return ['status'=>1,'msg'=>'Success','shoppingTotalPrice'=>$shoppingTotalPrice];
            }

            return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    // 加入购物车操作
    public function joinCart()
    {
    	if(Request::isAjax()){
    		$data = Request::param();
    		$goodsInfo = model('GoodsModel')->get($data['goods_id']);
    		$where['user_id'] = Session::get('userInfo.uid');
    		$where['goods_id'] = $data['goods_id'];
    		$cartInfo = model('ShoppingCartModel')->where($where)->find();
    		if($cartInfo){
    			$setData['shopping_goods_number'] = $cartInfo['shopping_goods_number']+1;
    			$setData['shopping_goods_total_price'] = $setData['shopping_goods_number'] * $goodsInfo['goods_new_price'];
    			$setDataAction = model('ShoppingCartModel')->where($where)->update($setData);

    			if($setDataAction){
    				$cartGoodsNumber = model('ShoppingCartModel')->where('user_id',Session::get('userInfo.uid'))->sum('shopping_goods_number');
    				return ['status'=>1,'msg'=>'成功加入购物车','cartGoodsNumber'=>$cartGoodsNumber];
    			}

    			return ['status'=>2,'msg'=>'加入购物车失败，请稍后再试'];
    		}

    		

    		$insertData['goods_id'] = $data['goods_id'];
    		$insertData['user_id'] = Session::get('userInfo.uid');
    		$insertData['shopping_goods_number'] = 1;
    		$insertData['shopping_goods_total_price'] = $goodsInfo['goods_new_price'];

    		$insertDataAction = model('ShoppingCartModel')->create($insertData);
    		if($insertDataAction){
    			$cartGoodsNumber = model('ShoppingCartModel')->where('user_id',Session::get('userInfo.uid'))->sum('shopping_goods_number');
    			return ['status'=>1,'msg'=>'成功加入购物车','cartGoodsNumber'=>$cartGoodsNumber];
			}

    		return ['status'=>2,'msg'=>'加入购物车失败，请稍后再试'];


    	}

    	return ['status'=>2,'msg'=>'请求类型错误'];
    }
}
