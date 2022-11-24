<?php
	namespace app\model\Community;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class CommunityReplyModel extends Model{
		public $table = 'community_reply';
		public $title = '社区回复管理';

		// 获取某个社区内容的回复
		protected function getReplyList(Request $request,$id = 0){
			$fields = $this->getList($request,'field');
			$field = [];
			foreach($fields as $key => $val){
				array_push($field,"{$val} as {$key}");
			}

			$where = [['IsPraise','=',0]];
			if($id){
				array_push($where,['ID','=',$id]);
			}

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->get();
			if($object){
				$result = $this->objectToArray($object);
			}

			return $result;
		}

		// 获取某个社区内容的点赞
		protected function getPraiseList(Request $request,$id = 0){
			$fields = $this->getList($request,'field');
			$field = [];
			foreach($fields as $key => $val){
				array_push($field,"{$val} as {$key}");
			}

			$where = [['IsPraise','=',1],['IsDel','=',0];
			if($id){
				array_push($where,['ID','=',$id]);
			}

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->get();
			if($object){
				$result = $this->objectToArray($object);
			}

			return $result;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$uid = $request->post('uid');
			$is_praise = $request->post('is_praise');
			$content = trim($request->post('content'),'');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100005;
				}
			}

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100132;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);

			if(!$user){
				return 100132;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100132;
			}

			$data['nickname'] 	= empty($user['nickname']) ? $user['mobile'] : $user['nickname'];
			$data['face'] 		= $user['face'];
			
			if(!$is_praise && empty($content)){
				return 110201;
			}

			return $data;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'community_id'			=> 'CommunityID',
				'is_praise'				=> 'IsPraise',
				'uid'					=> 'UserID',
				'nickname'				=> 'NickName',
				'face'					=> 'Face',
				'content'				=> 'Content',
				'is_del'				=> 'IsDel',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'community_id','field'=>'CommunityID','type'=>'varchar','length'=>'250','default'=>'','title'=>'社区ID','width'=>0],
				['map'=>'is_praise','field'=>'IsPraise','type'=>'switch','length'=>'1','default'=>'','title'=>'类别','width'=>0],
				['map'=>'nickname','field'=>'NickName','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户','width'=>0],
				['map'=>'content','field'=>'Content','type'=>'varchar','length'=>'2048','default'=>'','title'=>'内容','width'=>300],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>