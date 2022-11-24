<?php
	namespace app\model\Collection;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;
	use app\model\Goods\GoodsModel;
	use app\model\Market\MarketModel;

	class CollectionModel extends Model{
		public $table = 'collection';
		public $title = '藏品集管理';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			try{
				$tab = $this->tab;
				$issuer = $this->prex.'issuer';
				$creator = $this->prex.'creator';
				$market = $this->prex.'market';

				$table = "$tab,$issuer,$creator";

				$field = "$tab.ID as id,$tab.Title as title,$issuer.Title as issuer_title,$creator.RealName as realname,$tab.Pic as pic,IssueNumber as issue_number,LimitNumber as limit_number,LimitOrder as limit_order,IsBlind as is_blind,StartTime as start_time,EndTime as end_time,Hits as hits,Collect as collect,IsPriority as is_priority,PriorityAmount as priority_amount,Goods as goods,Sales as sales,IsIssue as is_issue,$tab.CreateTime as create_time";
				$where = "IssuerID = $issuer.ID AND CreatorID = $creator.ID AND $tab.IsDel = 0";
				$orderby = "$tab.ID DESC";
				$param = [];
				$keyword = trim($request->input('keyword',''));
				if(!empty($keyword)){
					$keyword = $this->getCharset($keyword);
					$where .= " AND ($tab.Title LIKE '%{$keyword}%')";
				}
				$limit = $this->getLimit($request);

				$object = Db::select("SELECT COUNT($tab.ID) as count FROM $table WHERE $where");
				$this->rows = $object[0]->count;
				
				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				
				$object = Db::select($sql);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],'collection');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						
					}
				}
				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];

			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}


			/*
			$field = [
				"collection.ID as id",
				"collection.Title as title",
				"IssuerID as issuer_id",
				"CreatorID as creator_id",
				"collection.Pic as pic",
				"IssueNumber as issue_number",
				"LimitNumber as limit_number",
				"LimitOrder as limit_order",
				"IsBlind as is_blind",
				"StartTime as start_time",
				"EndTime as end_time",
				"Hits as hits",
				"Collect as collect",
				"IsPriority as is_priority",
				"PriorityAmount as priority_amount",
				"Sales as issuer_sales",
				"collection.CreateTime as create_time",
				"IsIssue as is_issue"
			];
			$whereRaw = $tab.'.IsDel = 0';
			$where = [[$tab.'.IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND ($tab.Title LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->join('issuer','issuer.ID','=','IssuerID')
						->select(...$field)
						->where($where)
						->count();

				$object = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->orderby("$tab.CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],'collection');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						
					}
				}
				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
			*/
		}

		/**
		 * 获取发行方列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			try{
				$tab = $this->tab;
				$issuer = $this->prex.'issuer';
				$creator = $this->prex.'creator';

				$table = "$tab,$issuer,$creator";

				$field = "$tab.ID as id,$tab.Title as title,IssuerID as issuer_id,$issuer.Title as issuer_title,$issuer.Logo as issuer_logo,$issuer.Pic as issuer_pic,CreatorID as creator_id,$creator.RealName as creator_name,$tab.Pic as pic,IssueNumber as issue_number,LimitNumber as limit_number,LimitOrder as limit_order,IsBlind as is_blind,IsBlind as is_blind,StartTime as start_time,EndTime as end_time,Hits as hits,Collect as collect,IsPriority as is_priority,PriorityAmount as priority_amount,Goods as goods,Sales as sales,$tab.CreateTime as create_time,IsIssue as is_issue";
				$where = "IssuerID = $issuer.ID AND CreatorID = $creator.ID AND $tab.IsDel = 0";
				$orderby = "$tab.StartTime DESC";
				$param = [];

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby";
				$object = Db::select($sql,$param);

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],'collection');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						$service = new GoodsModel();
						$result[$i]['detail'] = $service->getList($request,'collection',$result[$i]['goods']);
					}
				}
				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}


			/*
			$thead = [];

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"IssuerID as issuer_id",
				"CreatorID as creator_id",
				"Pic as pic",
				"IssueNumber as issue_number",
				"LimitNumber as limit_number",
				"LimitOrder as limit_order",
				"IsBlind as is_blind",
				"StartTime as start_time",
				"EndTime as end_time",
				"Hits as hits",
				"Collect as collect",
				"IsPriority as is_priority",
				"PriorityAmount as priority_amount",
				"Goods as goods",
				"Sales as sales",
				"CreateTime as create_time",
				"IsIssue as is_issue"
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
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->orderby("CreateTime","DESC")
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],'collection');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						$service = new GoodsModel();
						$result[$i]['detail'] = $service->getList($request,'collection',$result[$i]['goods']);
					}
				}
				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			} */
		}

		/**
		 * 获取发行方单条记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getListById(Request $request,$id = 0,$goods_id = 0){
			try{
				$tab = $this->tab;
				$issuer = $this->prex.'issuer';
				$creator = $this->prex.'creator';

				$table = "$tab,$issuer,$creator";

				$field = "$tab.ID as id,$tab.Title as title,IssuerID as issuer_id,$issuer.Title as issuer_title,$issuer.Logo as issuer_logo,$issuer.Pic as issuer_pic,$issuer.Description as issuer_desc,CreatorID as creator_id,$creator.RealName as creator_name,$creator.Introduction as creator_intro,$tab.Pic as pic,$tab.Picture as picture,IssueNumber as issue_number,LimitNumber as limit_number,LimitOrder as limit_order,IsBlind as is_blind,IsBlind as is_blind,StartTime as start_time,EndTime as end_time,Hits as hits,Collect as collect,IsPriority as is_priority,PriorityAmount as priority_amount,Goods as goods,Sales as sales,$tab.CreateTime as create_time,IsIssue as is_issue";
				$where = "IssuerID = $issuer.ID AND CreatorID = $creator.ID AND $tab.IsDel = 0 AND $tab.ID = ?";
				// $orderby = "$tab.StartTime DESC";
				$param = [$id];

				$status = $request->input('status');
				if($status != '' && in_array($status,[0,1])){
					$where .= " AND IsIssue = ?";
					array_push($param,$status);
				}

				$sql = "SELECT $field FROM $table WHERE $where";
				$object = Db::select($sql,$param);

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					// for($i=0;$i<count($result);$i++){
						$result[0]['pic'] = $this->setImg($result[0]['pic'],'collection');
						$result[0]['create_time'] = date('Y-m-d H:i:s',$result[0]['create_time']);

						// $result[0]['goods'] = explode(',',$result[0]['goods']);

						$temp = explode(',',$result[0]['goods']);
						$result[0]['goods_list'] = [];
						if($temp){
							foreach($temp as $val){
								array_push($result[0]['goods_list'],(int)$val);
							}
						}

						// var_dump('goods_id: '.$goods_id);
						if($goods_id && in_array($goods_id,explode(',',$result[0]['goods']))){
							$service = new GoodsModel();
							$result[0]['detail'] = $service->getList($request,$goods_id);
							if($result[0]['detail'] && isset($result[0]['detail']['pic'])){
								$result[0]['goods_title'] = $result[0]['detail']['title'];
								$result[0]['goods_pic'] = $result[0]['detail']['pic'];
							}
						}else{
							$service = new GoodsModel();
							$result[0]['detail'] = $service->getList($request,'collection',$result[0]['goods']);
							$result[0]['count'] = count($result[0]['detail']);
						}

						if(strtotime($result[0]['start_time']) > time()){
							$result[0]['is_start'] = 0;
							$result[0]['waitime'] = strtotime($result[0]['start_time']) - time();
						}else{
							$result[0]['is_start'] = 1;
							$result[0]['waitime'] = 0;
						}

						if(strtotime($result[0]['end_time']) <= time()){
							$result[0]['is_over'] = 1;
						}else{
							$result[0]['is_over'] = 0;
						}
					// }
				}
				return $result[0];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}


			/*
			$args = func_get_args();
			$id = isset($args[1]) ? $args[1] : 0;

			$field = [
				"ID as id",
				"Title as title",
				"IssuerID as issuer_id",
				"CreatorID as creator_id",
				"Pic as pic",
				"Picture as picture",
				"IssueNumber as issue_number",
				"LimitNumber as limit_number",
				"LimitOrder as limit_order",
				"IsBlind as is_blind",
				"StartTime as start_time",
				"EndTime as end_time",
				"Hits as hits",
				"Collect as collect",
				"IsPriority as is_priority",
				"PriorityAmount as priority_amount",
				"Goods as goods",
				"Sales as sales",
				"Description as description",
				"CreateTime as create_time",
				"IsIssue as is_issue"
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
					$result['pic'] = $this->setImg($result['pic'],'collection');
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
					$temp = explode(',',$result['goods']);
					$tmp = [];
					foreach($temp as $val){
						array_push($tmp,(int)$val);
					}
					$result['goods'] = $tmp;

				}
				return $result;
			}catch(\Exception $e){
				// var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
			*/
		}

		// setExcute
		protected function setExcute(Request $request,$data,$flag = false){
			$service = new MarketModel();
			$num = $service->setCollectionGoods($request,$data);
			return true;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$issuer_id = $request->post('issuer_id');
			$creator_id = $request->post('creator_id');
			$pic = $request->post('pic');
			$issue_number = $request->post('issue_number');
			$limit_number = $request->post('limit_number');
			$limit_order = $request->post('limit_order');
			$is_blind = $request->post('is_blind');
			$start_time = $request->post('start_time');
			$end_time = $request->post('end_time');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100750;
				}
			}
			
			if(empty($title)){
				return 100751;
			}

			if($this->checkExists(['Title'=>$title,'IssuerID'=>$issuer_id,'CreatorID'=>$creator_id],$id)){
				return 100752;
			}
			
			if(empty($issuer_id) || !is_numeric($issuer_id) || !$issuer_id){
				return 100753;
			}
			
			if(empty($creator_id) || !is_numeric($creator_id) || !$creator_id){
				return 100754;
			}
			
			if(empty($pic)){
				return 100755;
			}
			
			if(empty($issue_number) || !is_numeric($issue_number) || !$issue_number){
				return 100756;
			}
			
			if(!is_numeric($limit_number)){
				return 100757;
			}
			
			if(!is_numeric($limit_order)){
				return 100758;
			}
			
			if(!in_array($is_blind,[0,1,'0','1'])){
				return 100759;
			}
			
			if(empty($start_time)){
				return 100760;
			}
			
			// if(!Preg::isDate($start_time)){
			// 	return 100761;
			// }
			
			if(empty($end_time)){
				return 100762;
			}

			if(strtotime($end_time) <= strtotime($start_time)){
				return 100764;
			}

			$goods = $request->post('goods');

			// if(!empty($goods)){
			// 	// $goods = json_decode($goods,true);
			// 	$data['goods'] = implode(',',$goods);
			// }else{
			// 	$data['goods'] = '';
			// }
			// var_dump($data);
			// if(!Preg::isDate($end_time)){
			// 	return 100763;
			// }

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'issuer_id'				=> 'IssuerID',
				'creator_id'			=> 'CreatorID',
				'pic'					=> 'Pic',
				'picture'				=> 'Picture',
				'description'			=> 'Description',
				'issue_number'			=> 'IssueNumber',
				'limit_number'			=> 'LimitNumber',
				'limit_order'			=> 'LimitOrder',
				'is_blind'				=> 'IsBlind',
				'start_time'			=> 'StartTime',
				'end_time'				=> 'EndTime',
				'skin'					=> 'Skin',
				'is_priority'			=> 'IsPriority',
				'priority_amount'		=> 'PriorityAmount',
				'goods'					=> 'Goods',
				'content'				=> 'Content',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
				'is_issue'				=> 'IsIssue'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'藏品集标题','width'=>200],
				['map'=>'issuer_title','field'=>'Title','type'=>'varchar','length'=>'2048','default'=>'','title'=>'发行方','width'=>180],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'2048','default'=>'','title'=>'创作者','width'=>150],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'250','default'=>'','title'=>'主图','width'=>0],
				['map'=>'issue_number','field'=>'IssueNumber','type'=>'varchar','length'=>'2048','default'=>'','title'=>'发行数量','width'=>100],
				['map'=>'limit_number','field'=>'LimitNumber','type'=>'varchar','length'=>'2048','default'=>'','title'=>'限购','width'=>0],
				['map'=>'is_blind','field'=>'IsBlind','type'=>'varchar','length'=>'2048','default'=>'','title'=>'是否盲盒','width'=>100],
				['map'=>'start_time','field'=>'StartTime','type'=>'varchar','length'=>'2048','default'=>'','title'=>'开始时间','width'=>180],
				['map'=>'end_time','field'=>'EndTime','type'=>'varchar','length'=>'2048','default'=>'','title'=>'结束时间','width'=>180],
				['map'=>'is_priority','field'=>'IsPriority','type'=>'switch','length'=>'1','default'=>'','title'=>'优先购','width'=>0],
				['map'=>'priority_amount','field'=>'PriorityAmount','type'=>'varchar','length'=>'2048','default'=>'','title'=>'优先购金额','width'=>150],
				['map'=>'goods','field'=>'Goods','type'=>'varchar','length'=>'10','default'=>'','title'=>'藏品列表','width'=>100],
				['map'=>'is_issue','field'=>'IsIssue','type'=>'switch','length'=>'10','default'=>'','title'=>'状态','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180]
			];
		}
	}
?>