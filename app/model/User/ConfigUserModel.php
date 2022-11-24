<?php
	namespace app\model\User;

	use support\Request;
	use app\model\Model;

	class ConfigUserModel extends Model{
		public $table = 'config_user';
		public $title = '用户设置';
		public $tabtype = 2;	// 配置表
	}
?>