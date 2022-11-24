<?php
	namespace app\model\Order;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class OrderDetailModel extends Model{
		public $table = 'order_detail';
		public $title = '订单明细';

		protected function getOrderList(Request $request,$code){
			try{
				$detail = $this->tab;
				$order = $this->prex.'order';
				$goods = $this->prex.'goods';
				$cate = $this->prex.'goods_cate';

				$table = "$order,$detail,$goods,$cate";
				$field = "$detail.ID as id,$detail.OrderType as type,$detail.OrderCode as `order`,$goods.GoodsTitle as goods_title,$goods.Pic as goods_pic,$goods.Stock as stock,$goods.Sales as sales,$goods.LimitCount as limit_count,$goods.LimitOrder as limit_order,IsAllowShare as is_allow_share,$goods.Content as content,$goods.Status as goods_status,$cate.Title as cate_title,$detail.RealName as realname,Quantity as quantity,$detail.Price as price,$detail.Amount as amount,$detail.CreateTime as create_time,$detail.ExpireTime as expire_time,$detail.State as state";
				
				$where = "$order.OrderCode = $detail.OrderCode AND $detail.GoodsID = $goods.ID AND $detail.CategoryID = $cate.ID AND $detail.OrderCode = ?";
				$orderby = "$detail.ID ASC";

				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby";
				
				$object = Db::select($sql,[$code]);

				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
					return count($result) > 1 ? $result : $result[0];
				}
				return [];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		// 批量添加订单明细
		public function append($data){
			if(!$data){
				return false;
			}

			$sql = "INSERT INTO ".$this->tab." (`CategoryID`,`OrderType`,`OrderCode`,`UserID`,`Mobile`,`RealName`,`Idcard`,`GoodsID`,`SpecID`,`SpecTitle`,`SpecCode`,`Quantity`,`Price`,`Amount`,`CreateTime`,`UpdateTime`,`ExpireTime`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			$time = time();
			$param = [$data['cate_id'],$data['type'],$data['order'],$data['uid'],$data['mobile'],$data['realname'],$data['idcard'],$data['goods_id'],0,'','',$data['total'],$data['amount'],$data['amount'],$time,$time,$data['expire_time']];

			$result = Db::insert($sql,$param);
			// var_dump($sql);
			// var_dump($param);

			return $result !== false ? true : false;
		}

		protected function getFieldList(Request $request){
			return [
				'id'				=> 'ID',
				'cate_id'			=> 'CategoryID',
				'type'				=> 'OrderType',
				'order'				=> 'OrderCode',
				'uid'				=> 'UserID',
				'mobile'			=> 'Mobile',
				'realname'			=> 'RealName',
				'idcard'			=> 'Idcard',
				'goods_id'			=> 'GoodsID',
				'spec_id'			=> 'SpecID',
				'spec_title'		=> 'SpecTitle',
				'spec_code'			=> 'SpecCode',
				'quantity'			=> 'Quantity',
				'price'				=> 'Price',
				'amount'			=> 'Amount',
				'create_time'		=> 'CreateTime',
				'update_time'		=> 'UpdateTime',
				'expire_time'		=> 'ExpireTime',
				'state'				=> 'State'
			];
		}
	}
?>