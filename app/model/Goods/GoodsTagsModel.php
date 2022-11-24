<?php
	namespace app\model\Goods;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class GoodsTagsModel extends Model{
		public $table = 'goods_tags';
		public $title = '商品标签';

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
				return 100601;
			}

			if($this->checkExists(['TagName'=>$title],$id)){
				return 100602;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'TagName',
				'pic'					=> 'Pic',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'8','default'=>'','title'=>'标签名称','width'=>0],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'8','default'=>'','title'=>'标签图片','width'=>0],
			];
		}
	}
?>