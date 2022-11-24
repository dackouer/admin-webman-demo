<?php
	namespace app\controller\User;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\User\UserModel;
	use app\model\User\UserContactModel;
	use app\model\User\UserPriorityModel;

	class User extends Controller{
		protected $table = 'User';
		
		/**
		 * 获取单个用户或分页用户
		 * @param  Request $request [description]
		 * @param  integer $id      [description]
		 * @return [type]           [description]
		 */
		public function index(Request $request,$id = 0){
			if($id){
				$service = new UserModel();
				$res = $service->getList($request,$id);
			}else{
				$service = new UserModel();
				$res = $service->getList($request);
			}
			return Json::show($res);
		}

		/**
		 * 获取某用户的上级用户
		 * @return [type] [description]
		 */
		public function parent(Request $request,$id = 0){
			if(is_null($id) || !is_numeric($id) || !$id){
				return Json::show(100007);
			}
			$service = new UserModel();
			$res = $service->getList($request,'parent',$id);
			return Json::show($res);
		}

		/**
		 * 获取某用户的下级用户
		 * @return [type] [description]
		 */
		public function child(Request $request,$id = 0){
			if(is_null($id) || !is_numeric($id) || !$id){
				return Json::show(100007);
			}
			$service = new UserModel();
			$res = $service->getList($request,'children',$id);
			return Json::show($res);
		}

		/**
		 * 获取某用户的联系人或活动排行榜
		 * @return [type] [description]
		 */
		public function contact(Request $request,$id = 0){
			$service = new UserModel();
			$res = $service->getList($request,'contact',$id);
			// var_dump($res);
			return Json::show($res);
		}

		/**
		 * 获取邀请活动排行榜
		 * @return [type] [description]
		 */
		public function inviter(Request $request){
			$service = new UserModel();
			$res = $service->getList($request,'inviter');
			// var_dump($res);
			return Json::show($res);
		}

		/**
		 * 获取邀请活动排行榜TOP
		 * @return [type] [description]
		 */
		public function invite(Request $request){
			$service = new UserModel();
			$res = $service->getList($request,'invites');
			// var_dump($res);
			return Json::show($res);
		}

		/**
		 * 用户认证
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function auth(Request $request){
			$service = new UserModel();
			$res = $service->setAuth($request);
			return Json::show($res);
		}

		/**
		 * 忘记密码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function forget(Request $request){
			$service = new UserModel();
			$res = $service->checkForget($request);
			return Json::show($res);
		}

		/**
		 * 重置密码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function pass(Request $request){
			$service = new UserModel();
			$res = $service->setPassword($request);
			return Json::show($res);
		}

		/**
		 * 设置安全密码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function secure(Request $request){
			$service = new UserModel();
			$res = $service->setSecure($request);
			return Json::show($res);
		}

		/**
		 * 设置预订
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function check(Request $request){
			$service = new UserModel();
			$result = $service->checkUserLogin($request);
			if($result){
				return Json::show($result);
			}else{
				return Json::show(1);
			}
		}

		/**
		 * 修改密码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function modpwd(Request $request){
			$service = new UserModel();
			$result = $service->setPassword($request,true);
			return Json::show($result);
		}

		/**
		 * 修改用户信息
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function modinfo(Request $request){
			$service = new UserModel();
			$result = $service->setUserInfo($request);
			return Json::show($result);
		}

		/**
		 * 充值
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function charge(Request $request){
			$service = new UserModel();
			$result = $service->setCharge($request);
			return Json::show($result);
		}

		/**
		 * 锁定
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function lock(Request $request){
			$service = new UserModel();
			$result = $service->setLocked($request);
			return Json::show($result);
		}

		/**
		 * 解锁
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function unlock(Request $request,$id = 0){
			$service = new UserModel();
			$result = $service->setUnLocked($request,$id);
			return Json::show($result);
		}

		/**
		 * 获取用户优先购
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function priority(Request $request){
			$service = new UserPriorityModel();
			$res = $service->getList($request,'show');
			return Json::show($res);
		}

		/**
		 * 获取map字段表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function map(Request $request){
			$service = new UserModel();
			$res = $service->getList($request,'map');
			return Json::show($res);
		}

		/**
		 * 删除用户
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function del(Request $request){
			$service = new UserModel();
			$res = $service->setDel($request);
			return Json::show($res);
		}

		public function test(Request $request){
			$service = new UserModel();
			$result = $service->test($request);
			return Json::show($result);
		}

		/**
		 * 导出
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function export(Request $request){
			$service = new UserModel();
			$result = $service->getList($request,'export');
			return Json::show($result);
		}
	}
?>