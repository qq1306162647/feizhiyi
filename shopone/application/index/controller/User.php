<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
use app\common\model\UserModel;
use think\facade\Config;
class User extends Base
{
    // 设置
    public function settings()
    {
        $viewData['webTitle'] = '设置';
        $this->assign('viewData',$viewData);
        return $this->view->fetch();  
    }

    //编辑用户信息页面
    public function editUserInfo()
    {
        $viewData['webTitle'] = '个人资料';
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }

    //修改用户信息
    public function setUserInfo()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'user_name|姓名'=>[
                    'require'=>'require',
                ],
                'user_phone|电话'=>[
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
                $fileMkdir = 'uploads/user/';
                $info = $file->validate([
                    'size'=>10000000,
                    'ext'=>'jpeg,jpg,png,gif'
                ])->rule('uniqid')->move($fileMkdir);
                $image = \think\Image::open($fileMkdir.$info->getSaveName());
                $image->thumb(200, 200)->save($fileMkdir.'s_'.$info->getFilename());
                if($info){
                    $data['user_picture'] = $info->getSaveName();
                }else{
                    return ['status'=>2,'msg'=>$file->getError()];
                }
            }
            $userInfo =  model('UserModel')->where('uid',Session::get('userInfo.uid'))->find();

            $model = new UserModel;
            // 过滤post数组中的非数据表字段数据
            $setUserInfo = $model->allowField(true)->save($data,['uid' => Session::get('userInfo.uid')]);

