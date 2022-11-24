<?php
	namespace app\controller;

	use support\Request;
	use Webman\Config;
	use app\lib\Json;
	use Yansongda\Pay\Pay as PayModel;
	use app\model\Api\Wechat\WechatModel;

	class Pay{
		public function index(Request $request){
			try{
				$config = Config::get('payment');
				PayModel::config($config);

				$order = [
					'out_trade_no' => time().'',
					'description' => 'subject-测试',
					'amount' => [
					    'total' => 1,
					    'currency' => 'CNY',
					],
					'payer' => [
					    'openid' => '123fsdf234',
					]
				];

				$result = PayModel::wechat()->mini($order);

				return Json::show($result);
			}catch(\Exception $e){
				return Json::show(['code' => $e->getCode(),'msg' => $e->getMessage()]);
			}
		}

		public function minipay(Request $request){
			try{
				$url = "https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi";
				$data = [
					'appid'			=> 'wx70b76ad9e0013990',
					'mchid'			=> '1618670072',
					'description'	=> '测试描述',
					'out_trade_no'	=> 'IBT_'.time(),
					'notify_url'	=> 'https://v.ibtgs.com/pay/notify',
					'amount' 		=> ['total' => 1,'currency' => 'CNY'],
					'payer' 		=> ['openid' => '123fsdf234']
				];

				$result = $this->curlPost($url,json_encode($data));

				return Json::show($result);
			}catch(\Exception $e){
				return Json::show(['code' => $e->getCode(),'msg' => $e->getMessage()]);
			}
		}

		public function sign(Request $request){
			$wechat = new WechatModel();
			$sign = $wechat->getSign($request);

			return Json::show($sign);
		}


		public function notify(Request $request){
			// var_dump('pay success');
			return response('hello notify');
		}


    
	    /*
	     * curl GET 方式
	     * 参数1 $url
	     * 参数2 $data 格式 array('name'=>'test', 'age' => 18)
	     */
	    private function curlGet($url){
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , false);
	        curl_setopt($ch, CURLOPT_ENCODING       , 'gzip,deflate');
	        $res  = curl_exec($ch);
	        curl_close($ch);
	        return $res;
	    }
	    
	    /*
	     * curl POST 方式
	     * 参数1 $url
	     * 参数2 $data 格式 array('name'=>'test', 'age' => 18)
	     */
	    private function curlPost($url, $data){
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , false);
	        curl_setopt($ch, CURLOPT_POST           , 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS     , $data);
	        curl_setopt($ch, CURLOPT_ENCODING       , 'gzip,deflate');
	        $res  = curl_exec($ch);
	        curl_close($ch);
	        return json_decode($res,true);
	    }
	}
?>