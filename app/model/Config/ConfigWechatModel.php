<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigWechatModel extends Model{
		public $table = 'config_wechat';
		public $title = '微信设置';
		public $tabtype = 2;	// 配置表

		protected function getShowList(Request $request){
			return [
				'title'	=> $this->title,
				'map'	=> $this->getList($request,'map'),
				'data'  => $this->getList($request,1)
			];
		}

		protected function getFieldList(Request $request){
			return [
				'id'				=> 'ID',
				'wechat_name'		=> 'WechatName',
				'appid'				=> 'AppId',
				'secret'			=> 'AppSecret',
				'server_url'		=> 'ServerUrl',
				'token'				=> 'Token',
				'wx_qrcode'			=> 'WxQrcode',
				'mini_wechat_name'	=> 'MiniWechatName',
				'mini_original_id'	=> 'MiniOriginalId',
				'mini_appid'		=> 'MiniAppId',
				'mini_secret'		=> 'MiniAppSecret',
				'mini_qrcode'		=> 'MiniQrcode',
				'app_wechat_name'	=> 'AppWechatName',
				'app_appid'			=> 'AppAppId',
				'app_secret'		=> 'AppAppSecret',
				'web_wechat_name'	=> 'WebWechatName',
				'web_appid'			=> 'WebAppId',
				'web_secret'		=> 'WebAppSecret',
				'mchid'				=> 'MchId',
				'serial_number'		=> 'SerialNumber',
				'apikey'			=> 'ApiKey',
				'apiv3key'			=> 'Apiv3Key',
				'apicert'			=> 'Apicert',
				'apikeys'			=> 'Apikeys',
				'notify_url'		=> 'NotifyUrl',
				'return_url'		=> 'ReturnUrl',
				'service_qrcode'	=> 'ServiceQrcode',
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
				['map'=>'wechat_name','field'=>'WechatName','type'=>'varchar','length'=>'32','default'=>'','title'=>'公众号名称','width'=>0],
				['map'=>'appid','field'=>'AppId','type'=>'varchar','length'=>'32','default'=>'','title'=>'AppId','width'=>0],
				['map'=>'secret','field'=>'AppSecret','type'=>'varchar','length'=>'32','default'=>'','title'=>'AppSecret','width'=>0],
				['map'=>'server_url','field'=>'ServerUrl','type'=>'varchar','length'=>'16','default'=>'','title'=>'服务器地址','width'=>0],
				['map'=>'token','field'=>'Token','type'=>'varchar','length'=>'1','default'=>[1,0],'title'=>'Token','width'=>0],
				['map'=>'wx_qrcode','field'=>'WxQrcode','type'=>'img','length'=>'2','default'=>'6','title'=>'公众号二维码','width'=>0],
				['map'=>'mini_wechat_name','field'=>'MiniWechatName','type'=>'varchar','length'=>'1','default'=>0,'title'=>'小程序名称','width'=>0],
				['map'=>'mini_original_id','field'=>'MiniOriginalId','type'=>'varchar','length'=>'1','default'=>[1,0],'title'=>'小程序原始id','width'=>0],
				['map'=>'mini_appid','field'=>'MiniAppId','type'=>'varchar','length'=>'1','default'=>[1,0],'title'=>'小程序AppId','width'=>0],
				['map'=>'mini_secret','field'=>'MiniAppSecret','type'=>'varchar','length'=>'1','default'=>[1,0],'title'=>'小程序AppSecret','width'=>0],
				['map'=>'mini_qrcode','field'=>'MiniQrcode','type'=>'img','length'=>'1','default'=>[1,0],'title'=>'小程序二维码','width'=>0],
				['map'=>'app_wechat_name','field'=>'AppWechatName','type'=>'varchar','length'=>'1','default'=>11,'title'=>'移动应用名称','width'=>0],
				['map'=>'app_appid','field'=>'AppAppId','type'=>'varchar','length'=>'1','default'=>6,'title'=>'移动应用AppId','width'=>0],
				['map'=>'app_secret','field'=>'AppAppSecret','type'=>'varchar','length'=>'1','default'=>[1,0],'title'=>'移动应用AppSecret','width'=>0],
				['map'=>'web_wechat_name','field'=>'AppWechatName','type'=>'float','length'=>'1','default'=>0,'title'=>'网站应用名称','width'=>0],
				['map'=>'web_appid','field'=>'WebAppId','type'=>'varchar','length'=>'1','default'=>30,'title'=>'网站应用AppId','width'=>0],
				['map'=>'web_secret','field'=>'WebAppSecret','type'=>'varchar','length'=>'1','default'=>[1,0],'title'=>'网站应用AppSecret','width'=>0],
				['map'=>'mchid','field'=>'MchId','type'=>'varchar','length'=>'2','default'=>15,'title'=>'商户号ID','width'=>0],
				['map'=>'serial_number','field'=>'SerialNumber','type'=>'varchar','length'=>'2','default'=>15,'title'=>'API证书序列号','width'=>0],
				['map'=>'apikey','field'=>'ApiKey','type'=>'varchar','length'=>'2','default'=>15,'title'=>'Api私钥','width'=>0],
				['map'=>'apiv3key','field'=>'Apiv3Key','type'=>'varchar','length'=>'2','default'=>15,'title'=>'Apiv3私钥','width'=>0],
				['map'=>'apicert','field'=>'Apicert','type'=>'varchar','length'=>'2','default'=>15,'title'=>'Apicert证书','width'=>0],
				['map'=>'apikeys','field'=>'Apikeys','type'=>'file','length'=>'2','default'=>15,'title'=>'Apikeys证书','width'=>0],
				['map'=>'notify_url','field'=>'NotifyUrl','type'=>'varchar','length'=>'2','default'=>15,'title'=>'回调地址','width'=>0],
				['map'=>'return_url','field'=>'ReturnUrl','type'=>'varchar','length'=>'2','default'=>15,'title'=>'返回地址','width'=>0],
				['map'=>'service_qrcode','field'=>'ServiceQrcode','type'=>'img','length'=>'2','default'=>15,'title'=>'客服二维码','width'=>0],
			];
		}
	}
?>