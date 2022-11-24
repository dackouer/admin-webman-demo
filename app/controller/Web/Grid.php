<?php
	namespace app\controller\Web;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Web\GridModel;

	class Grid extends Controller{
		protected $table = 'Grid';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new GridModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new GridModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new GridModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function parent(Request $request,$pid = 0){
			$service = new GridModel();
			$result = $service->getList($request,'parent',$pid);
			return Json::show($result);
		}

		public function add(Request $request){
			$service = new GridModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		public function mod(Request $request){
			$service = new GridModel();
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
				$service = new GridModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new GridModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new GridModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}

		public function del(Request $request){
			$service = new GridModel();
			$result = $service->del($request);
			return Json::show($result);
		}
	}
?>