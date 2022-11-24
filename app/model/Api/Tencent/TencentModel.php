<?php
	namespace app\model\Api\Tencent;

	use support\Request;
	use app\lib\Preg;

	use TencentCloud\Common\Credential;
	use TencentCloud\Common\Profile\ClientProfile;
	use TencentCloud\Common\Profile\HttpProfile;
	use TencentCloud\Common\Exception\TencentCloudSDKException;
	use TencentCloud\Ocr\V20181119\OcrClient;
	use TencentCloud\Ocr\V20181119\Models\RecognizeHealthCodeOCRRequest;
	use TencentCloud\Ocr\V20181119\Models\RecognizeTravelCardOCRRequest;

	use EasyWeChat\Kernel\Exceptions\Exception;
	use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
	use EasyWeChat\Pay\Application;
	use Symfony\Component\HttpFoundation\HeaderBag;
	use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
	use EasyWeChat\OpenWork\Message;

	use app\model\User\UserModel;
	use app\model\Order\OrderModel;
	use app\model\Config\ConfigWechatModel;
	use app\lib\Token;

	class TencentModel{
		private $config = [];
		private $secretId = 'AKIDGLAj13pKXUAajbCXbOu97pGRLyKQv9Au';
		private $secretKey = 'UheLlunPkoa5JHyOXP0KN9dqmRpxoPjq';
		private $host = 'https://api.sndtsng.com/';

		public function __construct(){
			$this->setConfig();
		}

		// 检验健康码
		public function VerifyHealthCode(Request $request){
			try {
				$SecretId = $this->secretId;
				$SecretKey = $this->secretKey;
				$ap = $request->post('ap');
				if(empty($ap)){
					$ap = 'ap-beijing';
				}
				$ImageUrl = $request->post('url');
				if(empty($ImageUrl)){
					return array(
						'code' => 1,
						'message' => '请上传健康码图片'
					);
				}

			    $cred = new Credential($SecretId, $SecretKey);
			    $httpProfile = new HttpProfile();
			    $httpProfile->setEndpoint("ocr.tencentcloudapi.com");
			      
			    $clientProfile = new ClientProfile();
			    $clientProfile->setHttpProfile($httpProfile);
			    $client = new OcrClient($cred, $ap, $clientProfile);

			    $req = new RecognizeHealthCodeOCRRequest();
			    
			    $params = array(
			    	"ImageUrl" => $ImageUrl
			    );
			    $req->fromJsonString(json_encode($params));

			    $resp = $client->RecognizeHealthCodeOCR($req);

			    return json_decode($resp->toJsonString(),true);
			}catch(TencentCloudSDKException $e) {
			    return array(
			    	'code' => 1,
			    	'message' => $e->getMessage()
			    );
			}

		}

		// 检验行程码
		public function VerifyTravelCard(Request $request){
			try {
				$SecretId = $this->secretId;
				$SecretKey = $this->secretKey;
				$ap = $request->post('ap');
				if(empty($ap)){
					$ap = 'ap-beijing';
				}
				$ImageUrl = $request->post('url');
				if(empty($ImageUrl)){
					return array(
						'code' => 1,
						'message' => '请上传行程码图片'
					);
				}

			    $cred = new Credential($SecretId, $SecretKey);
			    $httpProfile = new HttpProfile();
			    $httpProfile->setEndpoint("ocr.tencentcloudapi.com");
			      
			    $clientProfile = new ClientProfile();
			    $clientProfile->setHttpProfile($httpProfile);
			    $client = new OcrClient($cred, $ap, $clientProfile);

			    $req = new RecognizeTravelCardOCRRequest();
			    
			    $params = array(
			        "ImageUrl" => $ImageUrl
			    );
			    $req->fromJsonString(json_encode($params));
			    $resp = $client->RecognizeTravelCardOCR($req);
			    
			    return json_decode($resp->toJsonString(),true);
			}
			catch(TencentCloudSDKException $e) {
			    return array(
			    	'code' => 1,
			    	'message' => $e->getMessage()
			    );
			}

		}

		// 检验身份证二要素
		public function VerifyIdcard(Request $request){
			$idcard = trim($request->input('idcard'));
			if(empty($idcard)){
				return 300100;	
			}
			if(!Preg::isIdcard($idcard)){
				return 300101;	
			}

			$realname = trim($request->input('realname'));
			if(empty($realname)){
				return 300102;	
			}

			// ÔÆÊÐ³¡·ÖÅäµÄÃÜÔ¿Id
			$secretId = 'AKIDgUxmwshOX83RmAofUcEj5FfwgK3n26Qe87z0';
			// ÔÆÊÐ³¡·ÖÅäµÄÃÜÔ¿Key
			$secretKey = 'cmDbtDwf5r6lfViprod0atfz9dCc5t4e7w6xbu1m';
			$source = 'market';

			// Ç©Ãû
			$datetime = gmdate('D, d M Y H:i:s T');
			$signStr = sprintf("x-date: %s\nx-source: %s", $datetime, $source);
			$sign = base64_encode(hash_hmac('sha1', $signStr, $secretKey, true));
			$auth = sprintf('hmac id="%s", algorithm="hmac-sha1", headers="x-date x-source", signature="%s"', $secretId, $sign);

			// ÇëÇó·½·¨
			$method = 'POST';
			// ÇëÇóÍ·
			$headers = array(
			    'X-Source' => $source,
			    'X-Date' => $datetime,
			    'Authorization' => $auth,
			    
			);
			// ²éÑ¯²ÎÊý
			$queryParams = array (

			);
			// body²ÎÊý£¨POST·½·¨ÏÂ£©
			$bodyParams = array (
			    'cardNo' => $idcard,
			    'realName' => $realname,
			);
			// url²ÎÊýÆ´½Ó
			$url = 'https://service-6wu95l73-1253495967.bj.apigw.tencentcs.com/release/idcard/idcheckPost';
			if (count($queryParams) > 0) {
			    $url .= '?' . http_build_query($queryParams);
			}

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(function ($v, $k) {
			    return $k . ': ' . $v;
			}, array_values($headers), array_keys($headers)));
			if (in_array($method, array('POST', 'PUT', 'PATCH'), true)) {
			    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($bodyParams));
			}

			$data = curl_exec($ch);
			if (curl_errno($ch)) {
			    // $result = json_decode(curl_error($ch),true);
			    $result = curl_error($ch);
			} else {
			    $result = json_decode($data,true);
			}
			curl_close($ch);

			return $result;
		}

		/**
		 * 微信支付
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function pay(Request $request){
			$type = $request->post('type','jsapi');

			switch(strtolower(trim($type))){
				case 'jsapi':
					$result = $this->payByJsapi($request);
					break;
				case 'native':
					$result = $this->payByNative($request);
					break;
				default:
					$result = $this->payByJsapi($request);
			}

			return $result;
		}

		/**
		 * 微信jsapi支付
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		private function payByJsapi(Request $request){
			$config = [
				'mch_id' => 1601399743,
				// 商户证书
			    'private_key' => __DIR__ . '/cert/apiclient_key.pem',
			    'certificate' => __DIR__ . '/cert/apiclient_cert.pem',
			    // v3 API 秘钥
		        'secret_key' => 'j02r4sn3dtnnq291fd2334nvjf45xvgk',	
		        // v2 API 秘钥
	            'v2_secret_key' => '',
	            'http' => [
                    'throw'  => true, // 状态码非 200、300 时是否抛出异常，默认为开启
                    'timeout' => 5.0,
                ]
			]; 

			$app = new Application($config);
			$response = $app->getClient()->postJson("v3/pay/transactions/jsapi", [
			   "mchid" 			=> "1601399743", // <---- 请修改为您的商户号
			   "out_trade_no" 	=> "native12177525012012070352333'.rand(1,1000).'",
			   "appid" 			=> "wxfa0741c046a44ab7", // <---- 请修改为服务号的 appid
			   "description" 	=> "Image形象店-深圳腾大-QQ公仔",
			   "notify_url" 	=> "https://weixin.qq.com/",
			   "amount" => [
			        "total" => 1,
			        "currency" => "CNY"
			    ],
			    "payer" 		=> [
			        "openid" => "opiYT0fz8enX7eLvvawdjGvuraa0" // <---- 请修改为服务号下单用户的 openid
			    ]
			]);

			\dd($response->toArray(false));











			/*

			$result = $this->checkOrder($request);
			if(!is_array($result)){
				return $result;
			}

			// var_dump('订单验证成功');
			$config = [
				'app_id'	=> 'wx70b76ad9e0013990',
				'mch_id' => 1618670072,
				// 商户证书
			    'private_key' => __DIR__ . '/cert/apiclient_key.pem',
			    'certificate' => __DIR__ . '/cert/apiclient_cert.pem',
			    // v3 API 秘钥
		        'secret_key' => 'BqA02RQ0wTOoP1tmVEddRP5jkRcVCZ1P',	
		        // v2 API 秘钥
	            'v2_secret_key' => 'GVN0IoqDtHmm8w8wXazBjpC4vPY5o0CD',
	            'http' => [
                    'throw'  => true, // 状态码非 200、300 时是否抛出异常，默认为开启
                    'timeout' => 5.0,
                ]
			];

			try{
	            $app = new Application($config);
				$response = $app->getClient()->postJson("v3/pay/transactions/jsapi", [
				   "mchid" 			=> (string)$app->getMerchant()->getMerchantId(), // <---- 请修改为您的商户号
				   "out_trade_no" 	=> 'SN_'.time(),
				   "appid" 			=> $config['app_id'], // <---- 请修改为服务号的 appid
				   "description" 	=> 1,
				   "notify_url" 	=> $this->host."pay/notify",
				   "amount" 		=> [
				        'total' 	=> 1,
	                    'currency' 	=> 'CNY',
				    ],
				    "payer" 		=> [
				        "openid" 	=> $result['openid'] // <---- 请修改为服务号下单用户的 openid
				    ]
				]);
			}catch(InvalidArgumentException $e){
				// var_dump($e);
			}
			$res = $response->toArray();
			// var_dump($res);
			$utils = $app->getUtils();
			$config = $utils->buildBridgeConfig($res['prepay_id'], $config['app_id'], 'RSA');
			
			$data = array_merge($result,$config);
			$data['amount'] = 1;
			return Json::show($data);
			// var_dump($data);
			return view('pay/jsapi', $data);
			*/
		}

		/**
		 * 微信native支付
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		private function payByNative(Request $request){
			$result = $this->checkOrder($request);
			if(!is_array($result)){
				return $result;
			}
		}

		/**
		 * 检查订单
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		private function checkOrder(Request $request){
			$order = trim($request->post('order'));
			$token = trim($request->post('token'));

			// var_dump('order: '.$order);
			// var_dump('token: '.$token);

			if(empty($order) || empty($token)){
				return 100007;
			}

			$token = Token::decrypt($token);
			$token = explode('_',$token);
			// var_dump($token);

			// if($token[0] != $order){
			// 	return 100011;
			// }

			$service = new OrderModel();
			$data = $service->getList($request,'pay',$order);
			if(!$data){
				return 100850;
			}
			// var_dump($data);
			if($data['status'] == -1){
				return 100851;		// 订单已取消
			}

			if($data['status'] == 2){
				return 100853;		// 订单已支付
			}

			if($data['status'] != 1){
				return 100854;		// 无效的订单状态
			}

			if(!isset($data['total']) || empty($data['total']) || !is_numeric($data['total']) || $data['total'] <= 0){
				return 100856;		// 无效的订单数量
			}

			if(!isset($data['amount']) || empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0){
				return 100857;		// 无效的订单金额
			}

			if(isset($data['stock']) && $data['stock'] <= 0){
				return 100855;		// 商品已售罄
			}

			if(isset($data['limit_goods']) && $data['limit_goods']){
				return 100858;		// 商品已被限购
			}

			if(isset($data['limit_order']) && $data['limit_order']){
				return 100859;		// 订单已被限购
			}



			$uid = $data['uid'];
			if(empty($uid) || !$uid){
				return 100860;
			}

			// if($token[1] != $uid){
			// 	return 100011;
			// }

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			if(!$user){
				return 100860;
			}

			return $data;
		}

		private function setConfig(){
			$service = new ConfigWechatModel();
			$result = $service->fetch(1);

			if($result){
				 $this->config = [
		            'app_id'    => $result['MiniAppId'],
		            'secret'    => $result['MiniAppSecret'],
		            'token'     => 'snhb',
		            'aes_key'   => '', // 明文模式请勿填写 EncodingAESKey
		            'oauth' => [
		                'scopes'   => ['snsapi_userinfo'],
		                'callback' => $this->host.'pay/notify',
		            ],
		            'http' => [
		                'timeout' => 5.0,
		                'retry' => true,
		            ],
		            'mch_id' => $result['MchId'],
		            'private_key' => '/www/wwwroot/webman/public/cert/apiclient_key.pem',
		            'certificate' => '/www/wwwroot/webman/public/cert/apiclient_cert.pem',

		             // v3 API 秘钥
		            'secret_key' => $result['Apiv3Key'],

		            // v2 API 秘钥
		            'v2_secret_key' => $result['ApiKey'],
		        ];
			}
		}
	}
?>