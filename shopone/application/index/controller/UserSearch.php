<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
class UserSearch extends Base
{
    public function index()
    {
        $viewData['webTitle'] = '商品搜索';
        $viewData['dataList'] = model('UserSearchModel')->userDataList(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch('user_search/search_index');
    }

    //清除记录
    public function delUserLog()
    {
        if(Request::isAjax()){
            // $data = Request::param();
            // $data['user_id'] = Session::get('userInfo.uid');
            return model('UserSearchModel')->delAllData(Session::get('userInfo.uid'));
        }  
        return ['status'=>2,'msg'=>'请求类型错误'];
    }
    
    //提交搜索关键词
    public function setSearchValue()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $data['user_id'] = Session::get('userInfo.uid');
            $dataRule = [
                'search_name|搜索关键词'=>[
                    'require'=>'require',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            // Session::set('');
            model('UserSearchModel')->insertDatas($data);
            return $this->updateSearchKeywords($data['search_name']);
        }  
        return ['status'=>2,'msg'=>'请求类型错误，请稍后再试'];
    } 
    
    //给关键词赋值
    public function updateSearchKeywords($values)
    {
        Session::set('searchKeywords',$values);
        if(Session::has('searchKeywords')){
            return ['status'=>1,'msg'=>'Success','keywords'=>$values];
        }
        return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
    }

    //点击记录给关键词赋值
    public function updateSessionSearchKeywords()
    {
        if(Request::isAjax()){
            $data = Request::param();
            Session::set('searchKeywords',$data['s']);
            if(Session::has('searchKeywords')){
                return ['status'=>1,'msg'=>'Success','keywords'=>$data['s']];
            }
            return ['status'=>2,'msg'=>'操作失败，请稍后再试'];
        }


        return ['status'=>1,'msg'=>'请求类型错误，请稍后再试'];
        
    }

}
