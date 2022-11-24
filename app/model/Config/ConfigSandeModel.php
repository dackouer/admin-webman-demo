<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigSandeModel extends Model{
		public $table = 'config_sande';
		public $title = '杉德设置';
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
				'mcname'			=> 'MerchantName',
				'mcid'				=> 'MerchantID',
				'merkey'			=> 'MerKey',
				'md5key'			=> 'Md5Key',
				'mccer'				=> 'MerchantCer',
				'mcpfx'				=> 'MerchantPfx',
				'prikey'			=> 'Prikey',
				'sandecer'			=> 'SandeCer',
				'sandepro'			=> 'SandeProCer',
				'notify_url'		=> 'NotifyUrl',
				'account_url'		=> 'AccountUrl',
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
				['map'=>'mcname','field'=>'MerchantName','type'=>'varchar','length'=>'250','default'=>'','title'=>'商户名称','width'=>0],
				['map'=>'mcid','field'=>'MerchantID','type'=>'varchar','length'=>'250','default'=>'','title'=>'商户号','width'=>0],
				['map'=>'merkey','field'=>'MerKey','type'=>'varchar','length'=>'250','default'=>'','title'=>'商户私钥KEY1','width'=>0],
				['map'=>'md5key','field'=>'Md5Key','type'=>'varchar','length'=>'250','default'=>'','title'=>'商户私钥MD5KEY','width'=>0],
				['map'=>'mccer','field'=>'MerchantCer','type'=>'varchar','length'=>'250','default'=>'','title'=>'商户cer文件','width'=>0],
				['map'=>'mcpfx','field'=>'MerchantPfx','type'=>'varchar','length'=>'250','default'=>'','title'=>'商户pfx文件','width'=>0],
				['map'=>'prikey','field'=>'Prikey','type'=>'varchar','length'=>'250','default'=>'','title'=>'prikey文件','width'=>0],
				['map'=>'sandecer','field'=>'SandeCer','type'=>'varchar','length'=>'250','default'=>'','title'=>'杉德cer文件','width'=>0],
				['map'=>'sandepro','field'=>'SandeProCer','type'=>'varchar','length'=>'250','default'=>'','title'=>'杉德cer文件','width'=>0],
				['map'=>'notify_url','field'=>'NotifyUrl','type'=>'varchar','length'=>'250','default'=>'','title'=>'支付回调地址','width'=>0],
				['map'=>'account_url','field'=>'AccountUrl','type'=>'varchar','length'=>'250','default'=>'','title'=>'开户回调地址','width'=>0],
			];
		}
	}
?>