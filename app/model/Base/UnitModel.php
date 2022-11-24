<?php
	namespace app\model\Base;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class UnitModel extends Model{
		public $table = 'unit';
		public $title = '单位管理';

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
				'title'					=> 'UnitName',
				'symbol'				=> 'Symbol',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'UnitName','type'=>'varchar','length'=>'250','default'=>'','title'=>'单位名称','width'=>0],
				['map'=>'symbol','field'=>'Symbol','type'=>'varchar','length'=>'2048','default'=>'','title'=>'标识符','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>