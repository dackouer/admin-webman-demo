<?php
	namespace app\controller\Module;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Module\EngineModel;

	class Engine extends Controller{
		protected $table = 'Engine';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new EngineModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new EngineModel();
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
				$service = new EngineModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new EngineModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

	    /**
	     * 获取显示列表
	     * @param  Request $request [description]
	     * @return [type]           [description]
	     */
	    public function show(Request $request){
	        $service = new EngineModel();
	        $result = $service->getList($request,'show');
	        return Json::show($result);
	    }

		public function list(Request $request){
			$service = new EngineModel();
			$result = $service->getList($request);
			return Json::show($result);
		}

		/**
		 * 获取map字段表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function map(Request $request){
			$service = new EngineModel();
			$res = $service->getList($request,'map');
			return Json::show($res);
		}
	}
?>