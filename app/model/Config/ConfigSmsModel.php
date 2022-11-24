<?php
	namespace app\model\Config;

	use support\Request;
	use support\Db;
	use app\model\Model;

	class ConfigSmsModel extends Model{
		public $table = 'config_aliyun';
		public $title = '短信设置';
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
				'id'		=> 'ID',
				'appkey'	=> 'AppKey',
				'secret'	=> 'AppSecret',
				'sign'		=> 'SignName',
				'template'	=> 'TemplateCode',
				'type'		=> 'CreateType',
				'length'	=> 'Length',
				'is_log'	=> 'IsLog'
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
				['map'=>'appkey','field'=>'AppKey','type'=>'varchar','length'=>'32','default'=>'','title'=>'AppKey','width'=>0],
				['map'=>'secret','field'=>'AppSecret','type'=>'varchar','length'=>'32','default'=>'','title'=>'AppSecret','width'=>0],
				['map'=>'sign','field'=>'SignName','type'=>'varchar','length'=>'32','default'=>'','title'=>'短信签名','width'=>0],
				['map'=>'template','field'=>'TemplateCode','type'=>'varchar','length'=>'16','default'=>'','title'=>'模板ID','width'=>0],
				['map'=>'type','field'=>'CreateType','type'=>'radio','length'=>'1','default'=>[[1,'纯数字'],[2,'纯字母'],[3,'混合']],'title'=>'创建方式','width'=>0],
				['map'=>'length','field'=>'Length','type'=>'int','length'=>'2','default'=>'6','title'=>'短信长度','width'=>0],
				['map'=>'is_log','field'=>'IsLog','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启日志','width'=>0],
			];
		}
	}
?>