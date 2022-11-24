<?php
	namespace app\controller\User;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\User\UserPriorityModel;

	class UserPriority extends Controller{
		protected $table = 'UserPriority';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new UserPriorityModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new UserPriorityModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new UserPriorityModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function batch(Request $request){
			$service = new UserPriorityModel();
			$result = $service->setBatch($request);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new UserPriorityModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new UserPriorityModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new UserPriorityModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>