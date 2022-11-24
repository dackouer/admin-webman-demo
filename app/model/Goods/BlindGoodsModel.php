<?php
	namespace app\model\Goods;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class BlindGoodsModel extends Model{
		public $table = 'blind_goods';
		public $title = '盲盒藏品';

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$blind_id = $request->post('blind_id');
			$goods_id = $request->post('goods_id');
			$rate = $request->post('rate');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100005;
				}
			}
			
			if(empty($blind_id)){
				return 100711;
			}
			
			if(empty($goods_id)){
				return 100711;
			}

			if($this->checkExists(['BlindID'=>$blind_id,'GoodsID'=>$goods_id],$id)){
				return 100712;
			}
			
			if(!is_numeric($rate)){
				return 100713;
			}

			return true;
		}

		/**
		 * [setAppend description]
		 * @param [type] $request [description]
		 * @param [type] $data    [description]
		 */
		public function append($data,$flag = false){
			if(!$data){
				return false;
			}
			
			$blind_goods = $data['blind_goods'];
			if(!is_array($blind_goods)){
				$blind_goods = json_decode($blind_goods,true);
			}

			if(!$flag){
				$sql = "INSERT INTO ".$this->tab." (`BlindID`,`GoodsID`,`Rate`,`CreateTime`) VALUES ";
				$str = "";
				$param = [];
				$time = time();

				foreach($blind_goods as $val){
					$str .= "(?,?,?,?),";
					array_push($param,$data['id'],$val['goods_id'],$val['rate'],$time);
				}

				$str = trim($str,",");

				if(empty($str)){
					return false;
				}

				$sql .= $str;
				$result = Db::insert($sql,$param);

				return $result !== false ? true : false;
			}else{
				$num = 0;
				foreach($blind_goods as $val){
					if($this->checkExists(['BlindID'=>$data['id'],'GoodsID'=>$val['goods_id']])){
						$sql = "UPDATE ".$this->tab." SET Rate = ? WHERE BlindID = ? AND GoodsID = ?";
						$param = [$val['rate'],$data['id'],$val['goods_id']];
						if(Db::update($sql,$param)){
							$num++;
						}
					}else{
						$sql = "INSERT INTO ".$this->tab." (`BlindID`,`GoodsID`,`Rate`,`CreateTime`) VALUES (?,?,?,?)";
						$param = [$data['id'],$val['goods_id'],$val['rate'],time()];
						if(Db::insert($sql,$param)){
							$num++;
						}
					}
				}
			}
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'blind_id'				=> 'BlindID',
				'goods_id'				=> 'GoodsID',
				'rate'					=> 'Rate',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'blind_id','field'=>'BlindID','type'=>'varchar','length'=>'250','default'=>'','title'=>'盲盒','width'=>0],
				['map'=>'goods_id','field'=>'GoodsID','type'=>'varchar','length'=>'2048','default'=>'','title'=>'藏品','width'=>0],
				['map'=>'rate','field'=>'Rate','type'=>'varchar','length'=>'2048','default'=>'','title'=>'比例','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>