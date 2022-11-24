<?php
	namespace app\controller\Api\Sande;

	use support\Request;
	use app\lib\Json;
	use app\model\Api\Sande\SandeModel;

	class Sande{
		private $url = 'https://m.huanrang.art/';
		/**
		 * 用户中心
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function index(Request $request){
			$service = new SandeModel();
			$url = $service->getAccountUrl($request);
			return redirect($url);
		}

		/**
		 * 获取支付链接
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function pay(Request $request){
			$service = new SandeModel();
			$result = $service->test($request);
			// var_dump($result);
			return Json::show(['url' => $result]);
		}

		/**
		 * H5快捷支付
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function test(Request $request){
			$service = new SandeModel();
			$result = $service->test($request);

			return redirect($result);
		}

		/**
		 * H5快捷充值
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function charge(Request $request){
			$service = new SandeModel();
			$result = $service->charge($request);

			return Json::show(['url' => $result]);
		}

		/**
		 * H5一键快捷
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function payment(Request $request){
			$service = new SandeModel();
			$result = $service->payment($request);

			return Json::show(['url' => $result]);
		}

		/**
		 * 查询账户余额
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function balance(Request $request){
			$service = new SandeModel();
			$result = $service->getUserBalance($request);
			return Json::show($result);
		}

		/**
		 * [ctob description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function ctob(Request $request){
			$service = new SandeModel();
			$url = $service->getCtobUrl($request);
			return redirect($url);
		}

		/**
		 * [ctoc description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function ctoc(Request $request){
			$service = new SandeModel();
			$url = $service->getCtocUrl($request);
			return redirect($url);
		}

		/**
		 * 支付回调
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function notify(Request $request){
			$service = new SandeModel();
			$result = $service->setNotify($request);
			return $result;
		}

		/**
		 * 开户回调
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function account(Request $request){
			// var_dump('sande account notify begin');
			$service = new SandeModel();
			$result = $service->setAccount($request);
			return $result;
		}

		/**
		 * 成功返回
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
	    public function success(Request $request){
	    	$uid = $request->input('uid');
		    $order = $request->input('order');
		    if(empty($uid) || !is_numeric($uid) || !$uid){
		    	$uid = 0;
		    }
		    if(empty($order) || !is_numeric($order) || !$order){
		    	$order = 0;
		    }
	        $url = $this->url . "#/pages/order/success?uid={$uid}&order={$order}";
	        return redirect($url);
	    }
	}
?>