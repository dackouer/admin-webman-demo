<?php
	namespace app\controller\Activity;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Activity\ActivityCateModel;

	class ActivityCate extends Controller{
		protected $table = 'ActivityCate';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new ActivityCateModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new ActivityCateModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new ActivityCateModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function add(Request $request){
			$service = new ActivityCateModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		public function mod(Request $request){
			$service = new ActivityCateModel();
			$result = $service->mod($request);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new ActivityCateModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new ActivityCateModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new ActivityCateModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>