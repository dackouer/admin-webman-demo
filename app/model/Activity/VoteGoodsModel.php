<?php
	namespace app\model\Activity;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;
	use app\model\User\UserModel;

	class VoteGoodsModel extends Model{
		public $table = 'vote_goods';
		public $title = '投票藏品';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$activity = $this->prex.'activity';
			$vote = $this->prex.'vote_goods';
			$goods = $this->prex.'goods';

			$table = "$vote,$activity,$goods";

			$field = "$vote.ID as id,ActivityID as activity_id,$activity.Title as activity_title,GoodsID as goods_id,$goods.GoodsTitle as goods_title,(FavorNumber + BaseNumber) as favor_number,OpposeNumber as oppose_number";

			$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID";
			$orderby = "FavorNumber DESC";
			$param = [];
			
			try{
				$sql = "SELECT COUNT($vote.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$object = Db::select($sql,$param);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);
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
			$vote = $this->prex.'vote_goods';
			$goods = $this->prex.'goods';

			$table = "$vote,$activity,$goods";

			$field = "$vote.ID as id,ActivityID as activity_id,GoodsID as goods_id,(FavorNumber + BaseNumber) as favor_number,OpposeNumber as oppose_number";

			$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID";
			$orderby = "FavorNumber DESC";
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

		protected function getActivityList(Request $request,$aid = 0){
			$result = [];

			if($aid){
				$activity = $this->prex.'activity';
				$vote = $this->prex.'vote_goods';
				$goods = $this->prex.'goods';

				$table = "$vote,$activity,$goods";

				$field = "$vote.ID as id,ActivityID as activity_id,GoodsID as goods_id,GoodsTitle as goods_title,$goods.pic as goods_pic,(FavorNumber + BaseNumber) as favor_number,OpposeNumber as oppose_number";

				$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID AND ActivityID = ?";
				$orderby = "FavorNumber DESC";
				$param = [$aid];

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby";
				$object = Db::select($sql,$param);
				if($object){
					$result = $this->objectToArray($object);
				}
			}

			return $result;
		}

		/**
		 * 获取发行方单条记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getListById(Request $request,$id = 0){
			$activity = $this->prex.'activity';
			$vote = $this->prex.'vote_goods';
			$goods = $this->prex.'goods';

			$table = "$vote,$activity,$goods";

			$field = "$vote.ID as id,ActivityID as activity_id,GoodsID as goods_id,(FavorNumber + BaseNumber) as favor_number,BaseNumber as base_number,OpposeNumber as oppose_number";

			$where = "ActivityID = $activity.ID AND GoodsID = $goods.ID AND $vote.ID = ?";
			$orderby = "FavorNumber DESC";
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

		/**
		 * 投票
		 * @param Request $request [description]
		 */
		public function setVote(Request $request){
			$activity_id = $request->post('activity_id');
			$goods_id = $request->post('goods_id');
			$value = $request->post('value',1);

			if($value){
				$sql = "UPDATE ".$this->tab." SET FavorNumber = FavorNumber + 1 WHERE ActivityID = ? AND GoodsID = ?";
			}else{
				$sql = "UPDATE ".$this->tab." SET OpposeNumber = OpposeNumber + 1 WHERE ActivityID = ? AND GoodsID = ?";
			}
			$param = [$activity_id,$goods_id];

			return Db::update($sql,$param);
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$activity_id = $request->post('activity_id');
			$goods_id = $request->post('goods_id');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100007;
				}
			}
			
			if(empty($activity_id) || !is_numeric($activity_id) || !$activity_id){
				return 100007;
			}
			
			if(empty($goods_id) || !is_numeric($goods_id) || !$goods_id){
				return 100007;
			}

			if($this->checkExists(['ActivityID' => $activity_id,'GoodsID' => $goods_id],$id)){
				return 100007;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'activity_id'			=> 'ActivityID',
				'goods_id'				=> 'GoodsID',
				'base_number'			=> 'BaseNumber',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'activity_title','field'=>'ActivityTitle','type'=>'int','length'=>'250','default'=>'','title'=>'活动标题','width'=>300],
				['map'=>'goods_title','field'=>'GoodsTitle','type'=>'int','length'=>'2048','default'=>'','title'=>'藏品','width'=>200],
				['map'=>'favor_number','field'=>'FavorNumber','type'=>'int','length'=>'2048','default'=>'','title'=>'赞成票','width'=>0],
				['map'=>'oppose_number','field'=>'OpposeNumber','type'=>'int','length'=>'2048','default'=>'','title'=>'反对票','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180]
			];
		}
	}
?>