<?php
	namespace app\model\City;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class CityModel extends Model{
		public $table = 'city';
		public $title = '城市管理';

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

			$keyword = trim($request->post('keyword',''));
			
			if(!empty($keyword)){
				$where .= " AND (Title LIKE '%".$keyword."%' OR Code LIKE '%".$keyword."%')";
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
			$code = $request->post('code');
			$level = $request->post('level');
			$pid = $request->post('pid');
			$tel_code = $request->post('tel_code');
			$zip_code = $request->post('zip_code');
			$spell = $request->post('spell');
			$en_name = $request->post('en_name');
			$short_en_name = $request->post('short_en_name');
			$longitude = $request->post('longitude');
			$latitude = $request->post('latitude');
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
				return 100301;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100302;
			}
			
			if(empty($code)){
				return 100303;
			}

			if($this->checkExists(['Code'=>$symbol],$id)){
				return 100304;
			}

			if(empty($level) || !is_numeric($level) || !$level){
				return 100305;
			}

			if(!is_numeric($pid)){
				return 100306;
			}

			if(empty($sort) || !is_numeric($sort) || !$sort){
				return 100307;
			}

			return true;
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'code','field'=>'Code','type'=>'varchar','length'=>'250','default'=>'','title'=>'编码','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'简称','width'=>200],
				['map'=>'level','field'=>'Level','type'=>'int','length'=>'1','default'=>'','title'=>'级别','width'=>0],
				['map'=>'pid','field'=>'PID','type'=>'int','length'=>'10','default'=>'','title'=>'父级','width'=>120],
				['map'=>'tel_code','field'=>'TelCode','type'=>'varchar','length'=>'10','default'=>'','title'=>'区号','width'=>120],
				['map'=>'zip_code','field'=>'ZipCode','type'=>'varchar','length'=>'10','default'=>'','title'=>'邮政编码','width'=>120],
				['map'=>'spell','field'=>'Spell','type'=>'varchar','length'=>'10','default'=>'','title'=>'拼英','width'=>120],
				['map'=>'en_name','field'=>'EnName','type'=>'varchar','length'=>'10','default'=>'','title'=>'英文名','width'=>120],
				['map'=>'short_en_name','field'=>'ShortEnName','type'=>'varchar','length'=>'10','default'=>'','title'=>'英文简写','width'=>120],
				['map'=>'longitude','field'=>'Longitude','type'=>'varchar','length'=>'10','default'=>'','title'=>'经度','width'=>120],
				['map'=>'latitude','field'=>'Latitude','type'=>'varchar','length'=>'10','default'=>'','title'=>'纬度','width'=>120],
				['map'=>'number','field'=>'Number','type'=>'int','length'=>'4','default'=>'','title'=>'子数目','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'int','length'=>'4','default'=>'','title'=>'排序','width'=>0],
			];
		}
	}
?>