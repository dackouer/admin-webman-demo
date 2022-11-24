<?php
	namespace app\controller\Menu;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Menu\MenuModel;

	class Menu extends Controller{
		protected $table = 'Menu';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new MenuModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new MenuModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function list(Request $request){
			$service = new MenuModel();
			$result = $service->getList($request,'grant');
			return Json::show($result);
		}

		public function grant(Request $request){
			$service = new MenuModel();
			$result = $service->getList($request,'grant');
			return Json::show($result);
		}

		public function role(Request $request){
			$service = new MenuModel();
			$result = $service->getList($request,'role');
			return Json::show($result);
		}
	}
?>