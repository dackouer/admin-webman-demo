<?php
	namespace app\controller\Order;

	use support\Request;
	use support\Redis;
	use support\Log;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Order\OrderModel;

	class Order extends Controller{
		protected $table = 'Order';
		
		public function index(Request $request,$order = 0){
			if($order){
				$service = new OrderModel();
				$result = $service->getList($request,$order);
			}else{
				$service = new OrderModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function test(Request $request){
			$service = new OrderModel();
			$result = $service->test($request);

			return response('code: '.$result);
		}

		/**
		 * 导出
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function export(Request $request){
			$service = new OrderModel();
			$result = $service->getList($request,'export');
			return Json::show($result);
		}

		/**
		 * 获取用户的订单列表
		 * @param  Request $request [description]
		 * @param  integer $uid     [description]
		 * @return [type]           [description]
		 */
		public function personal(Request $request,$uid = 0,$status = ''){
			$service = new OrderModel();
			$result = $service->getList($request,'personal',$uid,$status);
			return Json::show($result);
		}

		/**
		 * 获取用户的订单信息
		 * @param  Request $request [description]
		 * @param  integer $uid     [description]
		 * @return [type]           [description]
		 */
		public function user(Request $request){
			$service = new OrderModel();
			$result = $service->getList($request,'user');
			return Json::show($result);
		}

		/**
		 * [pay description]
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function pay(Request $request){
			$service = new OrderModel();
			$result = $service->pay($request);

			return Json::show($result);
		}

		/**
		 * 开盲盒
		 * @param Request $request [description]
		 */
		public function open(Request $request){
			$service = new OrderModel();
			$result = $service->openBlind($request);

			return Json::show($result);
		}

		/**
		 * 转赠
		 * @param Request $request [description]
		 */
		public function send(Request $request){
			$service = new OrderModel();
			$result = $service->setSend($request);

			return Json::show($result);
		}

		/**
		 * 获取转赠记录
		 * @param Request $request [description]
		 */
		public function transfer(Request $request){
			$service = new OrderModel();
			$result = $service->getList($request,'transfer');

			return Json::show($result);
		}

		/**
		 * 出售
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function sale(Request $request){
			$service = new OrderModel();
			$result = $service->setSale($request);
			
			return Json::show($result);
		}

		/**
		 * 取消出售
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function cancel_sale(Request $request){
			$service = new OrderModel();
			$result = $service->setCancelSale($request);
			
			return Json::show($result);
		}

		/**
		 * 支付回调
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function notify(Request $request){
			// var_dump('开始处理回调');
			$service = new OrderModel();
			return $service->setNotify($request);

			// return Json::show($data);
		}

		/**
		 * 退单
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function refund(Request $request){
			$service = new OrderModel();
			$result = $service->setRefund($request);
			
			if(is_array($result)){
				if(isset($result['num']) && $result['num'] > 0){
					return json_encode(['code' => 0,'msg' => 'success','data' => $result]);
				}
				return json_encode(['code' => 1,'msg' => 'fail','data' => $result]);
			}else{
				return Json::show($result);
			}
		}

		/**
		 * 获取订单状态数量
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function count(Request $request,$uid = 0){
			$service = new OrderModel();
			$result = $service->getList($request,'count',$uid);
			
			return Json::show($result);
		}

		/**
		 * 取消订单
		 * @param Request $request [description]
		 */
		public function cancel(Request $request){
			$service = new OrderModel();
			$result = $service->cancel($request);
			return Json::show($result);
		}

		/**
		 * 手动上链
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function mchain(Request $request,$order = 0){
			$service = new OrderModel();
			$result = $service->handChain($request,$order);
			if(isset($result['code']) && $result['code'] == 'fail'){
				return Json::show(1,$result['msg']);
			}
			return Json::show($result);
		}

		/**
		 * 手动获取链地址
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function schain(Request $request,$operation_id = ''){
			$service = new OrderModel();
			$result = $service->getChainByOperationID($request,$operation_id);
			return Json::show($result);
		}

		/**
		 * 手动回调
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function mnotify(Request $request,$order = 0){
			$service = new OrderModel();
			$result = $service->handNotify($request,$order);
			return Json::show($result);
		}

		/**
		 * 锁单
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function mlock(Request $request,$order = 0){
			$service = new OrderModel();
			$result = $service->handLock($request,$order);
			return Json::show($result);
		}

		/**
		 * 恢复锁单
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function unlock(Request $request,$order = 0){
			$service = new OrderModel();
			$result = $service->handUnLock($request,$order);
			return Json::show($result);
		}

		/**
		 * 空投
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function airdrop(Request $request){
			$service = new OrderModel();
			$result = $service->handAirdrop($request);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new OrderModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new OrderModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new OrderModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>