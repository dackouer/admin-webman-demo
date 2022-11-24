<?php
	namespace app\controller\Config;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Config\ConfigSystemModel;

	class ConfigSystem extends Controller{
		public function index(Request $request){
			$service = new ConfigSystemModel();
			$result = $service->getList($request,'show');

			return Json::show($result);
		}

		/**
		 * [field description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function field(Request $request){
			$service = new ConfigSystemModel();
			$result = $service->getList($request,'field');

			return Json::show($result);
		}

		public function mod(Request $request,$id = 1){
			$service = new ConfigSystemModel();
			$result = $service->mod($request);

			return Json::show($result);
		}
	}
?>