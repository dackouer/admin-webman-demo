<?php
	namespace app\model\Message;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class MessageModel extends Model{
		public $table = 'message';
		public $title = '消息管理';

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$content = $request->post('content');

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
				return 100961;
			}
			
			if(empty($content)){
				return 100962;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'content'				=> 'Content',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'标题','width'=>180],
				['map'=>'content','field'=>'Content','type'=>'varchar','length'=>'2048','default'=>'','title'=>'消息内容','width'=>400],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>