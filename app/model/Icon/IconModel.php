<?php
	namespace app\model\Icon;

	use support\Request;
	use support\Redis;
	use app\model\Model;

	class IconModel extends Model{
		public $table = 'icon';
		public $title = '图标管理';
	}
?>