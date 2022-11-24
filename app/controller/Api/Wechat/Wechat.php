<?php
	namespace app\controller\Api\Wechat;

	use support\Request;
	use app\lib\Json;
	use app\model\Api\Wechat\WechatService;

	class Wechat{
		public function oauth(Request $request){
			$service = new WechatService();
			$result = $service->setOauth($request);
			if(is_array($result) && isset($result['errcode'])){
				return Json::show($result['errcode'],$result['errmsg']);
			}
			return Json::show($result);
		}

		public function order(Request $request){
			$service = new WechatService();
			$result = $service->setOrder($request);

			return Json::show($result);
		}

		public function sign(Request $request){
			$service = new WechatService();
			$result = $service->getSign($request);

			return Json::show($result);
		}
	}
?>