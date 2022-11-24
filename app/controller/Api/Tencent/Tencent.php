<?php
	namespace app\controller\Api\Tencent;

	use support\Request;
	use app\lib\Json;

	use app\model\Api\Tencent\TencentModel;

	class Tencent{
		public function index(Request $request){

		}

		/**
		 * 核验健康码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function health(Request $request){
			$service = new TencentModel();
			$result = $service->VerifyHealthCode($request);

			return Json::show($result);
		}

		/**
		 * 核验行程码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function travel(Request $request){
			$service = new TencentModel();
			$result = $service->VerifyTravelCard($request);
			
			return Json::show($result);
		}

		/**
		 * 核验身份证二要素
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function idcard(Request $request){
			$service = new TencentModel();
			$result = $service->VerifyIdcard($request);
			
			//
			if(isset($result['error_code'])){
				if($result['result']['isok']){
					return Json::show($result);
				}else{
					return Json::show($result['error_code'],$result);
				}
			}else{
				if(isset($result['message'])){
					return Json::show(1,$result['message']);
				}
			}
		}

		public function pay(Request $request){
			$service = new TencentModel();
			$result = $service->pay($request);

			return Json::show($result);
		}
	}
?>