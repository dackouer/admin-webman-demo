<?php
	namespace app\model\Notice;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class NoticeModel extends Model{
		public $table = 'notice';
		public $title = '公告管理';

		// 获取所有公告
		protected function getAllList(Request $request){
			$field = [
				'ID as id',
				'Title as title',
				'Content as content'
			];

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where('IsDel',0)
						->orderby('ID','DESC')
						->limit(10)
						->get();

			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['url'] = '/pages/notice/detail?id='.$result[$i]['id'];
					$result[$i]['opentype'] = 'navigate';
				}
			}

			return $result;
		}

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
				['map'=>'content','field'=>'Content','type'=>'varchar','length'=>'2048','default'=>'','title'=>'公告内容','width'=>400],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>