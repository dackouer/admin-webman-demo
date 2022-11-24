<?php
	namespace app\model\Order;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Random;
	use app\lib\Preg;
	use app\lib\Token;
	use app\lib\Json;
	use app\lib\Office;
	use app\model\Model;
	use app\model\User\UserModel;
	use app\model\Goods\GoodsModel;
	use app\model\Config\ConfigWechatModel;

	class OrderModel extends Model{
		public $table = 'order';
		public $title = '订单管理';

		protected function _init(){
			$service = new ConfigOrderModel();
			$this->config = $service->fetch(1);
		}

		public function test(Request $request){
			
		}

		protected function getShowList(Request $request){
			$order = $this->tab;
			$detail = $this->prex.'order_detail';
			$user = $this->prex.'user';
			$goods = $this->prex.'goods';
			$cate = $this->prex.'goods_cate';

			$table = "$order,$user,$goods,$cate";
			$field = "$order.ID as id,OrderType as type,OrderCode as `order`,$goods.GoodsTitle as goods_title,StockCode as stock_code,$cate.Title as cate_title,$order.UserID as uid,$order.RealName as realname,$user.Mobile as mobile,TotalCount as total,TotalFee as amount,Platform as platform,PayType as pay_type,PlatformOrder as platform_order,PayTime as pay_time,PayStatus as pay_status,$order.CreateTime as create_time,$order.Status as status";
			$where = "UserID = $user.AccountID AND GoodsID = $goods.ID AND $order.CategoryID = $cate.ID";
			$orderby = "$order.ID DESC";
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				$keyword = $this->colation($keyword);
				if(is_numeric($keyword) && strlen($keyword) == 30){
					$keyword = substr($keyword,0,strlen($keyword) - 10);
				}
				$where .= " AND (OrderCode LIKE ? OR UserID LIKE ? OR $order.RealName LIKE ? OR $user.Mobile LIKE ?)";
				array_push($param,$keyword,$keyword,$keyword,$keyword);
			}

			$type = $request->input('type');
			if($type != ''){
				if(is_numeric($type) && in_array($type,[1,2,3,4,5,6,7,8])){
					$where .= " AND OrderType = ?";
					array_push($param,$type);
				}elseif(is_string($type) && strpos($type,',') !== false){
					$where .= " AND OrderType IN ($type)";
				}
			}

			$cate_id = $request->input('cate_id');
			if($cate_id != ''){
				if(is_numeric($cate_id) && in_array($cate_id,[1,2,3,4])){
					$where .= " AND $order.CategoryID = ?";
					array_push($param,$cate_id);
				}elseif(is_string($cate_id) && strpos($cate_id,',') !== false){
					$where .= " AND $order.CategoryID IN ($cate_id)";
				}
			}

			$start_time = trim($request->input('start_time',''));
			if(!empty($start_time)){
				$where .= " AND $order.CreateTime >= ?";
				array_push($param,strtotime($start_time));
			}

			$end_time = trim($request->input('end_time',''));
			if(!empty($end_time)){
				$where .= " AND $order.CreateTime <= ?";
				array_push($param,strtotime($end_time));
			}

			$platform = trim($request->input('platform',''));
			if(!empty($platform)){
				$where .= " AND Platform = ?";
				array_push($param,$platform);
			}

			$pay_type = trim($request->input('pay_type',''));
			if(!empty($pay_type)){
				$where .= " AND PayType = ?";
				array_push($param,$pay_type);
			}

			$status = $request->input('status');
			if($status != '' && in_array($status,[-2,-1,0,1,2,3,4,5])){
				$where .= " AND $order.Status = ?";
				array_push($param,$status);
			}

			$goods_id = $request->input('goods_id');
			if(!empty($goods_id) && is_numeric($goods_id) && $goods_id){
				$where .= " AND GoodsID = ?";
				array_push($param,$goods_id);
			}

			$paystatus = $request->input('paystatus');
			if(!empty($paystatus) && is_numeric($paystatus) && $paystatus){
				$where .= " AND PayStatus = ?";
				switch($paystatus){
					case 1:
						array_push($param,1);
						break;
					case 2:
						array_push($param,0);
						break;
					default:
				}
			}

			try{
				$sql = "SELECT COUNT($order.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$object = Db::select($sql,$param);

				$result = [];
				if($object){
					$result = $this->objectToArray($object);

					for($i=0;$i<count($result);$i++){
						if($result[$i]['pay_time']){
							$result[$i]['pay_time'] = date('Y-m-d H:i:s',$result[$i]['pay_time']);
						}
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						$result[$i]['amount'] = $result[$i]['amount'] / 100;
						// $result[$i]['midfee'] = $result[$i]['midfee'] / 100;

						switch($result[$i]['type']){
							case 1:
								$result[$i]['type_title'] = '藏品';
								break;
							case 2:
								$result[$i]['type_title'] = '盲盒';
								break;
							case 3:
								$result[$i]['type_title'] = '转赠';
								break;
							case 4:
								$result[$i]['type_title'] = '空投';
								break;
							case 5:
								$result[$i]['type_title'] = '合成';
								break;
							case 6:
								$result[$i]['type_title'] = '盲盒已开';
								break;
							default:
								$result[$i]['type_title'] = '未知';
						}

						switch($result[$i]['pay_type']){
							case 'balance':
								$result[$i]['pay_type'] = '余额';
								break;
							case 'score':
								$result[$i]['pay_type'] = '积分';
								break;
							case 'coin':
								$result[$i]['pay_type'] = '金币';
								break;
							default:
						}
						
						switch($result[$i]['pay_status']){
							case 0:
								$result[$i]['pay_status_title'] = '';
								break;
							case 1:
								$result[$i]['pay_status_title'] = '待支付';
								break;
							case 2:
								$result[$i]['pay_status_title'] = '已支付';
								break;
							default:
								$result[$i]['pay_status_title'] = '';
						}

						switch($result[$i]['status']){
							case -2:
								$result[$i]['status_title'] = '被回收';
								break;
							case -1:
								$result[$i]['status_title'] = '已取消';
								break;
							case 0:
								$result[$i]['status_title'] = "待确认";
								break;
							case 1:
								$result[$i]['status_title'] = '待支付';
								break;
							case 2:
								$result[$i]['status_title'] = '已支付';
								break;
							case 3:
								$result[$i]['status_title'] = '已转赠';
								break;
							case 4:
								$result[$i]['status_title'] = '转售中';
								break;
							case 5:
								$result[$i]['status_title'] = '已转售';
								break;
							default:
								$result[$i]['status_title'] = '未知';
						}

						$service = new OrderDetailModel();
						// $result[$i]['goods'] = $service->getList($request,'order',$result[$i]['order']);
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
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 获取发行方列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			$order = $this->tab;
			$detail = $this->prex.'order_detail';
			// $collection = $this->prex.'collection';
			$issuer = $this->prex.'issuer';
			$creator = $this->prex.'creator';
			$goods = $this->prex.'goods';
			$cate = $this->prex.'goods_cate';
			$user = $this->prex.'user';

			$table = "$order";
			// $field = "$order.ID as id,OrderType as type,OrderCode as `order`,$collection.Title as collection_title,$collection.Pic as collection_pic,$issuer.Title as issuer_title,$issuer.Pic as issuer_pic,$issuer.Logo as issuer_logo,$creator.RealName as creator_name,$creator.Avatar as avatar,$goods.GoodsTitle as goods_title,$goods.Pic as goods_pic,ShowType as show_type,LinkUrl as link_url,$goods.Stock as stock,$goods.Sales as sales,$goods.LimitCount as limit_count,$goods.LimitOrder as limit_order,$goods.LimitBalance as limit_balance,$goods.LimitCoin as limit_coin,IsAllowShare as is_allow_share,IsAllowAirdrop as is_allow_airdrop,IsAllowSend as is_allow_send,IsAllowSale as is_allow_sale,$goods.Status as goods_status,$cate.Title as cate_title,$order.RealName as realname,$order.StockCode as stock_code";
			// $where = "$order.CollectionID = $collection.ID AND $order.IssuerID = $issuer.ID AND $order.CreatorID = $creator.ID AND $order.GoodsID = $goods.ID AND $order.CategoryID = $cate.ID";
			$field = "$order.ID as id,OrderType as type,OrderCode as `order`,RealName as realname,GoodsID as goods_id,TotalCount as total,TotalFee as amount,Platform as platform,PayType as pay_type,PayTime as pay_time,PayStatus as pay_status,OrderHash as order_hash,CreateTime as create_time,ExpireTime as expire_time,IsBlind as is_blind,IsOpen as is_open,Status as status,State as state,Remark as remark";
			$where = "1 = 1";
			$orderby = "$order.ID DESC";
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				$keyword = $this->setKeyword($keyword);
				$where .= " AND (OrderCode LIKE '%{$keyword}%' OR UserID LIKE '%{$keyword}%' OR $user.Mobile LIKE '%{$keyword}%')";
			}

			$uid = $request->input('uid');
			// var_dump('uid:'.$uid);
			if(!empty($uid) && is_numeric($uid) && $uid){
				$where .= " AND UserID = ?";
				array_push($param,$uid);
			}

			$type = $request->input('type');
			if(!empty($type) && is_numeric($type) && $type){
				$where .= " AND OrderType = ?";
				array_push($param,$type);
			}

			$start_time = trim($request->input('start_time',''));
			if(!empty($start_time)){
				$where .= " AND $order.CreateTime >= ?";
				array_push($param,strtotime($start_time));
			}

			$end_time = trim($request->input('end_time',''));
			if(!empty($end_time)){
				$where .= " AND $order.CreateTime <= ?";
				array_push($param,strtotime($end_time));
			}

			$platform = trim($request->input('platform',''));
			if(!empty($platform)){
				$where .= " AND Platform = ?";
				array_push($param,$platform);
			}

			$paytype = trim($request->input('paytype',''));
			if(!empty($paytype)){
				$where .= " AND PayType = ?";
				array_push($param,$paytype);
			}

			$paystatus = $request->input('paystatus');
			if($paystatus != '' && !empty($paystatus)){
				$where .= " AND PayStatus = ?";
				array_push($param,$paystatus);
			}

			$status = $request->input('status');
			if($status != ''){
				if(is_numeric($status) && in_array($status,[-1,0,1,2,3,4,5])){
					$where .= " AND $order.Status = ?";
					array_push($param,$status);
				}else{
					$where .= " AND $order.Status IN ($status)";
					// array_push($param,$status);
				}
			}

			$state = $request->input('state');
			if($state != ''){
				if(is_numeric($state) && in_array($status,[-1,0,1,2,3])){
					$where .= " AND $order.State = ?";
					array_push($param,$state);
				}else{
					$where .= " AND $order.State IN ($state)";
				}
			}

			try{
				$sql = "SELECT COUNT($order.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$object = Db::select($sql,$param);
				// var_dump('sql: '.$sql);
				// var_dump($param);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);

					for($i=0;$i<count($result);$i++){
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);

						switch($result[$i]['status']){
							case -1:
								$result[$i]['status_title'] = '已取消';
								break;
							case 0: 
								$result[$i]['status_title'] = '购物车';
								break;
							case 1: 
								$result[$i]['status_title'] = '待支付';
								break;
							case 2: 
								$result[$i]['status_title'] = '已支付';
								break;
							case 3: 
								$result[$i]['status_title'] = '已转赠';
								break;
							case 4: 
								$result[$i]['status_title'] = '转售中';
								break;
							case 5: 
								$result[$i]['status_title'] = '已转售';
								break;
							default: 
								$result[$i]['status_title'] = '未知';
						}

						$service = new OrderDetailModel();
						$result[$i]['goods'] = $service->getList($request,'order',$result[$i]['order']);
					}
				}

				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}


		// 导出
		protected function getExportList(Request $request){
			$field = $request->input('field');
			$type = $request->input('type',0);
			$is_blind = $request->input('is_blind',0);
			$start_time = $request->input('start_time');
			$end_time = $request->input('end_time');
			$count = $request->input('count',0);
			$order = $request->input('order',0);
			$name = $request->input('name',time());

			// var_dump($field);

			if(!is_numeric($type)){
				return Json::show(110786);
			}
			if(!is_numeric($is_blind)){
				return Json::show(110787);
			}
			if(!is_numeric($count)){
				return Json::show(110788);
			}
			if(!in_array($order,[0,1,'0','1'])){
				return Json::show(110789);
			}

			$fields = "";
			$title = [];
			if(empty($field)){
				$fields = 'OrderCode,GoodsID,StockCode,IssuerID,CreatorID,UserID,Mobile,SourceOrder,TotalFee,Status';
			}else{
				$map = $this->getList($request,'map');
				$mapkey = array_keys($map);
				$mapval = array_values($map);
				
				$temp = $field;
				foreach($temp as $val){
					if(in_array($val,$mapkey)){
						$fields .= "`{$map[$val]}`,";
					}else{
						if(in_array($val,$mapval)){
							$fields .= "`{$val}`,";
						}
					}
				}
				$fields = trim($fields,",");
			}

			if(empty($fields)){
				$fields = 'OrderCode,GoodsID,StockCode,IssuerID,CreatorID,UserID,Mobile,SourceOrder,TotalFee,Status';
			}

			$where = "1 = 1";
			if(!empty($type) && is_numeric($type) && $type){
				$where .= " ADN OrderType = $type";
			}
			if(!empty($is_blind) && is_numeric($is_blind) && $is_blind){
				$is_blind = (int)$is_blind;
				if($is_blind === 2){
					$where .= " AND IsBlind = 1";
				}else{
					$where .= " AND IsBlind = 0";
				}
			}
			
			if(!empty($start_time)){
				$where .= " AND CreateTime >= ".strtotime($start_time);
			}

			if(!empty($end_time)){
				$where .= " AND CreateTime <= ".strtotime($end_time);
			}

			$orderby = !$order ? "ID ASC" : ($order === 1 ? "ID ASC" : "ID DESC");
			$sql = "SELECT $fields FROM ".$this->prex.$this->table." WHERE $where ORDER BY $orderby";
			if($count){
				$sql .= " LIMIT $count";
			}

			$object = Db::select($sql);
			$result = $this->objectToArray($object);
			if($result){
				for($i=0;$i<count($result);$i++){
					$result[$i]['OrderCode'] .= " ";
					$result[$i]['TotalFee'] = $result[$i]['TotalFee'] / 100;

					switch($result[$i]['Status']){
						case -2:
							$result[$i]['Status'] = '被回收';
							break;
						case -1:
							$result[$i]['Status'] = '已取消';
							break;
						case 0:
							$result[$i]['Status'] = "待确认";
							break;
						case 1:
							$result[$i]['Status'] = '待支付';
							break;
						case 2:
							$result[$i]['Status'] = '已支付';
							break;
						case 3:
							$result[$i]['Status'] = '已转赠';
							break;
						case 4:
							$result[$i]['Status'] = '转售中';
							break;
						case 5:
							$result[$i]['Status'] = '已转售';
							break;
						default:
							$result[$i]['Status'] = '未知';
					}
				}
			}

			$field = array('订单编号','商品ID','库存编号','发行方ID','创作者ID','购买者','手机号码','来源订单号','订单金额','订单状态');
			
			Office::export($request,$field,$result,$name);

			return ['file'=> $this->host['api'].'upload/export/'.$name.'.xlsx'];
		}
		/**
		 * 获取发行方单条记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getListById(Request $request,$id = 0){
			$order = $this->tab;
			$detail = $this->prex.'order_detail';
			$user = $this->prex.'user';

			if(empty($id) || !$id){
				return [];
			}

			$table = "$order";
			$field = "$order.ID as id,OrderType as type,OrderCode as `order`,UserID as uid,RealName as realname,OpenID as openid,GoodsID as goods_id,CategoryID as cate_id,TotalCount as total,TotalFee as amount,Platform as platform,PayType as pay_type,PayTime as pay_time,PlatformOrder as platform_order,PayStatus as pay_status,CreateTime as create_time,ExpireTime as expire_time,Status as status,State as state,Remark as remark";
			$where = "OrderCode = ?";
			$param = [$id];

			$result = [];
			$sql = "SELECT $field FROM $table WHERE $where LIMIT 1";
			$object = Db::select($sql,$param);
			if($object){
				if($object[0]->pay_time){
					$object[0]->pay_time = date('Y-m-d H:i:s',$object[0]->pay_time);
				}
				$object[0]->create_time = date('Y-m-d H:i:s',$object[0]->create_time);

				if($object[0]->expire_time > time()){
					$object[0]->waitime = $object[0]->expire_time - time();
				}else{
					$object[0]->waitime = 0;
				}

				$result = $this->objectToArray($object);
				$service = new OrderDetailModel();
				$result[0]['goods'] = $service->getList($request,'order',$result[0]['order']);
				$result[0]['buy_message'] = $this->config['BuyMessage'];
				$result = $result[0];
			}

			return $result;
		}

		// 获取某用户的转赠记录
		protected function getTransferList(Request $request){
			$uid = $request->input('uid');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);

			if(!$user){
				return 100007;
			}

			$order = $this->tab;
			$detail = $this->prex.'order_detail';
			$issuer = $this->prex.'issuer';
			$creator = $this->prex.'creator';
			$goods = $this->prex.'goods';
			$cate = $this->prex.'goods_cate';
			$user = $this->prex.'user';

			$table = "$order";
			$field = "$order.ID as id,OrderType as type,OrderCode as `order`,SourceOrder as source_order,RealName as realname,GoodsID as goods_id,TotalCount as total,TotalFee as amount,Platform as platform,PayType as pay_type,PayTime as pay_time,PayStatus as pay_status,OrderHash as order_hash,CreateTime as create_time,ExpireTime as expire_time,IsBlind as is_blind,Status as status,State as state,Remark as remark";
			$where = "OrderType = 3 AND SourceUserID = ?";
			$orderby = "$order.ID DESC";
			$param = [$uid];

			$limit = $this->getLimit($request);

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
			$object = Db::select($sql,$param);

			$result = [];
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);

					switch($result[$i]['status']){
						case -1:
							$result[$i]['status_title'] = '已取消';
							break;
						case 0: 
							$result[$i]['status_title'] = '购物车';
							break;
						case 1: 
							$result[$i]['status_title'] = '待支付';
							break;
						case 2: 
							$result[$i]['status_title'] = '已支付';
							break;
						case 3: 
							$result[$i]['status_title'] = '已转赠';
							break;
						case 4: 
							$result[$i]['status_title'] = '转售中';
							break;
						case 5: 
							$result[$i]['status_title'] = '已转售';
							break;
						default: 
							$result[$i]['status_title'] = '未知';
					}

					$service = new OrderDetailModel();
					$result[$i]['goods'] = $service->getList($request,'order',$result[$i]['order']);
				}
			}

			return $result;

		}

		/**
		 * 订单支付
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function pay(Request $request){
			if(!$this->config['IsPay']){
				return 100846;
			}

			$uid = $request->post('uid');
			$order = $request->post('order');
			$platform = trim($request->post('platform',''));
			$pay_type = trim($request->post('pay_type',''));
			$amount = $request->post('amount','');

			// var_dump('uid: '.$uid);
			// var_dump('order: '.$order);
			// var_dump('platform: '.$platform);
			// var_dump('pay_type: '.$pay_type);
			// var_dump('amount: '.$amount);

			if(empty($platform) || empty($pay_type) || !is_string($platform) || !is_string($pay_type) || !$platform || !$pay_type){
				return 100007;
			}

			if(empty($platform) || !in_array($platform,['huanrang','sande','wechat','alipay']) || !in_array($pay_type,['balance','coin','h5','c2b','c2c','jsapi','native'])){
				return 100007;
			}

			if($platform == 'huanrang'){
				if(!$this->config['IsPlatformPay']){
					return 100847;
				}
			}

			if($platform == 'wechat'){
				if(!$this->config['IsWechatPay']){
					return 100848;
				}
			}

			if($platform == 'alipay'){
				if(!$this->config['IsAliPay']){
					return 100849;
				}
			}

			if($platform == 'sande'){
				if(!$this->config['IsSandePay']){
					return 100850;
				}
			}

			if($pay_type == 'balance'){
				if(!$this->config['IsBalancePay']){
					return 100851;
				}
			}

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			if(empty($order) || !is_numeric($order) || !$order){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			if(!$user){
				return 100007;
			}

			if(!$user['is_auth']){
				return 100791;
			}
			if($user['age'] < 18){
				return 100792;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			$result = $this->getList($request,$order);
			if(!$result){
				return 100007;
			}

			if($result['status'] == -1){
				return 100835;
			}

			if($result['status'] == 2){
				return 100836;
			}

			if($result['status'] != 1){
				return 100834;
			}

			if($result['expire_time'] < time()){
				return 100841;
			}

			if($platform == 'huanrang' && $pay_type == 'balance'){
				if($user['balance'] <= 0){
					return 100837;
				}
				if($user['balance'] < $result['amount']/100){
					return 100837;
				}
			}

			$number = $this->getNotpayOrderByUser($uid,$order);
			if($number > 0){
				return 100823;
			}

			/*
			$collection_id = $result['collection_id'];
			$type = $result['type'];

			$service = new CollectionModel();
			$collection = $service->getList($request,$collection_id);

			if(!$collection){
				return 100800;
			}

			if(!$collection['is_issue']){
				return 100801;
			}

			if(($type == 1 && $collection['is_blind']) || ($type == 2 && !$collection['is_blind'])){
				return 100802;
			}

			if(strtotime($collection['start_time']) > time()){

				return 100803;
			}

			if(strtotime($collection['end_time']) < time()){
				return 100804;
			}

			if($collection['sales'] >= $collection['issue_number']){
				return 100805;
			}
			
			if($collection['limit_number']){
				$number = $this->getCollectionOrderByUser($collection_id,$uid,$type);
				if($number >= $collection['limit_number']){
					return 100806;
				}
			}
			*/

			$goods_id = $result['goods_id'];

			$service = new GoodsModel();
			$goods = $service->getList($request,$goods_id);

			if(!$goods){
				return 100810;
			}
			
			// if(!in_array($goods_id,explode(',',$collection['goods']))){
			// 	return 100811;
			// }

			if($goods['status'] != 1){
				return 100812;
			}

			$service = new UserPriorityModel();
			$priority = $service->getList($request,'priority',$uid,$goods_id);
			if(!$priority){
				if(strtotime($goods['start_time']) > time()){
					return 100803;
				}
			}else{
				if((strtotime($goods['start_time']) - $priority['priority_time'] * 3600) > time()){
					return 100803;
				}
			}

			if(strtotime($goods['end_time']) < time()){
				return 100804;
			}

			if($goods['stock'] > 0 && $goods['sales'] >= $goods['stock']){
				return 100813;
			}

			if($goods['limit_count']){
				$number = $this->getGoodsOrderByUser($goods_id,$uid,$result['type']);
				if($number >= $goods['limit_count']){
					return 100814;
				}
			}

			if($goods['limit_order']){
				$number = $this->getGoodsOrderByUser($goods_id,$uid,$result['type']);
				if($number >= $goods['limit_order']){
					return 100815;
				}
			}


			$result['platform'] = $platform;
			$result['pay_type'] = $pay_type;


			// 支付前更新支付方式
			if($this->setPlatform($order,$platform,$pay_type)){
				// var_dump('update platform');
				if($platform == 'sande'){
					switch($pay_type){
						case 'h5':		// 杉德一键快捷
							// var_dump('sande h5');
							$service = new SandeModel();
							$res = $service->payment($request);
							if(strtolower(substr($res,0,4)) == 'http'){
								return ['url' => $res];
							}else{
								return $res;
							}
						case 'c2b':		// 杉德C2B
							$service = new SandeModel();
							$res = $service->ctob($request);
							if(strtolower(substr($res,0,4)) == 'http'){
								return ['url' => $res];
							}else{
								return $res;
							}
						case 'c2c':		// 杉德C2C
							$service = new SandeModel();
							$res = $service->ctoc($request);
							if(strtolower(substr($res,0,4)) == 'http'){
								return ['url' => $res];
							}else{
								return $res;
							}
						default:
							return 100007;

					}
				}elseif($platform == 'wechat'){
					switch($pay_type){
						case 'native':		// 微信native支付
							break;
						case 'jsapi':		// 微信jsapi支付
							break;
						default:
							return 100007;

					}
				}elseif($platform == 'alipay'){
					switch($pay_type){
						case 'native':		// 支付宝native支付
							break;
						case 'jsapi':		// 支付宝jsapi支付
							break;
						default:
							return 100007;

					}
				}elseif($platform == 'huanrang'){
					switch($pay_type){
						case 'balance':		// 平台余额支付
							return $this->updatePay($order,$result);
						case 'coin':		// 平台金币支付
							return $this->updatePay($order,$result);
						default:
							return 100007;

					}
				}else{
					return 100007;
				}
				
			}else{
				return 100007;
			}

		}

		/**
		 * 处理支付回调订单状态
		 * @param [type] $order [description]
		 */
		private function setStatus($request,$data){
			// var_dump('开始处理支付回调订单状态');
			// var_dump($data);
			// 
			// 
			// 
			// var_dump($data);

			$appid = $data['appid'];
			$amount = $data['total_fee'];
			$mch_id = $data['mch_id'];
			$openid = $data['openid'];
			$out_trade_no = $data['out_trade_no'];

			var_dump('out_trade_no: '.$out_trade_no);
			$result_code = $data['result_code'];
			$return_code = $data['return_code'];
			$trade_type = $data['trade_type'];
			$order = substr($out_trade_no,0,strlen($out_trade_no)-10);
			var_dump('order: '.$order);
			$order = trim($order);
			if(empty($order)){
				return false;
			}
			var_dump('处理回调：'.$order);
			$result = $this->getList($request,$order);
			var_dump($result);
			if(!$result){
				return false;
			}
			// var_dump('result:');
			// var_dump($result);
			$service = new ConfigWechatModel();
			$config = $service->fetch(1);
			var_dump($config);
			if($this->config['IsTestPay']){
				$result_amount = $this->config['TestPayFee'] * 100;
			}else{
				$result_amount = $result['amount'];
			}

			// var_dump('订单：platform_no: '.$result['platform_no']);
			// var_dump('订单：platform_key: '.$result['platform_key']);
			// var_dump('订单：platform_order: '.$result['platform_order']);
			// var_dump('回调：out_trade_no: '.$out_trade_no);
			if($appid != $config['MiniAppId'] || $mch_id != $config['MchId'] || $result_amount != $amount || $result['openid'] != $openid){
				var_dump('订单验证失败');
				return false;
			}

			if($result['status'] == 2){
				var_dump('订单已支付');
				return true;
			}

			if(!in_array($result['status'],[-1,1])){
				var_dump('订单状态错误');
				return false;
			}


			$sql = "UPDATE ".$this->tab." SET PayStatus = 1,Status = 2,Payment = ?,PayTime = ? WHERE OrderCode = ?";
			$param = [$amount,time(),$order];
			var_dump('sql: '.$sql);
			$resp = Db::update($sql,$param);
			var_dump('resp: '.$resp);
			
			if($resp){
				var_dump('更新订单状态为支付成功');
				var_dump('处理库存');
				$service = new GoodsModel();
				$service->setStock($result['goods']);
				return true;
			}else{
				var_dump('回调处理失败');
			}

			return false;
		}

		/**
		 * 处理支付回调
		 * @param Request $request [description]
		 */
		public function setNotify(Request $request){
			$xml = $request->rawBody();
			$xml = json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA));
			$data = json_decode($xml,true);
			var_dump('收到回调信息');
			var_dump($data);
			if($data){
				if($data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS'){
					// var_dump('回调状态ok，开始处理');
					return $this->setStatus($request,$data);
				}else{
					// var_dump('回调状态失败');
				}
				return false;
			}
		}

		// 处理第三方平台订单支付状态
		public function updatePayment(Request $request,$data){
			// var_dump('处理第三方平台订单支付状态');
			if(!$data || !isset($data['orderCode'])){
				return false;
			}

			$mid = $data['mid'];
			$platform_order = $data['orderCode'];
			$order = substr($data['orderCode'],0,strlen($data['orderCode']) - 10);
			$amount = (int)$data['totalAmount'];
			$status = (int)$data['orderStatus'];
			// $midfee = (int)$data['midFee'];

			// var_dump('mid: '.$mid);
			// var_dump('order: '.$order);
			// var_dump('amount: '.$amount);
			// var_dump('status: '.$status);
			// var_dump('midfee: '.$midfee);

			$service = new ConfigSandeModel();
			$config_sande = $service->fetch(1);
			
			if($mid != $config_sande['MerchantID']){
				return false;
			}

			$result = $this->getList($request,$order);

			if(!$result){
				return false;
			}

			if($this->config['IsTestPay']){
				$real_amount = $this->config['TestPayFee'] * 100;
			}else{
				$real_amount = $result['amount'];
			}

			if($amount != $real_amount){
				return false;
			}

			if($result['status'] == 2){
				return true;
			}

			if($result['status'] != 1){
				return false;
			}
			
			$resp = $this->updatePay($order,$result,$amount,$platform_order);

			if(!is_array($resp)){
				return false;
			}
			return true;
		}

		// 平台支付更新订单支付状态
		private function updatePay($order,$data,$amount = 0,$platform_order = ''){
			if(!$amount && isset($data['amount'])){
				$amount = $data['amount'];
			}
			$sql = "UPDATE ".$this->tab." SET PayStatus = 2,Status = 2,Payment = ?,PayTime = ?,PlatformOrder = ? WHERE OrderCode = ?";
			$param = [$amount,time(),$platform_order,$order];
			// var_dump($sql);
			// var_dump($param);
			// var_dump($data);
			if(Db::update($sql,$param)){
				// 订单支付状态更新成功，处理回调状态
				return $this->setOrderNotify($data);
			}else{
				return 100839;
			}
		}

		// 处理支付回调状态
		private function setOrderNotify($data){
			// var_dump('处理支付回调状态');
			// var_dump($data);
			
			// 处理优先购
			if($data['is_priority']){

				$service = new UserPriorityModel();
				$service->setPriorityIncrement($data['uid'],$data['goods_id']);
			}

			// 处理库存
			$this->updateGoodsStock($data);
			
			// 处理用户
			if($data['platform'] == 'huanrang' && $data['pay_type'] == 'balance'){
				$this->updateOrderUser($data);
			}

			// 处理上链
			$this->setChain($data);

			return $data;
		}	

		// 处理支付成功用户的状态
		private function updateOrderUser($data){
			$sql = "UPDATE hrang_user SET TotalBalance = TotalBalance - ?,Balance = Balance - ? WHERE AccountID = ?";
			$param = [$data['amount']/100,$data['amount']/100,$data['uid']];

			if(Db::update($sql,$param)){
				return true;
			}
			return false;
		}	

		// 处理支付成功后库存信息
		private function updateGoodsStock($data){
			$sql = "UPDATE hrang_goods SET Sales = Sales + ? WHERE ID = ?";
			$param = [$data['total'],$data['goods_id']];

			if(Db::update($sql,$param)){
				return true;
			}
			return false;
		}

		// 更新订单上链信息
		private function updateOrderChain($order,$operation_id = ''){
			if(empty($operation_id)){
				return false;
			}
			$time = time();

			$sql = "UPDATE ".$this->tab." SET OperationID = ?,HashTime = ? WHERE OrderCode = ?";
			$param = [$operation_id,$time,$order];

			return Db::update($sql,$param) !== false ? true : false;
		}

		// 更新订单上链信息
		private function updateOrderChainByOperationID($operation_id = '',$hash = ''){
			if(empty($operation_id) && empty($hash)){
				return false;
			}

			$sql = "UPDATE ".$this->tab." SET OrderHash = ? WHERE OperationID = ?";
			$param = [$hash,$operation_id];

			return Db::update($sql,$param);
		}

		// 处理订单上链
		private function setChain($data){

			$arr = [
				'cate_id'	=> $data['goods']['cate_chain'],
				'title'		=> $data['goods']['goods_title']
			];

			$service = new AvataModel();
			$result = $service->issue($arr,true);

			if($result){
				if(isset($result['error'])){
					return ['code' => 'fail','msg' => $result['error']['code'].': '.$result['error']['message']];
				}else{
					$resp = $this->updateOrderChain($data['order'],$result['data']['operation_id']);
					if($resp){
						// var_dump($result);
						// var_dump('order: '.$data['order']);
						// var_dump('operation_id: '.$result['data']['operation_id']);
						\Workerman\Timer::add(60,array($this,'autoHash'),[$data['order'],$result['data']['operation_id']],false);

						return ['code' => 'ok','msg' => 'success'];
					}
					return 100473;
				}
			}else{
				return 100472;
			}
		}

		// 设置支付平台和支付方式
		public function setPlatform($order,$platform,$pay_type){
			$sql = "UPDATE ".$this->tab." SET Platform = ?,PayType = ?,PayStatus = 1 WHERE OrderCode = ?";
			$param = [$platform,$pay_type,$order];

			$result = Db::update($sql,$param);

			return $result !== false ? true : false;
		}

		/**
		 * 转赠订单
		 * @param Request $request [description]
		 */
		public function setSend(Request $request){
			if(!$this->config['IsOrder']){
				return 100780;
			}

			if(!$this->config['IsTransfer']){
				return 100784;
			}

			$order = $request->post('order');
			$user_id = $request->post('user_id');
			$secret = $request->post('secret');

			if(empty($order)){
				return 100007;
			}

			$result = $this->getList($request,$order);

			if(!$result){
				return 100007;
			}

			if($result['status'] != 2){
				return 100834;
			}

			$goods_id = $result['goods_id'];
			if(!$goods_id){
				return 100834;
			}

			$service = new GoodsModel();
			$goods = $service->getList($request,$goods_id);

			if(!$goods){
				return 100834;
			}

			if(!$goods['is_allow_send']){
				return 100817;
			}

			if(empty($user_id) || !is_numeric($user_id) || !$user_id){
				return 100007;
			}

			if(Preg::isMobile($user_id)){
				$service = new UserModel();
				$user = $service->getList($request,'mobile',$user_id);
			}else{
				$service = new UserModel();
				$user = $service->getList($request,$user_id);
			}

			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			if(!$user['is_auth']){
				return 100842;
			}

			if($user['uid'] == $result['uid'] || $user['mobile'] == $result['uid']){
				return 100225;
			}

			if(empty($secret)){
				return 100190;
			}

			$service = new UserModel();
			if(!$service->checkSecurePassword($result['uid'],$secret)){
				return 100224;
			}

			$sql = "UPDATE ".$this->tab." SET Status = 3 WHERE OrderCode = ?";
			$param = [$order];

			if(Db::update($sql,$param)){
				if($this->createOrder($request,3,$user,$goods,$result)){
					return ['code'=>'ok','msg'=>'success'];
				}

				return 100852;
			}

			return 100843;
		}

		// 创建一个订单
		private function createOrder(Request $request,$type,$user,$goods,$order = [],$status = 2){
			$data = [
				'cate_id'				=> $goods['cate_id'],
				'issuer_id'				=> $goods['issuer_id'],
				'creator_id'			=> $goods['creator_id'],
				'collection_id'			=> isset($goods['collection_id']) ? $goods['collection_id'] : 0,
				'is_blind'				=> $goods['is_blind'],
				'goods_id'				=> $goods['id'],
				'stock_code'			=> isset($order['stock_code']) ? $order['stock_code'] : $this->getStockCode($goods['id'],$goods['total_stock']),
				'type'					=> $type,
				'order'					=> $this->createOrderNumber(),
				'uid'					=> $user['uid'],
				'mobile'				=> $user['mobile'],
				'realname'				=> $user['realname'],
				'idcard'				=> $user['idcard'],
				'total'					=> isset($order['total']) ? $order['total'] : 1,
				'amount'				=> isset($order['amount']) ? $order['amount'] : $goods['price'],
				'source_order'			=> isset($order['uid']) ? ($user['uid'] != $order['uid'] ? $order['order'] : '') : '',
				'source_uid'			=> isset($order['uid']) ? ($user['uid'] != $order['uid'] ? $order['uid'] : '') : 0,
				'token'					=> $this->createOrderToken(),
				'status'				=> $status,
				'create_time'			=> time(),
				'expire_time'			=> time()
			];

			$sql = "INSERT INTO ".$this->tab." (`CategoryID`,`IssuerID`,`CreatorID`,`CollectionID`,`IsBlind`,`GoodsID`,`StockCode`,`OrderType`,`OrderCode`,`UserID`,`Mobile`,`RealName`,`Idcard`,`TotalCount`,`TotalFee`,`SourceOrder`,`SourceUserID`,`OrderToken`,`Status`,`CreateTime`,`ExpireTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$param = [$data['cate_id'],$data['issuer_id'],$data['creator_id'],$data['collection_id'],$data['is_blind'],$data['goods_id'],$data['stock_code'],$data['type'],$data['order'],$data['uid'],$data['mobile'],$data['realname'],$data['idcard'],$data['total'],$data['amount'],$data['source_order'],$data['source_uid'],$data['token'],$data['status'],$data['create_time'],$data['expire_time']];
			if(Db::insert($sql,$param)){
				$service = new OrderDetailModel();
				return $service->append($data);
			}
			return false;
		}

		/**
		 * 出售
		 * @param Request $request [description]
		 */
		public function setSale(Request $request){
			if(!$this->config['IsOrder']){
				return 100780;
			}

			if(!$this->config['IsSecMarket']){
				return 100226;
			}

			if(!$this->config['IsResale']){
				return 100227;
			}

			$order = $request->post('order');
			$amount = $request->post('amount');
			$secret = $request->post('secret');

			if(empty($order)){
				return 100007;
			}

			$result = $this->getList($request,$order);

			if(!$result){
				return 100007;
			}
			$uid = $result['uid'];
			if($result['status'] != 2){
				return 100834;
			}

			$goods_id = $result['goods_id'];
			if(!$goods_id){
				return 100834;
			}

			$service = new GoodsModel();
			$goods = $service->getList($request,$goods_id);

			if(!$goods){
				return 100834;
			}

			if(!$goods['is_allow_sale']){
				return 100820;
			}

			if(empty($amount) || !is_numeric($amount) || !$amount){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$result['uid']);

			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			if(!$user['is_auth']){
				return 100842;
			}

			if(empty($secret)){
				return 100190;
			}

			$service = new UserModel();
			if(!$service->checkSecurePassword($uid,$secret)){
				return 100224;
			}

			$sql = "UPDATE ".$this->tab." SET Status = 4 WHERE OrderCode = ?";
			$param = [$order];

			if(Db::update($sql,$param)){
				return ['code'=>'ok','msg'=>'success'];
			}

			return 100844;
		}

		/**
		 * 取消出售
		 * @param Request $request [description]
		 */
		public function setCancelSale(Request $request){
			$order = $request->post('order');

			if(empty($order)){
				return 100007;
			}

			$result = $this->getList($request,$order);

			if(!$result){
				return 100007;
			}
			$uid = $result['uid'];
			if($result['status'] != 4){
				return 100834;
			}

			$sql = "UPDATE ".$this->tab." SET Status = 2 WHERE OrderCode = ?";
			$param = [$order];

			if(Db::update($sql,$param)){
				return ['code'=>'ok','msg'=>'success'];
			}

			return 100845;
		}

		/**
		 * 取消订单
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function cancel(Request $request){
			$uid = $request->input('uid');
			$order = $request->input('order');

			if(empty($uid) || !$uid || empty($order) || !$order){
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

			$result = $this->getList($request,$order);

			if(!$result){
				return 100007;
			}

			if($result['status'] == -1){
				return 100830;
			}

			if($result['status'] == 2){
				return 100831;
			}

			if($result['status'] != 1){
				return 100832;
			}

			if($result['uid'] != $uid){
				return 100833;
			}

			$sql = "UPDATE ".$this->tab." SET Status = -1,Remark = ? WHERE OrderCode = ?";
			$param = ['手动取消',$order];

			if(Db::update($sql,$param)){
				return ['code' => 0,'msg' => 'success'];
			}else{
				return 100032;
			}
		}

		// 自动取消订单
		public function autoCancel($order,$remark = 'timeout'){

			$sql = "UPDATE ".$this->tab." SET Status = -1,Remark = ? WHERE Status = 1 AND OrderCode = ?";
			$res = Db::update($sql,[$remark,$order]);
			if($res === 1){
				// var_dump('订单未支付，取消订单成功');
				return true;
			}else{
				// var_dump('订单状态不符或已被取消');
				return false;
			}
		}

		// 创建订单后添加订单明细
		protected function setExcute(Request $request,$data,$flag = false){
			if(!$flag){

				// 优先购处理
				// $service = new UserPriorityModel();
				// $service->setPriorityIncrement($data['uid'],$data['goods_id']);

				$service = new OrderDetailModel();
				if($service->append($data)){

					// 添加定时器过期自动取消订单
					$waitime = $this->config['WaitTime'];
					$waitime = $waitime * 60;
					if($waitime){
						// var_dump('创建取消订单的定时器：'.$waitime.' 秒');
						\Workerman\Timer::add($waitime,array($this,'autoCancel'),$data['order'],false);
					}

					return true;
				}else{
					// 订单详情添加失败
				}
			}
		}

		// validate
		protected function validate(Request $request,$flag = false){
			if(!$this->config['IsOrder']){
				return 100780;
			}

			$type = $request->post('type',1);
			$uid = $request->post('uid');
			$goods_id = $request->post('goods_id');
			$is_cart = $request->post('is_cart',0);
			$remark = trim($request->post('remark',''));
			$amount = 0;
			$total = 0;


			if($type == '' || !in_array($type,[1,2])){
				return 100781;
			}
			
			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100790;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			// var_dump($user);
			if(!$user){
				return 100790;
			}
			if($this->config['IsMustAuth'] && !$user['is_auth']){
				return 100791;
			}
			// if($user['age'] < 18){
			// 	return 100792;
			// }
			if(!$user['is_valid']){
				return 100793;
			}
			if($user['is_locked']){
				return 100794;
			}
			if($user['is_del']){
				return 100795;
			}

			$data['type'] = $type;
			$data['mobile'] = $user['mobile'];
			$data['realname'] = $user['realname'];
			$data['idcard'] = $user['idcard'];
			$data['openid'] = $user['openid'];

			if(empty($goods_id) || !is_numeric($goods_id) || !$goods_id){
				return 100810;
			}

			$service = new GoodsModel();
			$goods = $service->getList($request,$goods_id);

			if(!$goods){
				return 100810;
			}

			if($goods['status'] != 1){
				return 100812;
			}
			
			if($goods['stock'] > 0 && ($goods['sales'] >= $goods['stock'])){
				return 100813;
			}

			if($goods['limit_count']){
				$number = $this->getGoodsOrderByUser($goods_id,$uid,$type);
				if($number >= $goods['limit_count']){
					return 100814;
				}
			}

			if($goods['limit_order']){
				$number = $this->getGoodsOrderByUser($goods_id,$uid,$type);
				if($number >= $goods['limit_order']){
					return 100815;
				}
			}

			if($is_cart){
				// 购物车
				$quantity = $request->post('quantity');
				if(empty($quantity) || !is_numeric($quantity) || !$quantity){
					return 100816;
				}
				if($quantity > ($goods['stock'] - $goods['sales'])){
					return 100817;
				}
				$data['amount'] = $goods['price'] * $quantity;
				$data['total'] = $quantity;
			}else{
				$quantity = $request->post('quantity');
				if(empty($quantity) || !is_numeric($quantity) || !$quantity){
					return 100816;
				}
				if($quantity > ($goods['stock'] - $goods['sales'])){
					return 100817;
				}
				$data['amount'] = $goods['price'] * $quantity;
				$data['total'] = $quantity;
			}
			
			// var_dump('amount: '.$amount);
			// var_dump('price: '.$goods['price']);
			// if(empty($amount) || !is_numeric($amount) || !$amount){
			// 	return 100821;
			// }

			// if($amount != $goods['price']/100){
			// 	return 100821;
			// }

			// if($total > 1){
			// 	return 100822;
			// }

			// $data['stock_code'] = $this->getStockCode($goods_id,$goods['total_stock']);
			// if(!$data['stock_code']){
			// 	return 100840;
			// }

			
			$data['cate_id'] = $goods['cate_id'];
			$data['order'] = $this->createOrderNumber();
			$data['token'] = $this->createOrderToken();

			$data['expire_time'] = time() + $this->config['WaitTime'] * 60;

			return $data;
		}

		// 创建订单编号
		private function createOrderNumber(){
			$num = $this->config['OrderLength'];
			$order = date('Ymd').Random::create($num);

			$object = Db::table($this->table)->select('ID')->where('OrderCode',$order)->first();
			
			if($object){
				$order = $this->createOrderNumber();
			}

			return $order;
		}

		// 创建订单token
		private function createOrderToken(){
			$token = Token::create();

			$object = Db::table($this->table)->select('ID')->where('OrderToken',$token)->first();
			
			if($object){
				$token = $this->createOrderToken();
			}

			return $token;
		}

		// 获取某个用户未支付订单
		private function getNotpayOrderByUser($uid,$order = ''){
			$sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE UserID = ? AND Status = 1";
			$param = [$uid];
			if(!empty($order)){
				$sql .= " AND OrderCode <> ?";
				array_push($param,$order);
			}
			$object = Db::select($sql,$param);
			if($object){
				return $object[0]->count;
			}else{
				return 0;
			}
		}

		// 获取某个用户某个商品集的有效购买数量
		public function getCollectionOrderByUser($collection_id,$uid,$type){
			$sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE CollectionID = ? AND UserID = ? AND OrderType = ? AND Status = 2";
			$param = [$collection_id,$uid,$type];

			$object = Db::select($sql,$param);
			if($object){
				return $object[0]->count;
			}else{
				return 0;
			}
		}

		// 获取某个用户某个商品的有效购买数量
		public function getGoodsOrderByUser($goods_id,$uid,$type){
			$sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE GoodsID = ? AND UserID = ? AND OrderType = ? AND Status = 2";
			$param = [$goods_id,$uid,$type];

			$object = Db::select($sql,$param);
			if($object){
				return $object[0]->count;
			}else{
				return 0;
			}
		}

		/**
		 * 手动回调
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function handNotify(Request $request,$order = 0){
			return 100006;
		}

		/**
		 * 锁单
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function handLock(Request $request,$order = 0){
			return 100006;
		}

		/**
		 * 恢复锁单
		 * @param  Request $request [description]
		 * @param  integer $order   [description]
		 * @return [type]           [description]
		 */
		public function handUnLock(Request $request,$order = 0){



			return 100006;
		}

		// 获取某个用户的订单列表
		protected function getPersonalList(Request $request,$uid = 0,$status = ''){
			if(is_null($uid) || empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			if(!$user){
				return 100007;
			}
			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100006;
			}

			$order = $this->tab;
			$detail = $this->prex.'order_detail';
			$goods = $this->prex.'goods';
			$cate = $this->prex.'goods_cate';
			$user = $this->prex.'user';

			$table = "$order";
			$field = "$order.ID as id,OrderType as type,OrderCode as `order`,UserID as uid,RealName as realname,TotalCount as total,TotalFee as amount,Platform as platform,PayType as pay_type,PayTime as pay_time,PayStatus as pay_status,CreateTime as create_time,ExpireTime as expire_time,Status as status,State as state,Remark as remark";
			$where = "UserID = ?";
			$orderby = "$order.ID DESC";
			$param = [$uid];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				$keyword = $this->setKeyword($keyword);
				$where .= " AND (OrderCode LIKE '%{$keyword}%' OR UserID LIKE '%{$keyword}%' OR $user.Mobile LIKE '%{$keyword}%')";
			}

			$type = $request->input('type');
			if(!empty($type) && is_numeric($type) && $type){
				$where .= " AND OrderType = ?";
				array_push($param,$type);
			}

			$start_time = trim($request->input('start_time',''));
			if(!empty($start_time)){
				$where .= " AND $order.CreateTime >= ?";
				array_push($param,strtotime($start_time));
			}

			$end_time = trim($request->input('end_time',''));
			if(!empty($end_time)){
				$where .= " AND $order.CreateTime <= ?";
				array_push($param,strtotime($end_time));
			}

			$platform = trim($request->input('platform',''));
			if(!empty($platform)){
				$where .= " AND Platform = ?";
				array_push($param,$platform);
			}

			$paytype = trim($request->input('paytype',''));
			if(!empty($paytype)){
				$where .= " AND PayType = ?";
				array_push($param,$paytype);
			}

			$paystatus = $request->input('paystatus');
			if($paystatus != '' && !empty($paystatus)){
				$where .= " AND PayStatus = ?";
				array_push($param,$paystatus);
			}

			// $status = $request->input('status');
			if($status != '' && !is_null($status)){
				if(is_numeric($status) && in_array($status,[-1,0,1,2,3,4,5])){
					$where .= " AND $order.Status = ?";
					array_push($param,$status);
				}else{
					$where .= " AND $order.Status IN ($status)";
					// array_push($param,$status);
				}
			}

			$state = $request->input('state');
			if($state != ''){
				if(is_numeric($state) && in_array($status,[-1,0,1,2,3])){
					$where .= " AND $order.State = ?";
					array_push($param,$state);
				}else{
					$where .= " AND $order.State IN ($state)";
				}
			}

			try{
				$sql = "SELECT COUNT($order.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				$object = Db::select($sql,$param);
				// var_dump('sql: '.$sql);
				// var_dump($param);
				$result = [];
				if($object){
					$result = $this->objectToArray($object);

					for($i=0;$i<count($result);$i++){
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);

						switch($result[$i]['status']){
							case -1:
								$result[$i]['status_title'] = '已取消';
								break;
							case 0: 
								$result[$i]['status_title'] = '购物车';
								break;
							case 1: 
								$result[$i]['status_title'] = '待支付';
								break;
							case 2: 
								$result[$i]['status_title'] = '已支付';
								break;
							default: 
								$result[$i]['status_title'] = '未知';
						}

						$service = new OrderDetailModel();
						$result[$i]['goods'] = $service->getList($request,'order',$result[$i]['order']);
					}
				}

				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}


		// 获取某个用户的订单信息
		protected function getUserList(Request $request){
			// var_dump('alsdfjkas');
			$uid = $request->post('uid');
			$collection_id = $request->post('collection_id');
			$goods_id = $request->post('goods_id');
			$type = $request->post('type');
			$status = $request->post('status',2);
			$state = $request->post('state');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$field = "COUNT(ID) as count";
			$where = "UserID = ?";
			$param = [$uid];

			if(!empty($collection_id) && is_numeric($collection_id) && $collection_id){
				$where .= " AND CollectionID = ?";
				array_push($param,$collection_id);
			}

			if(!empty($goods_id) && is_numeric($goods_id) && $goods_id){
				$where .= " AND GoodsID = ?";
				array_push($param,$goods_id);
			}

			if(!empty($type) && is_numeric($type) && $type){
				$where .= " AND OrderType = ?";
				array_push($param,$type);
			}

			if(!empty($status) && is_numeric($status) && $status){
				$where .= " AND Status = ?";
				array_push($param,$status);
			}

			if(!empty($state) && is_numeric($state) && $state){
				$where .= " AND State = ?";
				array_push($param,$state);
			}

			$sql = "SELECT $field FROM ".$this->tab." WHERE $where";
			$object = Db::select($sql,$param);

			$count = 0;
			if($object){
				$count = $object[0]->count;
			}

			return ['uid' => $uid,'user_count' => $count];
		}

		// public function test(Request $request){
		// 	$code = $this->getStockCode(1,2000);
		// 	return $code;
		// }

		// 获取某个藏品的销售编号
		private function getStockCode($goods_id,$total_stock){
			$sql = "SELECT StockCode FROM ".$this->tab." WHERE GoodsID = ? AND Status = 2";
			$param = [$goods_id];

			$result = [];
			$object = Db::select($sql,$param);
			if($object){
				$result = $this->objectToArray($object);
				$result = array_column($result,'StockCode');
			}

			$arr = [];
			for($i=1;$i<=$total_stock;$i++){
				if($result){
					if(!in_array($i,$result)){
						array_push($arr,$i);
					}
				}else{
					array_push($arr,$i);
				}
			}

			if($arr){
				$num = mt_rand(0,count($arr)-1);
				shuffle($arr);
				
				// var_dump($arr);
				// var_dump('num: '.$num);
				return isset($arr[$num]) ? $arr[$num] : 0;
			}else{
				return 0;
			}


		}

		// 
		private function getRandomArray($arr){
			$num = mt_rand(0,count($arr));
			shuffle($arr);

			if(isset($arr[$num])){
				return $arr[$num];
			}else{
				return $this->getRandomArray($arr);
			}
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'cate_id'				=> 'CategoryID',
				'goods_id'				=> 'GoodsID',
				'stock_code'			=> 'StockCode',
				'type'					=> 'OrderType',
				'order'					=> 'OrderCode',
				'uid'					=> 'UserID',
				'mobile'				=> 'Mobile',
				'realname'				=> 'RealName',
				'idcard'				=> 'Idcard',
				'openid'				=> 'OpenID',
				'total'					=> 'TotalCount',
				'amount'				=> 'TotalFee',
				'chain_id'				=> 'Goods',
				'token'					=> 'OrderToken',
				'create_time'			=> 'CreateTime',
				'expire_time'			=> 'ExpireTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'type_title','field'=>'OrderType','type'=>'varchar','length'=>'250','default'=>'','title'=>'类型','width'=>70],
				['map'=>'order','field'=>'OrderCode','type'=>'varchar','length'=>'2048','default'=>'','title'=>'订单编号','width'=>220],
				['map'=>'cate_title','field'=>'CateTitle','type'=>'varchar','length'=>'2048','default'=>'','title'=>'类型','width'=>70],
				['map'=>'uid','field'=>'UserID','type'=>'varchar','length'=>'2048','default'=>'','title'=>'账号ID','width'=>100],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'2048','default'=>'','title'=>'用户姓名','width'=>130],
				['map'=>'mobile','field'=>'Mobile','type'=>'varchar','length'=>'2048','default'=>'','title'=>'手机号码','width'=>150],
				['map'=>'total','field'=>'TotalCount','type'=>'varchar','length'=>'2048','default'=>'','title'=>'数量','width'=>70],
				['map'=>'amount','field'=>'TotalFee','type'=>'int','length'=>'250','default'=>'','title'=>'金额','width'=>70],
				['map'=>'platform','field'=>'Platform','type'=>'varchar','length'=>'2048','default'=>'','title'=>'支付平台','width'=>100],
				['map'=>'pay_type','field'=>'PayType','type'=>'varchar','length'=>'2048','default'=>'','title'=>'支付方式','width'=>100],
				['map'=>'platform_order','field'=>'PlatformOrder','type'=>'varchar','length'=>'2048','default'=>'','title'=>'支付订单','width'=>300],
				['map'=>'pay_time','field'=>'PayTime','type'=>'varchar','length'=>'2048','default'=>'','title'=>'支付时间','width'=>180],
				['map'=>'pay_status_title','field'=>'PayStatus','type'=>'varchar','length'=>'2048','default'=>'','title'=>'支付状态','width'=>90],
				['map'=>'status_title','field'=>'Status','type'=>'varchar','length'=>'2048','default'=>'','title'=>'订单状态','width'=>90],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'下单时间','width'=>180]
			];
		}
	}
?>