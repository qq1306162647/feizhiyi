<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class UserModel extends Model
{
	protected 	$table = 'my_user';
	protected 	$pk = 'uid';
	protected 	$autoWriteTimestamp = true;
	protected 	$createTime 		= 'user_create_time';
	protected 	$updateTime 		= 'user_update_time';
	protected 	$dateFormat 		= 'Y/m/d';
	protected 	$insert 			= ['user_create_time'];
	protected 	$update 			= ['user_update_time'];

	public static function userUplevel($uid)
	{
		$upgradewhereOne = 0;
		$upgradewhereTwo = 0;
		//本次要是升级用户的信息
		$thisUpLevelUser = model('UserModel')
							->where('uid',$uid)
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->find();
		//级别列表
        $userLevelList = model('UserLevelModel')->dataList(); 

        //升级经理的条件
		if($thisUpLevelUser['user_level']==1){
			$upgradewhereOne = $thisUpLevelUser['user_first_order'];
			$upgradewhereTwo = $thisUpLevelUser['all_first_order'];
		}elseif($thisUpLevelUser['user_level']==2){
			$upgradewhereOne = $thisUpLevelUser['user_first_order'];
			$upgradewhereTwo = $thisUpLevelUser['total_achievement'];
		}

		
		//级别列表
        $userLevelList = model('UserLevelModel')->dataList(); 
		//用户升级操作
		foreach ($userLevelList as $levelkey => $levelvalue) {
        	if($upgradewhereOne >= $levelvalue['satisfy_where_one']  and $upgradewhereTwo >= $levelvalue['satisfy_where_two'] and $thisUpLevelUser['user_level'] < $levelvalue['lid']){
        		//升级操作
        		model('UserModel')->where('uid',$thisUpLevelUser['uid'])->setField('user_level',$levelvalue['lid']);
        		
        	}
        }
	}

	//修改密码
	public static function setPassword($data){
		$setPassword = UserModel::where('uid',$data['uid'])->setField('password_text',md5($data['password']));
		if($setPassword){
			return ['status'=>1,'msg'=>'操作成功'];
		}

		return ['status'=>2,'msg'=>'操作失败'];
	}

	//设置运营商
	public static function setUserLevel($data){
		$setUserLevel = UserModel::where('uid',$data['uid'])->setField('user_level',4);
		if($setUserLevel){
			return ['status'=>1,'msg'=>'操作成功'];
		}

		return ['status'=>2,'msg'=>'操作失败'];
	}


	//根据手机号查找信息
	public static function userDataInfo($phone)
	{
		return UserModel::where('user_phone',$phone)->find();
	}
	

	//用户登录
	public static function userLogin($data)
	{
		$where['user_phone'] = $data['user_phone'];
		$where['user_password'] = md5($data['password']);
		$userInfo = UserModel::where($where)->find();
		if($userInfo){
			Session::set('userInfo',$userInfo);
			return ['status'=>1,'msg'=>'登录成功'];
		}

		return ['status'=>2,'msg'=>'手机号或密码错误'];

	}



	//数据列表
	public static function dataList()
	{
		$userList =  UserModel::order('uid desc')
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->paginate(20);
		foreach ($userList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['superiorAngen'] =UserModel::where('uid',$value['recommend_code'])
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->find();
		}

		return $userList;

	}
	//CEO数据列表
	public static function ceoDataList($where)
	{
		$userList =  UserModel::order('uid desc')
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->where($where)
							->paginate(20);
		foreach ($userList as $key => $value) {
			$dataList[$key] = $value;
			$ceoMonthOrderData = model('UserAchievementModel')->ceoMonthOrderNumber($value['uid']);
			$dataList[$key]['ceoMonthOrderNumber'] = $ceoMonthOrderData['ceoMonthOrderNumber'];
			$dataList[$key]['ceoMonthOrderTotal'] = $ceoMonthOrderData['ceoMonthOrderTotal'];

			$dataList[$key]['superiorAngen'] =UserModel::where('uid',$value['recommend_1'])
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->find();
			//全部推荐人数
			$dataList[$key]['recommend_1'] 	= UserModel::where('recommend_1',$value['uid'])->count();

			//直推的VIP人数
			$vipWhere['recommend_1'] = $value['uid'];
			$vipWhere['is_vip'] = 2;
			$dataList[$key]['vip_number'] =  UserModel::where($vipWhere)->count();

			//9层之内的总人数
			$dataList[$key]['recommend_2']  = $dataList[$key]['recommend_1'];
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_2',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_3',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_4',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_5',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_6',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_7',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_8',$value['uid'])->where('is_vip',2)->count();
			$dataList[$key]['recommend_2'] 	+= UserModel::where('recommend_9',$value['uid'])->where('is_vip',2)->count();
		}

		return $userList;

	}
	//带条件数据列表
	public static function whereDataList($where)
	{
		$userList =  UserModel::order('uid desc')
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->where($where)
							->paginate(20);
		foreach ($userList as $key => $value) {
			$dataList[$key] = $value;
			$dataList[$key]['superiorAngen'] =UserModel::where('uid',$value['recommend_code'])
							->join('my_user_level','my_user_level.lid = my_user.user_level')
							->find();
		}

		return $userList;

	}

	//我的粉丝
	public static function myFansList($id)
	{
		$userInfo = UserModel::get($id);
		$dataList = UserModel::where('recommend_1',$userInfo['uid'])->select();
		return $dataList;

	}

	
	



	//新增数据
	public static function insertDatas($data)
	{
		$model = new UserModel;
		// 过滤post数组中的非数据表字段数据
		$insertDatas = $model->allowField(true)->create($data);
		// $insertDatas = UserModel::create($data);
		if($insertDatas){
			
			$recommendInfo = UserModel::get($data['recommend_code']);
			//增加直推人 的直推人数和 团队人数
			$setUserOneData['recommend_one_number'] = $recommendInfo['recommend_one_number'] + 1;
			$setUserOneData['recommend_team_number'] = $recommendInfo['recommend_team_number'] + 1;
			$setUsreOne = UserModel::where('uid',$recommendInfo['uid'])->update($setUserOneData);

			//增加二级 的团队人数
			UserModel::where('uid',$recommendInfo['recommend_code'])->setInc('recommend_team_number');

			return ['status'=>1,'msg'=>'注册成功','code'=>$insertDatas->uid];

		}

		return ['status'=>2,'msg'=>'注册失败，请稍后再试'];
	}

	//数据更新
	public static function updateDatas($data)
	{
		$model = new UserModel;
		// 过滤post数组中的非数据表字段数据
		$updateDatas = $model->allowField(true)->save($data,['openid' => $data['openid']]);
		if($updateDatas){
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];

	}


	//修改数据
	public static function setDatas($data)
	{
		$setDatas = UserModel::where('uid',$data['uid'])->update($data);
		if($setDatas){
			Session::set('userInfo',UserModel::where('uid',$data['uid'])->find());
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
	}

	//更换推荐人
	public static function setRecommended($data)
	{	
		$dataInfo = UserModel::where('uid',$data['recommend_one'])->find();
		if($dataInfo){
			$setUserData['recommend_1'] 	= $dataInfo['uid'];
			$setUserData['recommend_2'] 	= $dataInfo['recommend_1'];
			$setUserData['recommend_3'] 	= $dataInfo['recommend_2'];
			$setUserData['recommend_4'] 	= $dataInfo['recommend_3'];
			$setUserData['recommend_5'] 	= $dataInfo['recommend_4'];
			$setUserData['recommend_6'] 	= $dataInfo['recommend_5'];
			$setUserData['recommend_7'] 	= $dataInfo['recommend_6'];
			$setUserData['recommend_8'] 	= $dataInfo['recommend_7'];
			$setUserData['recommend_9'] 	= $dataInfo['recommend_8'];
			$setUserData['recommend_10'] 	= $dataInfo['recommend_9'];
			$setUserData['recommend_code'] 	= $dataInfo['uid'];
			$setDatas = UserModel::where('uid',$data['uid'])->update($setUserData);
			if($setDatas){
				return ['status'=>1,'msg'=>'更换成功'];
			}
		}else{
			return ['status'=>2,'msg'=>'没有查到编号【'.$data['recommend_one'].'】的推荐人'];
		}

		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
		
	}

	
}