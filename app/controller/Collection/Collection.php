<?php
	namespace app\controller\Collection;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Collection\CollectionModel;

	class Collection extends Controller{
		protected $table = 'Collection';
		
		public function index(Request $request,$id = 0,$goods_id = 0){
			if($id){
				$service = new CollectionModel();
				$result = $service->getList($request,$id,$goods_id);
			}else{
				$service = new CollectionModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new CollectionModel();
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
				$service = new CollectionModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new CollectionModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new CollectionModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>