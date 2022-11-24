<?php
	namespace app\model\Web;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class CarouselModel extends Model{
		public $table = 'carousel';
		public $title = '轮播图管理';

		// 获取展示列表
		protected function getShowList(Request $request){
			$field = [
				'ID as id',
				'Title as title',
				'Pic as img',
				'LinkUrl as url',
				'OpenType as opentype',
				'Sort as sort',
			];

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where('IsDel',0)
						->orderby('Sort','ASC')
						->limit(10)
						->get();

			if($object){
				$result = $this->objectToArray($object);
			}

			
			$arr = [
			    'title' => $this->title,
			    'table' => strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $this->table)),
			    'layer' => 1,
			    'thead' => $this->getList($request,'map'),
			    'rows'  => count($result),
			    'data'  => $result
			];

			return $arr;
		}

		// 获取所有列表
		protected function getAllList(Request $request){
			$field = [
				'ID as id',
				'Title as title',
				'Pic as img',
				'LinkUrl as url',
				'OpenType as opentype',
				'Sort as sort',
			];

			$result = [];
			$object = Db::table($this->table)
						->select(...$field)
						->where('IsDel',0)
						->orderby('ID','DESC')
						->limit(10)
						->get();

			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					// $result[$i]['url'] = '/pages/news/detail?id='.$result[$i]['id'];
					$result[$i]['opentype'] = 'navigate';
				}
			}

			return $result;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$img = $request->post('img');
			$url = $request->post('url');
			$opentype = $request->post('opentype');
			$sort = $request->post('sort');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100990;
				}
			}
			
			if(empty($title)){
				return 100991;
			}
			
			if(empty($img)){
				return 100993;
			}
			
			if(empty($url)){
				return 100994;
			}

			if(empty($sort) || !is_numeric($sort) || !$sort){
				return 100212;
			}

			return true;
			
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'img'					=> 'Pic',
				'url'					=> 'LinkUrl',
				'opentype'				=> 'OpenType',
				'sort'					=> 'Sort',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'标题','width'=>200],
				['map'=>'img','field'=>'Pic','type'=>'pic','length'=>'2048','default'=>'','title'=>'图片','width'=>0],
				['map'=>'url','field'=>'LinkUrl','type'=>'url','length'=>'2048','default'=>'','title'=>'链接','width'=>0],
				['map'=>'opentype','field'=>'OpenType','type'=>'url','length'=>'2048','default'=>'','title'=>'打开方式','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'int','length'=>'3','default'=>'1','title'=>'排序','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>