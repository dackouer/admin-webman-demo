<?php
	namespace app\model\Config;

	use support\Request;
	use app\model\Model;

	class ConfigOrderModel extends Model{
		public $table = 'config_order';
		public $title = '订单设置';
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
				'is_order'			=> 'IsOrder',
				'is_must_auth'		=> 'IsMustAuth',
				'is_share'			=> 'IsShare',
				'is_integral'		=> 'IsIntegral',
				'is_commission'		=> 'IsCommission',
				'commission_value'	=> 'CommissionValue',
				'is_blind'			=> 'IsBlind',
				'is_airdrop'		=> 'IsAirdrop',
				'is_priority'		=> 'IsPriority',
				'is_transfer'		=> 'IsTransfer',
				'is_compose'		=> 'IsCompose',
				'is_sec_market'		=> 'IsSecMarket',
				'is_resale'			=> 'IsResale',
				'is_single'			=> 'IsSingle',
				'order_length'		=> 'OrderLength',
				'is_pay'			=> 'IsPay',
				'is_balance_pay'	=> 'IsBalancePay',
				'is_wechat_pay'		=> 'IsWechatPay',
				'is_ali_pay'		=> 'IsAliPay',
				'is_sande_pay'		=> 'IsSandePay',
				'is_platform_pay'	=> 'IsPlatformPay',
				'is_cent_mall'		=> 'IsCentMall',
				'is_test_pay'		=> 'IsTestPay',
				'test_pay_fee'		=> 'TestPayFee',
				'wait_time'			=> 'WaitTime',
				'is_locked'			=> 'OrderLocked',
				'show_order_length'	=> 'ShowOrderLength',
				'buy_message'		=> 'BuyMessage',
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
				['map'=>'is_order','field'=>'IsOrder','type'=>'switch','length'=>'32','default'=>'','title'=>'开启订单(总开关)','width'=>0],
				['map'=>'is_must_auth','field'=>'IsMustAuth','type'=>'switch','length'=>'32','default'=>'','title'=>'开启实名下单','width'=>0],
				['map'=>'is_share','field'=>'IsShare','type'=>'switch','length'=>'32','default'=>'','title'=>'开启分享(总开关)','width'=>0],
				['map'=>'is_integral','field'=>'IsIntegral','type'=>'switch','length'=>'16','default'=>'','title'=>'开启积分(总开关)','width'=>0],
				['map'=>'is_commission','field'=>'IsCommission','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启分佣(总开关)','width'=>0],
				['map'=>'commission_value','field'=>'CommissionValue','type'=>'int','length'=>'2','default'=>'6','title'=>'分佣值','width'=>0],
				// ['map'=>'commission_rate','field'=>'CommissionRate','type'=>'varchar','length'=>'1','default'=>0,'title'=>'分佣单位','width'=>0],
				['map'=>'is_blind','field'=>'IsBlind','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启盲盒(总开关)','width'=>0],
				['map'=>'is_airdrop','field'=>'IsAirdrop','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启空投(总开关)','width'=>0],
				['map'=>'is_priority','field'=>'IsPriority','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启优先购(总开关)','width'=>0],
				['map'=>'is_transfer','field'=>'IsTransfer','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启转赠(总开关)','width'=>0],
				['map'=>'is_compose','field'=>'IsCompose','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启合成(总开关)','width'=>0],
				['map'=>'is_sec_market','field'=>'IsSecMarket','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启二级市场(总开关)','width'=>0],
				['map'=>'is_resale','field'=>'IsResale','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启转售(总开关)','width'=>0],
				['map'=>'is_single','field'=>'IsSingle','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'单商品模式','width'=>0],
				['map'=>'order_length','field'=>'OrderLength','type'=>'int','length'=>'1','default'=>11,'title'=>'订单长度(除日期)','width'=>0],
				['map'=>'is_pay','field'=>'IsPay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启支付','width'=>0],
				['map'=>'is_balance_pay','field'=>'IsBalancePay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启余额支付','width'=>0],
				['map'=>'is_wechat_pay','field'=>'IsWechatPay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启微信支付','width'=>0],
				['map'=>'is_ali_pay','field'=>'IsAliPay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启支付宝支付','width'=>0],
				['map'=>'is_sande_pay','field'=>'IsSandePay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启杉德支付','width'=>0],
				['map'=>'is_platform_pay','field'=>'IsPlatformPay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启平台支付','width'=>0],
				['map'=>'is_cent_mall','field'=>'IsCentMall','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启积分商城(总开关)','width'=>0],
				['map'=>'is_test_pay','field'=>'IsTestPay','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启测试支付','width'=>0],
				['map'=>'test_pay_fee','field'=>'TestPayFee','type'=>'float','length'=>'1','default'=>0,'title'=>'测试支付金额','width'=>0],
				['map'=>'wait_time','field'=>'WaitTime','type'=>'int','length'=>'1','default'=>30,'title'=>'订单超时时间(分)','width'=>0],
				['map'=>'is_locked','field'=>'OrderLocked','type'=>'switch','length'=>'1','default'=>[1,0],'title'=>'开启未支付库存锁','width'=>0],
				['map'=>'show_order_length','field'=>'ShowOrderLength','type'=>'int','length'=>'4','default'=>0,'title'=>'显示订单时间段(单位:月)','width'=>0],
				['map'=>'buy_message','field'=>'BuyMessage','type'=>'textarea','length'=>'4','default'=>0,'title'=>'购买须知','width'=>0],
				// ['map'=>'confirm_time','field'=>'AutoConfirmTime','type'=>'int','length'=>'2','default'=>15,'title'=>'订单自动确认时间(天)','width'=>0],
			];
		}
	}
?>