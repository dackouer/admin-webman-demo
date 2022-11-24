<?php
	namespace app\model\Issuer;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\model\Model;

	class IssuerModel extends Model{
		public $table = 'issuer';
		public $title = '发行方管理';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"Logo as logo",
				"Pic as pic",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				// $whereRaw .= " AND (`Title` LIKE ? OR `Mobile` LIKE ? OR `RealName` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->select(...$field)
						->where($where)
						->count();

				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->orderby("CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['logo'] = $this->setImg($result[$i]['logo'],'issuer');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						
					}
				}
				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 获取发行方列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			// $thead = [];

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"Logo as logo",
				"Pic as pic",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				// $whereRaw .= " AND (`Title` LIKE ? OR `Mobile` LIKE ? OR `RealName` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->orderby("CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['logo'] = $this->setImg($result[$i]['logo'],'issuer');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
				}
				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 获取发行方单条记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getListById(Request $request){
			$args = func_get_args();
			$id = isset($args[1]) ? $args[1] : 0;

			$field = [
				"ID as id",
				"Title as title",
				"Logo as logo",
				"Pic as pic",
				"Picture as picture",
				"Description as desc",
				"Content as content",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			
			$where = [['IsDel','=',0],['ID','=',$id]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
			}
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['logo'] = $this->setImg($result['logo'],'issuer');
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
				}
				return $result;
			}catch(\Exception $e){
				var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$logo = $request->post('logo');
			$pic = $request->post('pic');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100710;
				}
			}
			
			if(empty($title)){
				return 100711;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100712;
			}
			
			if(empty($logo)){
				return 100713;
			}
			
			if(empty($pic)){
				return 100714;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'desc'					=> 'Description',
				'logo'					=> 'Logo',
				'pic'					=> 'Pic',
				'picture'				=> 'Picture',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
				'is_valid'				=> 'IsValid'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'发行方名称','width'=>200],
				['map'=>'logo','field'=>'Logo','type'=>'pic','length'=>'250','default'=>'','title'=>'Logo','width'=>0],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'250','default'=>'','title'=>'主图','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180],
				['map'=>'is_valid','field'=>'IsValid','type'=>'switch','length'=>'10','default'=>'','title'=>'状态','width'=>0]
			];
		}
	}
?>