<?php
	namespace app\controller\Activity;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Activity\RecordVoteModel;

	class RecordVote extends Controller{
		protected $table = 'RecordVote';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new RecordVoteModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new RecordVoteModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new RecordVoteModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function cate(Request $request,$cid = 0){
			$service = new RecordVoteModel();
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
				$service = new RecordVoteModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new RecordVoteModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new RecordVoteModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>