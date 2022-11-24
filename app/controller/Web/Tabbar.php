<?php
	namespace app\controller\Web;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Web\TabbarModel;

	class Tabbar extends Controller{
		protected $table = 'Tabbar';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new TabbarModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new TabbarModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new TabbarModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function add(Request $request){
			$service = new TabbarModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		public function mod(Request $request){
			$service = new TabbarModel();
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
				$service = new TabbarModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new TabbarModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new TabbarModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}

		public function del(Request $request){
			$service = new TabbarModel();
			$result = $service->del($request);
			return Json::show($result);
		}
	}
?>