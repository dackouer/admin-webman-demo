<?php
	namespace app\model\Base;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class CurrencyModel extends Model{
		public $table = 'currency';
		public $title = '币种管理';

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
				return 100721;
			}

			if($this->checkExists(['CurrencyName'=>$title],$id)){
				return 100722;
			}
			
			if(empty($symbol)){
				return 100723;
			}

			if($this->checkExists(['Symbol'=>$symbol],$id)){
				return 100724;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'CurrencyName',
				'symbol'				=> 'Symbol',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'CurrencyName','type'=>'varchar','length'=>'250','default'=>'','title'=>'币种名称','width'=>0],
				['map'=>'symbol','field'=>'Symbol','type'=>'varchar','length'=>'2048','default'=>'','title'=>'符号','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>