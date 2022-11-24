<?php
	namespace app\model\Module;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class ModuleModel extends Model{
		public $table = 'module';
		public $title = '模块管理';
		public $layer = 2;

		/**
		 * 获取所有列表
		 * @return [type] [description]
		 */
		protected function getAllList(Request $request){
			$args = func_get_args();
            $field = 'ID as id,Title as title,Tabname as tabname,Pic as pic,Level as level,PID as pid,Layer as layer,EngineID as engine_id,CharsetID as charset_id,CollateID as collate_id,IncrementValue as increment_value,ParentTable as parent_table,CateTable as cate_table,StatusTable as status_table,Number as `number`,TagID as tag_id,HandleList as handle_list,Comment as comment,Sort as sort,IsDel as is_del,CreateTime as create_time';
            $where = '1 = 1';
            $fields = $this->getFields('Field');
            if(in_array('IsDel',$fields)){
                $where .= " AND IsDel = 0";
            }
            $order = 'ID ASC';

            $sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $order";
            $object = Db::select($sql);
            $result = $this->objectToArray($object);
            return $this->nav($result);
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
				array('id'=>1,'title'=>'系统模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>2,'sort'=>1),
				array('id'=>2,'title'=>'模型模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>5,'sort'=>2),
				array('id'=>3,'title'=>'菜单模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>1,'sort'=>3),
				array('id'=>4,'title'=>'基础模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>1,'sort'=>4),
				array('id'=>5,'title'=>'设置模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>1,'sort'=>5),
				array('id'=>6,'title'=>'用户模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>1,'sort'=>6),
				array('id'=>7,'title'=>'权限模块','tabname'=>'','pic'=>'','level'=>1,'pid'=>0,'number'=>1,'sort'=>7),

				array('id'=>8,'title'=>'系统设置','tabname'=>'config_system','pic'=>'','level'=>2,'pid'=>1,'number'=>0,'sort'=>1),

				array('id'=>9,'title'=>'系统设置','tabname'=>'config_system','pic'=>'','level'=>2,'pid'=>2,'number'=>0,'sort'=>1),
			);
		}

		protected function getFieldList(Request $request){
			return [
				'id'				=> 'ID',
				'title'				=> 'Title',
				'tabname'			=> 'Tabname',
				'pic'				=> 'Pic',
				'level'				=> 'Level',
				'pid'				=> 'PID',
				'layer'				=> 'Layer',
				'engine_id'			=> 'EngineID',
				'charset_id'		=> 'CharsetID',
				'collate_id'		=> 'CollateID',
				'increment_value'	=> 'IncrementValue',
				'parent_table'		=> 'ParentTable',
				'cate_table'		=> 'CateTable',
				'status_table'		=> 'StatusTable',
				'tag_id'			=> 'TagID',
				'handle_list'		=> 'HandleList',
				'comment'			=> 'Comment',
				'sort'				=> 'Sort',
				'is_del'			=> 'IsDel',
				'create_time'		=> 'CreateTime',
				'update_time'		=> 'UpdateTime'
			];
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
				        $temp[$i]['width'] = $res[$i]['Field'] == 'Title' ? 200 : ($res[$i]['Field'] == 'Tabname' ? 150 : 0);
				    }
			    }

			    return $temp;
			}
		}
	}
?>