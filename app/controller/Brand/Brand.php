<?php
	namespace app\controller\Brand;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Brand\BrandModel;

	class Brand extends Controller{
		protected $table = 'Brand';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new BrandModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new BrandModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new BrandModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new BrandModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new BrandModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>