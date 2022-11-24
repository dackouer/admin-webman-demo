<?php
	namespace app\controller\Creator;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Creator\CreatorModel;

	class Creator extends Controller{
		protected $table = 'Creator';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new CreatorModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new CreatorModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new CreatorModel();
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
				$service = new CreatorModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new CreatorModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new CreatorModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>