<?php
	namespace app\model\Bank;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class BankModel extends Model{
		public $table = 'Bank';
		public $title = '银行管理';

		protected function getShowList(Request $request){
			$tab = $this->tab;
			$fields = $this->getList($request,'field');
			$field = [];
			foreach($fields as $key => $val){
				array_push($field,"{$val} as {$key}");
			}
			$field = implode(',',$field);

			$where = "1 = 1";
			$orderby = "Level ASC,Sort ASC";
			$param = [];

			$keyword = $request->input('keyword');
			if(!empty($keyword)){
				$where .= " AND (Title LIKE '%".$keyword."%' OR FullName LIKE '%".$keyword."%')";
			}

			$sql = "SELECT COUNT($tab.ID) as count FROM $tab WHERE $where";
			$object = Db::select($sql);
			$this->rows = $object[0]->count;

			$limit = $this->getLimit($request);

			$sql = "SELECT $field FROM $tab WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
			
			$object = Db::select($sql,$param);

			$result = [];
			if($object){
				$result = $this->objectToArray($object);
			}

			$arr = [
			    'title' => $this->title,
			    'table' => strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $this->table)),
			    'layer' => 2,
			    'thead' => $this->getList($request,'map'),
			    'rows'  => $this->rows,
			    'data'  => $result
			];

			return $arr;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$full_name = $request->post('full_name');
			$level = $request->post('level');
			$pid = $request->post('pid');
			$is_popular = $request->post('is_popular');
			$sort = $request->post('sort');

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
				return 100311;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100312;
			}
			
			if(empty($full_name)){
				return 100313;
			}

			if($this->checkExists(['FullName'=>$title],$id)){
				return 100314;
			}

			if(empty($level) || !is_numeric($level) || !$level){
				return 100315;
			}

			if(!is_numeric($pid)){
				return 100316;
			}

			if(!in_array($is_popular,[0,1,'0','1'])){
				return 100317;
			}

			if(empty($sort) || !is_numeric($sort) || !$sort){
				return 100318;
			}

			return true;
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'180','default'=>'','title'=>'银行名称','width'=>180],
				['map'=>'full_name','field'=>'FullName','type'=>'varchar','length'=>'250','default'=>'','title'=>'全称','width'=>200],
				['map'=>'bank_en_name','field'=>'BankEnName','type'=>'varchar','length'=>'250','default'=>'','title'=>'英文名称','width'=>200],
				['map'=>'bank_code','field'=>'BankCode','type'=>'varchar','length'=>'2048','default'=>'','title'=>'银行编码','width'=>0],
				['map'=>'website','field'=>'Website','type'=>'varchar','length'=>'10','default'=>'','title'=>'网址','width'=>0],
				['map'=>'hotline','field'=>'Hotline','type'=>'varchar','length'=>'10','default'=>'','title'=>'服务热线','width'=>0],
				['map'=>'level','field'=>'Level','type'=>'int','length'=>'10','default'=>'','title'=>'级别','width'=>0],
				['map'=>'pid','field'=>'PID','type'=>'int','length'=>'10','default'=>'','title'=>'父级','width'=>0],
				['map'=>'number','field'=>'Number','type'=>'int','length'=>'10','default'=>'','title'=>'子数目','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'int','length'=>'10','default'=>'','title'=>'排序','width'=>0]
			];
		}
	}
?>