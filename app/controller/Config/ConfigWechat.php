<?php
	namespace app\controller\Config;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Config\ConfigWechatModel;

	class ConfigWechat extends Controller{
		public function index(Request $request,$id = 0){
			if($id){
				$service = new ConfigWechatModel();
				$result = $service->getList($request,1);
			}else{
				$service = new ConfigWechatModel();
				$result = $service->getList($request,'show');
			}
			return Json::show($result);
		}

		/**
		 * [field description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function field(Request $request){
			$service = new ConfigWechatModel();
			$result = $service->getList($request,'field');

			return Json::show($result);
		}

		public function mod(Request $request,$id = 1){
			// var_dump('id: '.$id);
			$service = new ConfigWechatModel();
			$result = $service->mod($request);

			return Json::show($result);
		}
	}
?>