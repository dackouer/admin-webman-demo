<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigTencentModel extends Model{
		public $table = 'config_tencent';
		public $title = '腾讯云设置';
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
				'secret_id'			=> 'SecretId',
				'secret_key'		=> 'SecretKey',
				'app_id'			=> 'AppId',
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
				['map'=>'secret_id','field'=>'SecretId','type'=>'varchar','length'=>'250','default'=>'','title'=>'SecretId','width'=>0],
				['map'=>'secret_key','field'=>'SecretKey','type'=>'varchar','length'=>'250','default'=>'','title'=>'SecretKey','width'=>0],
				['map'=>'app_id','field'=>'AppId','type'=>'varchar','length'=>'250','default'=>'','title'=>'AppId','width'=>0],
			];
		}
	}
?>