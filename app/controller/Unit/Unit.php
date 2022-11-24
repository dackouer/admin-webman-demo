<?php
	namespace app\controller\Unit;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Base\UnitModel;

	class Unit extends Controller{
		protected $table = 'Unit';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new UnitModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new UnitModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new UnitModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new UnitModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new UnitModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new UnitModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}

		public function del(Request $request){
			$service = new UnitModel();
			$result = $service->del($request);
			return Json::show($result);
		}
	}
?>