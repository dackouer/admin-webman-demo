<?php
	namespace app\model\Module;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class CollateModel extends Model{
		public $table = 'collate';
		public $title = '排序规则';

		protected function validate(Request $request,$flag = false){
			$id = $request->post('id',0);
			$title = $request->post('title');
			$is_default = $request->post('is_default');

			if(empty($title)){
				return 100237;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100238;
			}

			if(!in_array($is_default,[0,1,'0','1'])){
				return 100220;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'			=> 'ID',
				'title'			=> 'Title',
				'is_default'	=> 'IsDefault',
				'create_time'	=> 'CreateTime',
				'update_time'	=> 'UpdateTime',
			];
		}
	}
?>