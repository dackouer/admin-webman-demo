<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigSystemModel extends Model{
		public $table = 'config_system';
		public $title = '系统设置';
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
				'web_name'			=> 'WebName',
				'en_name'			=> 'EnName',
				'logo'				=> 'Logo',
				'domain'			=> 'Domain',
				'icp'				=> 'Icp',
				'psr'				=> 'Psr',
				'copy_right'		=> 'CopyRight',
				'support'			=> 'Support',
				'web_status'		=> 'WebStatus',
				'web_msg'			=> 'WebMsg',
				'co_name'			=> 'CoName',
				'co_en_name'		=> 'CoEnName',
				'legaler'			=> 'Legaler',
				'co_number'			=> 'CoNumber',
				'license'			=> 'License',
				'contact'			=> 'Contact',
				'telphone'			=> 'Telphone',
				'fax'				=> 'Fax',
				'mobile'			=> 'Mobile',
				'hotline'			=> 'Hotline',
				'email'				=> 'Email',
				'address'			=> 'Address',
				'miit'				=> 'Miit',
				'pagesize'			=> 'Pagesize',
				'keywords'			=> 'Keywords',
				'description'		=> 'Description',
				'webcode'			=> 'Webcode',
				'user_agreement'	=> 'UserAgreement',
				'web_agreement'		=> 'WebAgreement',
				'privacy'			=> 'Privacy',
				'about'				=> 'About'
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
				['map'=>'web_name','field'=>'WebName','type'=>'varchar','length'=>'250','default'=>'','title'=>'网站名称','width'=>0],
				['map'=>'en_name','field'=>'EnName','type'=>'varchar','length'=>'250','default'=>'','title'=>'网站英文名称','width'=>0],
				['map'=>'logo','field'=>'Logo','type'=>'varchar','length'=>'250','default'=>'','title'=>'Logo','width'=>0],
				['map'=>'domain','field'=>'Domain','type'=>'varchar','length'=>'250','default'=>'','title'=>'Domain','width'=>0],
				['map'=>'icp','field'=>'Icp','type'=>'varchar','length'=>'250','default'=>'','title'=>'ICP','width'=>0],
				['map'=>'psr','field'=>'Psr','type'=>'varchar','length'=>'250','default'=>'','title'=>'PSR','width'=>0],
				['map'=>'copy_right','field'=>'CopyRight','type'=>'varchar','length'=>'250','default'=>'','title'=>'版权所有','width'=>0],
				['map'=>'support','field'=>'Support','type'=>'varchar','length'=>'250','default'=>'','title'=>'技术支持','width'=>0],
				['map'=>'web_status','field'=>'WebStatus','type'=>'varchar','length'=>'250','default'=>'','title'=>'网站状态','width'=>0],
				['map'=>'web_msg','field'=>'WebMsg','type'=>'varchar','length'=>'250','default'=>'','title'=>'网站信息','width'=>0],
				['map'=>'co_name','field'=>'CoName','type'=>'varchar','length'=>'250','default'=>'','title'=>'企业名称','width'=>0],
				['map'=>'co_en_name','field'=>'CoEnName','type'=>'varchar','length'=>'250','default'=>'','title'=>'企业英文名称','width'=>0],
				['map'=>'legaler','field'=>'Legaler','type'=>'varchar','length'=>'250','default'=>'','title'=>'法人代表','width'=>0],
				['map'=>'co_number','field'=>'CoNumber','type'=>'varchar','length'=>'250','default'=>'','title'=>'注册号','width'=>0],
				['map'=>'license','field'=>'License','type'=>'varchar','length'=>'250','default'=>'','title'=>'营业执照','width'=>0],
				['map'=>'contact','field'=>'Contact','type'=>'varchar','length'=>'250','default'=>'','title'=>'联系人','width'=>0],
				['map'=>'telphone','field'=>'Telphone','type'=>'varchar','length'=>'250','default'=>'','title'=>'座机号码','width'=>0],
				['map'=>'fax','field'=>'Fax','type'=>'varchar','length'=>'250','default'=>'','title'=>'传真','width'=>0],
				['map'=>'mobile','field'=>'Mobile','type'=>'varchar','length'=>'250','default'=>'','title'=>'手机号码','width'=>0],
				['map'=>'hotline','field'=>'Hotline','type'=>'varchar','length'=>'250','default'=>'','title'=>'客服热线','width'=>0],
				['map'=>'email','field'=>'Email','type'=>'varchar','length'=>'250','default'=>'','title'=>'Email','width'=>0],
				['map'=>'address','field'=>'Address','type'=>'varchar','length'=>'250','default'=>'','title'=>'地址','width'=>0],
				['map'=>'miit','field'=>'Miit','type'=>'varchar','length'=>'250','default'=>'','title'=>'工信备案网址','width'=>0],
				['map'=>'pagesize','field'=>'Pagesize','type'=>'varchar','length'=>'250','default'=>'','title'=>'显示条数','width'=>0],
				['map'=>'keywords','field'=>'Keywords','type'=>'varchar','length'=>'250','default'=>'','title'=>'关键词','width'=>0],
				['map'=>'description','field'=>'Description','type'=>'textarea','length'=>'250','default'=>'','title'=>'描述','width'=>0],
				['map'=>'webcode','field'=>'Webcode','type'=>'textarea','length'=>'250','default'=>'','title'=>'统计代码','width'=>0],
				['map'=>'user_agreement','field'=>'UserAgreement','type'=>'textarea','length'=>'250','default'=>'','title'=>'用户协议','width'=>0],
				['map'=>'web_agreement','field'=>'WebAgreement','type'=>'textarea','length'=>'250','default'=>'','title'=>'平台协议','width'=>0],
				['map'=>'privacy','field'=>'Privacy','type'=>'textarea','length'=>'250','default'=>'','title'=>'隐私政策','width'=>0],
				['map'=>'about','field'=>'About','type'=>'textarea','length'=>'250','default'=>'','title'=>'关于我们','width'=>0],
			];
		}
	}
?>