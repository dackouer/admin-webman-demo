<?php
	namespace app\controller\Api\Avata;

	use support\Request;
	use app\lib\Json;

	use app\model\Api\Avata\AvataModel;
	use app\model\Api\Avata\ApiClient;
	use app\model\User\UserModel;

	class Avata{
		public function index(Request $request){

		}

		/**
		 * 创建链账户
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function create(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->create($request);
			return Json::show($result);
		}

		/**
		 * 批量创建链账户
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function batch_create(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->batch_create($request);
			return Json::show($result);
		}

		/**
		 * 查询链账户
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function account(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->account($request);
			return Json::show($result);
		}

		/**
		 * 查询链账户操作记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function account_record(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->account_record($request);
			return Json::show($result);
		}

		/**
		 * 查询交易记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function transaction(Request $request,$operation_id = 0){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->getTransaction($request,$operation_id);
			return Json::show($result);
		}

		/**
		 * 创建NFT类别
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function create_cate(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->create_cate($request);
			return Json::show($result);
		}

		/**
		 * 查询NFT类别
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function get_cate(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->get_cate($request);
			return Json::show($result);
		}

		/**
		 * 发行 NFT
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function issue(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->issue($request);
			return Json::show($result);
		}

		/**
		 * 转让 NFT
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function transfer(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->transfer($request);
			return Json::show($result);
		}

		/**
		 * 编辑 NFT
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function edit(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->edit($request);
			return Json::show($result);
		}

		/**
		 * 销毁 NFT
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function destroy(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->destroy($request);
			return Json::show($result);
		}

		/**
		 * 查询 NFT
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function get_issue(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);;
			}
			$service = new ApiClient();
			$result = $service->get_issue($request);
			return Json::show($result);
		}

		/**
		 * 查询 NFT 详情
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function detail(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);
			}
			$service = new ApiClient();
			$result = $service->detail($request);
			return Json::show($result);
		}

		/**
		 * DDC充值 购买能量值/业务费
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function order(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);
			}
			$service = new ApiClient();
			$result = $service->order($request);
			return Json::show($result);
		}

		/**
		 * 查询能量值/业务费充值列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function charges(Request $request){
			if(!$this->checkToken($request)){
				return Json::show(100011);
			}
			$service = new ApiClient();
			$result = $service->charges($request);
			return Json::show($result);
		}

		/**
		 * 查询能量值/业务费购买结果
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function charge(Request $request,$order = null){
			if(is_null($order) || empty($order)){
				return 100007;
			}
			if(!$this->checkToken($request)){
				return Json::show(100011);
			}
			$service = new ApiClient();
			$result = $service->charge($request,$order);
			return Json::show($result);
		}

        /**
         * [checkToken description]
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        private function checkToken(Request $request){
            $service = new UserModel();
            if($service->checkToken($request)){
            	return true;
            }
            return false;
        }
	}
?>