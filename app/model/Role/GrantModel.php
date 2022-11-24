<?php
	namespace app\model\Role;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class GrantModel extends Model{
		public $table = 'grant';
		public $title = '权限控制';
	}
?>