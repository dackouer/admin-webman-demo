<?php
	namespace app\controller;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\user\UserModel;
	use app\model\Model;
	use app\lib\Server;
	use app\lib\Token;
	use app\lib\Des;
	use app\lib\Json;
	use app\model\Order\OrderModel;
	use app\model\Config\ConfigWechatModel;

	class Test{
		public function index(Request $request){

			$data = "extend=&charset=UTF-8&data=%7B%22head%22%3A%7B%22version%22%3A%221.0%22%2C%22respTime%22%3A%2220220901165845%22%2C%22respCode%22%3A%22000000%22%2C%22respMsg%22%3A%22%E6%88%90%E5%8A%9F%22%7D%2C%22body%22%3A%7B%22mid%22%3A%226888804052380%22%2C%22orderCode%22%3A%22202209012795371940781662022702%22%2C%22tradeNo%22%3A%22202209012795371940781662022702%22%2C%22clearDate%22%3A%2220220901%22%2C%22totalAmount%22%3A%22000000000020%22%2C%22orderStatus%22%3A%221%22%2C%22payTime%22%3A%2220220901165845%22%2C%22settleAmount%22%3A%22000000000020%22%2C%22buyerPayAmount%22%3A%22000000000020%22%2C%22discAmount%22%3A%22000000000000%22%2C%22txnCompleteTime%22%3A%2220220901165845%22%2C%22payOrderCode%22%3A%220901j00000031187%22%2C%22accLogonNo%22%3A%22621790*********1058%22%2C%22accNo%22%3A%22621790*********1058%22%2C%22midFee%22%3A%22000000000010%22%2C%22extraFee%22%3A%22000000000000%22%2C%22specialFee%22%3A%22000000000000%22%2C%22plMidFee%22%3A%22000000000000%22%2C%22bankserial%22%3A%22%22%2C%22externalProductCode%22%3A%2200000016%22%2C%22cardNo%22%3A%22621790*********1058%22%2C%22creditFlag%22%3A%22%22%2C%22bid%22%3A%22SDSMP00688880405238020220901042547469248%22%2C%22benefitAmount%22%3A%22000000000000%22%2C%22remittanceCode%22%3A%22%22%2C%22extend%22%3A%22%22%7D%7D&sign=AezLY1uj7GeG3B5v0TeYTU%2BxeP4lBBnvpnZYQApfl8sTBv96V%2BjBMm4%2FviG4fOREOj%2BJYvU%2FcPsXFIIz9flnUgXc9QH1Szfyxfay32xTUSY2wxkKiKYPgcm2vPPSxmOEpQU7zmYsOYZXnb%2B1ZZpwXeHkGz6mP5AIUOVmoR7ODk9xX409gzQsv9iYXJWKI8Z9ZeUwqoI6ajepb5HXZF4D%2FRZ8fode7IBQ3Dfsg84ASxtJQ21BrnAtAWwSucCkPXMupvfqw1BusexquaP9o%2Fq1H5XeNTK9Y7NV%2BToMlY4v7bBQOdVUz8zVh3bnKveECSVrxvroiS7Y42RHMCi2N%2Fa1CQ%3D%3D&signType=01";


			$data = $this->splitStr($data);

			$data = json_decode(urldecode($data['data']),true);
			// var_dump($data);
			// H5一键快捷支付
			if(isset($data['head']['respCode']) && $data['head']['respCode'] == '000000' && isset($data['body']['orderStatus']) && $data['body']['orderStatus'] == '1' && isset($data['body']['mid']) && $data['body']['mid'] == '6888804052380'){
				
				$service = new OrderModel();
				return $service->updatePayment($request,$data['body']);
			}

			

			

			return Json::show($data);

			
			// $token = Token::create();

			// return response('token: '.$token);


			// $service = new ConfigWechatModel();
			// $data = $service->fetch(1);

			// return Json::show($data);
			

			/*
			$key = 'JTSOAERP';
			$iv = '';
			$str = '{"data":{"customerso":"aa22","customerorder":"abc11"},"detailDataList":[{"customeritem":"6","item":"ea4e1229d5c44bf7974a55dccd6dbf76"}]}';

			$data = [
				"data" => [
					"customerso" => "aa22",
					"customerorder" => "abc11"
				],
				"detailDataList" => [
					[
						"customeritem" => "6",
						"item" => "ea4e1229d5c44bf7974a55dccd6dbf76"
					]
				]
			];

			// array_count_values(array_column($arr,'is_reg'))[0];

			$service = new Des($key);
			$result = $service->encrypt(json_encode($data));
			$tt = $result == $res ? 'ok' : 'no';
			return response('result: '.$result.' tt: '.$tt);
			*/
		}

		private function splitStr($str){
	        $str = explode('&',$str);
	        $temp = array();
	        foreach($str as $val){
	            $s = explode('=',$val);
	            $temp[$s[0]] = $s[1];
	        }
	        return $temp;
	    }

	    public function query(Request $request){
	    	$sql = "ALTER TABLE hrang_goods modify OddsRate float(5,2) not null default '100' comment '中奖概率'";
	    	$result = Db::select($sql);

	    	if($result !== false){
	    		return Json::show(['msg'=>'ok']);
	    	}else{
	    		return Json::show(['msg'=>'fail']);
	    	}
	    }

		public function show(){
			// $args = func_get_args();
			// $str = MD5(implode('_',$args));
			// var_dump('str: '.$str);
		}

		protected function colation($str){
            $arr = [" ","#","!","~","!","$","%","^","&","*","(",")","\\","\/","<",">","`"];
            foreach($arr as $val){
                $str = str_replace($val,"",$str);
            }
            return $str;
        }

        private function verify($plainText, $sign){
	        $resource = openssl_pkey_get_public($this->publicKey());
		    $result   = openssl_verify($plainText, base64_decode($sign), $resource);
		    if(PHP_VERSION_ID < 80000){
		    	openssl_free_key($resource);
		    }
		    var_dump('校验结果===========');
		    var_dump($result);
	    }

	    private function publicKey(){
	        try {
	            $file = file_get_contents('/www/wwwroot/huanrang/cert/sande.cer');
	            if (!$file) {
	                throw new \Exception('getPublicKey::file_get_contents ERROR');
	            }
	            $cert   = chunk_split(base64_encode($file), 64, "\n");
	            var_dump($cert);
	            $cert   = "-----BEGIN CERTIFICATE-----\n" . $cert . "-----END CERTIFICATE-----\n";
	            $res    = openssl_pkey_get_public($cert);
	            $detail = openssl_pkey_get_details($res);
	            if(PHP_VERSION_ID < 80000){
		            openssl_free_key($res);
		        }
	            if (!$detail) {
	                throw new \Exception('getPublicKey::openssl_pkey_get_details ERROR');
	            }
	            return $detail['key'];
	        } catch (\Exception $e) {
	            throw $e;
	        }
	    }
	}
?>