<?php
	namespace app\model\Order;

	use support\Request;
	use app\model\Model;

	class ConfigOrderModel extends Model{
		public $table = 'config_order';
		public $title = '订单设置';
		public $tabtype = 2;	// 配置表
	}
?>