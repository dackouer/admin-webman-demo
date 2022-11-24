<?php
	namespace app\model\Community;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\User\UserModel;
	use app\model\Model;

	class CommunityModel extends Model{
		public $table = 'community';
		public $title = '社区管理';

		protected function getAllList(Request $request,$uid = 0){
			if(!$uid){
				return [];
			}
			$fields = $this->getList($request,'field');
			$field = [];
			foreach($fields as $key => $val){
				array_push($field,"{$val} as {$key}");
			}

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where([['IsDel','=',0],['UserID','=',$uid]])
						->orderby('CreateTime','DESC')
						->get();
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
					$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					$result[$i]['update_time'] = date('Y-m-d H:i:s',$result[$i]['update_time']);
					$result[$i]['content'] = trim($result[$i]['content']);
				}
			}

			return $result;
		}

		protected function getUserList(Request $request,$uid = 0){
			if(!$uid){
				return [];
			}
			$fields = $this->getList($request,'field');
			$field = [];
			foreach($fields as $key => $val){
				array_push($field,"{$val} as {$key}");
			}

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where([['IsDel','=',0],['UserID','=',$uid]])
						->orderby('CreateTime','DESC')
						->get();
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
					$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					$result[$i]['update_time'] = date('Y-m-d H:i:s',$result[$i]['update_time']);
					$result[$i]['content'] = trim($result[$i]['content']);
				}
			}

			return $result;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$uid = $request->post('uid');
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
			
			if(empty($content)){
				return 110201;
			}
			// var_dump($request->input('imgs'));
			if(!empty($picture)){
				$data['picture'] = json_encode($picture);
			}else{
				// var_dump($request->input('imgs'));
				$pics = [];
				$imgs = $request->post('imgs');
				if($imgs){
					foreach($imgs as $val){
						array_push($pics,$val['url']);
					}
				}
				// var_dump($pics);
				$data['picture'] = json_encode($pics);
			}

			return $data;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'uid'					=> 'UserID',
				'nickname'				=> 'NickName',
				'face'					=> 'Face',
				'praise'				=> 'Praise',
				'is_praise'				=> 'IsPraise',
				'picture'				=> 'Picture',
				'content'				=> 'Content',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'nickname','field'=>'NickName','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户','width'=>0],
				['map'=>'content','field'=>'Content','type'=>'varchar','length'=>'2048','default'=>'','title'=>'内容','width'=>300],
				['map'=>'praise','field'=>'Praise','type'=>'varchar','length'=>'2','default'=>'','title'=>'点赞数','width'=>0],
				['map'=>'is_praise','field'=>'IsPraise','type'=>'switch','length'=>'1va','default'=>'','title'=>'开启点赞','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>