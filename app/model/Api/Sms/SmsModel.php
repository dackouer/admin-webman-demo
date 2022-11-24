<?php
	namespace app\model\Api\Sms;

	use support\Request;
	use support\Redis;
	use app\lib\Preg;
	use app\model\User\UserModel;
	use app\model\Record\RecordSmsModel;

	class SmsModel{
		public function index(Request $request){

		}

		public function sendsms(Request $request){
			$token = $request->header('Authorization');
			// $service = new Token();
			// if(!$service->checkToken($request)){
			// 	return Json::show(100011);
			// }
			$action = $request->post('action','login');
			$uid = $request->post('uid',0);

			if(empty($action) || !in_array($action,['test','login','register','security'])){
				return 100007;
			}

			if(in_array($action,['test','login','register'])){
				$uid = 83176150;
			}else{
				if(!$uid){
					return 100007;
				}
				$user = new UserModel();
				if(!$user){
					return 100007;
				}
			}

			switch($action){
				case 'test':
					$template = 'SMS_248190095';
					break;
				case 'register':
					$template = 'SMS_248185128';
					break;
				case 'login':
					$template = 'SMS_247100041';
					break;
				case 'security':
					$template = 'SMS_248190095';
					break;
				default:
					$template = 'SMS_248190095';
			}

			$mobile = $request->post('mobile');
			if(empty($mobile)){
				$mobile = $request->post('username');
			}
			if(empty($mobile)){
				return 100120;
			}
			if(!Preg::isMobile($mobile)){
				return 100121;
			}

			$service = new RecordSmsModel();
			$res = $service->getList($request,'top');

			if($res){

			}

			$num = $request->post('num',6);
			$type = $request->post('type',1);
			$code = $this->createCode($num,$type);

	        $params = ['code' => $code];//参数
	        $areacode = "86";//国际区号,腾讯云选传,其他不传
	        $sms = new \Hzdad\Wbsms\Wbsms('aliyun');//传入短信服务商名称, 腾讯云 qcloud , 阿里云 aliyun, 七牛 qiniu, 华为 huawei
	        $result = $sms->sendsms($action,$mobile,$params,$areacode);
	        // var_dump($result);
	        if($result['code'] == 200){
	        	// Redis::set('smscode_'.MD5($token.$mobile),$code);
	        	Redis::set('smscode_'.MD5($mobile),$code);

	        	$data = [
	        		'uid'			=> $uid,
	        		'type'			=> $action,
	        		'template'		=> $template,
	        		'mobile'		=> $mobile,
	        		'code'			=> $code,
	        		'create_time'	=> time(),
	        		'create_ip'		=> $request->getRealIp($safe_mode=true),
	        		'expire_time'	=> time() + 120,
	        	];
	        	$service = new RecordSmsModel();
	        	$service->setAppend($request,$data);
	        }

	        return $result;
		}

		// 生成验证码
		private function createCode($len = 6,$type = ''){
			$chars = '0123456789';
			switch($type){
				case '':
				case 1:
				case 'num':
					break;
				case 2:
					$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
				case 3:
					$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
				default:

			}

			$str = "";
			for($i=0;$i<$len;$i++){
				$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			}
			return $str;
		}
	}
?>