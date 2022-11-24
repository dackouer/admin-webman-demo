<?php
	namespace app\model\Market;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;
	use app\model\Goods\GoodsModel;

	class MarketModel extends Model{
		public $table = 'market';
		public $title = '市场管理';

		protected function getShowList(Request $request){

		}

		protected function getAllList(Request $request){
			$market = $this->tab;
			$goods = $this->prex.'goods';

			$table = "$market,$goods";
			$field = [
				"$market.ID as id",
				"GoodsID as goods_id",
				"GoodsTitle as goods_title",
				"MarketCode as market_code",
			];

			$where = [
				["GoodsID","=","$goods.ID"],
				["State","=",1]
			];
			$param = [];

			$keyword = trim($request->input('keyword'),'');
			if(!empty($keyword)){
				array_push($where,["GoodsTitle","like","%{$keyword}%"]);
			}

			$orderBy = "$market.ID DESC";

			$limit = $this->getLimit($request);

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderBy LIMIT $limit[0],$limit[1]";

			$result = [];
			$object = Db::select($sql);
			if($object){
				$result = $this->objectToArray($object);
			}

			return $result;
		}

		/**
		 * 设置藏品集藏品
		 * @param Request $request [description]
		 * @param [type]  $goods   [description]
		 */
		public function setCollectionGoods(Request $request,$data){
			$collection_id = $data['id'];
			$goods = explode(',',$data['goods']);
			$cate = $data['is_blind'] ? 2 : 1;

			$service = new GoodsModel();
			$res = $service->getList($request,'cate',$cate);
			
			$num = 0;
			if($res){
				foreach($res as $val){
					// var_dump($val);
					$arr = [
						'CollectionID'	=> $collection_id,
						'GoodsID'		=> $val['id']
					];
					if(in_array($val['id'],$goods)){
						// var_dump($val['id'].'is exists');
						if($this->checkExists($arr)){
							// var_dump($val['id'].'is okok');
							if($this->modify($request,['State' => $val['status']],$arr)){
								$num++;
							}
						}else{
							// var_dump($val['id'].'is nono');
							$da = [
								'CollectionID'	=> $collection_id,
								'GoodsID'		=> $val['id'],
								'State'			=> $val['status'],
								'Price'			=> $val['price'],
								'CreateTime'	=> time(),
								'CreateIP'		=> $request->getRealIp($safe_mode=true)
							];
							if($this->setAppend($request,$da)){
								$num++;
							}
						}
					}else{
						// var_dump($val['id'].'is not exists');
						if($this->modify($request,['State' => -1],$arr)){
							$num++;
						}
					}
				}
			}

			return $num;
		}

		/**
		 * 同步藏品状态
		 * @param Request $request [description]
		 * @param [type]  $data    [description]
		 */
		public function setGoodsStatus(Request $request,$data){
			// var_dump($data);
			$sql = "UPDATE ".$this->tab." SET State = ? WHERE GoodsID = ?";
			$param = [$data['status'],$data['id']];
			// var_dump('set status sql: '.$sql);
			// var_dump($param);

			return Db::update($sql,$param);
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$symbol = $request->post('symbol');

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

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'collection_id'			=> 'CollectionID',
				'goods_id'				=> 'GoodsID',
				'price'					=> 'Price',
				'market_code'			=> 'MarketCode',
				'source_user_id'		=> 'SourceUserID',
				'source_goods_id'		=> 'SourceGoodsID',
				'source_order'			=> 'SourceOrder',
				'state'					=> 'State',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'UnitName','type'=>'varchar','length'=>'250','default'=>'','title'=>'藏品集名称','width'=>0],
				['map'=>'symbol','field'=>'Symbol','type'=>'varchar','length'=>'2048','default'=>'','title'=>'标识符','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>