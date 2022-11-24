<?php
	namespace app\controller\Goods;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Goods\GoodsCateModel;

	class GoodsCate extends Controller{
		protected $table = 'GoodsCate';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new GoodsCateModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new GoodsCateModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		/**
		 * [show description]
		 * @param Request $request [description]
		 */
		public function show(Request $request){
			$service = new GoodsCateModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		/**
		 * [list description]
		 * @param Request $request [description]
		 */
		public function list(Request $request){
			$service = new GoodsCateModel();
			$result = $service->getList($request,'list');
			return Json::show($result);
		}

		/**
		 * [add description]
		 * @param Request $request [description]
		 */
		public function add(Request $request){
			$service = new GoodsCateModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		/**
		 * [mod description]
		 * @param Request $request [description]
		 */
		public function mod(Request $request){
			$service = new GoodsCateModel();
			$result = $service->mod($request);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new GoodsCateModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new GoodsCateModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		/**
		 * [del description]
		 * @param Request $request [description]
		 */
		public function del(Request $request){
			$service = new GoodsCateModel();
			$result = $service->del($request);
			return Json::show($result);
		}

		/**
		 * [remove description]
		 * @param Request $request [description]
		 */
		public function remove(Request $request){
			$service = new GoodsCateModel();
			$result = $service->remove($request);
			return Json::show($result);
		}

		/**
		 * [clear description]
		 * @param Request $request [description]
		 */
		public function clear(Request $request){
			$service = new GoodsCateModel();
			$result = $service->clear($request);
			if($result){
				return Json::show(0,'数据清空成功');
			}
			return Json::show(1,'数据清空失败');
		}

		public function map(Request $request){
			$service = new GoodsCateModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>