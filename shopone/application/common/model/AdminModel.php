<?php
namespace app\common\model;
use think\Model;
use think\facade\Session;
class AdminModel extends Model
{
	protected	$pk = 'aid';
	protected	$table = 'my_admin';

	public static function setPassword($data)
	{
		$setData = AdminModel::where('aid',Session::get('adminInfo.aid'))->update($data);
		if($setData)
		{
			// Session::set(AdminModel::)
			return ['status'=>1,'msg'=>'修改成功'];
		}
		return ['status'=>2,'msg'=>'修改失败，请稍后再试'];
	}

	
}