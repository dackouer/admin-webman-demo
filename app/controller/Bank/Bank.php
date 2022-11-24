<?php
	namespace app\controller\Bank;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Bank\BankModel;

	class Bank extends Controller{
		protected $table = 'Bank';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new BankModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new BankModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new BankModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new BankModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}

		public function map(Request $request){
			$service = new BankModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>