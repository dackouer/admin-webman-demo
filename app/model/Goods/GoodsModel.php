<?php
	namespace app\model\Goods;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Random;
	use app\lib\Preg;
	use app\model\Model;
	use app\model\Market\MarketModel;
	use app\model\User\UserPriorityModel;
	use app\model\Api\Avata\AvataModel;
	use app\model\Order\ConfigOrderModel;

	class GoodsModel extends Model{
		public $table = 'goods';
		public $title = '商品管理';

		protected function _init(){
			$service = new ConfigOrderModel();
			$this->config = $service->fetch(1);
		}

		/**
		 * [getShowList description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getShowList(Request $request){

			$tab = $this->tab;
			$cate = $this->prex.'goods_cate';
			$brand = $this->prex.'brand';
			$unit = $this->prex.'unit';

			$table = "$tab,$cate,$brand,$unit";
			$field = "$tab.ID as id,$cate.Title as cate_title,GoodsTitle as title,Keyword as keyword,$tab.Description as `desc`,IsVirtual as is_virtual,GoodsCode as goods_code,$tab.Pic as pic,$tab.Picture as picture,LinkUrl as link_url,BrandName as brand_name,$tab.Tags as tags,Price as price,OriginalPrice as original_price,CostPrice as cost_price,UnitName as unit_name,Stock as stock,LimitCount as limit_count,LimitOrder as limit_order,GiveCent as give_cent,IsAllowShare as is_allow_share,$tab.Hits as hits,$tab.Collects as collect,$tab.Sales as sales,Status as status,$tab.Sort as sort";
			$where = "CategoryID = $cate.ID AND BrandID = $brand.ID AND UnitID = $unit.ID AND $tab.IsDel = 0";
			$orderby = "";
			$param = [];

			$keyword = $request->input('keyword');
			if(!empty($keyword)){
				$where .= " AND (GoodsTitle LIKE '%".$keyword."%' OR GoodsCode LIKE '%".$keyword."%')";
				// array_push($param,$keyword);
				// array_push($param,$keyword);
			}

			$cate_id = $request->input('cate_id');
			if(!empty($cate_id) && is_numeric($cate_id) && $cate_id){
				$where .= " AND CategoryID = ?";
				array_push($param,$cate_id);
			}

			$order = $request->post('order');
			if(empty($order) || !$order){
				$orderby = "$tab.Hits DESC,$tab.Collects DESC,$tab.Sales DESC,$tab.Sort ASC";
			}else{

			}

			$sql = "SELECT COUNT($tab.ID) as count FROM $table WHERE $where";
			$object = Db::select($sql);
			$this->rows = $object[0]->count;

			$limit = $this->getLimit($request);

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";

			$object = Db::select($sql,$param);

			$result = [];
			if($object){
				$result = $this->objectToArray($object);
				if($result){
					for($i=0;$i<count($result);$i++){
						$result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
						$result[$i]['tags'] = $this->getJsonDecode($result[$i]['tags']);
					}
				}
			}

			$arr = [
			    'title' => $this->title,
			    'table' => strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $this->table)),
			    'layer' => 1,
			    'thead' => $this->getList($request,'map'),
			    'rows'  => $this->rows,
			    'data'  => $result
			];

			return $arr;
		}

		protected function getListById(Request $request,$id = 0){
			if(!$id){
				return [];
			}

			try{
				$tab = $this->tab;
				$cate = $this->prex.'goods_cate';
				$brand = $this->prex.'brand';
				$currency = $this->prex.'currency';
				$unit = $this->prex.'unit';

				$table = "$tab,$cate,$brand,$currency,$unit";
				// $field = "$tab.ID as id,CategoryID as cate_id,$cate.Title as cate_title,GoodsTitle as title,Keyword as keyword,$tab.Description as `desc`,IsVirtual as is_virtual,GoodsCode as goods_code,$tab.Pic as pic,$tab.Picture as picture,ShowType as show_type,LinkUrl as link_url,BrandID as brand_id,BrandName as brand_name,$tab.Tags as tags,Price as price,OriginalPrice as original_price,CostPrice as cost_price,CurrencyID as currency_id,CurrencyName as currency_name,$currency.Symbol as symbol,Stock as stock,UnitID as unit_id,UnitName as unit_name,LimitCount as limit_count,LimitOrder as limit_order,LimitBalance as limit_balance,LimitCoin as limit_coin,GiveCent as give_cent,IsAllowShare as is_allow_share,$tab.Hits as hits,$tab.Collects as collect,$tab.Sales as sales,StartTime as start_time,EndTime as end_time,Status as status,$tab.Sort as sort,$tab.Content as content";
				$field = "$tab.ID as id,CategoryID as cate_id,$cate.Title as cate_title,GoodsTitle as title,Keyword as keyword,$tab.Description as `desc`,IsVirtual as is_virtual,GoodsCode as goods_code,$tab.Pic as pic,$tab.Picture as picture,BrandID as brand_id,BrandName as brand_name,$tab.Tags as tags,Price as price,OriginalPrice as original_price,CostPrice as cost_price,CurrencyID as currency_id,CurrencyName as currency_name,$currency.Symbol as symbol,GoodsNumber as goods_number,BatchCode as batch_code,Barcode as bar_code,Stock as stock,UnitID as unit_id,UnitName as unit_name,LimitCount as limit_count,LimitOrder as limit_order,LimitBalance as limit_balance,LimitCoin as limit_coin,GiveCent as give_cent,IsAllowShare as is_allow_share,$tab.Hits as hits,$tab.Collects as collect,$tab.Sales as sales,StartTime as start_time,EndTime as end_time,Status as status,$tab.Sort as sort,$tab.Content as content";
				$where = "CategoryID = $cate.ID AND BrandID = $brand.ID AND CurrencyID = $currency.ID AND UnitID = $unit.ID AND $tab.IsDel = 0 AND $tab.ID = ?";
				$orderby = "";
				$param = [$id];

				$sql = "SELECT $field FROM $table WHERE $where LIMIT 1";
				// var_dump('sql: '.$sql);
				// var_dump($param);
				$object = Db::select($sql,$param);
				// var_dump($object);
				if($object){
					$result = $this->objectToArray($object);
					if($result){
						$result[0]['start_time'] = !empty($result[0]['start_time']) ? date('Y-m-d H:i:s',$result[0]['start_time']) : '';
						$result[0]['end_time'] = !empty($result[0]['end_time']) ? date('Y-m-d H:i:s',$result[0]['end_time']) : '';
						$result[0]['picture'] = $this->getJsonDecode($result[0]['picture']);
						$result[0]['tags'] = $this->getJsonDecode($result[0]['tags']);
						$result[0]['status'] = (string)$result[0]['status'];

						if(!empty($result[0]['start_time']) && strtotime($result[0]['start_time']) > time()){
							$result[0]['is_start'] = 0;
							$result[0]['waitime'] = strtotime($result[0]['start_time']) - time();
						}else{
							$result[0]['is_start'] = 1;
							$result[0]['waitime'] = 0;
						}

						if(!empty($result[0]['end_time']) && strtotime($result[0]['end_time']) <= time()){
							$result[0]['is_over'] = 1;
						}else{
							$result[0]['is_over'] = 0;
						}

						$result[0]['buy_message'] = $this->config['BuyMessage'];
					}
					return $result[0];
				}
				return [];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		// 获取正在销售的商品列表
		protected function getSaleList(Request $request){
			$tab = $this->tab;
			$cate = $this->prex.'goods_cate';
			$brand = $this->prex.'brand';
			$unit = $this->prex.'unit';
			$issuer = $this->prex.'issuer';
			$creator = $this->prex.'creator';

			$table = "$tab,$cate,$brand,$unit,$issuer,$creator";
			$field = "$tab.ID as id,$cate.Title as cate_title,GoodsTitle as title,Keyword as keyword,$tab.Description as `desc`,IsVirtual as is_virtual,GoodsCode as goods_code,$tab.Pic as pic,$tab.Picture as picture,ShowType as show_type,LinkUrl as link_url,$issuer.Title as issuer_title,$issuer.Logo as issuer_logo,$issuer.Pic as issuer_pic,$issuer.Description as issuer_desc,$creator.RealName as creator_name,$creator.Avatar as creator_avatar,$creator.Introduction as creator_intro,BrandName as brand_name,$tab.Tags as tags,Price as price,OriginalPrice as original_price,CostPrice as cost_price,UnitName as unit_name,TotalStock as total_stock,Stock as stock,ReserveStock as reserve_stock,LimitCount as limit_count,LimitOrder as limit_order,LimitBalance as limit_balance,LimitCoin as limit_coin,GiveCent as give_cent,IsAllowShare as is_allow_share,IsAllowAirdrop as is_allow_airdrop,IsAllowSend as is_allow_send,IsAllowSale as is_allow_sale,IsAllowPriority as is_allow_priority,$tab.Hits as hits,$tab.Collects as collect,$tab.Sales as sales,$tab.OperationID as operation_id,GoodsHash as goods_hash,OddsRate as rate,BlindGoods as blind_goods,ComposeGoods as compose_goods,StartTime as start_time,EndTime as end_time,Status as status,$tab.Sort as sort";
			$where = "CategoryID = $cate.ID AND BrandID = $brand.ID AND UnitID = $unit.ID AND IssuerID = $issuer.ID AND CreatorID = $creator.ID AND CategoryID IN (1,2) AND $tab.Status = 1 AND $tab.IsDel = 0";
			$orderby = "";
			$param = [];

			$keyword = $request->input('keyword');
			if(!empty($keyword)){
				$where .= " AND (GardenTitle LIKE '%?%' OR GoodsCode LIKE '%?%')";
				array_push($param,$keyword);
				array_push($param,$keyword);
			}

			$cate_id = $request->input('cate_id');
			if(!empty($cate_id) && is_numeric($cate_id) && $cate_id){
				$where .= " AND CategoryID = ?";
				array_push($param,$cate_id);
			}

			$order = $request->post('order');
			if(empty($order) || !$order){
				$orderby = "$tab.StartTime DESC";
			}else{

			}

			$limit = $this->getLimit($request);

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";

			$object = Db::select($sql,$param);
			if($object){
				$result = $this->objectToArray($object);
				if($result){
					for($i=0;$i<count($result);$i++){
						$result[$i]['is_start'] = 0;
						$result[$i]['is_end'] = 0;
						$result[$i]['is_out'] = 0;
						// var_dump('start_time: '.date('Y-m-d H:i:s',$result[$i]['start_time']));
						// var_dump('time: '.date('Y-m-d H:i:s',time()));
						if($result[$i]['start_time'] <= time()){
							$result[$i]['is_start'] = 1;
						}
						if($result[$i]['end_time'] <= time()){
							$result[$i]['is_end'] = 1;
						}
						if($result[$i]['stock'] <= $result[$i]['sales']){
							$result[$i]['is_out'] = 1;
						}
						$result[$i]['start_time'] = date('Y-m-d H:i:s',$result[$i]['start_time']);
						$result[$i]['end_time'] = date('Y-m-d H:i:s',$result[$i]['end_time']);
						$result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
						$result[$i]['tags'] = $this->getJsonDecode($result[$i]['tags']);
					}
				}
				return $result;
			}
			return [];
		}

		// 获取某个藏品集下的藏品列表
		// protected function getCollectionList(Request $request,$goods){
		// 	$sql = "SELECT * FROM ".$this->tab." WHERE IN IN (?)";
		// 	$param = [$goods];

		// 	$result = [];
		// 	$object = Db::select($sql,$param);
		// 	if($object){
		// 		$result = $this->objectToArray($object);
		// 	}
		// 	return $result;
		// }

		/**
		 * [getAllList description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			$tab = $this->tab;
			$cate = $this->prex.'goods_cate';
			$brand = $this->prex.'brand';
			$unit = $this->prex.'unit';

			$table = "$tab,$cate,$brand,$unit";
			$field = "$tab.ID as id,$cate.Title as cate_title,GoodsTitle as title,Keyword as keyword,$tab.Description as `desc`,IsVirtual as is_virtual,GoodsCode as goods_code,$tab.Pic as pic,$tab.Picture as picture,LinkUrl as link_url,BrandName as brand_name,$tab.Tags as tags,Price as price,OriginalPrice as original_price,CostPrice as cost_price,UnitName as unit_name,Stock as stock,LimitCount as limit_count,LimitOrder as limit_order,GiveCent as give_cent,IsAllowShare as is_allow_share,$tab.Hits as hits,$tab.Collects as collect,$tab.Sales as sales,Status as status,$tab.Sort as sort";
			$where = "CategoryID = $cate.ID AND BrandID = $brand.ID AND UnitID = $unit.ID AND $tab.IsDel = 0 AND Status = 1";
			$orderby = "";
			$param = [];

			$keyword = $request->input('keyword');
			if(!empty($keyword)){
				$where .= " AND (GoodsTitle LIKE '%?%' OR GoodsCode LIKE '%?%')";
				array_push($param,$keyword);
				array_push($param,$keyword);
			}

			$cate_id = $request->input('cate_id');
			if(!empty($cate_id) && is_numeric($cate_id) && $cate_id){
				$where .= " AND CategoryID = ?";
				array_push($param,$cate_id);
			}

			$order = $request->post('order');
			if(empty($order) || !$order){
				$orderby = "$tab.Hits DESC,$tab.Collects DESC,$tab.Sales DESC,$tab.Sort ASC";
			}else{

			}

			$limit = $this->getLimit($request,20);

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";

			$object = Db::select($sql,$param);
			if($object){
				$result = $this->objectToArray($object);
				if($result){
					for($i=0;$i<count($result);$i++){
					    if(isset($result[$i]['start_time'])){
    						$result[$i]['start_time'] = date('Y-m-d H:i:s',$result[$i]['start_time']);
					    }
					    if(isset($result[$i]['end_time'])){
						    $result[$i]['end_time'] = date('Y-m-d H:i:s',$result[$i]['end_time']);
					    }
						$result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
						$result[$i]['tags'] = $this->getJsonDecode($result[$i]['tags']);
					}
				}
				return $result;
			}
			return [];
		}

		// 获取某个类别的商品
		protected function getCateList(Request $request,$cid = 0){
			if(!$cid){
				return [];
			}

			$field = [
				'ID as id',
				'GoodsTitle as title',
				'GoodsCode as goods_code',
				'Price as price',
				'OriginalPrice as original_price',
				'CostPrice as cost_price',
				'TotalStock as total_stock',
				'Stock as stock',
				'ReserveStock as reserve_stock',
				'LimitCount as limit_count',
				'LimitOrder as limit_order',
				'LimitBalance as limit_balance',
				'LimitCoin as limit_coin',
				'IsAllowShare as is_allow_share',
				'GiveCent as give_cent',
				'IsCommission as is_commission',
				'IsAllowAirdrop as is_allow_airdrop',
				'IsAllowSend as is_allow_send',
				'IsAllowSale as is_allow_sale',
				'IsAllowPriority as is_allow_priority',
				'OperationID as operation_id',
				'GoodsHash as goods_hash',
				'BlindGoods as blind_goods',
				'ComposeGoods as compose_goods',
				'StartTime as start_time',
				'EndTime as end_time',
				'Status as status'
			];
			$where = [['IsDel','=',0],['CategoryID','=',$cid]];

			$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->get();
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){					
					$result[$i]['start_time'] = date('Y-m-d H:i:s',$result[$i]['start_time']);
					$result[$i]['end_time'] = date('Y-m-d H:i:s',$result[$i]['end_time']);
					$result[$i]['selected'] = 0;
				}
				return $result;
			}
			return [];
		}

		// 获取可售的商品列表
		protected function getCatesList(Request $request){

			$field = [
				'ID as id',
				'GoodsTitle as title',
				'GoodsCode as goods_code',
				'Price as price',
				'OriginalPrice as original_price',
				'CostPrice as cost_price',
				'TotalStock as total_stock',
				'Stock as stock',
				'ReserveStock as reserve_stock',
				'LimitCount as limit_count',
				'LimitOrder as limit_order',
				'LimitBalance as limit_balance',
				'LimitCoin as limit_coin',
				'IsAllowShare as is_allow_share',
				'GiveCent as give_cent',
				'IsCommission as is_commission',
				'IsAllowAirdrop as is_allow_airdrop',
				'IsAllowSend as is_allow_send',
				'IsAllowSale as is_allow_sale',
				'IsAllowPriority as is_allow_priority',
				'OperationID as operation_id',
				'GoodsHash as goods_hash',
				'BlindGoods as blind_goods',
				'ComposeGoods as compose_goods',
				'StartTime as start_time',
				'EndTime as end_time',
				'Status as status'
			];
			$where = [['IsDel','=',0]];

			$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->whereIn('CategoryID',[1,2])
						->get();
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){					
					$result[$i]['start_time'] = date('Y-m-d H:i:s',$result[$i]['start_time']);
					$result[$i]['end_time'] = date('Y-m-d H:i:s',$result[$i]['end_time']);
				}
				return $result;
			}
			return [];
		}

		// 获取所有藏品列表
		protected function getGoodsList(Request $request){
			return $this->getList($request,'cate',1);
		}

		// 获取所有盲盒列表
		protected function getBlindList(Request $request){
			return $this->getList($request,'cate',2);
		}

		// 获取所有合成藏品列表
		protected function getComposeList(Request $request,$goods_list,$uid = 0){
			if(!$goods_list){
				return [];
			}

			$gid = [];
			foreach($goods_list as $val){
				array_push($gid,$val['goods_id']);
			}

			$object = Db::table($this->table)
						->select('ID as id','GoodsTitle as title','Pic as pic')
						->whereIn('ID',$gid)
						->get();
			if($object){
				for($i=0;$i<count($goods_list);$i++){
					if($object[$i]->id == $goods_list[$i]['goods_id']){
						$goods_list[$i]['title'] = $object[$i]->title;
						$goods_list[$i]['pic'] = $object[$i]->pic;
						$goods_list[$i]['user_count'] = 0;
					}
				}
			}

			if($uid){
				$object = Db::table('order')
							->select("COUNT(ID) as count,GoodsID as goods_id")
							->where('UserID',$uid)
							->whereIn('GoodsID',$gid)
							->groupBy('GoodsID')
							->get();
				if($object){
					for($i=0;$i<count($goods_list);$i++){
						if($object[$i]->goods_id == $goods_list[$i]['goods_id']){
							$goods_list[$i]['user_count'] = $object[$i]->count;
						}
					}
				}
			}

			return $goods_list;
		}

		/**
		 * 获取某个藏品集下的藏品列表
		 * @param  Request $request [description]
		 * @param  [type]  $id      [description]
		 * @return [type]           [description]
		 */
		protected function getCollectionList(Request $request,$id = 0){
			if(!$id || empty($id)){
				return [];
			}
			$tab = $this->tab;
			$collection = $this->prex.'collection';
			$cate = $this->prex.'goods_cate';
			$brand = $this->prex.'brand';
			$unit = $this->prex.'unit';

			$table = "$tab,$cate,$brand,$unit";
			$field = "$tab.ID as id,CategoryID as cate_id,$cate.Title as cate_title,GoodsTitle as title,IsVirtual as is_virtual,GoodsCode as goods_code,$tab.Pic as pic,$tab.Picture as picture,BrandName as brand_name,$tab.Tags as tags,Price as price,OriginalPrice as original_price,CostPrice as cost_price,UnitName as unit_name,Stock as stock,AlarmStock as alarm_stock,GoodsNumber as goods_number,BatchCode as batch_code,Barcode as bar_code,LimitCount as limit_count,LimitOrder as limit_order,GiveCent as give_cent,$tab.Hits as hits,$tab.Collects as collect,$tab.Sales as sales,$tab.OperationID as operation_id,GoodsHash as goods_hash,BlindGoods as blind_goods,ComposeGoods as compose_goods,StartTime as start_time,EndTime as end_time,$tab.Status as status,$tab.Sort as sort";
			$where = "CategoryID = $cate.ID AND BrandID = $brand.ID AND UnitID = $unit.ID AND $tab.IsDel = 0 AND $tab.ID IN ($id)";
			$orderby = "$tab.ID ASC";
			$param = [];

			// if($state != '' && in_array($state,[-1,0,1])){
			// 	$where .= " $tab.Status = ?";
			// 	array_push($param,$state);
			// }

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby";
			$object = Db::select($sql,$param);

			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['start_time'] = date('Y-m-d H:i:s',$result[$i]['start_time']);
					$result[$i]['end_time'] = date('Y-m-d H:i:s',$result[$i]['end_time']);
				}
			}else{
				$result = [];
			}

			return $result;
		}

		// 获取空投商品
		protected function getAirpopList(Request $request){
			$sql = "SELECT ID as id,GoodsTitle as title FROM ".$this->tab." WHERE IsDel = 0 AND IsAllowAirdrop = 1 AND CategoryID IN (1,2)";
			$param = [];

			$result = [];
			$object = Db::select($sql);
			if($object){
				$result = $this->objectToArray($object);
			}

			return $result;
		}

		/**
		 * 商品上链
		 * @param Request $request [description]
		 * @param integer $id      [description]
		 */
		public function setHash(Request $request,$id = 0){
			if(!$id){
				return 100007;
			}

			$result = $this->getList($request,$id);
			if(!$result){
				return 100007;
			}

			if($result['goods_hash'] != ''){
				return 100470;
			}

			$data = [
				'cate_id'	=> $result['cate_id'] == 1 ? 'avatarsj1zyrai0ibznssqxvpukvbsoa' : 'avata3hh6gllsv0w3anauwlpnkqcwxh9',
				'title'		=> $result['title']
			];

			$service = new AvataModel();
			$resp = $service->issue($data);
			// var_dump($resp);
			
			if($resp && isset($resp['error']['code']) && $resp['error']['code'] == 'CHAIN_ERROR'){
				return '上链失败：'.$resp['error']['message'];
			}

			if($resp && isset($resp['data']['operation_id'])){
				if($this->updateOperationID($request,$id,$resp['data']['operation_id'])){
					return $resp;
				}
				return 100471;
			}

			return 100472;
		}

		private function updateOperationID(Request $request,$id,$operation_id){
			// $service = new AvataModel();
			// $result = $service->getTransaction($request,$operation_id);
			// if($result && isset($result['data']['tx_hash']) && $result['data']['tx_hash'] != ''){
			// 	$tx_hash = $result['data']['tx_hash'];
			// 	$class_id = $result['data']['class_id'];
			// 	$status = $result['data']['status'];
			// 	$block_height = $result['data']['block_height'];
			// 	$time = time();
			// }else{
			// 	$tx_hash = '';
			// 	$class_id = '';
			// 	$status = 0;
			// 	$block_height = 0;
			// 	$time = 0;
			// }

			// $sql = "UPDATE ".$this->tab." SET OperationID = ?,GoodsHash = ?,HashCate = ?,HashStatus = ?,HashHeight = ?,HashTime = ? WHERE ID = ?";
			// $param = [$operation_id,$tx_hash,$class_id,$status,$block_height,$time,$id];
			// if(Db::update($sql,$param)){
			// 	if($status){
			// 		return true;
			// 	}
			// 	return false;
			// }
			// return false;



			$sql = "UPDATE ".$this->tab." SET OperationID = ?,HashTime = ? WHERE ID = ?";
			$param = [$operation_id,time(),$id];
			if(Db::update($sql,$param) !== false){
				\Workerman\Timer::add(60,array($this,'autoHash'),[$id,$operation_id],false);
				return true;
			}
			return false;
		}

		// 定时器自动更新上链结果
		public function autoHash($id,$operation_id){
			$service = new AvataModel();
			$result = $service->getTransaction($operation_id);
			if($result && isset($result['data']['tx_hash']) && $result['data']['tx_hash'] != ''){
				$tx_hash = $result['data']['tx_hash'];
				$class_id = $result['data']['class_id'];
				$status = $result['data']['status'];
				$block_height = $result['data']['block_height'];
				$time = time();

				$sql = "UPDATE ".$this->tab." SET GoodsHash = ? WHERE ID = ?";
				$param = [$tx_hash,$id];

				return Db::update($sql,$param) !== false ? true : false;
			}
			return false;
		}

		protected function setRequest(Request $request,$flag = false){
			if(!$flag){
				$code = $request->post('code');
				if(empty($code)){
					$data['code'] = Random::create(12);
				}
				$data['create_time'] = time();
			}
			$price = $request->post('price');
			$data['price'] = $price * 100;

			$original_price = $request->post('original_price');
			$data['original_price'] = $original_price * 100;

			$cost_price = $request->post('cost_price');
			$data['cost_price'] = $cost_price * 100;

			$data['start_time'] = strtotime($request->post('start_time'));
			$data['end_time'] = strtotime($request->post('end_time'));

			$picture = $request->post('picture');
			$data['picture'] = json_encode($picture);

			$data['tags'] = json_encode($request->post('tags'));

			return $data;
		}

		protected function setExcute(Request $request,$data,$flag = false){
			if($data['cate_id'] == 2){
				$service = new BlindGoodsModel();
				return $service->append($data,$flag);
			}
			return true;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$cate_id = $request->post('cate_id');
			$title = $request->post('title');
			$pic = $request->post('pic');
			$issuer_id = $request->post('issuer_id');
			$creator_id = $request->post('creator_id');
			$is_virtual = $request->post('is_virtual');
			$start_time = $request->post('start_time');
			$end_time = $request->post('end_time');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100005;
				}
			}
			
			if(empty($cate_id) || !is_numeric($cate_id) || !$cate_id){
				return 100402;
			}
			$service = new GoodsCateModel();
			$resp = $service->getList($request,$cate_id);
			if(!$resp){
				return 100461;
			}

			if(empty($title)){
				return 100403;
			}
			if(strlen($title) < 5 || strlen($title) > 200){
				return 100404;
			}

			if($this->checkExists(['CategoryID'=>$cate_id,'GoodsTitle'=>$title],$id)){
				return 100405;
			}

			if(!in_array($is_virtual,array(0,1,'0','1'))){
				return 100406;
			}

			// $code = Random::create(12);
			// $code = trim($request->post('code',$code));
			// if(empty($code)){
			// 	return 100407;
			// }

			$pic = $request->post('pic');
			if(empty($pic)){
				return 100408;
			}

			$picture = $request->post('picture');
			if(empty($picture)){
				return 100409;
			}

			$show_type = $request->post('show_type');
			if($show_type == 3){
				$link_url = $request->post('link_url');
				if(empty($link_url)){
					return 100463;
				}
			}

			$brand_id = $request->post('brand_id');
			if(empty($brand_id) || !is_numeric($brand_id) || !$brand_id){
				return 100410;
			}

			$price = $request->post('price');
			if(empty($price)){
				return 100413;
			}
			if(!is_numeric($price)){
				return 100414;
			}

			$original_price = $request->post('original_price',0);
			// if(empty($original_price)){
			// 	return 100415;
			// }
			if(!is_numeric($original_price)){
				return 100416;
			}

			$cost_price = $request->post('cost_price',0);
			// if(empty($cost_price)){
			// 	return 100417;
			// }
			if(!is_numeric($cost_price)){
				return 100418;
			}

			$unit_id = $request->post('unit_id');
			if(empty($unit_id) || !is_numeric($unit_id) || !$unit_id){
				return 100419;
			}

			$stock = $request->post('stock',0);
			
			if(!is_numeric($stock) || !$stock){
				return 100421;
			}

			$alarm_stock = $request->post('alarm_stock',0);
			// if(empty($alarm_stock)){
			// 	return 100422;
			// }
			if(!is_numeric($alarm_stock)){
				return 100423;
			}

			
			$goods_number = $request->post('goods_number');
			if(empty($goods_number)){
				return 100424;
			}

			$batch_code = $request->post('batch_code');
			if(empty($batch_code)){
				return 100425;
			}

			$bar_code = $request->post('bar_code');
			if(empty($bar_code)){
				return 100426;
			}

			$limit_count = $request->post('limit_count',0);
			if(!is_numeric($limit_count)){
				return 100428;
			}

			$limit_order = $request->post('limit_order',0);
			if(!is_numeric($limit_order)){
				return 100430;
			}

			$limit_balance = $request->post('limit_balance',0);
			if(!is_numeric($limit_balance)){
				return 100454;
			}

			$limit_coin = $request->post('limit_coin',0);
			if(!is_numeric($limit_coin)){
				return 100455;
			}

			/*
			$fee_pieces = $request->post('fee_pieces',0);
			if(!is_numeric($fee_pieces)){
				return 100432;
			}

			$fee_amount = $request->post('fee_amount',0);
			if(!is_numeric($fee_amount)){
				return 100434;
			}

			$delivery_time = $request->post('delivery_time',0);
			if(!is_numeric($delivery_time)){
				return 100436;
			}

			$is_sevenday = $request->post('is_sevenday',0);
			if(!is_numeric($is_sevenday)){
				return 100438;
			}

			$is_tenfold = $request->post('is_tenfold',0);
			if(!is_numeric($is_tenfold)){
				return 100440;
			}

			$is_indemnity = $request->post('is_indemnity',0);
			if(!is_numeric($is_indemnity)){
				return 100442;
			}

			$freight_id = $request->post('freight_id',0);
			if(!is_numeric($freight_id)){
				return 100443;
			}
			*/
			
