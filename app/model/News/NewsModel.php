<?php
	namespace app\model\News;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;
	use app\model\User\UserModel;

	class NewsModel extends Model{
		public $table = 'news';
		public $title = '新闻管理';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$user = $this->tab;

			$field = [
				"ID as id",
				"Title as title",
				"CateID as cate_id",
				"Pic as pic",
				"Keyword as keyword",
				"Description as desc",
				"Hits as hits",
				"IsOriginal as is_original",
				"IsComment as is_comment",
				"AuthorID as author",
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
						// $result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
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
				"Keyword as keyword",
				"Description as desc",
				"Hits as hits",
				"IsOriginal as is_original",
				"IsComment as is_comment",
				"AuthorID as author",
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
						// $result[$i]['picture'] = $this->getJsonDecode($result[$i]['picture']);
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
				"Keyword as keyword",
				"Description as desc",
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
					$result['picture'] = $this->getJsonDecode($result['picture']);
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
				}
				return $result;
			}catch(\Exception $e){
				// var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		protected function setRequest(Request $request,$flag = false){
			if(!$flag){
				$data['create_time'] = time();
			}
			$data['update_time'] = time();
			$picture = $request->post('picture');
			$data['picture'] = json_encode($picture);

			return $data;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$author = $request->post('author',83176150);
			$cate_id = $request->post('cate_id');
			$title = $request->post('title');
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
					return 100900;
				}
			}
			
			if(empty($author)){
				return 100901;
			}

			$service = new UserModel();
			$user = $service->getList($request,$author);
			if(!$user){
				return 100902;
			}
			
			if(empty($cate_id) || !is_numeric($cate_id) || !$cate_id){
				return 100903;
			}

			$service = new NewsCateModel();
			$new_cate = $service->getList($request,$cate_id);
			if(!$new_cate){
				return 100903;
			}

			if(empty($title)){
				return 100904;
			}

			if($this->checkExists(['Title'=>$title,'CateID'=>$cate_id],$id)){
				return 100905;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'cate_id'				=> 'CateID',
				'title'					=> 'Title',
				'keyword'				=> 'Keyword',
				'desc'					=> 'Description',
				'pic'					=> 'Pic',
				'picture'				=> 'Picture',
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
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'新闻标题','width'=>250],
				['map'=>'cate_id','field'=>'CateID','type'=>'varchar','length'=>'2048','default'=>'','title'=>'类别','width'=>120],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'2048','default'=>'','title'=>'图片','width'=>130],
				['map'=>'hits','field'=>'Hits','type'=>'int','length'=>'2048','default'=>'','title'=>'点击量','width'=>100],
				['map'=>'is_original','field'=>'IsOriginal','type'=>'switch','length'=>'250','default'=>'','title'=>'原创','width'=>0],
				['map'=>'is_comment','field'=>'IsComment','type'=>'switch','length'=>'2048','default'=>'','title'=>'评论','width'=>100],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180]
			];
		}
	}
?>