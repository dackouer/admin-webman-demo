<?php
	namespace app\controller\Module;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Module\CollateModel;

	class Collate extends Controller{
		protected $table = 'Collate';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new CollateModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new CollateModel();
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
				$service = new CollateModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new CollateModel();
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
	        $service = new CollateModel();
	        $result = $service->getList($request,'show');
	        return Json::show($result);
	    }

		public function list(Request $request){
			$service = new CollateModel();
			$result = $service->getList($request);
			return Json::show($result);
		}

		/**
		 * 获取map字段表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function map(Request $request){
			$service = new CollateModel();
			$res = $service->getList($request,'map');
			return Json::show($res);
		}
	}
?>