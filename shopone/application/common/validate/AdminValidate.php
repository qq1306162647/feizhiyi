<?php
namespace app\common\validate;
use think\Validate;

class AdminValidate   extends Validate
{
	protected $rule = [
		'admin_name|用户名'=>[
			'require'=>'require',
			'length'=>'1,254',
		],
		'admin_pwd|密码'=>[
			'require'=>'require',
			'length'=>'1,254',
		],
	];
}