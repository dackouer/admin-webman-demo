<?php
	namespace app\controller\Goods;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Goods\GoodsModel;

	class Goods extends Controller{
		protected $table = 'Goods';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new GoodsModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new GoodsModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		/**
		 * 获取正在销售的商品列表
		 * @param  Request $request [description]
		 * @param  integer $cid     [description]
		 * @return [type]           [description]
		 */
		public function sale(Request $request){
			$service = new GoodsModel();
			$result = $service->getList($request,'sale');
			return Json::show($result);
		}

		/**
		 * 获取发行商品列表
		 * @param  Request $request [description]
		 * @param  integer $cid     [description]
		 * @return [type]           [description]
		 */
		public function issue(Request $request){
			$service = new GoodsModel();
			$result = $service->getList($request,'issue');
			return Json::show($result);
		}

		/**
		 * 获取某类的商品列表
		 * @param  Request $request [description]
		 * @param  integer $cid     [description]
		 * @return [type]           [description]
		 */
		public function cate(Request $request,$cid = 0){
			$service = new GoodsModel();
			$result = $service->getList($request,'cate',$cid);
			return Json::show($result);
		}

		/**
		 * 获取可售的商品列表
		 * @param  Request $request [description]
		 * @param  integer $cid     [description]
		 * @return [type]           [description]
		 */
		public function cates(Request $request){
			$service = new GoodsModel();
			$result = $service->getList($request,'cates');
			return Json::show($result);
		}

		/**
		 * 获取可以空投的商品列表
		 * @param  Request $request [description]
		 * @param  integer $cid     [description]
		 * @return [type]           [description]
		 */
		public function airpop(Request $request){
			$service = new GoodsModel();
			$result = $service->getList($request,'airpop');
			return Json::show($result);
		}

		/**
		 * 商品上链
		 * @param  Request $request [description]
		 * @param  integer $id      [description]
		 * @return [type]           [description]
		 */
		public function hash(Request $request,$id = 0){
			$service = new GoodsModel();
			$result = $service->setHash($request,$id);
			return Json::show($result);
		}
	}
?>