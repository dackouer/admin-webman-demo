<?php
	namespace app\controller\Api\Aliyun;

	use support\Request;
	use app\lib\Json;

	use app\model\Api\Aliyun\AliyunModel;

	class Aliyun{
		public function index(Request $request){

		}

		/**
		 * 发送验证码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function sms(Request $request){
			$service = new AliyunModel();
			$result = $service->sms($request);

			// var_dump($result);
		}
	}
?>