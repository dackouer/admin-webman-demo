<?php
	namespace app\model\User;

	use support\Request;
	use app\model\Model;
	use app\lib\Server;

	class RecordSignModel extends Model{
		public $table = 'record_sign';

		protected function setRequest(Request $request){
			$data['create_time'] = Server::getDate();
			$data['create_ip'] = Server::getIP();
		}

		// 验证
		protected function validate(Request $request){
			$uid = $request->session()->get('uid');
			if(empty($uid)){
				return 100007;
			}

			return true;
		}
	}
?>