<?php
	namespace app\controller\Community;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Community\CommunityModel;
	use app\model\Community\CommunityReplyModel;

	class Community extends Controller{
		protected $table = 'Community';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new CommunityModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new CommunityModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new CommunityModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		/**
		 * 获取用户数据
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function user(Request $request,$uid = 0){
			$service = new CommunityModel();
			$result = $service->getList($request,'user',$uid);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new CommunityModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new CommunityModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new CommunityModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}

		/**
		 * 获取点赞数据
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function praise(Request $request,$id = 0){
			$service = new CommunityReplyModel();
			$result = $service->getList($request,'praise',$id);
			return Json::show($result);
		}

		/**
		 * 获取回复数据
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function reply(Request $request,$id = 0){
			$service = new CommunityReplyModel();
			$result = $service->getList($request,'reply',$id);
			return Json::show($result);
		}

		/**
		 * 点赞
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function add_praise(Request $request){
			$service = new CommunityReplyModel();
			$result = $service->add($request);
			return Json::show($result);
		}

		/**
		 * 回复
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function add_reply(Request $request){
			$service = new CommunityReplyModel();
			$result = $service->add($request);
			return Json::show($result);
		}
	}
?>