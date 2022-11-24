<?php
	namespace app\model\Activity;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;
	use app\model\User\UserModel;

	class RecordVoteModel extends Model{
		public $table = 'record_vote';
		public $title = '投票记录';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$activity = $this->prex.'activity';
			$tab = $this->prex.'record_vote';
			$goods = $this->prex.'goods';
			$user = $this->prex.'user';

			$table = "$tab,$activity,$goods,$user";

			$field = "$tab.ID as id,ActivityID as activity_id,$activity.Title as activity_title,GoodsID as goods_id,$goods.GoodsTitle as goods_title,UserID as uid,$user.RealName as realname,IsFavor as is_favor,IsOppose as is_oppose,$tab.CreateTime as create_time";

			$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID AND UserID = $user.AccountID";
			$orderby = "$tab.ID DESC";
			$param = [];
			
			try{
				$sql = "SELECT COUNT($tab.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$object = Db::select($sql,$param);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
				}

				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 获取发行方列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			$activity = $this->prex.'activity';
			$tab = $this->prex.'record_vote';
			$goods = $this->prex.'goods';

			$table = "$tab,$activity,$goods,$user";

			$field = "$tab.ID as id,ActivityID as activity_id,GoodsID as goods_id,UserID as uid,IsFavor as is_favor,IsOppose as is_oppose,$tab.CreateTime as create_time";

			$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID AND User = $user.AccountID";
			$orderby = "$tab.ID DESC";
			$param = [];
			
			try{
				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$object = Db::select($sql,$param);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);
				}

				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 获取发行方单条记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getListById(Request $request,$id = 0){
			$activity = $this->prex.'activity';
			$tab = $this->prex.'record_vote';
			$goods = $this->prex.'goods';

			$table = "$tab,$activity,$goods,$user";

			$field = "$tab.ID as id,ActivityID as activity_id,GoodsID as goods_id,UserID as uid,IsFavor as is_favor,IsOppose as is_oppose,$tab.CreateTime as create_time";

			$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID AND User = $user.AccountID";
			$orderby = "$tab.ID DESC";
			$param = [$id];
			
			try{
				$sql = "SELECT $field FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result = $result[0];
				}

				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$activity_id = $request->post('activity_id');
			$goods_id = $request->post('goods_id');
			$uid = $request->post('uid');
			$value = $request->post('value',1);

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100007;
				}
			}
			
			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 110113;
			}
			
			if(empty($activity_id) || !is_numeric($activity_id) || !$activity_id){
				return 110111;
			}
			
			if(empty($goods_id) || !is_numeric($goods_id) || !$goods_id){
				return 110112;
			}

			if(!in_array($value,[1,0])){
				return 110114;
			}

			if($this->checkExists(['ActivityID' => $activity_id,'UserID' => $uid],$id)){
				return 110115;
			}

			if($value){
				$data['is_favor'] = 1;
			}else{
				$data['is_oppose'] = 1;
			}

			return $data;
		}

		protected function setExcute(Request $request,$data,$flag = false){
			if(!$flag){
				$service = new VoteGoodsModel();
				$res = $service->setVote($request);
				return $res !== false ? true : false;
			}
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'activity_id'			=> 'ActivityID',
				'goods_id'				=> 'GoodsID',
				'uid'					=> 'UserID',
				'is_favor'				=> 'IsFavor',
				'is_oppose'				=> 'IsOppose',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'realname','field'=>'RealName','type'=>'int','length'=>'2048','default'=>'','title'=>'用户','width'=>120],
				['map'=>'activity_title','field'=>'ActivityTitle','type'=>'int','length'=>'250','default'=>'','title'=>'活动标题','width'=>300],
				['map'=>'goods_title','field'=>'GoodsTitle','type'=>'int','length'=>'2048','default'=>'','title'=>'藏品','width'=>200],
				['map'=>'is_favor','field'=>'IsFavor','type'=>'int','length'=>'2048','default'=>'','title'=>'赞成','width'=>0],
				['map'=>'is_oppose','field'=>'IsOppose','type'=>'int','length'=>'2048','default'=>'','title'=>'反对','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'投票时间','width'=>180]
			];
		}
	}
?>