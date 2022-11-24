<?php
	namespace app\model\Brand;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class BrandModel extends Model{
		public $table = 'brand';
		public $title = '品牌管理';

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$pic = $request->post('pic');

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
				return 100701;
			}

			if($this->checkExists(['BrandName'=>$title],$id)){
				return 100702;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'BrandName',
				'logo'					=> 'Logo',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'BrandName','type'=>'varchar','length'=>'250','default'=>'','title'=>'品牌名称','width'=>0],
				['map'=>'logo','field'=>'Logo','type'=>'img','length'=>'250','default'=>'','title'=>'Logo','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>