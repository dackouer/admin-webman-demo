<?php
	namespace app\controller\Record;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Record\RecordSmsModel;

	class RecordSms extends Controller{
		protected $table = 'RecordSms';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new RecordSmsModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new RecordSmsModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}

		public function show(Request $request){
			$service = new RecordSmsModel();
			$result = $service->getList($request,'show');
			return Json::show($result);
		}

		public function map(Request $request){
			$service = new RecordSmsModel();
			$result = $service->getList($request,'map');
			return Json::show($result);
		}
	}
?>