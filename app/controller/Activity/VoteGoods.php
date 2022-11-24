<?php
	namespace app\controller\Activity;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Activity\VoteGoodsModel;

	class VoteGoods extends Controller{
		protected $table = 'VoteGoods';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new VoteGoodsModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new VoteGoodsModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new VoteGoodsModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function cate(Request $request,$cid = 0){
			$service = new VoteGoodsModel();
			$result = $service->getList($request,'cate',$cid);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new VoteGoodsModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new VoteGoodsModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new VoteGoodsModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}

		public function del(Request $request){
			$service = new VoteGoodsModel();
            $result = $service->del($request);

            if($result === true){
                return Json::show(0,'ok');
            }
            if(is_numeric($result)){
                return Json::show($result);
            }
            return Json::show(100031);
		}
	}
?>