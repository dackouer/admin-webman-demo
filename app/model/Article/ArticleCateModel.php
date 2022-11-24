<?php
	namespace app\model\Article;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;

	class ArticleCateModel extends Model{
		public $table = 'article_cate';
		public $title = '文章类别管理';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"Pic as pic",
				"Sort as sort",
				"CreateTime as create_time"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND (`Title` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->count();

				$object = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->orderby("CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],$this->table);
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
			$thead = [];

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"Pic as pic",
				"Sort as sort",
				"CreateTime as create_time"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND (`RealName` LIKE ? OR `Mobile` LIKE ? OR `Idcard` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->orderby("CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],$this->table);
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
				"Pic as pic",
				"Sort as sort",
				"CreateTime as create_time"
			];
			
			$where = [['IsDel','=',0],['ID','=',$id]];
			$orWhere = [];
			$param = [];
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['pic'] = $this->setImg($result['pic'],$this->table);
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

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100950;
				}
			}
			
			if(empty($title)){
				return 100951;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100952;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'pic'					=> 'Pic',
				'level'					=> 'Level',
				'pid'					=> 'PID',
				'sort'					=> 'Sort',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'类别名称','width'=>120],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'2048','default'=>'','title'=>'图片','width'=>130],
				['map'=>'sort','field'=>'Sort','type'=>'int','length'=>'2048','default'=>'','title'=>'排序','width'=>180],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180]
			];
		}
	}
?>