<?php
	namespace app\lib;

	use support\Request;

	class Json{
		public static function show($code = 1,$msg = ''){
			if(!empty($msg)){
				if(is_array($msg) || is_object($msg)){
					if(!$msg){
						return json(['code' => $code,'msg' => 'success','data' => []]);
					}
					return json(['code' => $code, 'msg' => 'success', 'data' => $msg]);
				}
				return json(['code' => $code, 'msg' => $msg]);
			}else{
				if(is_array($code) || is_object($code)){
					if(!$code){
						return json(['code' => 0,'msg' => 'success','data' => []]);
					}
					return json(['code' => 0, 'msg' => 'success', 'data' => $code]);
				}

				if(is_numeric($code)){
					return json(['code' => $code,'msg' => Lang::get($code)]);
				}

				if(is_string($code)){
					return json(['code' => 1,'msg' => $code]);
				}

				if(is_null($code) || empty($code) || $code === 0){
					return json(['code' => 0,'msg' => 'success']);
				}

				return json(['code' => 1,'msg' => $code]);
			}
		}
	}
?>