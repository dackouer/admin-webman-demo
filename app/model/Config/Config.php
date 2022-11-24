<?php
	namespace app\model\Config;

	use support\Request;

	class Config{
		/**
		 * 获取系统配置项
		 * @return [type] [description]
		 */
		public function system(Request $request,$id = 1){
			$service = new ConfigSystemModel();
			$result = $service->getList($request,1);
			return $result;
		}

		/**
		 * 获取用户配置项
		 * @return [type] [description]
		 */
		public function user(Request $request,$id = 1){
			$service = new ConfigUserModel();
			$result = $service->getList($request,1);
			return $result;
		}
	}
?>