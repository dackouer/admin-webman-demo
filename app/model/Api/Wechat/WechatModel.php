<?php
	namespace app\model\Api\Wechat;
	
	use support\Request;


	class WechatModel{
		private $wxname;													// 公众号名称 https://mp.weixin.qq.com
		private $appid = 'wxa7b8e45807ba3754';								// 公众号appid https://mp.weixin.qq.com
		private $secret = '8b5088713c5945f802ba644150e28a7a';				// 公众号appsecret https://mp.weixin.qq.com
		private $token;														// 公众号token https://mp.weixin.qq.com
		

		public function __construct($appid = null,$secret = null,$token = null){
			if(!is_null($appid)){
				$this->appid = $appid;
			}
			if(!is_null($secret)){
				$this->secret = $secret;
			}
			if(!is_null($token)){
				$this->token = $token;
			}
		}

		// 获取签名
		public function getSign(Request $request){
			$jsapiTicket = $this->getJsApiTicket();
			// 注意 URL 一定要动态获取，不能 hardcode.
			// $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
   //  		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    		$url = $request->host();
    		$timestamp = time();
    		$nonceStr = $this->createNonceStr();

    		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
    		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    		$signature = sha1($string);

    		$signPackage = array(
    			"appId"     => $this->appid,
    			"nonceStr"  => $nonceStr,
    			"timestamp" => $timestamp,
    			"url"       => $url,
    			"signature" => $signature,
    			"rawString" => $string
    		);
    		return $signPackage; 
		}

		// 获取JsApiTicket
		private function getJsApiTicket(){
			// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
			$data = json_decode($this->get_php_file("jsapi_ticket.php"));
			if($data->expire_time < time()){
				$accessToken = $this->getAccessToken();
				// 如果是企业号用以下 URL 获取 ticket
				// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
				$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
				$res = json_decode($this->httpGet($url));
				$ticket = $res->ticket;
				if($ticket){
					$data->expire_time = time() + 7000;
					$data->jsapi_ticket = $ticket;
					$this->set_php_file("jsapi_ticket.php", json_encode($data));
				}
			}else{
				$ticket = $data->jsapi_ticket;
			}
			return $ticket;
		}

		// 获取AccessToken
		private function getAccessToken(){
			// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
			$data = json_decode($this->get_php_file("access_token.php"));
			if($data->expire_time < time()){
				// 如果是企业号用以下URL获取access_token
				// $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appid&corpsecret=$this->secret";
				$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->secret";
				$res = json_decode($this->httpGet($url));
				$access_token = $res->access_token;
				if($access_token){
					$data->expire_time = time() + 7000;
					$data->access_token = $access_token;
					$this->set_php_file("access_token.php", json_encode($data));
				}
			}else{
				$access_token = $data->access_token;
			}
			return $access_token;
		}

		// curl-get
		private function httpGet($url){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
			// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
			// 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl, CURLOPT_URL, $url);

			$res = curl_exec($curl);
			curl_close($curl);

			return $res;
		}

		// 创建随机字符串
		private function createNonceStr($length = 16){
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$str = "";
			for($i=0;$i<$length;$i++){
				$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			}
			return $str;
		}

		// 获取文件信息
		private function get_php_file($filename){
			return trim(substr(file_get_contents($filename), 15));
		}

		// 写入文件信息
		private function set_php_file($filename, $content){
			$fp = fopen($filename, "w");
			fwrite($fp, "<?php exit();?>" . $content);
			fclose($fp);
		}
	}
?>