<?php
namespace app\index\controller;
use think\facade\Session;
use think\facade\Request;
use app\common\model\UserModel;
use Endroid\QrCode\QrCode;
class Share extends Base
{

    
    public function index()
    {
        $viewData['webTitle'] = '分享';
        $this->assign('viewData',$viewData);
        return $this->view->fetch('share/share_index');
    }
    public function qrcode()
    {

    }
     /*
     * 生成二维码图片
     */
    public function createQrcode()
    {

    	$userInfo =  model('UserModel')->where('uid',Session::get('userInfo.uid'))->find();
    	$qrcode_dir = './qrcode/';
    	if(is_file($qrcode_dir.$userInfo['user_qrcode'])){
    		return ['status'=>1,'msg'=>'Success','filename'=>$userInfo['user_qrcode']];
    	}


        $link = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/index/Regist/index/s/'.Session::get('userInfo.uid');
        $fileNmae = $userInfo['uid'].md5(time().rand(100000,999999)).'.png';
        
        if (!file_exists($qrcode_dir)) mkdir($qrcode_dir, 0777, true);

        $pictureFile = $qrcode_dir .$fileNmae;
        $qrCode = new QrCode($link);
        $qrCode->writeString();
        $qrCode->writeFile($pictureFile);


        $setUserQrcode = model('UserModel')->where('uid',$userInfo['uid'])->setField('user_qrcode',$fileNmae);
        if($setUserQrcode){
        	return ['status'=>1,'msg'=>'Success','filename'=>$fileNmae];

            // dump($qrCode->writeString());
        }


        return ['status'=>2,'msg'=>'Error'];
    }
}
