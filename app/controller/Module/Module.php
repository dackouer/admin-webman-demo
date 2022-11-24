<?php
	namespace app\controller\Module;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Module\ModuleModel;

	class Module extends Controller{
		protected $table = 'Module';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new ModuleModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new ModuleModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

	    /**
	     * 获取显示列表
	     * @param  Request $request [description]
	     * @return [type]           [description]
	     */
	    public function show(Request $request){
	        $service = new ModuleModel();
	        $result = $service->getList($request,'show');
	        return Json::show($result);
	    }

		public function list(Request $request){
			$service = new ModuleModel();
			$result = $service->getList($request);
			return Json::show($result);
		}

		public function child(Request $request){
			$service = new ModuleModel();
			$result = $service->getList($request,'children');
			return Json::show($result);
		}

		/**
		 * 获取map字段表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function map(Request $request){
			$service = new ModuleModel();
			$res = $service->getList($request,'map');
			return Json::show($res);
		}
	}
?>