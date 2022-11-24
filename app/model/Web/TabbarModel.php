<?php
	namespace app\model\Web;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class TabbarModel extends Model{
		public $table = 'tabbar';
		public $title = '导航栏管理';

		protected function getShowList(Request $request){
			$fields = $this->getList($request,'field');
			$field = "";
			foreach($fields as $key => $val){
				$field .= "`{$val}` as `{$key}`,";
			}
			$field = trim($field,",");

			$sql = "SELECT $field FROM ".$this->tab." WHERE IsValid = 1 AND IsDel = 0 ORDER BY Sort ASC";
			// var_dump($sql);
			$object = Db::select($sql);
			$result = $this->objectToArray($object);
			
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

		protected function getAllList(Request $request){
			$fields = $this->getList($request,'field');
			$field = "";
			foreach($fields as $key => $val){
				$field .= "`{$val}` as `{$key}`,";
			}
			$field = trim($field,",");

			$sql = "SELECT $field FROM ".$this->tab." WHERE IsValid = 1 ORDER BY Sort ASC";
			$object = Db::select($sql);
			$result = $this->objectToArray($object);
			return $result;
		}

		protected function validate(Request $request,$flag = false){
			if(!$flag){
				$res = $this->getList($request);
				if(count($res) >= 5){
					return 101011;
				}
			}
			
			$id = $request->input('id',0);
			$title = $request->post('title');
			$pic = $request->post('pic');
			$active_pic = $request->post('active_pic');
			$url = $request->post('url');
			$type = $request->post('type');
			$is_valid = $request->post('is_valid');
			$sort = $request->post('sort');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100007;
				}
			}
			
			if(empty($title)){
				return 101001;
			}
			
			
			if(empty($pic)){
				return 101003;
			}
			
			if(empty($active_pic)){
				return 101004;
			}
			
			if(empty($url)){
				return 101005;
			}

			if(empty($sort) || !is_numeric($sort) || !$sort){
				return 101006;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'			=> 'ID',
				'title'			=> 'Title',
				'pic'			=> 'Pic',
				'active_pic'	=> 'ActivePic',
				'type'			=> 'LinkType',
				'appid'			=> 'AppId',
				'url'			=> 'LinkUrl',
				'is_valid'		=> 'IsValid',
				'sort'		    => 'Sort',
				'create_time'	=> 'CreateTime',
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'标题','width'=>150],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'2048','default'=>'','title'=>'图片','width'=>0],
				['map'=>'active_pic','field'=>'ActivePic','type'=>'pic','length'=>'2048','default'=>'','title'=>'激活图片','width'=>0],
				['map'=>'type','field'=>'LinkType','type'=>'url','length'=>'2048','default'=>'','title'=>'打开方式','width'=>0],
				['map'=>'appid','field'=>'AppId','type'=>'url','length'=>'2048','default'=>'','title'=>'Appid','width'=>0],
				['map'=>'url','field'=>'LinkUrl','type'=>'url','length'=>'2048','default'=>'','title'=>'链接','width'=>0],
				['map'=>'is_valid','field'=>'IsValid','type'=>'url','length'=>'2048','default'=>'','title'=>'有效','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'url','length'=>'2','default'=>'1','title'=>'排序','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>