<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigUserModel extends Model{
		public $table = 'config_user';
		public $title = '用户设置';
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
				'id'							=> 'ID',
				'is_reg'						=> 'IsReg',
				'is_login_reg'					=> 'IsLoginReg',
				'is_login'						=> 'IsLogin',
				'is_login_login'				=> 'IsLoginLogin',
				'is_reg_username'				=> 'IsRegUsername',
				'is_reg_nickname'				=> 'IsRegNickname',
				'is_reg_realname'				=> 'IsRegRealname',
				'is_reg_gender'					=> 'IsRegGender',
				'is_reg_password'				=> 'IsRegPassword',
				'is_reg_checkpwd'				=> 'IsRegCheckpwd',
				'is_reg_mobile'					=> 'IsRegMobile',
				'is_reg_email'					=> 'IsRegEmail',
				'is_reg_role'					=> 'IsRegRole',
				'is_reg_invite'					=> 'IsRegInvite',
				'is_reg_numcode'				=> 'IsRegNumcode',
				'is_reg_smscode'				=> 'IsRegSmscode',
				'is_reg_emailcode'				=> 'IsRegEmailcode',
				'username_min_length'			=> 'UsernameMinLength',
				'username_max_length'			=> 'UsernameMaxLength',
				'username_special_character'	=> 'UsernameSpecialCharacter',
				'is_username_letter'			=> 'IsUsernameLetter',
				'is_username_numeral'			=> 'IsUsernameNumeral',
				'is_username_chinese'			=> 'IsUsernameChinese',
				'is_username_special'			=> 'IsUsernameSpecial',
				'preg_username'					=> 'PregUsername',
				'auth_min_age'					=> 'AuthMinAge',
				'auth_max_age'					=> 'AuthMaxAge',
				'reg_activate_type'				=> 'RegActivateType',
				'password_min_length'			=> 'PasswordMinLength',
				'password_max_length'			=> 'PasswordMaxLength',
				'password_special_character'	=> 'PasswordSpecialCharacter',
				'preg_password'					=> 'PregPassword',
				'is_test_smscode'				=> 'IsTestSmscode',
				'test_smscode'					=> 'TestSmscode',
				'max_idcard_reg_count'			=> 'MaxIdcardRegCount',
				'max_mobile_reg_count'			=> 'MaxMobileRegCount',
				'max_email_reg_count'			=> 'MaxEmailRegCount',
				'account_length'				=> 'AccountLength',
				'invite_len'					=> 'InviteLen',
				'invite_type'					=> 'InviteType',
				'token_expire_time'				=> 'TokenExpireTime',
				'default_password'				=> 'DefaultPassword',
				'reg_send_score'				=> 'RegSendScore',
				'sign_send_score'				=> 'SignSendScore',
				'share_send_score'				=> 'ShareSendScore',
				'reg_send_coin'					=> 'RegSendCoin',
				'sign_send_coin'				=> 'SignSendCoin',
				'share_send_coin'				=> 'ShareSendCoin',
				'reg_send_balance'				=> 'RegSendBalance',
				'sign_send_balancee'			=> 'SignSendBalancee',
				'share_send_balancee'			=> 'ShareSendBalancee',
				'is_reg_log'					=> 'IsRegLog',
				'is_login_log'					=> 'IsLoginLog',
				'web_interval'					=> 'WebInterval',
				'login_interval'				=> 'LoginInterval',
				'login_number'					=> 'LoginNumber',
				'default_reg_roleid'			=> 'DefaultRegRoleid',
				'disable_keyword'				=> 'DisableKeyword',
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
				['map'=>'is_reg','field'=>'IsReg','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启前端注册','width'=>0],
				['map'=>'is_login_reg','field'=>'IsLoginReg','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启后端注册','width'=>0],
				['map'=>'is_login','field'=>'IsLogin','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启前端登录','width'=>0],
				['map'=>'is_login_login','field'=>'IsLoginLogin','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启后端登录','width'=>0],
				['map'=>'is_reg_username','field'=>'IsRegUsername','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册用户名必填','width'=>0],
				['map'=>'is_reg_nickname','field'=>'IsRegNickname','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册昵称必填','width'=>0],
				['map'=>'is_reg_realname','field'=>'IsRegRealname','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册真实姓名必填','width'=>0],
				['map'=>'is_reg_gender','field'=>'IsRegGender','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册性别必填','width'=>0],
				['map'=>'is_reg_password','field'=>'IsRegPassword','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册密码必填','width'=>0],
				['map'=>'is_reg_checkpwd','field'=>'IsRegCheckpwd','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册确认密码必填','width'=>0],
				['map'=>'is_reg_mobile','field'=>'IsRegMobile','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册手机号必填','width'=>0],
				['map'=>'is_reg_email','field'=>'IsRegEmail','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册Email必填','width'=>0],
				['map'=>'is_reg_role','field'=>'IsRegRole','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册角色必填','width'=>0],
				['map'=>'is_reg_invite','field'=>'IsRegInvite','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册邀请码必填','width'=>0],
				['map'=>'is_reg_numcode','field'=>'IsRegNumcode','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启注册图形验证码','width'=>0],
				['map'=>'is_reg_smscode','field'=>'IsRegSmscode','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启注册短信验证码','width'=>0],
				['map'=>'is_reg_emailcode','field'=>'IsRegEmailcode','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'注册邮箱验证码必填','width'=>0],
				['map'=>'username_min_length','field'=>'UsernameMinLength','type'=>'int','length'=>'1','default'=>5,'title'=>'用户名最小长度','width'=>0],
				['map'=>'username_max_length','field'=>'UsernameMaxLength','type'=>'int','length'=>'2','default'=>25,'title'=>'用户名最大长度','width'=>0],
				['map'=>'username_special_character','field'=>'UsernameSpecialCharacter','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户名允许特殊字符','width'=>0],
				['map'=>'is_username_letter','field'=>'IsUsernameLetter','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'字母','width'=>0],
				['map'=>'is_username_numeral','field'=>'IsUsernameNumeral','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'数字','width'=>0],
				['map'=>'is_username_chinese','field'=>'IsUsernameChinese','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'中文','width'=>0],
				['map'=>'is_username_special','field'=>'IsUsernameSpecial','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'特殊字符','width'=>0],
				['map'=>'preg_username','field'=>'PregUsername','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户名正则','width'=>0],
				['map'=>'auth_min_age','field'=>'AuthMinAge','type'=>'int','length'=>'2','default'=>'18','title'=>'实名认证允许最小年龄','width'=>0],
				['map'=>'auth_max_age','field'=>'AuthMaxAge','type'=>'int','length'=>'2','default'=>'65','title'=>'实名认证允许最大年龄','width'=>0],
				['map'=>'reg_activate_type','field'=>'RegActivateType','type'=>'radio','length'=>'1','default'=>[[1,'自动激活'],[2,'邮箱激活']],'title'=>'用户注册激活方式','width'=>0],
				['map'=>'password_min_length','field'=>'PasswordMinLength','type'=>'int','length'=>'1','default'=>6,'title'=>'密码最小长度','width'=>0],
				['map'=>'password_max_length','field'=>'PasswordMaxLength','type'=>'int','length'=>'2','default'=>36,'title'=>'密码最大长度','width'=>0],
				['map'=>'password_special_character','field'=>'PasswordSpecialCharacter','type'=>'varchar','length'=>'250','default'=>'','title'=>'密码允许特殊字符','width'=>0],
				['map'=>'preg_password','field'=>'PregPassword','type'=>'varchar','length'=>'250','default'=>'','title'=>'密码正则','width'=>0],
				['map'=>'is_test_smscode','field'=>'IsTestSmscode','type'=>'switch','length'=>1,'default'=>[1,0],'title'=>'开启测试短信验证码','width'=>0],
				['map'=>'test_smscode','field'=>'TestSmscode','type'=>'varchar','length'=>16,'default'=>'123456','title'=>'测试短信验证码','width'=>0],
				['map'=>'max_idcard_reg_count','field'=>'MaxIdcardRegCount','type'=>'int','length'=>1,'default'=>1,'title'=>'身份证最大注册用户数','width'=>0],
				['map'=>'max_mobile_reg_count','field'=>'MaxMobileRegCount','type'=>'int','length'=>1,'default'=>1,'title'=>'手机最大注册用户数','width'=>0],
				['map'=>'max_email_reg_count','field'=>'MaxEmailRegCount','type'=>'int','length'=>1,'default'=>1,'title'=>'邮箱最大注册用户数','width'=>0],
				['map'=>'account_length','field'=>'AccountLength','type'=>'int','length'=>1,'default'=>1,'title'=>'用户ID长度','width'=>0],
				['map'=>'invite_len','field'=>'InviteLen','type'=>'int','length'=>1,'default'=>1,'title'=>'邀请码长度','width'=>0],
				['map'=>'invite_type','field'=>'InviteType','type'=>'int','length'=>1,'default'=>1,'title'=>'生成邀请码方式','width'=>0],
				['map'=>'token_expire_time','field'=>'TokenExpireTime','type'=>'int','length'=>1,'default'=>3600,'title'=>'Token过期时间(秒)','width'=>0],
				['map'=>'default_password','field'=>'DefaultPassword','type'=>'varchar','length'=>32,'default'=>'Hr741852','title'=>'默认注册密码','width'=>0],
				['map'=>'reg_send_score','field'=>'RegSendScore','type'=>'int','length'=>1,'default'=>1,'title'=>'注册赠送积分','width'=>0],
				['map'=>'sign_send_score','field'=>'SignSendScore','type'=>'int','length'=>1,'default'=>1,'title'=>'签到赠送积分','width'=>0],
				['map'=>'share_send_score','field'=>'ShareSendScore','type'=>'int','length'=>1,'default'=>1,'title'=>'分享赠送积分','width'=>0],
				['map'=>'reg_send_coin','field'=>'RegSendCoin','type'=>'int','length'=>1,'default'=>1,'title'=>'注册送金币','width'=>0],
				['map'=>'sign_send_coin','field'=>'SignSendCoin','type'=>'int','length'=>1,'default'=>1,'title'=>'签到送金币','width'=>0],
				['map'=>'share_send_coin','field'=>'ShareSendCoin','type'=>'int','length'=>1,'default'=>1,'title'=>'分享送金币','width'=>0],
				['map'=>'reg_send_balance','field'=>'RegSendBalance','type'=>'int','length'=>1,'default'=>1,'title'=>'注册赠送余额','width'=>0],
				['map'=>'sign_send_balancee','field'=>'SignSendBalancee','type'=>'int','length'=>1,'default'=>1,'title'=>'签到赠送余额','width'=>0],
				['map'=>'share_send_balancee','field'=>'ShareSendBalancee','type'=>'int','length'=>1,'default'=>1,'title'=>'分享赠送余额','width'=>0],
				['map'=>'is_reg_log','field'=>'IsRegLog','type'=>'switch','length'=>1,'default'=>[1,0],'title'=>'开启注册日志','width'=>0],
				['map'=>'is_login_log','field'=>'IsLoginLog','type'=>'switch','length'=>1,'default'=>[1,0],'title'=>'开启登录日志','width'=>0],
				['map'=>'web_interval','field'=>'WebInterval','type'=>'int','length'=>1,'default'=>1,'title'=>'网页操作间隔','width'=>0],
				['map'=>'login_interval','field'=>'LoginInterval','type'=>'int','length'=>1,'default'=>1,'title'=>'注册登录操作间隔','width'=>0],
				['map'=>'login_number','field'=>'LoginNumber','type'=>'int','length'=>1,'default'=>5,'title'=>'开启登录错误次数','width'=>0],
				['map'=>'default_reg_roleid','field'=>'DefaultRegRoleid','type'=>'int','length'=>2,'default'=>19,'title'=>'用户默认注册角色','width'=>0],
				['map'=>'disable_keyword','field'=>'DisableKeyword','type'=>'varchar','length'=>2048,'default'=>'admin,admins,root,manage','title'=>'禁用关键词','width'=>0],
			];
		}
	}
?>