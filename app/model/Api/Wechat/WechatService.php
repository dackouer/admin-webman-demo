<?php
	namespace app\model\Api\Wechat;

	use support\Request;
	use support\Db;
	use app\model\User\UserModel;
	use app\model\Order\OrderModel;
	use app\model\Config\ConfigWechatModel;
	use app\model\Config\ConfigOrderModel;

	use EasyWeChat\Kernel\Exceptions\Exception;
	use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
	use EasyWeChat\Pay\Application;
	use Symfony\Component\HttpFoundation\HeaderBag;
	use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
	use EasyWeChat\OpenWork\Message;

	use app\lib\Wechat\NativePay;
	use app\lib\Wechat\WxPayApi;
	use app\lib\Wechat\WxPayUnifiedOrder;
	use app\lib\Wechat\JsApiPay;
	use app\lib\Wechat\WxPayConfig;
	use app\lib\Wechat\PayNotifyCallBack;
	use app\lib\Wechat\WxPayDownloadBill;
	use app\lib\Wechat\WxPayMicroPay;
	use app\lib\Wechat\MicroPay;
	use app\lib\Wechat\WxPayOrderQuery;
	use app\lib\Wechat\WxPayRefund;
	use app\lib\Wechat\CLogFileHandler;
	use app\lib\Wechat\Clog;

	class WechatService{
		private $host = 'https://api.sndtsng.com/';
		private $isTest = true;
		private $config = [];

		public function __construct(){
			$this->setConfig();
		}

		public function setOauth(Request $request){
		    $code = $request->post('code');
			if(empty($code)){
				return 100010;
			}
		    $user = json_decode($request->post('userInfo'));
		    if(!$user){
		        return 100007;
		    }
		    // var_dump($user);
			// var_dump('code: '.$code);
			// var_dump($this->config);
			try{
				$app = new \EasyWeChat\MiniApp\Application($this->config);

				$utils = $app->getUtils();
				$session = $utils->codeToSession($code);
				// var_dump($session);
				if($session){
					// $res = $app->getClient()->postJson('wxa/business/getuserphonenumber', ['code'=>$code]);
					// var_dump($session);
					$data = [
						'expires_in'	=> isset($session['expires_in']) ? $session['expires_in'] : '',
						'openid'		=> $session['openid'],
						'session_key'	=> $session['session_key'],
						'unionid'		=> isset($session['unionid']) ? $session['unionid'] : '',
						'face'			=> $user->avatarUrl,
						'city'			=> $user->city,
						'country'		=> $user->country,
						'gender'		=> $user->gender,
						'language'		=> $user->language,
						'nickname'		=> $user->nickName,
						'province'		=> $user->province,
					];
					// var_dump($data);
					$service = new UserModel();
					$result = $service->setAppend($request,$data);
					return $result;
				}else{
					return [];
				}
			}catch(\EasyWeChat\Kernel\Exceptions\HttpException $e){
				// var_dump($e);
				$message = $e->getMessage();
				$message = trim($message,'code2Session error: ');
				$message = json_decode($message,true);
				// var_dump($message);
				return $message;
			}
		}

		/**
		 * 网页授权
		 * @param Request $request [description]
		 */
		public function setAuth(Request $request){
			try {
	            $app = new Application($this->config);
	            $response = $app->getClient()->post('/v3/pay/transactions/native', [
	                'json' => [
	                    'mchid' 		=> (string)$app->getMerchant()->getMerchantId(),
	                    'out_trade_no' 	=> $result['code'].'SN_'.time(),
	                    'appid' 		=> $this->config['app_id'], //根据自已实际的填写
	                    'description' 	=> $result['code'],
	                    'notify_url' 	=> $this->host.'pay/notify', //注意是ssl协议
	                    'amount' 		=> ['total' => $amount,'currency' => 'CNY']
	                ]
	            ]);
	        } catch (InvalidArgumentException $e) {
	            //
	        }
		}


		public function getPhoneNumber(){
			// $app 实例化步骤这里省略 
			$app = new \EasyWeChat\MiniApp\Application;($this->config);
		    $data = [
		      'code' => (string) request()->get('code'),
		    ];
		    return $app->getClient()->postJson('wxa/business/getuserphonenumber', $data);
		}

		/**
		 * 小程序统一下单
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function setOrder(Request $request){
			$service = new ConfigOrderModel();
			$config = $service->fetch(1);

			if(!$config['IsOrder']){
				return 100800;
			}
			$uid = $request->post('uid');
			$order = $request->post('order');
			$key = $request->post('key');
			$token = $request->post('token');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}
			if(empty($order) || !is_numeric($order) || !$order){
				return 100007;
			}
			if(empty($token)){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			if(!$user){
				return 100007;
			}
			if($config['IsMustAuth'] && !$user['is_auth']){
				return 100760;
			}

			$service = new OrderModel();
			$resp = $service->getList($request,$order);
			// var_dump('order data:');
			// var_dump($resp);
			if(!$resp){
				return 100850;	// 订单无效
			}
			// var_dump($resp);
			if($resp['status'] == -1){
				return 100851;	
			}

			if($resp['status'] == 0){
				return 100850;
			}

			if($resp['status'] == 2){
				return 100853;
			}

			if($resp['status'] != 1){
				return 100854;
			}


			$title = $resp['goods']['goods_title'];
			$attach = 'attach';
			// var_dump('order:'.$order['order']);
			$order = $resp['order'].time();	 // 32位
			if($config['IsTestPay']){
				$amount = $config['TestPayFee'] * 100;
			}else{
				$amount = $resp['amount'];
			}
			// $fee = (int)trim($order['amount']);
			$stime = time();
			$etime = time() + 3600 * 600;
			$tag = 'tag';
			$backurl = 'https://api.yijiantea.cn/order/notify';

			$service = new OrderModel();
			$service->setPlatform($request,$order,$key);
			// dump($resp);
			try{
				$tools = new JsApiPay($request);
				// $openId = $tools->GetOpenid();
				$openId = $resp['openid'];
				// var_dump('openId: '.$openId);

				//②、统一下单
				$input = new WxPayUnifiedOrder();
				$input->SetBody($title);					// 商品描述
				$input->SetAttach($attach);				// 附加数据
				$input->SetOut_trade_no($order);			// 商户订单号
				$input->SetTotal_fee($amount);				// 标价金额
				// $input->SetTime_start($stime);			// 交易起始时间
				// $input->SetTime_expire($etime);			// 交易结束时间
				$input->SetGoods_tag($tag);				// 订单优惠标记
				$input->SetNotify_url($backurl);			// 回调地址
				$input->SetTrade_type("JSAPI");							// 交易类型
				$input->SetOpenid($openId);
				$config = new WxPayConfig();
				$order = WxPayApi::unifiedOrder($config, $input);
				//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
				//$this->printf_info($order);
				$jsApiParameters = $tools->GetJsApiParameters($order);
				// var_dump($jsApiParameters);
				if(isset($jsApiParameters['err_code'])){
					return $jsApiParameters['err_code_des'];
				}
				if(isset($jsApiParameters['return_code']) && $jsApiParameters['return_code'] == 'FAIL'){
					return $jsApiParameters['return_msg'];
				}
				//获取共享收货地址js函数参数
				$editAddress = $tools->GetEditAddressParameters();
				
				$arr = [
					'order'			  => $resp,
					'jsApiParameters' => json_decode($jsApiParameters,true),
					'editAddress'	  => json_decode($editAddress,true)
				];

				return $arr;

			}catch(Exception $e){
				Clog::ERROR(json_encode($e));
			}
		}

		public function getSign(Request $request){
			$app = new \EasyWeChat\MiniApp\Application($this->config);
			$utils = $app->getUtils();

			$prepayId = $request->input('prepayId');
			$appId = $this->config['app_id'];
			$signType = 'RSA'; // 默认RSA，v2要传MD5
			$config = $utils->buildMiniAppConfig($prepayId, $appId, $signType); 
		}

		// 设置配置项
		private function setConfig(){
		    $service = new \app\model\Config\ConfigWechatModel();
		    $result = $service->fetch(1);
		  //  var_dump($result);
		    if($this->isTest){
		        $this->config = [	// ibt
    				'app_id'    	=> $result['MiniAppId'],
    				'secret'    	=> $result['MiniAppSecret'],
    				'mini_appid'    => $result['MiniAppId'],
    				'token'			=> $result['Token'],
    				'mch_id'		=> $result['MchId'],
    				'secret_key'	=> $result['Apiv3Key'],
    				'v2_secret_key'	=> $result['ApiKey'],
    				'private_key' 	=> '/www/wwwroot/yitea/cert/wechat/'.$result['Apikeys'],
    				'certificate' 	=> '/www/wwwroot/yitea/cert/wechat/'.$result['Apicert'],
    				'http' 			=> ['timeout' => 5.0,'retry' => true]
    			];
		    }else{
    			$this->config = [	// ibt
    				'app_id'    	=> 'wxfa0741c046a44ab7',
    				'secret'    	=> '4fccf90feb1c0b44b40896930b378ee0',
    				'mini_appid'    => 'wxfa0741c046a44ab7',
    				'token'			=> '',
    				'mch_id'		=> 1601399743,
    				'secret_key'	=> 'j02r4sn3dtnnq291fd2334nvjf45xvgk',
    				'v2_secret_key'	=> 'j02r4sn3dtnnq291fd2334nvjf45xvgk',
    				'private_key' 	=> '/www/wwwroot/dackou/app/model/Api/Wechat/wx/apiclient_key.pem',
    				'certificate' 	=> '/www/wwwroot/dackou/app/model/Api/Wechat/wx/apiclient_cert.pem',
    				'http' 			=> ['timeout' => 5.0,'retry' => true]
    			];
		    }
		}
	}
?>