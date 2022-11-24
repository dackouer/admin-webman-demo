<?php
	namespace app\model\Role;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;
	use app\lib\Random;
	use app\lib\Server;

	class RoleModel extends Model{
		public $table = 'role';
		public $title = '角色管理';
		
		protected function getShowList(Request $request){
		    $fields = $this->getList($request,'field');
		    $field = [];
		    foreach($fields as $key => $val){
		        array_push($field,"{$val} as {$key}");
		    }
		    
		    $result = [];
		    $object = Db::table($this->table)
		                ->select(...$field)
		                ->where('IsDel',0)
		                ->orderBy('Level','ASC')
		                ->orderBy('Sort','ASC')
		                ->get();
		    if($object){
		        $result = $this->objectToArray($object);
		    }
		    
		    $arr = [
			    'title' => $this->title,
			    'table' => strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $this->table)),
			    'layer' => 2,
			    'thead' => $this->getList($request,'map'),
			    'rows'  => count($result),
			    'data'  => $this->nav($result)
			];

			return $arr;
		    
		}

		/**
		 * 获取所有列表
		 * @return [type] [description]
		 */
		protected function getAllList(Request $request){
			$args = func_get_args();
            $field = 'ID as id,Title as title,Sign as sign,Pic as pic,Level as level,PID as pid,IsDefault as is_default,IsAllowLogin as is_allow_login,IsAdmin as is_admin,Number as `number`,Sort as sort';
            $where = '1 = 1';
            $fields = $this->getFields('Field');
            if(in_array('IsDel',$fields)){
                $where .= " AND IsDel = 0";
            }
            $order = 'ID ASC';

            $sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $order";
            $object = Db::select($sql);
            $result = $this->objectToArray($object);
            if($result){
            	for($i=0;$i<count($result);$i++){
            		$result[$i]['sign'] = substr($result[$i]['sign'],0,3).'****'.substr($result[$i]['sign'],strlen($result[$i]['sign'])-3);
            	}
            }
            return $this->nav($result);
		}

		protected function setRequest(Request $request,$flag = false){
			if(!$flag){
				$data['sign'] = Random::token();
				$data['create_time'] = Server::getDate();
				return $data;
			}
			return [];
		}

		// 通过sign获取数据
		protected function getSignList(Request $request){
			$args = func_get_args();
			$sql = "SELECT * FROM ".$this->tab." WHERE Sign = ? LIMIT 1";
			$param = array($args[0]);

			$object = Db::select($sql,$param);
			$result = $this->objectToArray($object);

			return isset($result[0]) ? $result[0] : array();
		}

		/**
		 * 通过sign检查是否是某个角色
		 * @return [type] [description]
		 */
		public function checkRole($sign,$id = 0){
			if(!$sign || !$id){
				return false;
			}
			$sql = "SELECT id,pid FROM ".$this->tab." WHERE Sign = ? LIMIT 1";
			$param = array($sign);

			$object = Db::select($sql,$param);
			if($object){
				$result = $object[0];
				if(!$id){
					if($result->id < 9){
						return true;
					}
					return false;
				}
				if(is_array($id)){
					if(in_array($result->id,$id)){
						return true;
					}
					return false;
				}
				if(is_numeric($id) && $id){
					if($result->id == $id){
						return true;
					}
					return false;
				}
				return false;
			}
			return false;
		}

		

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'UnitName','type'=>'varchar','length'=>'250','default'=>'','title'=>'角色名称','width'=>150],
				['map'=>'sign','field'=>'Sign','type'=>'varchar','length'=>'32','default'=>'','title'=>'标识符','width'=>300],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'10','default'=>'','title'=>'图标','width'=>0],
				['map'=>'level','field'=>'Level','type'=>'int','length'=>'2','default'=>'','title'=>'级别','width'=>0],
				['map'=>'pid','field'=>'PID','type'=>'int','length'=>'2','default'=>'','title'=>'父级','width'=>0],
				['map'=>'is_admin','field'=>'IsAdmin','type'=>'switch','length'=>'1','default'=>'','title'=>'管理员','width'=>0],
				['map'=>'is_allow_login','field'=>'IsAllowLogin','type'=>'switch','length'=>'1','default'=>'','title'=>'允许登录','width'=>0],
				['map'=>'is_default','field'=>'IsDefault','type'=>'switch','length'=>'1','default'=>'','title'=>'默认注册','width'=>0],
				['map'=>'number','field'=>'Number','type'=>'int','length'=>'2','default'=>'','title'=>'子数目','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'int','length'=>'2','default'=>'','title'=>'排序','width'=>0]
			];
		}
	}
?>