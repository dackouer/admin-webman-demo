<?php
	namespace app\model\Api\Sande;

	use support\Request;
	use app\model\User\UserModel;
	use app\model\User\UserPriorityModel;
	use app\model\Order\OrderModel;
	use app\model\Order\ConfigOrderModel;
	use app\model\Goods\GoodsModel;

	class SandeModel{
		// private $mcid = '6888804044635';
		// private $merkey = 'AnZdTlM7CG/aAsivnO8uhdTDCNukb6mccZBj5k3HHNmgTRF6ShSj3JW63BbkvE0vwYtbuymLcv0=';
		// private $md5key = 'JaXl3/64V1zpWgGSguYCt7VugSw1d7/N06zQaQtr2X4/El0DwhvkJDpVjGa8l+hCi0NroWofPYD2Z+eXRwMCLm0q9R0S5swDv5QVBYLjaWRpQYgK20NGiZs6/zUwL70bWZoZDNU5yDNixuz+UKFTiw==';

		
		private $mcname = '天雄星（北京）影视科技有限公司';
		private $mcid = '6888804052380';
		private $merkey = 'm2h9HiSuKj62S/jvbopwdbeyYrMeTwQVaKb0MWEjlkL/hE4mHC92oP3hxnNriJHOZTc7VQwbpnM=';
		private $md5key = 'POzSjYD21MmnGbv3puUbBMtint1wB2FacShdpyiZpTxnJuMQeZBVywjNmYvDIZGfJxgHrCCfy6poo+2Ql3GfgbkYHMPZDCKwMN8GkJOGBAlJAxZYTv5t3M4sGzEIANRFtOUpsbpN8Oxixuz+UKFTiw==';
		private $host = 'https://127.0.0.1:8088/';
		private $url = 'https://m.huanrang.art/';
		private $notify_url = 'https://api.huanrang.art/sande/notify';
		private $account_url = 'https://api.huanrang.art/sande/account';
		private $return_url = 'https://api.huanrang.art/sande/success';

		/**
		 * H5快捷支付
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function test(Request $request){
			$order = $request->input('order');
			// if(empty($order)){
			// 	return 100007;
			// }

			$data = [
	            'version' => 10,
	            'mer_no' =>  $this->mcid, //商户号
	            'mer_key' => $this->merkey, // 商户私钥通过安卓APK工具解析出来的KEY1
	            'mer_order_no' => $order.time(), //商户唯一订单号
	            'create_time' => date('YmdHis'),
	            'expire_time' => date('YmdHis', time()+30*60),
	            'order_amt' => '0.01', //订单支付金额
	            'notify_url' => $this->notify_url, //订单支付异步通知
	            'return_url' => $this->return_url, //订单前端页面跳转地址
	            'create_ip' => "172_12_12_2",
	            'goods_name' => '测试',
	            'store_id' => '000000',
	            'product_code' => '02020002', // 产品编码: 云函数h5：02010006；支付宝H5：02020002；微信公众号H5：02010002；
	 //一键快捷：05030001；H5快捷：06030001；支付宝扫码：02020005  ；快捷充值：  06030003; 
	 //电子钱包【云账户】：开通账户并支付product_code应为：04010001；消费（C2C）product_code 为：04010003 ; 我的账户页面 product_code 为：00000001
	            'clear_cycle' => '3',
	            'pay_extra' => json_encode(["resourceAppid"=>"wx8c5f56c4c0596","resourceEnv"=>"oC6rSXbjjf-qqosKyWHola7Ow"]),//resourceAppid：小程序 AppID ;resourceEnv：云开发环境 ID，云函数所需参数，如不清楚请商户群里详问杉德联调人员
	            'accsplit_flag' => 'NO',
	            'jump_scheme' => 'sandcash://scpay',
	            'meta_option' => json_encode([["s" => "Android","n" => "wxDemo","id" => "com.pay.paytypetest","sc" => "com.pay.paytypetest"]]),
	            'sign_type' => 'MD5'
	           
	        ];
	        $temp = $data;
	        unset($temp['goods_name']);
	        unset($temp['jump_scheme']);
	        unset($temp['expire_time']);
	        unset($temp['product_code']);
	        unset($temp['clear_cycle']);
	        unset($temp['meta_option']);
	        
	        file_put_contents('log.txt', date('Y-m-d H:i:s', time()) . " 签名串:" . $this->getSignContent($temp)."&key=".$this->md5key . "\r\n", FILE_APPEND); // key对应商户私钥通过安卓APK工具解析出来的MD5KEY

	        $sign = strtoupper(md5($this->getSignContent($temp)."&key=".$this->md5key));  // key对应商户私钥通过安卓APK工具解析出来的MD5KEY
	        $data['sign'] = $sign;
	        
	        $query = http_build_query($data);
	        // var_dump($query);
	        $payurl = "https://sandcash.mixienet.com.cn/pay/h5/alipay?".$query;  //          云函数h5：applet；支付宝H5：alipay；微信公众号H5：wechatpay； //一键快捷：fastpayment；H5快捷：unionpayh5；支付宝扫码：alipaycode  ;快捷充值：quicktopup ；电子钱包【云账户】：cloud
	        return $payurl; // 返回支付url
		}

		/**
		 * H5快捷充值
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function charge(Request $request){
			$uid = $request->input('uid');
			$order = $request->input('order');
			$data = [
	            'version' => 10,
	            'mer_no' =>  $this->mcid, //商户号
	            'mer_key' => $this->merkey, // 商户私钥通过安卓APK工具解析出来的KEY1
	            'mer_order_no' => $order.time(), //商户唯一订单号
	            'create_time' => date('YmdHis'),
	            'expire_time' => date('YmdHis', time()+30*60),
	            'order_amt' => '0.1', //订单支付金额
	            'notify_url' => $this->notify_url, //订单支付异步通知
	            'return_url' => $this->return_url, //订单前端页面跳转地址
	            'create_ip' => "172_12_12_2",
	            'goods_name' => '测试充值',
	            'store_id' => '000000',
	            'product_code' => '06030003', // 产品编码: 云函数h5：02010006；支付宝H5：02020002；微信公众号H5：02010002；
	 //一键快捷：05030001；H5快捷：06030001；支付宝扫码：02020005  ；快捷充值：  06030003; 
	 //电子钱包【云账户】：开通账户并支付product_code应为：04010001；消费（C2C）product_code 为：04010003 ; 我的账户页面 product_code 为：00000001
	            'clear_cycle' => '3',
	            'pay_extra' => json_encode(["userId"=>"{$uid}","userName"=>"sd","idCard"=>"4562215485"]),//resourceAppid：小程序 AppID ;resourceEnv：云开发环境 ID，云函数所需参数，如不清楚请商户群里详问杉德联调人员
	            'accsplit_flag' => 'NO',
	            'jump_scheme' => 'sandcash://scpay',
	            'meta_option' => json_encode([["s" => "Android","n" => "wxDemo","id" => "com.pay.paytypetest","sc" => "com.pay.paytypetest"]]),
	            'sign_type' => 'MD5'
	           
	        ];
	        $temp = $data;
	        unset($temp['goods_name']);
	        unset($temp['jump_scheme']);
	        unset($temp['expire_time']);
	        unset($temp['product_code']);
	        unset($temp['clear_cycle']);
	        unset($temp['meta_option']);
	        
	        file_put_contents('log.txt', date('Y-m-d H:i:s', time()) . " 签名串:" . $this->getSignContent($temp)."&key=".$this->md5key . "\r\n", FILE_APPEND); // key对应商户私钥通过安卓APK工具解析出来的MD5KEY

	        $sign = strtoupper(md5($this->getSignContent($temp)."&key=".$this->md5key));  // key对应商户私钥通过安卓APK工具解析出来的MD5KEY
	        $data['sign'] = $sign;
	        
	        $query = http_build_query($data);
	        $url = "https://sandcash.mixienet.com.cn/pay/h5/quicktopup?".$query;
			return $url;
		}

		/**
		 * H5一键快捷
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function payment(Request $request){
			$uid = $request->input('uid');
			$order = $request->input('order');
			$platform = $request->input('platform');
			$pay_type = $request->input('pay_type');
			$amount = $request->input('amount');

			// var_dump('uid: '.$uid);
			// var_dump('order: '.$order);
			// var_dump('platform: '.$platform);
			// var_dump('pay_type: '.$pay_type);
			// var_dump('amount: '.$amount);

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			if(empty($order)){
				return 100007;
			}

			if(empty($platform) || empty($pay_type)){
				return 100007;
			}

			if($platform != 'sande' || $pay_type != 'h5'){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);

			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}


			$service = new OrderModel();
			$resp = $service->getList($request,$order);

			if(!$resp){
				return 100007;
			}

			if($resp['uid'] != $uid){
				return 100007;
			}

			if($resp['status'] == 2){
				return 100836;
			}

			if($resp['status'] == -1){
				return 100830;
			}

			if($resp['status'] != 1){
				return 100834;
			}

			if($amount * 100 != $resp['amount']){
				return 100007;
			}

			if(!in_array($resp['type'],[1,2])){
				return 100833;
			}

			$goods_id = isset($resp['goods_id']) ? $resp['goods_id'] : 0;
			if(!$goods_id){
				return 100833;
			}

			$service = new GoodsModel();
			$goods = $service->getList($request,$goods_id);


			if(!$goods){
				return 100810;
			}
			
			// if(!in_array($goods_id,explode(',',$collection['goods']))){
			// 	return 100811;
			// }

			if($goods['status'] != 1){
				return 100812;
			}

			if($goods['price'] * $resp['goods']['quantity'] != $resp['amount']){
				return 100821;
			}

			$service = new UserPriorityModel();
			$priority = $service->getList($request,'priority',$uid,$goods_id);
			if(!$priority){
				if(strtotime($goods['start_time']) > time()){
					return 100803;
				}
			}else{
				if((strtotime($goods['start_time']) - $priority['priority_time'] * 3600) > time()){
					return 100803;
				}
			}

			if(strtotime($goods['end_time']) < time()){
				return 100804;
			}

			if($goods['stock'] > 0 && $goods['sales'] >= $goods['stock']){
				return 100813;
			}

			if($goods['limit_count']){
				$service = new OrderModel();
				$number = $service->getGoodsOrderByUser($goods_id,$uid,$resp['type']);
				if($number >= $goods['limit_count']){
					return 100814;
				}
			}

			if($goods['limit_order']){
				$service = new OrderModel();
				$number = $service->getGoodsOrderByUser($goods_id,$uid,$resp['type']);
				if($number >= $goods['limit_order']){
					return 100815;
				}
			}

			$service = new ConfigOrderModel();
			$config_order = $service->fetch(1);

			if($config_order['IsTestPay']){
				$amount = $config_order['TestPayFee'] * 100;
			}else{
				$amount = $resp['amount'];
			}

			$amount = $amount / 100;

			if($amount <= 0.1){
				return 100858;
			}

			$title = $resp['goods']['goods_title'];
			$ip = $request->getRealIp($safe_mode=true);
			$ip = str_replace(".","_",$ip);

			$data = [
	            'version' => 10,
	            'mer_no' =>  $this->mcid, //商户号
	            'mer_key' => $this->merkey, // 商户私钥通过安卓APK工具解析出来的KEY1
	            'mer_order_no' => $order.time(), //商户唯一订单号
	            'create_time' => date('YmdHis'),
	            'expire_time' => date('YmdHis', time()+30*60),
	            'order_amt' => $amount, //订单支付金额
	            'notify_url' => $this->notify_url, //订单支付异步通知
	            'return_url' => $this->return_url."?uid={$uid}&order={$order}", //订单前端页面跳转地址
	            'create_ip' => $ip,
	            'goods_name' => $title,
	            'store_id' => '000000',
	            'product_code' => '05030001', // 产品编码: 云函数h5：02010006；支付宝H5：02020002；微信公众号H5：02010002；
	 //一键快捷：05030001；H5快捷：06030001；支付宝扫码：02020005  ；快捷充值：  06030003; 
	 //电子钱包【云账户】：开通账户并支付product_code应为：04010001；消费（C2C）product_code 为：04010003 ; 我的账户页面 product_code 为：00000001
	            'clear_cycle' => '3',
	            'pay_extra' => json_encode(["userId"=>"{$uid}"]),//resourceAppid：小程序 AppID ;resourceEnv：云开发环境 ID，云函数所需参数，如不清楚请商户群里详问杉德联调人员
	            'accsplit_flag' => 'NO',
	            'jump_scheme' => 'sandcash://scpay',
	            'meta_option' => json_encode([["s" => "Android","n" => "wxDemo","id" => "com.pay.paytypetest","sc" => "com.pay.paytypetest"]]),
	            'sign_type' => 'MD5'
	           
	        ];
	        $temp = $data;
	        unset($temp['goods_name']);
	        unset($temp['jump_scheme']);
	        unset($temp['expire_time']);
	        unset($temp['product_code']);
	        unset($temp['clear_cycle']);
	        unset($temp['meta_option']);
	        
	        file_put_contents('log.txt', date('Y-m-d H:i:s', time()) . " 签名串:" . $this->getSignContent($temp)."&key=".$this->md5key . "\r\n", FILE_APPEND); // key对应商户私钥通过安卓APK工具解析出来的MD5KEY

	        $sign = strtoupper(md5($this->getSignContent($temp)."&key=".$this->md5key));  // key对应商户私钥通过安卓APK工具解析出来的MD5KEY
	        $data['sign'] = $sign;
	        
	        $query = http_build_query($data);

			$url = "https://sandcash.mixienet.com.cn/pay/h5/fastpayment?".$query;
			return $url;
		}

		/**
		 * 生成用户中心地址
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function getAccountUrl(Request $request){
	    	$uid = $request->input('uid');
	        if(empty($uid)){
	            return 110600;
	        }

	        $service = new UserModel();
	        $user = $service->getList($request,$uid);
	        if(!$user){
	            return 110802;
	        }

	        if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
	        	return 100007;
	        }

	        $data = [
	            'jumpType'  => 1,
	            'createIp'  => $request->getRealIp($safe_mode = true),
	            'goodsName' => '幻壤用户中心',
	            'orderNo'   => Random::create(18),
	            'orderAmt'  => '0',
	            'returnUrl' => 'https://m.huanrang.art',
	            'userId'    => $uid,
	            'nickName'  => $user['realname'],
	            'userFeeAmt'=> 0
	        ];

	        $url = $this->host . 'pay/jumpUrl';
	        $res = $this->curlPost($url,$data);
	        
	        return $res;
		}

		/**
		 * 获取用户余额
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function getUserBalance(Request $request){
			$uid = $request->input('uid');
	        if(empty($uid)){
	            return 110600;
	        }

	        $service = new UserModel();
	        $user = $service->getList($request,$uid);
	        if(!$user){
	            return 110802;
	        }

	        if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
	        	return 100007;
	        }

	        $data = [
	            'accountType'  => '01',
	            'orderNo'   => Random::create(18),
	            'userId'    => $uid
	        ];

	        $url = $this->host . 'pay/queryAccountBalance';
	        $res = $this->curlPost($url,$data);
	        var_dump($res);
	        return $res;
		}

		/**
		 * 获取C2B地址
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function getCtobUrl(Request $request){
			$uid = $request->input('uid');
			$order = $request->input('order');
			$token = $request->input('token');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 110301;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);

			// if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
			// 	return 110301;
			// }

	        if(empty($order) || empty($token)){
	            return 110301;
	        }

	        $service = new OrderModel();
	        $result = $service->getList($request,$order);
	        if(!$result){
	            return 110302;
	        }
	        if($result['Status'] == 2){
	            return 110303;
	        }
	        if($result['Status'] == -1){
	            return 110304;
	        }
	        if($result['Status'] != 1){
	            return 110307;
	        }

	        // $ress = $service->getList('market',$result['MarketCode']);
	        // if($ress){
	        //     return 110765;
	        // }

	        $uid = $result['UserID'];
	        $realname = $result['RealName'];
	        $recieve = $result['SourceUserID'];
	        $accsplit = $result['AccsplitValue'];
	        $amount = $result['TotalFee'];

	        $type = $result['OrderType'];
	        if(!in_array($type,[0,1,5,6])){
	            return 110307;
	        }

	        if(isset($result['goods'][0]['Price'])){
	            if(!$result['goods'][0]['Price']){
	                return 110307;
	            }
	            if($amount != $result['goods'][0]['Price']){
	                return 110307;
	            }
	        }

	        // var_dump('C2C的订单金额和手续费：');
	        // var_dump('amount: '.$amount);
	        // var_dump('accsplit: '.$accsplit);

	        if(isset($result['goods']) && isset($result['goods'][0]['GoodsTitle'])){
	            $goods = $result['goods'][0]['GoodsTitle'];
	        }else{
	            $goods = $result['MarketTitle'];
	        }

	        $data = [
	            'jumpType'       => 2,
	            'createIp'       => $request->getRealIp($safe_mode = true),
	            'goodsName'      => $goods,
	            'orderNo'        => $order,
	            'orderAmt'       => $amount,
	            'returnUrl'      => $this->return_url.'?order='.$order,
	            'userId'         => $uid,
	            'nickName'       => $realname,
	            'recieveUserId'  => $recieve,
	            'userFeeAmt'     => 0
	        ];
	        // var_dump('c2c支付参数：');
	        // var_dump($data);

	        $url = $this->host . 'pay/jumpUrl';
	        $res = $this->curlPost($url,$data);
	        // var_dump($res);
	        Log::info('SANDE-C2C: '.json_encode($res));

	        return $res;
		}

		/**
		 * 获取C2C地址
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function getCtocUrl(Request $request){
			$uid = $request->input('uid');
			$order = $request->input('order');
			$token = $request->input('token');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 110301;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);

			// if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
			// 	return 110301;
			// }

	        if(empty($order) || empty($token)){
	            return 110301;
	        }

	        $service = new OrderModel();
	        $result = $service->getList($request,$order);
	        if(!$result){
	            return 110302;
	        }
	        if($result['Status'] == 2){
	            return 110303;
	        }
	        if($result['Status'] == -1){
	            return 110304;
	        }
	        if($result['Status'] != 1){
	            return 110307;
	        }

	        // $ress = $service->getList('market',$result['MarketCode']);
	        // if($ress){
	        //     return 110765;
	        // }

	        $uid = $result['UserID'];
	        $realname = $result['RealName'];
	        $recieve = $result['SourceUserID'];
	        $accsplit = $result['AccsplitValue'];
	        $amount = $result['TotalFee'];

	        $type = $result['OrderType'];
	        if(!in_array($type,[0,1,5,6])){
	            return 110307;
	        }

	        if(isset($result['goods'][0]['Price'])){
	            if(!$result['goods'][0]['Price']){
	                return 110307;
	            }
	            if($amount != $result['goods'][0]['Price']){
	                return 110307;
	            }
	        }

	        // var_dump('C2C的订单金额和手续费：');
	        // var_dump('amount: '.$amount);
	        // var_dump('accsplit: '.$accsplit);

	        if(isset($result['goods']) && isset($result['goods'][0]['GoodsTitle'])){
	            $goods = $result['goods'][0]['GoodsTitle'];
	        }else{
	            $goods = $result['MarketTitle'];
	        }

	        $data = [
	            'jumpType'       => 2,
	            'createIp'       => $request->getRealIp($safe_mode = true),
	            'goodsName'      => $goods,
	            'orderNo'        => $order,
	            'orderAmt'       => $amount,
	            'returnUrl'      => $this->return_url.'?order='.$order,
	            'userId'         => $uid,
	            'nickName'       => $realname,
	            'recieveUserId'  => $recieve,
	            'userFeeAmt'     => 0
	        ];
	        // var_dump('c2c支付参数：');
	        // var_dump($data);

	        $url = $this->host . 'pay/jumpUrl';
	        $res = $this->curlPost($url,$data);
	        // var_dump($res);
	        Log::info('SANDE-C2C: '.json_encode($res));

	        return $res;
		}

		/**
		 * 支付回调
		 * @param Request $request [description]
		 */
		public function setNotify(Request $request){
			// var_dump('sande notify begin');
			$data = $this->splitStr($request->rawBody());
			// var_dump($data);
			
			// 核验签名
			// if(!$this->verify($data['data'], $data['sign'])){
			// 		return false;
			// }

			$data = json_decode(urldecode($data['data']),true);
			// var_dump($data);
			// H5一键快捷支付
			if(isset($data['head']['respCode']) && $data['head']['respCode'] == '000000' && isset($data['body']['orderStatus']) && $data['body']['orderStatus'] == '1' && isset($data['body']['mid']) && $data['body']['mid'] == '6888804052380'){
				// var_dump('check success');
				$service = new OrderModel();
				return $service->updatePayment($request,$data['body']);
			}
	        
			/*
	        $post = $this->splitStr($request->rawBody());
	        $data = json_decode(urldecode($post['data']),true);
	        $sign = $post['sign'];
	        // var_dump('收到杉德的支付回调数据：');
	        // var_dump($data);
	        
	        // var_dump('签名校验成功');
	        if(isset($data['transType']) && $data['transType'] == 'C2C_TRANSFER'){
	            // c2c
	            // var_dump('C2C支付:');
	            if($data['orderStatus'] == '00' && $data['respCode'] == '00000'){
	                // var_dump('验证回调信息');
	                // 支付成功
	                $mid = $data['mid'];
	                $order = $data['orderNo'];
	                $amount = $data['amount'];

	                $service = new SandeModel();
	                // var_dump('验证mid');
	                if($service->checkMid($mid)){
	                    $service = new Order();
	                    $res = $service->getList('order',$order);
	                    // var_dump('处理订单: '.$order);
	                    if($res){
	                        // var_dump($res);
	                        if($res['Status'] != 1){
	                            // var_dump('状态不为1，直接返回，回调完成');
	                            return true;
	                        }
	                        if($res['OrderCode'] == $order){
	                            if($service->setStatus($order,2,'c2c',$amount,'','sande')){
	                                // var_dump('订单处理成功,回调完成');
	                                return true;
	                            }
	                        }
	                    }else{
	                        // var_dump('订单信息查询失败');
	                    }
	                }
	            }else{
	                // var_dump('未支付');
	            }
	            return false;
	        }else{
	            // var_dump('C2B支付:');
	            $data = $data['body'];
	            if((int)$data['orderStatus'] === 1 || $data['orderStatus'] === '1'){
	                // var_dump('验证回调信息');
	                // 支付成功
	                $mid = $data['mid'];
	                $order = $data['orderCode'];
	                $amount = $data['totalAmount'];

	                $service = new SandeModel();
	                // var_dump('验证mid');
	                if($service->checkMid($mid)){
	                    $service = new Order();
	                    $res = $service->getList('order',$order);
	                    // var_dump('处理订单: '.$order);
	                    if($res){
	                        // var_dump($res);
	                        if($res['Status'] != 1){
	                            // var_dump('状态不为1，直接返回，回调完成');
	                            return true;
	                        }
	                        if($res['OrderCode'] == $order){
	                            if($service->setStatus($order,2,'c2b',$amount,'','sande')){
	                                // var_dump('订单处理成功,回调完成');
	                                return true;
	                            }
	                        }
	                    }else{
	                        // var_dump('订单信息查询失败');
	                    }
	                }
	            }else{
	                // var_dump('未支付');
	            }
	        }
	       */
	        return false;
		}

		/**
		 * 开户回调
		 * @param Request $request [description]
		 */
		public function setAccount(Request $request){
			// var_dump('收到杉德的开户回调：');

	        $post = $this->splitStr($request->rawBody());
	        $data = json_decode(urldecode($post['data']),true);
	        $sign = $post['sign'];
	        // var_dump('收到杉德的开户回调数据：');
	        // var_dump($data);
	        
	        if($data['respCode'] == '00000' && $data['signProtocolInfo'][0]['signStatus'] == '01'){
	            // var_dump('签名校验成功');
	            $service = new User();
	            $service->setSandeAccount($data['bizUserNo']);
	            return true;
	        }
	        // var_dump('签名校验失败');
	        return false;
		}

		// 获取签名
		private function getSignContent($params) {
	        ksort($params);
	    
	        $stringToBeSigned = "";
	        $i = 0;
	        foreach ($params as $k => $v) {
	            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
	    
	                if ($i == 0) {
	                    $stringToBeSigned .= "$k" . "=" . "$v";
	                } else {
	                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
	                }
	                $i++;
	            }
	        }
	    
	        unset ($k, $v);
	        return $stringToBeSigned;
	    }
	    
	    // 检查
	    private function checkEmpty($value){
	        if (!isset($value))
	            return true;
	        if ($value === null)
	            return true;
	        if (trim($value) === "")
	            return true;

	        return false;
	    }

	    private function verify($plainText, $sign){
	        $resource = openssl_pkey_get_public($this->publicKey());
		    $result   = openssl_verify($plainText, base64_decode($sign), $resource);
		    openssl_free_key($resource);
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
	            $cert   = "-----BEGIN CERTIFICATE-----\n" . $cert . "-----END CERTIFICATE-----\n";
	            $res    = openssl_pkey_get_public($cert);
	            $detail = openssl_pkey_get_details($res);
	            openssl_free_key($res);
	            if (!$detail) {
	                throw new \Exception('getPublicKey::openssl_pkey_get_details ERROR');
	            }
	            return $detail['key'];
	        } catch (\Exception $e) {
	            throw $e;
	        }
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