// 			if(empty($start_time)){
// 				return 100464;
// 			}
			
// 			if(!Preg::isDate($start_time)){
// 				return 100465;
// 			}
			
			// if(strtotime($start_time) < time()){
			// 	return 100466;
			// }
			
// 			if(empty($end_time)){
// 				return 100467;
// 			}
			
// 			if(!Preg::isDate($end_time)){
// 				return 100468;
// 			}
			
// 			if(strtotime($end_time) <= strtotime($start_time)){
// 				return 100469;
// 			}

			$give_cent = $request->post('give_cent',0);
			if(!is_numeric($give_cent)){
				return 100445;
			}

			/*
			$cent_deduction = $request->post('cent_deduction',0);
			if(!is_numeric($cent_deduction)){
				return 100447;
			}

			$is_multiple_deduction = $request->post('is_multiple_deduction',0);
			if(!is_numeric($is_multiple_deduction)){
				return 100449;
			}
			*/

			$sort = $request->post('sort',1);
			if(empty($sort) || !is_numeric($sort) || !$sort){
				return 100411;
			}

			$status = $request->post('status',-1);
			if(!is_numeric($status) || !in_array($status,[-1,0,1])){
				return 100451;
			}



			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'cate_id'				=> 'CategoryID',
				'title'					=> 'GoodsTitle',
				'keyword'				=> 'Keyword',
				'desc'					=> 'Description',
				'is_virtual'			=> 'IsVirtual',
				'code'					=> 'GoodsCode',
				'pic'					=> 'Pic',
				'picture'				=> 'Picture',
				'show_type'				=> 'ShowType',
				'link_url'				=> 'LinkUrl',
				'brand_id'				=> 'BrandID',
				'sort'					=> 'Sort',
				'tags'					=> 'Tags',
				'price'					=> 'Price',
				'original_price'		=> 'OriginalPrice',
				'cost_price'			=> 'CostPrice',
				'currency_id'			=> 'CurrencyID',
				'unit_id'				=> 'UnitID',
				'stock'					=> 'Stock',
				'alarm_stock'			=> 'AlarmStock',
				'goods_number'			=> 'GoodsNumber',
				'batch_code'			=> 'BatchCode',
				'bar_code'				=> 'Barcode',
				'limit_count'			=> 'LimitCount',
				'limit_order'			=> 'LimitOrder',
				'limit_balance'			=> 'LimitBalance',
				'limit_coin'			=> 'LimitCoin',
				// 'fee_pieces'			=> 'FeePieces',
				// 'fee_amount'			=> 'FeeAmount',
				// 'delivery_time'			=> 'DeliveryTime',
				// 'is_sevenday'			=> 'IsSevenday',
				// 'is_tenfold'			=> 'IsTenfold',
				// 'is_indemnity'			=> 'IsIndemnity',
				// 'freight_id'			=> 'FreightID',
				'start_time'			=> 'StartTime',
				'end_time'				=> 'EndTime',
				'give_cent'				=> 'GiveCent',
				// 'cent_deduction'		=> 'CentDeduction',
				// 'is_multiple_deduction'	=> 'IsMultipleDeduction',
				// 'coupons'				=> 'Coupons',
				'is_allow_share'		=> 'IsAllowShare',
				// 'share_title'			=> 'ShareTitle',
				// 'share_pic'				=> 'SharePic',
				'is_allow_commission'	=> 'IsCommission',
				'commission_value'		=> 'ShareCommissionValue',
				'content'				=> 'Content',
				'status'				=> 'Status',
				'create_time'			=> 'CreateTime',
				'is_del'				=> 'IsDel'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'cate_title','field'=>'CategoryID','type'=>'varchar','length'=>'250','default'=>'','title'=>'类别','width'=>0],
				['map'=>'title','field'=>'GardenTitle','type'=>'varchar','length'=>'250','default'=>'','title'=>'商品标题','width'=>150],
				['map'=>'goods_code','field'=>'GoodsCode','type'=>'varchar','length'=>'64','default'=>'','title'=>'商品编码','width'=>150],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'250','default'=>'','title'=>'图片','width'=>0],
				['map'=>'brand_name','field'=>'BrandID','type'=>'varchar','length'=>'250','default'=>'','title'=>'品牌','width'=>0],
				['map'=>'price','field'=>'Price','type'=>'price','length'=>'1','default'=>'0','title'=>'价格','width'=>0],
				// ['map'=>'original_price','field'=>'OriginalPrice','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'原价','width'=>0],
				// ['map'=>'cost_price','field'=>'CostPrice','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'成本价','width'=>0],
				['map'=>'unit_name','field'=>'UnitID','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'单位','width'=>0],
				['map'=>'stock','field'=>'Stock','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'库存','width'=>0],
				['map'=>'sales','field'=>'Sales','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'销量','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'排序','width'=>0],
				['map'=>'status','field'=>'Status','type'=>'switch','length'=>'1','default'=>'0','title'=>'状态','width'=>0],
				// ['map'=>'batch_code','field'=>'BatchCode','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'批次号','width'=>0],
				// ['map'=>'bar_code','field'=>'Barcode','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'条形码','width'=>0],
				// ['map'=>'limit_count','field'=>'LimitCount','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'商品限购','width'=>0],
				// ['map'=>'limit_order','field'=>'LimitOrder','type'=>'tinyint','length'=>'1','default'=>'0','title'=>'订单限购','width'=>0],
				// ['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>