<?php
	namespace app\controller\Goods;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Goods\GoodsTagsModel;

	class GoodsTags extends Controller{
		protected $table = 'GoodsTags';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new GoodsTagsModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new GoodsTagsModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		/**
		 * [show description]
		 * @param Request $request [description]
		 */
		public function show(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		/**
		 * [list description]
		 * @param Request $request [description]
		 */
		public function list(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->list($request);
			return Json::show($result);
		}

		/**
		 * [add description]
		 * @param Request $request [description]
		 */
		public function add(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		/**
		 * [mod description]
		 * @param Request $request [description]
		 */
		public function mod(Request $request){
			$service = new GoodsTagsModel();
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
				$service = new GoodsTagsModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new GoodsTagsModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		/**
		 * [del description]
		 * @param Request $request [description]
		 */
		public function del(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->del($request);
			return Json::show($result);
		}

		/**
		 * [remove description]
		 * @param Request $request [description]
		 */
		public function remove(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->remove($request);
			return Json::show($result);
		}

		/**
		 * [clear description]
		 * @param Request $request [description]
		 */
		public function clear(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->clear($request);
			return Json::show($result);
		}

		public function map(Request $request){
			$service = new GoodsTagsModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>