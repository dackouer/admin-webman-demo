<?php
	namespace app\controller;

	use support\Request;
	use support\Db;
	use app\lib\Json;

	class Token{
		public function index(Request $request){
			// $result = Db::table('user')
   //              ->join('role','RoleID','=','role.ID')
   //              ->select('AccountID as uid','Sign as sign','Token as token','NickName')
   //              ->get();
   //          var_dump($result);
   //          $str = "83176150_b729295370d5ee9382672cad203fd68d_yFS0RH5GX296IonQhoBUEkPy3Rw";
   //          $token = \app\lib\Token::encrypt($str);
   //          $result['token'] = $token;
			// return Json::show(['token'=>$result]);
		}

		public function create(Request $request){
		    $token = $request->post('apiKey');
		  //  var_dump('token: '.$token);
		    $token = trim($token);
		    if(empty($token)){
		        return Json::show(100011);
		    }
		    
			$object = Db::table('user_token')->select('*')->orderBy('ID','DESC')->limit(1)->first();

			if($object && $object->ExpireTime > time()){
				return Json::show(['token'=>$object->Token]);
			}

			$uid = $request->post('uid',83176150);
			$sign = $request->post('sign','b729295370d5ee9382672cad203fd68d');
			$token = $request->post('token','yFS0RH5GX296IonQhoBUEkPy3Rw');
			$str = "{$uid}_{$sign}_{$token}";

            $token = \app\lib\Token::encrypt($str);

            $data = [
            	'UserID'		=> 83176150,
            	'Token'			=> $token,
            	'CreateTime'	=> time(),
            	'ExpireTime'	=> time() + 3600
            ];

            Db::table('user_token')->insert($data);

            return Json::show(['token'=>$token]);
		}

		// 检查appKey是否合法
		private function checkToken($request,$key){
			$temp = \app\lib\Token::decrypt($key);
            $token = explode('_',$temp);
            // var_dump('token: '.$token);
            if(count($token) < 3 || strlen($temp) < 27){
                return false;
            }
            $where = [
                ['AccountID','=',$token[0]],
                ['Sign','=',$token[1]],
                ['Token','=',$token[2]]
            ];
            
            $result = Db::table('user')
                        ->join('role','RoleID','=','role.ID')
                        ->select('AccountID as uid','Sign as sign','Token as token')
                        ->where($where)
                        ->first();
            
            if(!$result){
            	// var_dump('no user');
                return false;
            }

            $uid = $request->input('uid');
            if(!empty($uid) && $result->uid != $uid){
                return false;
            }

            $str = $result->uid.'_'.$result->sign.'_'.$result->token;
            $token = \app\lib\Token::encrypt($str);
            
            return ['token'=>$token];
		}
	}
?>