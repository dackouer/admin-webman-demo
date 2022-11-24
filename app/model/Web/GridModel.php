<?php
	namespace app\model\Web;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;
	use app\lib\Random;
	use app\lib\Server;

	class GridModel extends Model{
		public $table = 'grid';
		public $title = '列表管理';
		
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
            $field = 'ID as id,Title as title,Pic as pic,LinkUrl as url,Level as level,PID as pid,Number as `number`,Sort as sort';
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
		
		protected function getParentList(Request $request,$pid = 0){
		    $fields = $this->getList($request,'field');
		    $field = [];
		    foreach ($fields as $key => $val){
		        array_push($field,"{$val} as {$key}");
		    }
		    
		    $result = [];
		    $object = Db::table($this->table)
		                    ->select(...$field)
		                    ->where([['PID','=',$pid],['IsDel','=',0]])
		                    ->orderBy('Sort','ASC')
		                    ->get();
		    if($object){
		        $result = $this->objectToArray($object);
		        for($i=0;$i<count($result);$i++){
		            $result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
		        }
		    }
		    
		    return $result;
		}

        protected function getFieldList(Request $request){
            return [
                'id'    => 'ID',
                'title' => 'Title',
                'pic'   => 'Pic',
                'url'   => 'LinkUrl',
                'pid'   => 'PID',
                'level' => 'Level',
                'number' => 'Number',
                'sort'  => 'Sort',
                'create_time'   => 'CreateTime'
            ];
        }
		

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'列表名称','width'=>150],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'10','default'=>'','title'=>'图片','width'=>0],
				['map'=>'level','field'=>'Level','type'=>'int','length'=>'2','default'=>'','title'=>'级别','width'=>0],
				['map'=>'pid','field'=>'PID','type'=>'int','length'=>'2','default'=>'','title'=>'父级','width'=>0],
				['map'=>'url','field'=>'LinkUrl','type'=>'varchar','length'=>'250','default'=>'','title'=>'链接','width'=>0],
				['map'=>'number','field'=>'Number','type'=>'int','length'=>'2','default'=>'','title'=>'子数目','width'=>0],
				['map'=>'sort','field'=>'Sort','type'=>'int','length'=>'2','default'=>'','title'=>'排序','width'=>0]
			];
		}
	}
?>