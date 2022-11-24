<?php
	namespace app\controller\User;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\User\UserContactModel;

	class UserContact extends Controller{
		protected $table = 'UserContact';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new UserContactModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new UserContactModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new UserContactModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		/**
		 * [add description]
		 * @param Request $request [description]
		 */
		public function add(Request $request){
			$service = new UserContactModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		public function map(Request $request){
			$service = new UserContactModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>