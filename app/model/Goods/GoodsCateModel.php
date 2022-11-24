<?php
	namespace app\model\Goods;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class GoodsCateModel extends Model{
		public $table = 'goods_cate';
		public $title = '商品类别';

		protected function setRequest(Request $request,$flag = false){
			if(!$flag){
				$data['create_time'] = time();
				$data['update_time'] = time();
				return $data;
			}
			return [];
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = trim($request->post('title'));
			$sign = $request->post('sign');
			$pic = $request->post('pic');
			$level = $request->post('level');
			$pid = $request->post('pid');
			$sort = $request->post('sort');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100005;
				}
			}
			
			if(empty($title)){
				return 100501;
			}

			if($this->checkExists(['PID'=>$pid,'Title'=>$title],$id)){
				return 100502;
			}
			
			if(empty($sign)){
				return 100503;
			}

			if($this->checkExists(['PID'=>$pid,'Sign'=>$sign],$id)){
				return 100504;
			}
			
			if(empty($pic)){
			    return 100505;
			}

			if(empty($level) || !is_numeric($level) || !$level){
				return 100506;
			}

			if(!is_numeric($pid)){
				return 100507;
			}

			if(empty($sort) || !is_numeric($sort) || !$sort){
				return 100508;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'sign'					=> 'Sign',
				'pic'					=> 'Pic',
				'level'					=> 'Level',
				'pid'					=> 'PID',
				'sort'					=> 'Sort',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'8','default'=>'','title'=>'类别名称','width'=>0],
				['map'=>'sign','field'=>'Sign','type'=>'varchar','length'=>'8','default'=>'','title'=>'标识符','width'=>0],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'8','default'=>'','title'=>'图标','width'=>0],
			];
		}
	}
?>