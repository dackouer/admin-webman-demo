<?php
	namespace app\controller\Api\Sms;

	use support\Request;
	use support\Redis;
	use app\lib\Preg;
	use app\lib\Json;
	use app\lib\Token;
	use app\controller\Controller;
	use app\model\Api\Sms\SmsModel;
	use app\model\Api\Aliyun\AliyunModel;

	class Sms extends Controller{
		public function index(Request $request){
			
			
		}


		public function send(Request $request){
			$service = new SmsModel();
			$result = $service->sendsms($request);
			// var_dump($result);
			if(is_array($result) && isset($result['code'])){
				if($result['code'] == 200){
					return Json::show($result);
				}else{
					return Json::show($result['code'],$result['msg']);
				}
			}
			return Json::show($result);
		}
	}
?>