            // $setUserInfo = model('UserModel')->where('uid',Session::get('userInfo.uid'))->update($data);
            if($setUserInfo){
                if(isset($data['user_picture'])){
                    $file1='uploads/user/'.$userInfo['user_picture'];
                    $file2='uploads/user/s_'.$userInfo['user_picture'];
                    if(is_file($file1)){
                        unlink($file1);
                    }
                    if(is_file($file2)){
                        unlink($file2);
                    }
                    
                }
                return ['status'=>1,'msg'=>'修改成功'];
            }
            return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
        }
        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //修改登录密码操作
    public function setLoginPwdAction()
    {   
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'password|密码'=>[
                    'require'=>'require',
                    'length'=>'1,200',
                ],
                'password_confirm|确认密码'=>[
                    'require'=>'require',
                    'confirm'=>'password',
                    'length'=>'1,200',
                ],
               
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            $userInfo =  model('UserModel')->get(Session::get('userInfo.uid'));

            $setData = md5($data['password']);
            if($userInfo['user_password'] == $setData){
                return ['status'=>2,'msg'=>'修改失败，新密码不能与旧密码一样'];
            }
            $setUserInfo = model('UserModel')->where('uid',Session::get('userInfo.uid'))->setField('user_password',$setData);
            if($setUserInfo){
                return ['status'=>1,'msg'=>'登录密码修改成功'];
            }
            return ['status'=>2,'msg'=>'修改失败，请稍后再试'];


        }
        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //修改支付密码操作
    public function setPaysPwdAction()
    {   
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'password|密码'=>[
                    'require'=>'require',
                    'length'=>'1,200',
                ],
                'password_confirm|确认密码'=>[
                    'require'=>'require',
                    'confirm'=>'password',
                    'length'=>'1,200',
                ],
               
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            $userInfo =  model('UserModel')->get(Session::get('userInfo.uid'));

            $setData = md5($data['password']);
            if($userInfo['pays_password'] == $setData){
                return ['status'=>2,'msg'=>'修改失败，新密码不能与旧密码一样'];
            }
            $setUserInfo = model('UserModel')->where('uid',Session::get('userInfo.uid'))->setField('pays_password',$setData);
            if($setUserInfo){
                return ['status'=>1,'msg'=>'支付密码修改成功'];
            }
            return ['status'=>2,'msg'=>'修改失败，请稍后再试'];


        }
        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //用户积分充值
    public function userRecharge()
    {
        $viewData['webTitle'] = '积分充值';
        $viewData['wechatQrcode'] = Config::get('websetup.wechat_qrcode');
        $viewData['alipayQrcode'] = Config::get('websetup.alipay_qrcode');
        $viewData['dataList'] = model('RechargeModel')->order('rid asc')->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch();  
    }

    //我的直推
    public function oneTeam()
    {
        $viewData['webTitle'] = '我的直推';
        $viewData['dataList'] = model('UserModel')->where('recommend_code',Session::get('userInfo.uid'))->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch();  
    }

    //我的团队
    public function myTeam()
    {
        $viewData['webTitle'] = '我的团队';
        // $where['']
        $viewData['dataList'] = model('UserModel')->where('recommend_code',Session::get('userInfo.uid'))->whereOr('recommend_code_two',Session::get('userInfo.uid'))->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch();  
    }
    // 设置登录密码
    public function setLoginPwd()
    {
        $viewData['webTitle'] = '设置登录密码';
        $this->assign('viewData',$viewData);
        return $this->view->fetch();  
    }

    // 设置支付密码
    public function setPayPwd()
    {
        $viewData['webTitle'] = '设置支付密码';
        $this->assign('viewData',$viewData);
        return $this->view->fetch();  
    }
    // 我的收益
    public function profit()
    {
        $viewData['webTitle'] = '我的收益';
        $viewData['dataList'] = model('CommissionModel')->userCommissionList(Session::get('userInfo.uid'));
        $totalIncomeWhere['user_id'] = Session::get('userInfo.uid');
        $totalIncomeWhere['commission_cate'] = 1;
        $viewData['totalIncome'] = model('CommissionModel')->where($totalIncomeWhere)->sum('commission_value');
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }
    // 我的钱包
    public function wallet()
    {
        $viewData['webTitle'] = '我的钱包';
        $viewData['dataList'] = model('UserMoneyLogModel')->userLog(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }


    
    //收货地址
    public function receivingAddress()
    {
        $viewData['webTitle'] = '收货地址';
        $viewData['dataList'] = model('UserAddressModel')->dataList(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 

    }

    //选择收货地址
    public function selectAddress()
    {
        $viewData['webTitle'] = '收货地址';
        $viewData['dataList'] = model('UserAddressModel')->dataList(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 

    }

    //新增收货地址
    public function addedAddress()
    {
        $viewData['webTitle'] = '添加收货地址';
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }

    //编辑收货地址
    public function editAddress()
    {
        $viewData['webTitle'] = '编辑收货地址';
        $viewData['dataInfo'] = model('UserAddressModel')->get(Request::param('s'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }

    //设置收货地址的默认状态
    public function setAddressSelectStatus()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $data['user_id'] = Session::get('userInfo.uid');
            return  model('UserAddressModel')->defauleAddress($data);


        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //修改收货地址
    public function setAddress()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'address_name|收货人'=>[
                    'require'=>'require',
                    'length'=>'1,10',
                ],
                'address_phone|电话'=>[
                    'require'=>'require',
                    'mobile'=>'mobile',
                ],
                'address_text|详细地址'=>[
                    'require'=>'require',
                    'length'=>'5,120',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            // $data['user_id'] = Session::get('userInfo.uid');
            return  model('UserAddressModel')->updateDatas($data);


        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //提交收货地址操作
    public function getAddress()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'address_name|收货人'=>[
                    'require'=>'require',
                    'length'=>'1,10',
                ],
                'address_phone|电话'=>[
                    'require'=>'require',
                    'mobile'=>'mobile',
                ],
                'address_text|详细地址'=>[
                    'require'=>'require',
                    'length'=>'5,120',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            $data['user_id'] = Session::get('userInfo.uid');
            return  model('UserAddressModel')->insertDatas($data);


        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }

    //删除收货地址操作
    public function deleteAddress()
    {
        if(Request::isAjax()){
            $data = Request::param();
            return  model('UserAddressModel')->deleteDatas($data['s']);

        }

        return ['status'=>2,'msg'=>'请求类型错误'];
    }
    

    //提现
    public function withdrawal()
    {
        $viewData['webTitle'] = '货币提现';
        $viewData['userInfo'] = model('UserModel')->where('uid',Session::get('userInfo.uid'))->find();
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }

    public function moneyLog()
    {
        $viewData['webTitle'] = '货币明细';
        $viewData['dataList'] = model('MoneyLogModel')->where('user_id',Session::get('userInfo.uid'))->order('money_create_time desc')->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }

    public function withdrawalLog()
    {
        $viewData['webTitle'] = '提现记录';
        $viewData['dataList'] = model('WithdrawalMoneyModel')->where('withdrawal_user_id',Session::get('userInfo.uid'))->order('withdrawal_create_time desc')->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch(); 
    }

    //提现操作
    public function withdrawalAction()
    {
       if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'alnumber|支付宝账号'=>[
                    'require'=>'require',
                    'length'=>'1,200',
                ],
                'action_money|提现金额'=>[
                    'require'=>'require',
                    // 'egt'=>'100',
                    // 'length'=>'1,200',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);
            
            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            // $a = $data['reward_money'];
            // if (!!($a % 10) && $a){
            //      return ['status'=>2,'msg'=>'提现金额必须是10的倍数，如：10，20，30，110，260等等...'];
            // }
    
            $userInfo = model('UserModel')->where('uid',Session::get('userInfo.uid'))->find();

            if($data['action_money'] > $userInfo['commission']){
                return ['status'=>2,'msg'=>'提现金额不得大于佣金余额！'];
            }


            $withdrawalData['withdrawal_user_id'] = $userInfo['uid'];
            $withdrawalData['alipay_number'] = $data['alnumber'];
            $withdrawalData['withdrawal_value'] = $data['action_money'];
            $withdrawalData['service_money'] = round($data['action_money'] * 0.03,2);
            $withdrawalData['payment_value'] =$data['action_money'] - $withdrawalData['service_money'];


            //新增奖励记录
            $insertReward = model('WithdrawalMoneyModel')->insertDatas($withdrawalData);
            if($insertReward['status'] == 1){
                //修改用户佣金
                model('UserModel')->where('uid',$userInfo['uid'])->setDec('commission',$withdrawalData['withdrawal_value']);
                 return ['status'=>1,'msg'=>'操作成功'];
            }
        }
        return ['status'=>2,'msg'=>'请求类型错误'];
    }


    public function index()
    {
        $viewData['webTitle'] = '个人中心';
        $viewData['userInfo'] = model('UserModel')->where('uid',Session::get('userInfo.uid'))->join('my_user_level','my_user.user_level = my_user_level.lid')->find();
        // $viewData['recommend'] = model('UserModel')->where('uid',$viewData['userInfo']['recommend_1'])->find();
        // $viewData['money_log'] = model('MoneyLogModel')->where('user_id',Session::get('userInfo.uid'))->count();
        // $viewData['dataList'] = model('OrderStatusModel')->order('sid asc')->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch('user/user_index');
        
        
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

    //粉丝
    public function fans()
    {
        $viewData['webTitle'] = '我的粉丝';

        $viewData['dataList'] = model('UserModel')->where('recommend_1',Session::get('userInfo.uid'))->select();
        $viewData['fansNumber'] = model('UserModel')->where('recommend_1',Session::get('userInfo.uid'))->count();
        $userWhere['recommend_1'] = Session::get('userInfo.uid');
        $userWhere['is_vip'] = 1;
        $viewData['userNumber'] = model('UserModel')->where($userWhere)->count();
        $userWhere['is_vip'] = 2;
        $viewData['vipNumber'] = model('UserModel')->where($userWhere)->count();

        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }

 

    public function getPhoneNumber()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                's|手机号'=>[
                    'require'=>'require',
                    'mobile'=>'mobile',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);

            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }
            Session::set('phoneNumber',$data['s']);
            $userInfo = model('UserModel')->where('user_phone',Session::get('phoneNumber'))->find();
            if($userInfo){
                Session::set('searchUserInfo',$userInfo);
                return ['status'=>1];
                
            }else{
                return ['status'=>2,'msg'=>'查找不到本手机号的用户，请核对后重新输入点击确定'];
            }
        }

        return ['status'=>2,'msg'=>'请求类型错误'];


    }




    public function setData()
    {
        $viewData['webTitle'] = '修改资料';
        $viewData['userInfo'] = model('UserModel')->where('uid',Session::get('userInfo.uid'))->find();
        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }



    public function updateUserData()
    {
        if(Request::isAjax()){
            $data = Request::param();
            $dataRule = [
                'user_name|姓名'=>[
                    'require'=>'require',
                ],
                'user_phone|手机号'=>[
                    'require'=>'require',
                    'mobile'=>'mobile',
                ],
            ];
            $dataValidate = $this->validate($data,$dataRule);

            if(true !== $dataValidate){
                return ['status'=>2,'msg'=>$dataValidate];
            }

            return UserModel::setDatas($data);
        }

        return ['status'=>2,'msg'=>'请求类型错误'];
        
    }


  

    public function myOrder()
    {
        $statusNumber = Request::param('s');
        if($statusNumber){
            Session::set('order_status_number',$statusNumber);
            $where['order_status'] = $statusNumber;
        }else{
            Session::set('order_status_number',0);
        }
        $where['user_id'] = Session::get('userInfo.uid');
        $viewData['webTitle'] = '我的订单';
        $viewData['dataList'] = model('OrderModel')->userDataList($where);
        $viewData['statusList'] = model('OrderStatusModel')->order('sid asc')->select();
        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }

    //我的奖励
    public function myReward()
    {

        $viewData['webTitle'] = '我的奖励';
        $viewData['dataList'] = model('RewardModel')->userRewardList(Session::get('userInfo.uid'));
        $this->assign('viewData',$viewData);
        return $this->view->fetch();
    }


   

   

}
