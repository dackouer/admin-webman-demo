<?php
	namespace app\lib;

	use support\Request;
	use support\Redis;

	class Http{
		/**
		 * 设置或获取session
		 * @param  $token [description]
		 * @param  [type]  $key     [description]
		 * @param  [type]  $value   [description]
		 * @return [type]           [description]
		 */
		public static function session($token,$key = null,$value = null){
			// if(empty($token) || !$token){
			// 	return false;
			// }
			// $session = $request->session();

			// if(is_null($value) && is_null($key)){
			// 	return $session;
			// }

			// $key = MD5($token.'_'.$key);
			// if(!is_null($value) && !empty($value)){
			// 	$session->set($key,$value);
			// 	return true;
			// }else{
			// 	return $session->get($key);
			// }
		}

		/**
		 * 设置或获取redis
		 * @param  $token [description]
		 * @param  [type]  $key     [description]
		 * @param  [type]  $value   [description]
		 * @return [type]           [description]
		 */
		public static function redis($token,$key = null,$value = null){
			if(empty($token) || !$token){
				return false;
			}

			if(is_null($value) && is_null($key)){
				return false;
			}

			$key = MD5($token.'_'.$key);
			if(!is_null($value) && !empty($value)){
				Redis::set($key,$value);
				return true;
			}else{
				return Redis::exists($key) ? Redis::get($key) : false;
			}
		}
	}
?>