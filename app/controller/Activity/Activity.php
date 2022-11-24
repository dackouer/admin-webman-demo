<?php
	namespace app\controller\Activity;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Activity\ActivityModel;

	class Activity extends Controller{
		protected $table = 'Activity';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new ActivityModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new ActivityModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new ActivityModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function cate(Request $request,$cid = 0){
			$service = new ActivityModel();
			$result = $service->getList($request,'cate',$cid);
			return Json::show($result);
		}

		public function top(Request $request,$cid = 0){
			$service = new ActivityModel();
			$result = $service->getList($request,'top',$cid);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new ActivityModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new ActivityModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new ActivityModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>