<?php
	namespace app\controller\User;
	
	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\User\UserModel;

	class Reg{
		public function index(Request $request){
			$service = new UserModel();
			$res = $service->checkReg($request);
			
			return Json::show($res);
		}
	}
?>