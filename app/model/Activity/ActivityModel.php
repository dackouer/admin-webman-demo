<?php
	namespace app\model\Activity;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;
	use app\model\User\UserModel;

	class ActivityModel extends Model{
		public $table = 'activity';
		public $title = '活动管理';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"CateID as cate_id",
				"Pic as pic",
				"StartTime as start_time",
				"EndTime as end_time",
				"Hits as hits",
				"IsOriginal as is_original",
				"IsComment as is_comment",
				"AuthorID as author",
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
				array_push($where,['Title','like',$keyword]);
			}

			$cid = $request->input('cid');
			if(!empty($cid) && is_numeric($cid) && $cid){
				array_push($where,['CateID','=',$cid]);
			}

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
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
						$result[$i]['pic'] = $this->setImg($result[$i]['pic'],$this->table);
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);						
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
				"CateID as cate_id",
				"Pic as pic",
				"StartTime as start_time",
				"EndTime as end_time",
				"Hits as hits",
				"IsOriginal as is_original",
				"IsComment as is_comment",
				"AuthorID as author",
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
				"CateID as cate_id",
				"Pic as pic",
				"Picture as picture",
				"StartTime as start_time",
				"EndTime as end_time",
				"Description as description",
				"Hits as hits",
				"IsOriginal as is_original",
				"SourceUrl as source_url",
				"IsComment as is_comment",
				"AuthorID as author",
				"Sort as sort",
				"Content as content",
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

					if($result['cate_id'] == 2){
						$service = new VoteGoodsModel();
						$result['list'] = $service->getList($request,'activity',$id);
					}
				}
				return $result;
			}catch(\Exception $e){
				// var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		// 获取最后一条
		protected function getTopList(Request $request,$cid = 0){
			$field = [
				"ID as id",
				"Title as title",
				"CateID as cate_id",
				"Pic as pic",
				"Picture as picture",
				"StartTime as start_time",
				"EndTime as end_time",
				"Description as description",
				"Hits as hits",
				"IsOriginal as is_original",
				"SourceUrl as source_url",
				"IsComment as is_comment",
				"AuthorID as author",
				"Sort as sort",
				"Content as content",
				"CreateTime as create_time"
			];
			
			$where = [['IsDel','=',0]];
			if($cid){
				array_push($where,['CateID','=',$cid]);
			}
			$orWhere = [];
			$param = [];
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->orderby('ID','DESC')
						->limit(1)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['pic'] = $this->setImg($result['pic'],$this->table);
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);

					if($result['cate_id'] == 2){
						$service = new VoteGoodsModel();
						$result['list'] = $service->getList($request,'activity',$result['id']);
					}
				}
				return $result;
			}catch(\Exception $e){
				// var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}
		
		protected function getCateList(Request $request,$cid = 0){
			if(!$cid){
				return [];
			}

			$field = [
				"ID as id",
				"Title as title",
				"CateID as cate_id",
				"Pic as pic",
				"Description as desc",
				"StartTime as start_time",
				"EndTime as end_time",
				"Hits as hits",
				"IsOriginal as is_original",
				"IsComment as is_comment",
				"AuthorID as author",
				"CreateTime as create_time"
			];
			$whereRaw = 'CateID = $cid AND IsDel = 0';
			$where = [['IsDel','=',0],['CateID','=',$cid]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND (`Title` LIKE '%{$keyword}%')";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			// $limit = $this->getLimit($request);
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->orderby("CreateTime","DESC")
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

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$author = $request->post('author',83176150);
			$cate_id = $request->post('cate_id');
			$title = $request->post('title');
			$start_time = $request->post('start_time');
			$end_time = $request->post('end_time');
			$description = $request->post('description');
			$pic = $request->post('pic');
			$is_original = $request->post('is_original');
			$source_url = $request->post('source_url');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100920;
				}
			}
			
			if(empty($author)){
				return 100921;
			}

			$service = new UserModel();
			$user = $service->getList($request,$author);
			if(!$user){
				return 100922;
			}
			
			if(empty($cate_id) || !is_numeric($cate_id) || !$cate_id){
				return 100923;
			}

			$service = new ActivityCateModel();
			$new_cate = $service->getList($request,$cate_id);
			if(!$new_cate){
				return 100923;
			}

			if(empty($title)){
				return 100924;
			}

			if($this->checkExists(['Title'=>$title,'CateID'=>$cate_id],$id)){
				return 100925;
			}

			if(empty($start_time)){
				return 100926;
			}

			// if(strtotime($start_time) <= time()){
			// 	return 100927;
			// }

			if(empty($end_time)){
				return 100928;
			}

			if(strtotime($end_time) <= strtotime($start_time)){
				return 100929;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'cate_id'				=> 'CateID',
				'title'					=> 'Title',
				'description'			=> 'Description',
				'pic'					=> 'Pic',
				'picture'				=> 'Picture',
				'start_time'			=> 'StartTime',
				'end_time'				=> 'EndTime',
				'is_original'			=> 'IsOriginal',
				'source_url'			=> 'SourceUrl',
				'is_comment'			=> 'IsComment',
				'author'				=> 'AuthorID',
				'sort'					=> 'Sort',
				'content'				=> 'Content',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'活动标题','width'=>120],
				['map'=>'cate_id','field'=>'CateID','type'=>'varchar','length'=>'2048','default'=>'','title'=>'类别','width'=>120],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'2048','default'=>'','title'=>'图片','width'=>130],
				['map'=>'start_time','field'=>'StartTime','type'=>'time','length'=>'2048','default'=>'','title'=>'开始时间','width'=>180],
				['map'=>'end_time','field'=>'EndTime','type'=>'time','length'=>'2048','default'=>'','title'=>'结束时间','width'=>180],
				['map'=>'hits','field'=>'Hits','type'=>'int','length'=>'2048','default'=>'','title'=>'点击量','width'=>180],
				['map'=>'is_original','field'=>'IsOriginal','type'=>'switch','length'=>'250','default'=>'','title'=>'原创','width'=>0],
				['map'=>'is_comment','field'=>'IsComment','type'=>'switch','length'=>'2048','default'=>'','title'=>'评论','width'=>180],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180]
			];
		}
	}
?>