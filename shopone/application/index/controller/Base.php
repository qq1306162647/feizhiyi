<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Session;
use app\common\model\UserModel;
use think\facade\Config;
class Base extends Controller
{
	protected $userInfo = '';
	/**
	 * 初始化方法
	 * 创建常量，公共方法
	 * 在所有的方法之前被调用
	 */
	public function initialize()
	{	
		// $webset = Config::get('websetup');
		$this->assign('service_phone',Config::get('websetup.service_phone'));
		// dump($webset);

		// //更改底部菜单图片信息
		// Session::set('index_menu.icon','index_default.png');
  //       Session::set('index_menu.textClass','default_active');
        
  //       Session::set('article_menu.icon','article_default.png');
  //       Session::set('article_menu.textClass','default_active');

  //       Session::set('my_menu.icon','my_default.png');
  //       Session::set('my_menu.textClass','default_active');
        
		// $controllerName = request()->controller();
		// switch ($controllerName) {
		// 	case 'Index':
		// 		Session::set('index_menu.icon','index_selected.png');
		//         Session::set('index_menu.textClass','selected_active');
		// 		break;
		// 	case 'Cases':
		//         Session::set('article_menu.icon','article_selected.png');
		//         Session::set('article_menu.textClass','selected_active');
		// 		break;
		// 	case 'User':
		// 		Session::set('my_menu.icon','my_selected.png');
  //       		Session::set('my_menu.textClass','selected_active');
		// 		break;
		// 	default:

		// 		break;
		// }
		
		// Session::set('userInfo',UserModel::where('openid',Session::get('openid'))->find());
		// Session::set('userInfo',UserModel::where('openid','ooaq21OWsRrvrSTMDmAzcIC2a4LA')->find());
		// Session::delete('userInfo');
		// dump(Session::get('userInfo'));
		if(!Session::has('userInfo')){
			$this->redirect('index/login/index');
		}else{
			$userInfo = model('UserModel')->get(Session::get('userInfo.uid'));

			$this->assign('userInfo',$userInfo);
		}
	}


}