<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigQiniuModel extends Model{
		public $table = 'config_qiniu';
		public $title = '七牛云设置';
		public $tabtype = 2;	// 配置表

		protected function getShowList(Request $request){
			return [
				'title'	=> $this->title,
				'table' => $this->table,
				'map'	=> $this->getList($request,'map'),
				'data'  => $this->getList($request,1)
			];
		}

		protected function getFieldList(Request $request){
			return [
				'id'				=> 'ID',
				'access_key'		=> 'AccessKey',
				'secret_key'		=> 'SecretKey',
				'bucket'			=> 'Bucket',
				'dirname'			=> 'Dirname',
				'domain'			=> 'Domain',
			];
		}

		/**
		 * [getMapList description]
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'access_key','field'=>'AccessKey','type'=>'varchar','length'=>'250','default'=>'','title'=>'AccessKey','width'=>0],
				['map'=>'secret_key','field'=>'SecretKey','type'=>'varchar','length'=>'250','default'=>'','title'=>'SecretKey','width'=>0],
				['map'=>'bucket','field'=>'Bucket','type'=>'varchar','length'=>'250','default'=>'','title'=>'Bucket','width'=>0],
				['map'=>'dirname','field'=>'Dirname','type'=>'varchar','length'=>'250','default'=>'','title'=>'Dirname','width'=>0],
				['map'=>'domain','field'=>'Domain','type'=>'varchar','length'=>'250','default'=>'','title'=>'Domain','width'=>0],
			];
		}
	}
?>