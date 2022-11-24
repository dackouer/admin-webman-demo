<?php
	namespace app\model\User;

	use support\Request;
	use support\Db;
	use app\model\Model;
	use app\lib\Preg;
	use app\lib\Server;
	use app\model\User\UserModel;
	use app\model\Goods\GoodsModel;

	class UserPriorityModel extends Model{
		public $table = 'user_priority';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$priority = $this->tab;
			$user = $this->prex.'user';
			$goods = $this->prex.'goods';

			$table = "$priority,$user,$goods";
			$field = "$priority.ID as id,UserID as uid,RealName as realname,GoodsID as goods_id,$goods.GoodsTitle as goods_title,Number as number,Used as used,PriorityTime as priority_time,$priority.CreateTime as create_time";
			$where = "UserID = $user.AccountID AND GoodsID = $goods.ID AND $priority.IsDel = 0";
			$orderby = "$priority.ID DESC";
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				$keyword = $this->colation($keyword);
				$where .= " AND (UserID LIKE ? OR RealName LIKE ? OR $user.Mobile LIKE ?)";
				array_push($param,$keyword,$keyword,$keyword);
			}
			
			try{
				$sql = "SELECT COUNT($priority.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$result = Db::select($sql,$param);
				$result = $this->objectToArray($result);
				if($result){
					for($i=0;$i<count($result);$i++){
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						$result[$i]['priority_time'] .= '小时';
						$result[$i]['number'] .= '次';
						$result[$i]['used'] .= '次';
					}
				}

				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}


		protected function getPriorityList(Request $request,$uid = 0,$goods_id = 0){
			if(!$uid || !$goods_id){
				return [];
			}

			$field = "ID as id,UserID as uid,GoodsID as goods_id,Number as number,Used as used,PriorityTime as priority_time,(SELECT IsPriority FROM ".$this->prex."config_order WHERE ID = 1) as is_order_priority";
			$where = "UserID = ? AND GoodsID = ?";
			$orderby = "ID DESC";
			$param = [$uid,$goods_id];

			$sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $orderby LIMIT 1";

			$result = [];
			$object = Db::select($sql,$param);
			if($object){
				$result = $this->objectToArray($object);
				$result = $result[0];
			}

			return $result;
		}

		/**
		 * 获取发行方列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			$thead = [];

			$user = $this->tab;

			$field = [
				"ID as id",
				"RealName as realname",
				"NickName as nickname",
				"Mobile as mobile",
				"Email as email",
				"Avatar as avatar",
				"Idcard as idcard",
				"Birth as birth",
				"Gender as gender",
				"Introduction as intro",
				"ChainAddress as chain_id",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND (`RealName` LIKE ? OR `Mobile` LIKE ? OR `Idcard` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->orderby("CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['avatar'] = $this->setImg($result[$i]['avatar'],'creator');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
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
		protected function getListById(Request $request){
			$args = func_get_args();
			$id = isset($args[1]) ? $args[1] : 0;

			$field = [
				"ID as id",
				"RealName as realname",
				"NickName as nickname",
				"Mobile as mobile",
				"Email as email",
				"Avatar as avatar",
				"Idcard as idcard",
				"Birth as birth",
				"Gender as gender",
				"Introduction as intro",
				"ChainAddress as chain_id",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			
			$where = [['IsDel','=',0],['ID','=',$id]];
			$orWhere = [];
			$param = [];
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['avatar'] = $this->setImg($result['avatar'],'creator');
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
				}
				return $result;
			}catch(\Exception $e){
				// var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * [setPriorityIncrement description]
		 * @param [type] $uid      [description]
		 * @param [type] $goods_id [description]
		 */
		public function setPriorityIncrement($uid,$goods_id){
			$sql = "UPDATE ".$this->tab." SET Used = Used + 1 WHERE UserID = ? AND GoodsID = ?";
			$param = [$uid,$goods_id];

			$result = Db::update($sql,$param);

			return $result !== false ? true : false;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id');
			$uid = $request->post('uid');
			$type = $request->post('type',0);
			$goods_id = $request->post('goods_id');
			$user_list = $request->post('user_list');

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
				return 100711;
			}

			if($this->checkExists(['UnitName'=>$title],$id)){
				return 100712;
			}
			
			if(empty($symbol)){
				return 100713;
			}

			if($this->checkExists(['Symbol'=>$symbol],$id)){
				return 100714;
			}

			return true;
		}

		/**
		 * 批量添加优先购
		 * @param [type] $request [description]
		 */
		public function setBatch(Request $request){
			$uid = $request->post('uid');
			$type = $request->post('type',0);
			$goods_id = $request->post('goods_id');
			$user_list = $request->post('user_list');
			$number = $request->post('number');
			$priotiry_time = $request->post('priotiry_time');
			$remark = $request->post('remark');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			if($user['sign'] != '44369a7c6c130a96eb71f277f74d10e9'){
				return 100006;
			}


			if(empty($goods_id) || !is_numeric($goods_id) || !$goods_id){
				return 100810;
			}

			$service = new GoodsModel();
			$goods = $service->getList($request,$goods_id);
			if(!$goods){
				return 100810;
			}

			// if($goods['status'] != 1){
			// 	return 100812;
			// }

			if(empty($user_list)){
				return 100853;
			}

			$user_list = explode(',',$user_list);
			if(!$user_list){
				return 100854;
			}
 			// var_dump('number: '.$number);
			if(empty($number) || !is_numeric($number) || !$number){
				return 100857;
			}

			$num = 0;
			$errno = 0;
			$param = [];
			$time = time();

			foreach($user_list as $val){
				if(Preg::isMobile($val)){
					$service = new UserModel();
					$duser = $service->getList($request,'mobile',$val);
					
					if($duser){
						if($this->checkExists(['UserID' => $duser['uid'],'GoodsID' => $goods_id])){
							$sql = "UPDATE ".$this->tab." SET Number = Number + ?,PriorityTime = ?,CreateTime = ? WHERE UserID = ? AND GoodsID = ?";
							Db::update($sql,[$number,$priotiry_time,$time,$duser['uid'],$goods_id]);
							$num++;
						}else{
							$sql = "INSERT INTO ".$this->tab." (`UserID`,`GoodsID`,`Number`,`PriorityTime`,`CreateTime`) VALUES (?,?,?,?,?)";
							$param = [$duser['uid'],$goods_id,$number,$priotiry_time,$time];
							if(Db::insert($sql,$param)){
								$num++;
							}else{
								$errno++;
							}
						}						
					}else{
						$errno++;
					}
				}else{
					$service = new UserModel();
					$duser = $service->getList($request,(int)$val);
					if($duser){
						if($this->checkExists(['UserID' => $duser['uid'],'GoodsID' => $goods_id])){
							$sql = "UPDATE ".$this->tab." SET Number = Number + ?,PriorityTime = ?,CreateTime = ? WHERE UserID = ? AND GoodsID = ?";
							Db::update($sql,[$number,$priotiry_time,$time,$duser['uid'],$goods_id]);
							$num++;
						}else{
							$sql = "INSERT INTO ".$this->tab." (`UserID`,`GoodsID`,`Number`,`PriorityTime`,`CreateTime`) VALUES (?,?,?,?,?)";
							$param = [$duser['uid'],$goods_id,$number,$priotiry_time,$time];
							if(Db::insert($sql,$param)){
								$num++;
							}else{
								$errno++;
							}
						}
					}else{
						$errno++;
					}
				}
			}

			// $str = trim($str,',');
			// if(!empty($str)){
			// 	$sql = "INSERT INTO ".$this->tab." (`UserID`,`GoodsID`,`Number`,`PriorityTime`,`CreateTime`) VALUES $str";
			// 	if(Db::insert($sql,$param)){
			// 		return ['num'=>$num,'fail'=>$errno];
			// 	}else{
			// 		return 100856;
			// 	}
			// }
			return ['num'=>$num,'fail'=>$errno];
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'type'					=> 'PriorityType',
				'symbol'				=> 'UserID',
				'symbol'				=> 'GoodsID',
				'priority_time'			=> 'PriorityTime',
				'number'				=> 'Number',
				'fee'					=> 'PriorityFee',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'250','default'=>'','title'=>'会员','width'=>0],
				['map'=>'uid','field'=>'UserID','type'=>'varchar','length'=>'250','default'=>'','title'=>'会员ID','width'=>0],
				['map'=>'goods_title','field'=>'GoodsTitle','type'=>'varchar','length'=>'250','default'=>'','title'=>'藏品','width'=>0],
				['map'=>'number','field'=>'Number','type'=>'int','length'=>'2','default'=>'','title'=>'可用次数','width'=>0],
				['map'=>'used','field'=>'Used','type'=>'int','length'=>'2','default'=>'','title'=>'已使用','width'=>0],
				['map'=>'priority_time','field'=>'PriorityTime','type'=>'varchar','length'=>'2048','default'=>'','title'=>'优先时长','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180]
			];
		}
	}
?>