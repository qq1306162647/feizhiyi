<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class Order extends Base
{
  
    public function index()
    {
        
    	$viewData['webTitle'] = '我的订单';
        $data = Request::param();
        $data['s']  = isset($data['s']) ? $data['s'] : 0 ;
        $viewData['thisStatus'] = $data['s'];
        $viewData['statusList'] = model('OrderStatusModel')->order('sid asc')->select();
        $where['user_id'] = Session::get('userInfo.uid');
        $where['order_cancel_status'] = 1;
        if($data['s'] == 0){

            $viewData['dataList'] = model('OrderModel')->userDataList($where);
        }else{
            $where['order_status'] = $data['s'];
            $viewData['dataList'] = model('OrderModel')->userDataList($where);
        }
        $this->assign('viewData',$viewData);
       	return $this->view->fetch('order/order_index');
    }

    // 已失效的订单列表
    public function invalidList()
    {
        
        $viewData['webTitle'] = '已失效的订单';
        $where['user_id'] = Session::get('userInfo.uid');
        $where['order_cancel_status'] = 2;
        $viewData['dataList'] = model('OrderModel')->userDataList($where);
        $this->assign('viewData',$viewData);
        return $this->view->fetch('order/invalid_list');
    }



    //结算中心
    public function settleCenter()
    {
        $viewData['webTitle'] = '结算中心';
        $viewData['addressInfo'] = model('UserAddressModel')->where('user_id',Session::get('userInfo.uid'))->order('selected_status desc,aid desc')->find();
        $viewData['goodsInfo'] =  model('ShoppingCartModel')->settleCenterShoppingCart(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }

    //提交订单
    public function getOrderData()
    {
        if(Request::isAjax()){
            $data  = Request::param();
            $dataList = model('ShoppingCartModel')->getOrderShoppingCart(Session::get('userInfo.uid'));
            // $dataList = count($dataList);
            // return $dataList;
            if(count($dataList) > 0){
                
                $data['order_number'] = 'SHOP'.time().rand(1000,9999);
                $data['user_id']  = Session::get('userInfo.uid');
                $data['order_total_price'] = model('ShoppingCartModel')->shoppingCartSelectedTotal($data['user_id']);
                $data['order_goods_total'] = model('ShoppingCartModel')->shoppingCartGoodsNumber($data['user_id']);
                $addressInfo = model('UserAddressModel')->get($data['order_address_id']);
                $data['order_address_phone'] = $addressInfo['address_phone'];
                $data['order_address_name'] = $addressInfo['address_name'];
                $data['order_address_text'] = $addressInfo['address_text'];
                // model('OrderModel')->where('oid',$value['oid'])->update($setData);
                $insertOrder = model('OrderModel')->insertDatas($data);

                if($insertOrder['status'] == 1){
                    $insertGoodsData['order_id'] = $insertOrder['oid'];

                    foreach ($dataList as $key => $value) {
                       $insertGoodsData['goods_id'] = $value['goods_id'];
                       $insertGoodsData['order_goods_number'] = $value['shopping_goods_number'];
                       $insertGoodsData['order_goods_unit_price'] = $value['goods_new_price'];
                       $insertGoodsData['order_goods_total_price'] = $value['shopping_goods_total_price'];
                       $insetOrderGoods = model('OrderGoodsModel')->insertDatas($insertGoodsData);
                       if($insetOrderGoods['status'] == 1){
                            model('ShoppingCartModel')->destroy($value['sid']);
                       }
                    }

                    return ['status'=>1,'msg'=>'订单提交成功请支付','oid'=>$insertOrder['oid']];   
                }
                
            }else{
                return ['status'=>2,'msg'=>'您的购物车空空如也'];   
            }
            
            


        }   

        return ['status'=>2,'msg'=>'请求类型错误'];  
    }


    public static function orderPay()
    {

        
        if(Request::isAjax()){
            // if()
            $data = Request::param();
            $orderInfo = model('OrderModel')->get($data['oid']);
            $userInfo = model('UserModel')->get(Session::get('userInfo.uid'));
            if($userInfo['user_money'] < $orderInfo['order_total_price']){
                return ['status'=>3,'msg'=>'积分不足，请先充值积分在去支付'];
            }



            $setOrderData['order_pay_time'] = time();
            $setOrderData['order_status'] = 2;
            // $setOrderData['goods_sell_number'] = $orderInfo['goods_sell_number'] + 1;
            $setOrder = model('OrderModel')->where('oid',$orderInfo['oid'])->update($setOrderData);
            if($setOrder){
                $setUserMoney =  model('UserModel')->where('uid',$userInfo['uid'])->setDec('user_money',$orderInfo['order_total_price']);
                if($setUserMoney){
                    $logData['action_money_value'] = $orderInfo['order_total_price'];
                    $logData['user_id'] = $userInfo['uid'];
                    $logData['log_types'] = 1;
                    $logData['order_id'] = $orderInfo['oid'];
                    $logData['audit_state'] = 2;
                    model('UserMoneyLogModel')->create($logData); 

                    $orderGoodsList = model('OrderGoodsModel')->where('order_id',$orderInfo['oid'])->select();
                    foreach ($orderGoodsList as $key => $value) {
                        model('GoodsModel')->where('gid',$value['goods_id'])->setInc('goods_sell_number',$value['order_goods_number']);
                    }
                }
                
                return ['status'=>1,'msg'=>'支付成功'];
            }

            return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
            

        }

        return ['status'=>2,'msg'=>'请求类型错误'];  
    }
    public function details()
    {
        $viewData['webTitle'] = '订单详情';
        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }


    //取消订单
    public function cancelOrder()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                's|订单编号'=>[
                    'require'=>'require',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }

            $setWhere['user_id'] = Session::get('userInfo.uid');
            $setWhere['oid']  = $data['s'];

            $setData = model('OrderModel')->where($setWhere)->setField('order_cancel_status',2);

            if($setData){
              return ['status'=>1,'msg'=>'取消成功'];    
            }

            return ['status'=>2,'msg'=>'取消失败，请稍后再试'];    

        }

        return ['status'=>2,'msg'=>'请求类型错误'];  
    }
    //修改订单状态
    public function updateDataStatus()
    {
        if(Request::isAjax()){
            $data = Request::param();
            return model('OrderModel')->updateDataStatus($data);
        }
        return ['status'=>2,'mgs'=>'请求类型错误'];
    }
    //删除订单
    public function deleteOrder()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                's|订单编号'=>[
                    'require'=>'require',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }

            $setWhere['user_id'] = Session::get('userInfo.uid');
            $setWhere['oid']  = $data['s'];

            $setData = model('OrderModel')->where($setWhere)->delete();

            if($setData){
                model('OrderGoodsModel')->where('order_id',$data['s'])->delete();
                return ['status'=>1,'msg'=>'删除成功'];    
            }

            return ['status'=>2,'msg'=>'删除失败，请稍后再试'];    

        }

        return ['status'=>2,'msg'=>'请求类型错误'];  
    }

}
