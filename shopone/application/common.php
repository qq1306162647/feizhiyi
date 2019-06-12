<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//生成代理商证书
function createCertificate($id)
{
    $userInfo = model('UserModel')->userDataInfo($id);
    $image = \think\Image::open('./certificate/certificate_bg.png');
    //字体
    $font = './static/font/wryh.ttf';

    // 给原图加水印.png
    // 位置信息
    $position1[] = 0;
    $position1[] = 70;
    $saveDir = './certificate/';
    $saveFileName = "{$userInfo['uid']}.png";
    $textData1 = "兹授权{$userInfo['user_name']}为艾享你舒清贴产品代理商";
   
    $image->text($textData1,$font,20,'#804335',\think\Image::WATER_CENTER,$position1)->save($saveDir.$saveFileName);

    $image2 = \think\Image::open($saveDir.$saveFileName);
    $textData2 = "{$userInfo['level_name']}";
    $position2[] = 0;
    $position2[] = 110;
    $image2->text($textData2,$font,22,'#804335',\think\Image::WATER_CENTER,$position2)->save($saveDir.$saveFileName);

    if(file_exists($saveDir.$saveFileName)){
        $data['uid'] = $id;
        $data['certificate'] = $saveFileName;
        $data['certificate_level'] = $userInfo['user_level'];
        $setDatas = model('UserModel')->setDatas($data);
        if($setDatas){
            return ['status'=>1,'msg'=>'图片生成成功'];
        }
        return ['status'=>2,'msg'=>'图片生成失败'];
        
    }

    return ['status'=>2,'msg'=>'图片生成失败'];
   
}