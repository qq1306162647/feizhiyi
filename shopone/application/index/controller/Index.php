<?php
namespace app\index\controller;
use think\facade\Session;
use app\common\model\GoodsModel;
use think\facade\Request;

class Index extends Base
{

    public function index()
    {
    	$viewData['webTitle'] = '首页';
        $viewData['bannerList'] = model('BannerModel')->dataList();  //轮播图
        $where['goods_status'] = 1;
        $viewData['cateList'] = model('GoodsCategoryModel')->where('category_path',0)->order('category_sequence asc,cid desc')->select(); //类别
        $viewData['goodsListOne'] = model('GoodsModel')->where('goods_plate','like',"%4%")->where($where)->order('goods_seqencing asc,gid desc')->limit(3)->select(); //商品优选
        $viewData['goodsListTwo'] = model('GoodsModel')->where('goods_plate','like',"%5%")->where($where)->order('goods_seqencing asc,gid desc')->limit(10)->select(); //商品推荐
        $viewData['noticeInfo'] = model('NoticeModel')->order('notice_order asc,nid desc')->find(); //公告1个
       	$this->assign('viewData',$viewData);
       	return $this->view->fetch();
    }

    public function tests()
    {
        $dataList = model('OrderModel')->select();
        foreach ($dataList as $key => $value) {
            $addressInfo = model('UserAddressModel')->get($value['order_address_id']);
            $setData['order_address_phone'] = $addressInfo['address_phone'];
            $setData['order_address_name'] = $addressInfo['address_name'];
            $setData['order_address_text'] = $addressInfo['address_text'];
            model('OrderModel')->where('oid',$value['oid'])->update($setData);

        }

        echo 123;
    }

   

}
