<?php 
	namespace app\controller\Download;

	use support\Request;
	use app\lib\Json;

	class Download{
		public function index(Request $request){
			return Json::show(['result'=>'ok']);
		}
	}
?>