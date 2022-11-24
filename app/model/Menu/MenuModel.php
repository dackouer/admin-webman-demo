<?php
	namespace app\model\Menu;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\lib\Token;
	use app\lib\Http;
	use app\model\Model;

	class MenuModel extends Model{
		public $table = 'menu';
		public $title = '菜单管理';
		public $layer = 3;

		public function test(Request $request){
			$result = $this->getList('sort');
			// var_dump('sort: '.$result);
			return Json::show($result);
		}

		/**
		 * 切换菜单
		 * @param Request $request [description]
		 */
		public function setMenu(Request $request){
			$token = $request->header('Authorization');
			$menu_top = $request->post('menu_top',1);
			$menu_parent = $request->post('menu_parent',0);
			$menu_id = $request->post('menu_id',0);

			// if(!$menu_parent){
			// 	$service = $this->getList($request,'top');

			// }

			$request->session()->set($token.'_menu_top',$menu_top);
			$request->session()->set($token.'_menu_parent',$menu_parent);
			$request->session()->set($token.'_menu_id',$menu_id);

			return true;
		}

		/**
		 * 获取所有列表
		 * @return [type] [description]
		 */
		protected function getAllList(Request $request){
			$tab = $this->tab;
			$field = "ID as id,Title as title,Pic as pic,Level as level,PID as pid,IsOpen as is_open,Pvalue as pvalue,Cvalue as cvalue,Svalue as svalue,Router as router,Number as number,Sort as sort";
			$table = "$tab";
			$where = "IsDel = 0";
			$orderby = "$tab.Level ASC,$tab.Sort ASC";

			$keyword = $request->post('keyword');
			if(!empty($keyword)){
				$keyword = $this->colation($keyword);
				$where .= " AND Title LIKE '%".$keyword."%'";
			}

			$sql = "SELECT $field FROM $table WHERE $where ORDER By $orderby";

			$object = Db::select($sql,[]);
			$result = $this->objectToArray($object);
			return $this->nav($result);
		}
		
		protected function getRoleList(Request $request){
		    $tab = $this->tab;
			$field = "ID as id,Title as title,Pic as pic,Level as level,PID as pid,IsOpen as is_open,Pvalue as pvalue,Cvalue as cvalue,Svalue as svalue,Router as router,Number as number,Sort as sort";
			$table = "$tab";
			$where = "IsDel = 0";
			$orderby = "$tab.Level ASC,$tab.Sort ASC";

			$keyword = $request->post('keyword');
			if(!empty($keyword)){
				$keyword = $this->colation($keyword);
				$where .= " AND Title LIKE '%".$keyword."%'";
			}

			$sql = "SELECT $field FROM $table WHERE $where ORDER By $orderby";

            $result = [];
			$object = Db::select($sql,[]);
			if($object){
			    $result = $this->objectToArray($object);
			    for($i=0;$i<count($result);$i++){
			        $result[$i]['is_selected'] = 0;
			    }
			}
			return $this->tree($result);
		}

		/**
		 * 获取权限列表
		 * @return [type] [description]
		 */
		protected function getGrantList(Request $request){
			$tab = $this->tab;

			$field = "ID as id,Title as title,Pic as pic,Level as level,PID as pid,IsOpen as is_open,Router as router,Number as number,Sort as sort";

			$where = "IsDel = 0";
			$orderby = "Level ASC,Sort ASC";

			$sql = "SELECT $field FROM $tab WHERE $where ORDER BY $orderby";
			$object = Db::select($sql);
			$result = $this->objectToArray($object);
			return $this->tree($result);


			/*
			$token = $request->header('Authorization');
			$sign = Http::redis($token,'sign');
			$menu_id = Http::redis($token,'menu_id');
			if(!$menu_id){
				$menu_id = 5;
			}

			var_dump('token: '.$token);

			$tab = $this->tab;
			$role = $this->prex.'role';
			$grant = $this->prex.'grant';
			$table = "$tab,$role,$grant";
			$where = "$tab.IsDel = 0 AND Sign = ? AND MenuID = ? AND IsShow = 1";
			$orderby = "Level ASC,Sort ASC";
			
			$field = "$tab.ID as id,$tab.Title as title,$tab.Pic as pic,$tab.Level as level,$tab.PID as pid,$tab.IsOpen as is_open,$tab.ModuleID as module_id,$tab.Pvalue as pvalue,$tab.Cvalue as cvalue,$tab.Svalue as svalue,$tab.Router as router,$tab.Number as number,$tab.Sort as sort";
			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby";
			$param = array(Token::decrypt($sign),$menu_id);
			var_dump($sql);
			var_dump($param);
			$object = Db::select($sql,$param);
			$result = $this->objectToArray($object);
			var_dump($result);
			return $this->tree($result); */
		}

		// 设置默认值
		private function setDefault(){
			$this->flush();
			$data = $this->getList('default');
			$sql = "INSERT INTO ".$this->tab." (`Title`,`Pic`,`Level`,`PID`,`Router`,`Number`,`Sort`,`CreateTime`,`UpdateTime`) VALUES ";
			foreach($data as $val){
				$time = time();
				$title = $val['title'];
				$pic = $val['pic'];
				$level = $val['level'];
				$pid = $val['pid'];
				$router = $val['router'];
				$number = $val['number'];
				$sort = $val['sort'];

				$sql .= "('{$title}','{$pic}',{$level},{$pid},'{$router}',{$number},{$sort},'{$time}','{$time}'),";
			}
			$sql = trim($sql,",");
			if(Db::insert($sql)){
				return $data;
			}
			return array();
		}

		// 默认值
		protected function getDefaultList(Request $request){
			return array(
				array('id'=>1,'title'=>'系统管理','pic'=>'','router'=>'','level'=>1,'pid'=>0,'number'=>2,'sort'=>1),
				array('id'=>2,'title'=>'模块管理','pic'=>'','router'=>'','level'=>1,'pid'=>0,'number'=>5,'sort'=>2),
				array('id'=>3,'title'=>'菜单管理','pic'=>'','router'=>'','level'=>1,'pid'=>0,'number'=>1,'sort'=>3),

				array('id'=>4,'title'=>'系统设置','pic'=>'','router'=>'config/system','level'=>2,'pid'=>1,'number'=>0,'sort'=>1),
				array('id'=>5,'title'=>'用户设置','pic'=>'','router'=>'config/user','level'=>2,'pid'=>1,'number'=>0,'sort'=>2),

				array('id'=>6,'title'=>'模块管理','pic'=>'','router'=>'module','level'=>2,'pid'=>2,'number'=>0,'sort'=>1),
				array('id'=>7,'title'=>'行为管理','pic'=>'','router'=>'handle','level'=>2,'pid'=>2,'number'=>0,'sort'=>2),
				array('id'=>8,'title'=>'字符编码','pic'=>'','router'=>'charset','level'=>2,'pid'=>2,'number'=>0,'sort'=>3),
				array('id'=>9,'title'=>'存储引擎','pic'=>'','router'=>'engine','level'=>2,'pid'=>2,'number'=>0,'sort'=>4),
				array('id'=>10,'title'=>'排序规则','pic'=>'','router'=>'collate','level'=>2,'pid'=>2,'number'=>0,'sort'=>5),

				array('id'=>11,'title'=>'菜单设置','pic'=>'','router'=>'menu','level'=>2,'pid'=>3,'number'=>0,'sort'=>1)
			);
		}

		// 增修验证
		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$level = $request->post('level',1);
			$pid = $request->post('pid',0);
			$is_open = $request->post('is_open',0);
			// $module_id = $request->post('module_id',0);
			$pvalue = $request->post('pvalue',0);
			$cvalue = $request->post('cvalue',0);
			$svalue = $request->post('svalue',0);
			$sort = $request->post('sort',1);

			if(empty($title)){
				return 100201;
			}
			if(strlen($title) < 3 || strlen($title) > 20){
				return 100202;
			}
			if($this->checkExists(['PID'=>$pid,'Title'=>$title],$id)){
				return 100203;
			}

			if(!is_numeric($level) || !$level){
				return 100204;
			}

			if(!is_numeric($pid)){
				return 100205;
			}

			if(!in_array($is_open,[0,1])){
				return 100206;
			}

			// if(!is_numeric($module_id)){
			// 	return 100207;
			// }

			// if($level == $this->layer && !$module_id){
			// 	return 100208;	
			// }

			if(!is_numeric($pvalue)){
				return 100209;
			}

			if(!is_numeric($cvalue)){
				return 100210;
			}

			if(!is_numeric($svalue)){
				return 100211;
			}

			if(!is_numeric($sort) || !$sort){
				return 100212;
			}

			return true;
		}

		protected function getMapList(Request $request){
			$args = func_get_args(); 
			$res = $this->getFields();
			
			if(isset($args[1]) && !empty($args[1])){
			    return array_column($res,$args[1]);
			}else{
			    if($this->tabtype == 2){
			        $data = $this->getList($request,1);
			    }
			    $temp = array();
			    for($i=0;$i<count($res);$i++){
			    	if($res[$i]['Field'] != 'create_time' && $res[$i]['Field'] != 'update_time' && $res[$i]['Field'] != 'delete_time' && $res[$i]['Field'] != 'is_del'){
				        $temp[$i]['map'] = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $res[$i]['Field']));
				        $temp[$i]['field'] = $res[$i]['Field'];
				        $type = explode(' ',$res[$i]['Type']);
				        $type = $type[0];
				        $type = explode('(',$type);
				        $temp[$i]['type'] = $type[0];
				        $len = isset($type[1]) ? trim($type[1],")") : (strpos($type[0],'int') !== false ? 11 : 255);
				        $temp[$i]['length'] = $len;
				        $temp[$i]['default'] = $res[$i]['Default'];
				        $temp[$i]['title'] = $res[$i]['Comment'];
				        if($this->tabtype == 2 && $data){
				            $temp[$i]['value'] = $data[$res[$i]['Field']];
				        }
				        $temp[$i]['width'] = $res[$i]['Field'] == 'Title' ? 200 : 0;
				    }
			    }

			    return $temp;
			}
		}
	}
?>