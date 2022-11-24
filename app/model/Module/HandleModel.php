<?php
	namespace app\model\Module;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class HandleModel extends Model{
		public $table = 'handle';
		public $title = '行为管理';
		
		protected function validate(Request $request,$flag = false){
		    $id = $request->input('id',0);
			$title = $request->post('title');
			$handle_name = $request->post('handle_name');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100005;
				}
			}
			
			if(empty($title)){
				return 100231;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100232;
			}
			
			if(empty($handle_name)){
				return 100233;
			}

			if($this->checkExists(['HandleName'=>$handle_name],$id)){
				return 100234;
			}

			return true;
		}
	}
?>