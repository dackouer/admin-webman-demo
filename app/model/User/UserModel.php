<?php
	namespace app\model\User;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\lib\Token;
	use app\lib\Random;
	use app\lib\Encrypt;
	use app\lib\Server;
	use app\lib\Preg;
	use app\lib\Http;
	use app\lib\Office;
	use app\lib\Json;
	use app\model\Model;
	use app\model\Role\RoleModel;
	use app\model\Order\OrderModel;
	use app\model\Config\ConfigSystemModel;
	use app\model\Config\ConfigUserModel;
	use app\model\Api\Aliyun\AliyunModel;
	use app\model\Api\Avata\AvataModel;

	use app\model\Api\Tencent\TencentModel;

	class UserModel extends Model{
		public $table = 'user';
		public $title = '用户管理';
		protected $primaryKey = 'AccountID';

		protected function _init(){
			
			$service = new ConfigSystemModel();
			$this->conf = $service->fetch(1);

			$service = new ConfigUserModel();
			$this->config = $service->fetch(1);
		}

		/**
		 * 检查注册总入口
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function checkReg(Request $request){
			$uuid = $request->input('uuid');
			$token = $request->input('token');
			$uid = $request->input('uid');

			if(!empty($uuid) || !empty($token) || !empty($uid)){
				return 100007;
			}

			$reg_mode = $request->post('mode','back');

			$username = $request->post('username');
			if($username != 'admins'){
				if($this->conf['WebStatus'] == 0){
					return 110000;
				}
				if($this->conf['WebStatus'] == 2){
					return 110001;
				}
				if($reg_mode == 'front' && !$this->config['IsReg']){
					return 100014;
				}
				if($reg_mode == 'back' && !$this->config['IsLoginReg']){
					return 100015;
				}
			}
			$type = $request->post('type','username');
			
			switch(strtolower($type)){
				case 'username':
					return $this->checkUsernameReg($request);
				case 'mobile':
					return $this->checkMobileReg($request);
				case 'wechat':
					return $this->checkWechatReg($request);
				case 'qq':
					return $this->checkQqReg($request);
				case 'weibo':
					return $this->checkWeiboReg($request);
				default:
					return $this->checkUsernameReg($request);
			}
		}

		// 检查用户名注册
		private function checkUsernameReg(Request $request){
			$username = $request->post('username');
			if(empty($username)){
				return 100101;
			}
			
			if($this->checkDisableKeyword($username)){
				return 100136;
			}

			// if(strlen($username) < $this->config['UsernameMinLength'] || strlen($username) > $this->config['UsernameMaxLength']){
			// 	return '用户名长度大于'.$this->config['UsernameMinLength'].'小于'.$this->config['UsernameMaxLength'];
			// }
			// var_dump($this->config['preg_username']);
			// if(!preg_match($this->config['preg_username'],$username)){
			// 	return 100113;
			// }

			$preg = "/^[a-zA-Z][a-zA-Z0-9_.]{".$this->config['UsernameMinLength'].",".$this->config['UsernameMaxLength']."}$/";

			if(!preg_match($preg,$username)){
				return 100113;
			}
			
			if($this->checkExists(['UserName' => $username])){
				return 100114;
			}
			
			if(Preg::isMobile($username) && $this->checkExists(['Mobile' => $username])){
				return 100128;
			}
			
			if(Preg::isEmail($username) && $this->checkExists(['Email' => $username])){
				return 100129;
			}

			$password = $request->post('password');
			if(empty($password)){
				return 100102;
			}
			if(strlen($password) < $this->config['PasswordMinLength'] || strlen($password) > $this->config['PasswordMaxLength']){
				return '密码长度大于'.$this->config['PasswordMinLength'].'小于'.$this->config['PasswordMaxLength'];
			}
			// if(!empty($this->config['preg_password']) && !preg_match($this->config['preg_password'],$password)){
			// 	return 100114;
			// }
			
			$preg = "/^[a-zA-Z0-9_.]{".$this->config['PasswordMinLength'].",".$this->config['PasswordMaxLength']."}$/";
			if(!preg_match($preg,$password)){
				return 100114;
			}

			/*

			$nickname = trim($request->post('nickname'));
			if(empty($nickname)){
				return 100116;
			}

			if($this->checkExists($nickname,'nickname')){
				return 100117;
			}
			
			$mobile = trim($request->post('mobile'));
			if(empty($mobile)){
				return 100120;
			}

			if(!preg_match("/^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/",$mobile)){
				return 100121;
			}

			if($this->checkExists($mobile,'mobile')){
				return 100122;
			}

			$smscode = trim($request->post('smscode'));
			if(empty($smscode)){
				return 100122;
			}

			if($smscode != '123456'){
				return 100123;
			}

			// if(!$this->checkValidCode($request,$smscode,'smscode')){
			// 	return 100123;
			// }

			*/
			
			$result = $this->insert($request);

			if(is_array($result)){
				return [
					'uid'		=> $result['uid'],
					'username'	=> $username,
					'token'		=> Token::encrypt($result['token'])
				];
			}
			return false;
		}

		// 检查手机注册
		private function checkMobileReg(Request $request){
			if(!$this->config['IsReg']){
				return 100180;
			}
			if(!$this->config['IsRegMobile']){
				return 100181;
			}

			if($this->config['IsRegUsername']){
				$username = trim($request->post('username',''));
				if(empty($username)){
					return 100101;
				}

				if(!Preg::isUsername($username)){
					return 100113;
				}

				if($this->checkExists(['UserName' => $username])){
					return 100114;
				}

				$mobile = $request->post('mobile');
			}else{
				$mobile = $request->post('mobile');
				if(empty($mobile)){
					$mobile = $request->post('username');
				}
			}
			if(empty($mobile)){
				return 100120;
			}

			if(!Preg::isMobile($mobile)){
				return 100121;
			}
			
			if($this->checkExists(['Mobile' => $mobile])){
				return 100137;
			}

			if($this->config['IsRegPassword']){
				$password = ($request->post('password',''));
				if(empty($password)){
					return 100182;
				}
				if(!Preg::isPassword($password)){
					return 100115;
				}
			}

			if($this->config['IsRegCheckpwd']){
				$checkpwd = ($request->post('checkpwd',''));
				if(empty($checkpwd)){
					return 100183;
				}

				if($checkpwd != $password){
					return 100184;
				}
			}

			$smscode = $request->post('smscode');
			if(empty($smscode)){
				return 100122;
			}

			// if($smscode != '123456'){
			// 	return 100123;
			// }

			if(!$this->checkValidCode($request,$smscode,'smscode')){
				return 100123;
			}

			if($this->config['IsRegInvite']){
				$invite = $request->post('invite');
				if(empty($invite)){
					return 100185;
				}

				if(!$this->checkExists(['InviteCode' => $invite])){
					return 100186;
				}
			}
			
			$result = $this->insert($request);

			if(is_array($result)){
				// 更新联系人
				if(isset($result['parent_id'])){
					$this->setParentShare($result['parent_id']);
					
					$arr = [
						'UserID'		=> $result['parent_id'],
						'ChildID'		=> $result['uid'],
						'ActivityID'	=> isset($result['aid']) ? $result['aid'] : 1,
						'CreateTime'	=> time(),
						'CreateIP'		=> $request->getRealIp($safe_mode=true)
					];

					Db::table('user_contact')->insert($arr);
				}


				return [
					'uid'		=> $result['uid'],
					'mobile'	=> $mobile,
					'token'		=> Token::encrypt($result['token'])
				];
			}
			return false;
		}

		/**
		 * 设置上级和上上级用户分享人
		 * @param [type] $parent_id [description]
		 */
		private function setParentShare($uid){
			$sql = "UPDATE ".$this->tab." SET DirectShare = DirectShare + 1,TotalShare = TotalShare + 1 WHERE AccountID = ?";
			$param = [$uid];
			if(Db::update($sql,$param)){
				$object = Db::table($this->table)->select('ParentID')->where('AccountID',$uid)->first();
				if($object && $object->ParentID){
					$sql = "UPDATE ".$this->tab." SET TotalShare = TotalShare + 1 WHERE AccountID = ?";
					$param = [$object->ParentID];

					if(Db::update($sql,$param)){
						return true;
					}
					return false;
				}
				return true;
			}
			return false;
		}

		/**
		 * 小程序检查用户
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function getMiniList(Request $request){
			$uid = $request->input('uid');
			if(empty($uid) || !is_numeric($uid) || !$uid){
				return ;
			}
			$user = $this->getList($request,$uid);
			if($user){
				return ;
			}

			
		}

		/**
		 * 检查登录总入口
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function checkLogin(Request $request){
			// $token = $request->header('Authorization');
			
			$login_mode = $request->input('mode','back');

			$username = $request->post('username');
			/*
			if($username != 'admins'){
				var_dump($this->conf);
				if($this->conf['web_status'] == 0){
					return 110000;
				}
				if($this->conf['web_status'] == 2){
					return 110001;
				}
				if($login_mode == 'front' && !$this->config['is_login']){
					return 100012;
				}
				if($login_mode == 'back' && !$this->config['is_login_login']){
					return 100013;
				}
			} */
			$type = $request->input('type','username');
			
			switch(strtolower($type)){
				case 'username':
					return $this->checkUsernameLogin($request);
				case 'mobile':
					return $this->checkMobileLogin($request);
				case 'wechat':
					return $this->checkWechatLogin($request);
				case 'qq':
					return $this->checkQqLogin($request);
				case 'weibo':
					return $this->checkWeiboLogin($request);
				default:
					return $this->checkUsernameLogin($request);
			}
		}

		/**
		 * 检查用户名登录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		private function checkUsernameLogin(Request $request){
			if(!$this->config['IsLoginUsername']){
				return 100161;
			}

			$username = $request->post('username');
			if(empty($username)){

				return 100101;
			}

			$numcode = trim($request->post('numcode',''));
			if($this->config['IsLoginNumcode']){
				if(empty($numcode)){
					return 100103;
				}

				if(!$this->checkValidCode($request,$numcode)){
					return 100104;
				}
			}else{
				if(!empty($numcode)){
					if(!$this->checkValidCode($request,$numcode)){
						return 100104;
					}
				}
			}

			$password = $request->post('password');
			if(empty($password)){
				return 100102;
			}

			//
			$result = $this->getLoginList($request,$username);

			if($result){
				if(!password_verify($password,$result['password'])){
					return 100112;	// 密码错误
				}

				if(!$result['is_valid']){
					return 100106;
				}
				if($result['is_locked']){
					return 100107;
				}
				if($result['is_del']){
					return 100108;
				}

				$login_mode = $request->input('mode');

				if($login_mode != 'front'){
					if(!$result['is_allow_login']){
						return 100109;
					}
				}
				if($result['is_role_del']){
					return 100110;
				}

				if(empty($result['face'])){
					switch($result['gender']){
						case 0:
							$result['face'] = $this->host['image'].'unkown.png';
							break;
						case 1:
							$result['face'] = $this->host['image'].'male.png';
							break;
						case 2:
							$result['face'] = $this->host['image'].'female.png';
							break;
						default:
							$result['face'] = $this->host['image'].'unkown.png';
					}
				}

				$data = [
					'uid'		=> $result['uid'],
					'username'	=> $result['username'],
					'nickname'	=> $result['nickname'],
					'face'		=> $result['face'],
					'sign'		=> Token::encrypt($result['sign']),
					'token'		=> $this->encryptToken($result),
					'chain_id'  => $result['chain_id'],
					'invite'	=> $result['invite_code']
				];
				// var_dump($data);
				$this->setSession($request,$data);
				unset($data['sign']);
				return $data;
			}
			return 100105;
		}

		// 验证手机登录
		private function checkMobileLogin(Request $request){
			
			if(!$this->config['IsLoginMobile']){
				return 100161;
			}

			$username = $request->post('username');
			if(empty($username)){
				$username = $request->post('mobile');
			}
			if(empty($username)){
				return 100120;
			}

			if(!Preg::isMobile($username)){
				return 100121;
			}


			$numcode = trim($request->post('numcode',''));
			if($this->config['IsLoginNumcode']){
				if(empty($numcode)){
					return 100103;
				}

				if(!$this->checkValidCode($request,$numcode)){
					return 100104;
				}
			}else{
				if(!empty($numcode)){
					if(!$this->checkValidCode($request,$numcode)){
						return 100104;
					}
				}
			}

			$smscode = $request->post('smscode');

			if(empty($smscode)){
				return 100122;
			}

			if(!$this->checkValidCode($request,$smscode,'smscode')){
				return 100123;
			}

			// if($this->config['IsLoginSmscode']){
			// 	if(empty($smscode)){
			// 		return 100122;
			// 	}

			// 	if(!$this->checkValidCode($request,$smscode,'smscode')){
			// 		return 100123;
			// 	}
			// }else{
			// 	if(!empty($smscode)){
			// 		if(!$this->checkValidCode($request,$smscode,'smscode')){
			// 			return 100123;
			// 		}
			// 	}
			// }

			//
			$result = $this->getLoginList($request,$username,'mobile');

			if(!$result){
				if($this->config['IsAutoRegMobile']){
					// 自动注册
					$data = $this->setRequest($request);
					$data['mobile'] = $username;

					if($this->setAppend($request,$data)){

						// 更新联系人
						if(isset($data['parent_id'])){
							$this->setParentShare($data['parent_id']);
							
							$arr = [
								'UserID'		=> $data['parent_id'],
								'ChildID'		=> $data['uid'],
								'ActivityID'	=> isset($data['aid']) ? $data['aid'] : 1,
								'CreateTime'	=> time()
							];

							Db::table('user_contact')->insert($arr);
						}

						$result = $this->getLoginList($request,$username,'mobile');
						if($result){
							if(!$result['is_valid']){
								return 100106;
							}
							if($result['is_locked']){
								return 100107;
							}
							if($result['is_del']){
								return 100108;
							}

							$login_mode = $request->input('mode');

							if($login_mode != 'front'){
								if(!$result['is_allow_login']){
									return 100109;
								}
							}

							if($result['is_role_del']){
								return 100110;
							}

							// if(!$this->checkUserToken($result['token'])){
							// 	return 100111;
							// }

							$result['face'] = $this->setImg($result['face']);

							$data = [
								'uid'		=> $result['uid'],
								'username'	=> $result['username'],
								'nickname'	=> $result['nickname'],
								'face'		=> $result['face'],
								'sign'		=> Token::encrypt($result['sign']),
								'token'		=> $this->encryptToken($result),
								'chain_id'  => $result['chain_id'],
								'invite'	=> $result['invite_code']
							];
							// var_dump($data);
							$this->setSession($request,$data);
							unset($data['sign']);
							return $data;
						}
						return 100105;
					}
					return 100105;
				}else{
					return 100105;
				}
			}else{

				if(!$result['is_valid']){
					return 100106;
				}
				if($result['is_locked']){
					return 100107;
				}
				if($result['is_del']){
					return 100108;
				}
				$login_mode = $request->input('mode');

				if($login_mode != 'front'){
					if(!$result['is_allow_login']){
						return 100109;
					}
				}
				if($result['is_role_del']){
					return 100110;
				}

				// if(!$this->checkUserToken($result['token'])){
				// 	return 100111;
				// }

				$result['face'] = $this->setImg($result['face']);

				$data = [
					'uid'		=> $result['uid'],
					'username'	=> $result['username'],
					'nickname'	=> $result['nickname'],
					'face'		=> $result['face'],
					'sign'		=> Token::encrypt($result['sign']),
					'token'		=> $this->encryptToken($result),
					'chain_id'  => $result['chain_id'],
					'invite'	=> $result['invite_code']
				];
				// var_dump($data);
				$this->setSession($request,$data);
				unset($data['sign']);
				return $data;
			}
			
		}

		// 获取登录信息列表
		protected function getLoginList(Request $request,$value,$type = 'username'){
			$user = $this->tab;
			$role = $this->prex.'role';
			$table = "$user,$role";
			$field = "$user.ID as id,AccountID as uid,Uuid as uuid,UserName as username,NickName as nickname,RealName as realname,Mobile as mobile,Email as email,Face as face,Authentication as password,Gender as gender,Idcard as idcard,Birth as birth,ParentID as parent_id,Token as token,RoleID as role_id,IsAuth as is_auth,AuthCode as auth_code,InviteCode as invite_code,Invite as invite,Title as title,PID as pid,Sign as sign,Pic as pic,ChainAddress as chain_id,IsAllowLogin as is_allow_login,IsAdmin as is_admin,$user.IsValid as is_valid,$user.IsLocked as is_locked,$user.IsDel as is_del,$role.IsDel as is_role_del";
			$where = "RoleID = $role.ID";
			$param = [];
			switch(strtolower($type)){
				case '':
				case 'username':
					$where .= " AND (UserName = ? OR Mobile = ? OR Email = ?)";
					array_push($param,$value,$value,$value);
					break;
				case 'mobile':
					$where .= " AND Mobile = ?";
					array_push($param,$value);
					break;
				case 'email':
					$where .= " AND Email = ?";
					array_push($param,$value);
					break;
				case 'wechat':
					$where .= " AND OpenidWechat = ?";
					array_push($param,$value);
					break;
				case 'qq':
					$where .= " AND OpenidQQ = ?";
					array_push($param,$value);
					break;
				case 'weibo':
					$where .= " AND OpenidWeibo = ?";
					array_push($param,$value);
					break;
				default:
					$where .= " AND UserName = ?";
					array_push($param,$value);
			}

			$sql = "SELECT $field FROM $table WHERE $where LIMIT 1";
			
			$object = Db::select($sql,$param);
			$res = $this->objectToArray($object);
			return isset($res[0]) ? $res[0] : array();

		}

		protected function getParentList(Request $request,$pid = 0){
			$args = func_get_args();
            $field = "a.AccountID as uid,a.UserName as username,a.NickName as nickname,a.RealName as realname,a.Mobile as mobile,a.Email as email,a.Gender as gender,a.Face as face";
            $table = $this->tab." as a,".$this->tab." as b";
            $where = "a.AccountID = b.ParentID AND a.AccountID = ?";
            $sql = "SELECT $field FROM $table WHERE $where";
            $uid = isset($args[1]) ? $args[1] : $request->input('uid');
            $object = Db::select($sql,array($uid));
            $res = $this->objectToArray($object);
            return $res; 
		}

		protected function getChildrenList(Request $request){
			$args = func_get_args();
            $field = "AccountID as uid,UserName as username,NickName as nickname,RealName as realname,Mobile as mobile,Email as email,Gender as gender,Face as face";
            $table = $this->tab;
            $where = "ParentID = ?";
            $sql = "SELECT $field FROM $table WHERE $where";
            $uid = isset($args[1]) ? $args[1] : $request->input('uid');
            $object = Db::select($sql,array($uid));
            $res = $this->objectToArray($object);
            return $res; 
		}

		// 获取用户联系人列表/活动排行排
		protected function getContactList(Request $request,$id = 0){
			$aid = $request->input('aid',1);
			$uid = $id;
			$cid = $request->input('cid');
			$type = $request->input('type','list');
			$sort_by = $request->input('sort_by','total');
			$limit = $request->input('limit',0);

			$user = $this->tab;
			$contact = $this->prex.'user_contact';
			$activity = $this->prex.'activity';

			$table = "$user,$user as child_user,$contact,$activity";
			$field = "$contact.ID,UserID,$user.RealName as realname,$user.Mobile as mobile,$user.DirectShare as share_number,ChildID as child_uid,child_user.RealName as child_name,child_user.Mobile as child_mobile,child_user.Gender as child_gender,child_user.IsAuth as is_auth,BuyCount as goods_number,BuyNumber as blind_number,(BuyCount + BuyNumber) as total_number,$contact.CreateTime as create_time";
			$where = "UserID = $user.AccountID AND ChildID = child_user.AccountID AND ActivityID = $activity.ID";
			$param = [];

			if($aid){
				$where .= " AND ActivityID = ?";
				array_push($param,$aid);
			}

			if($uid){
				$where .= " AND UserID = ?";
				array_push($param,$uid);
			}

			if($cid){
				$where .= " AND ChildID = ?";
				array_push($param,$cid);
			}

			switch($sort_by){
				case '':
				case 'total':
					$orderBy = "total_number DESC";
					break;
				case 'goods':
					$orderBy = "BuyCount DESC";
					break;
				case 'blind':
					$orderBy = "BuyNumber DESC";
					break;
				default:
					$orderBy = "total_number DESC";
			}

			$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderBy";
			if($limit){
				$sql .= " LIMIT $limit";
			}
			// var_dump('sql: '.$sql);
			// var_dump($param);
			$object = Db::select($sql,$param);

			$result = [];
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					$result[$i]['child_name'] = $this->setRealname($result[$i]['child_name']);
					$result[$i]['child_mobile'] = $this->setMobile($result[$i]['child_mobile']);
					switch($result[$i]['child_gender']){
						case 0:
							$result[$i]['child_gender'] = '保密';
							break;
						case 1:
							$result[$i]['child_gender'] = '男';
							break;
						case 2:
							$result[$i]['child_gender'] = '女';
							break;
						default:
							$result[$i]['child_gender'] = '保密';
					}
				}
			}
			return $result;
		}

		/**
		 * 获取邀请排行榜Top
		 * @param  Request $request [description]
		 * @param  integer $aid     [description]
		 * @return [type]           [description]
		 */
		public function getInvitesList(Request $request){
			$aid = $request->input('aid',0);
			$num = $request->input('num',20);

			if(!$aid){
				$field = "ID as id,AccountID as uid,RealName as realname,Face as face,Mobile as mobile,Idcard as idcard,Birth as birth,Birth as age,IsAuth as is_auth,DirectShare as direct_share,CreateTime as create_time";
				$where = "IsValid = 1 AND IsLocked = 0 AND IsDel = 0";
				$orderby = "DirectShare DESC";

				$sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE $where";
				$object = Db::select($sql);
				$this->rows = $object[0]->count;

				$sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $orderby LIMIT $num";
				// var_dump($sql);
				$result = [];
				$object = Db::select($sql);
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['face'] = $this->setImg($result[$i]['face'],'');
						$result[$i]['age'] = $this->getAge($result[$i]['age']);
						$result[$i]['mobile'] = $this->setMobile($result[$i]['mobile']);
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
				}
				return $result;
			}else{
				// var_dump('lasdkflaskdjf');
			}
		}

		/**
		 * 获取邀请排行榜
		 * @param  Request $request [description]
		 * @param  integer $aid     [description]
		 * @return [type]           [description]
		 */
		public function getInviterList(Request $request){
			$aid = $request->input('aid',0);
			$num = $request->input('num',30);

			if(!$aid){
				$field = "ID as id,AccountID as uid,RealName as realname,Face as face,Mobile as mobile,Idcard as idcard,Birth as birth,Birth as age,IsAuth as is_auth,DirectShare as direct_share,CreateTime as create_time";
				$where = "IsValid = 1 AND IsLocked = 0 AND IsDel = 0";
				$orderby = "DirectShare DESC";

				$sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE $where";
				$object = Db::select($sql);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";
				// var_dump($sql);
				$result = [];
				$object = Db::select($sql);
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['face'] = $this->setImg($result[$i]['face'],'user/face');
						$result[$i]['age'] = $this->getAge($result[$i]['age']);
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
				}
				return [
					'thead'	=> $this->getList($request,'invitor'),
					'rows'	=> $this->rows,
					'data'	=> $result
				];
			}else{
				// var_dump('lasdkflaskdjf');
			}
		}

		protected function setRequest(Request $request,$flag = false){
			if(!$flag){

				$data['uid'] = $this->getAccountID();
				$data['uuid'] = $this->getUuid();
				$data['token'] = $this->getToken();
				$data['invite_code'] = $this->getInviteCode($data['uuid']);
				$data['regip'] = $request->getRealIp($safe_mode=true);
				$data['ip_address'] = Server::getIPAddress($data['regip']);
				$data['create_time'] = Server::getDate();

				// $face = $request->post('face');
				// if(empty($face)){
				// 	$data['face'] = 'unkown.png';
				// }

				$password = trim($request->post('password',''));
				if(empty($password)){
					$password = $this->config['DefaultPassword'];
				}
				$data['password'] = Encrypt::create($password);
				
				if($this->config['RegActivateType'] == 1){
					$data['is_valid'] = 1;
				}
				if($this->config['RegSendScore']){
					$data['total_score'] = $this->config['RegSendScore'];
					$data['score'] = $this->config['RegSendScore'];
				}
				if($this->config['RegSendCoin']){
					$data['total_coin'] = $this->config['RegSendCoin'];
					$data['coin'] = $this->config['RegSendCoin'];
				}
				if($this->config['RegSendBalance']){
					$data['total_balance'] = $this->config['RegSendBalance'];
					$data['balance'] = $this->config['RegSendBalance'];
				}
				$roleid = $request->post('role_id');
				if(empty($roleid) || !is_numeric($roleid) || !$roleid){
					$roleid = $this->config['DefaultRegRoleid'];
					if(!$roleid){
						$service = new RoleModel();
						$result = $service->getList($request,'default');
						if($result){
							$roleid = $result['ID'];
						}
					}
					$data['role_id'] = $roleid;
				}

				$invite = trim($request->input('invite',''));
				// var_dump('invite: '.$invite);
				if(!empty($invite)){
					// 处理邀请码
					$result = $this->getList($request,'invite',$invite);
					// var_dump('invite:');
					// var_dump($result);
					if($result){
						$data['parent_id'] = $result['uid'];
					}
				}

				$aid = $request->input('aid');
				if($aid){
					$data['aid'] = $aid;
				}

				return $data;
			}
		}

		// 生成不重复的uuid
		private function getUuid(){
			$uuid = Random::uuid();

			$object = Db::table($this->table)->select('ID')->where('Uuid',$uuid)->first();
			
			if($object){
				$uuid = $this->getUuid();
			}
			return $uuid;
		}

		// 生成不重复的uid
		private function getAccountID(){
			$uidlen = $this->config['AccountLength'];
			if($uidlen){
				$uidlen = 8;
			}

			$uid = Random::create($uidlen);

			$object = Db::table($this->table)->select('ID')->where('AccountID',$uid)->first();
			
			if($object){
				$uid = $this->getAccountID();
			}
			return $uid;
		}

		// 生成不重复的token
		private function getToken(){
			$token = Token::setToken();

			$object = Db::table($this->table)->select('ID')->where('Token',$token)->first();
			
			if($object){
				$token = $this->getToken();
			}
			return $token;
		}

		// 生成不重复的邀请码
		private function getInviteCode($uuid){
			$code = Random::invite($uuid);

			$object = Db::table($this->table)->select('ID')->where('InviteCode',$code)->first();
			
			if($object){
				$code = $this->getInviteCode($uuid);
			}
			return $code;
		}

		/**
		 * 检查忘记密码
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function checkForget(Request $request){
			$mobile = $request->post('mobile');
			$smscode = $request->post('smscode');

			if(empty($mobile)){
				return 100194;
			}

			if(!Preg::isMobile($mobile)){
				return 100195;
			}

			$user = $this->getList($request,'mobile',$mobile);

			if(!$user){
				return 100221;
			}
			// var_dump($user);
			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100794;
			}

			if(empty($smscode)){
				return 100196;
			}

			if(!$this->checkValidCode($request,$smscode,'smscode')){
				return 100197;
			}

			return ['code' => 'ok','uid' => $user['uid'],'msg' => 'success'];
		}

		/**
		 * 修改密码
		 * @param Request $request [description]
		 */
		public function setPassword(Request $request,$flag = false){
			$mobile = $request->post('mobile');
			$uid = $request->post('uid');
			$password = trim($request->post('password',''));
			$checkpwd = trim($request->post('checkpwd',''));

			if(empty($mobile)){
				return 100194;
			}

			if(!Preg::isMobile($mobile)){
				return 100195;
			}

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100131;
			}

			$user = $this->getList($request,$uid);
			if(!$user){
				return 100790;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100794;
			}

			if($user['mobile'] != $mobile){
				return 100833;
			}

			if(empty($password)){
				return 100182;
			}

			if(!Preg::isPassword($password)){
				return 100115;
			}

			if(!$flag){
				if(empty($checkpwd)){
					return 100183;
				}

				if($checkpwd != $password){
					return 100184;
				}
			}

			$password = Encrypt::create($password);

			$sql = "UPDATE ".$this->tab." SET Authentication = ? WHERE AccountID = ?";
			$param = [$password,$uid];

			if(Db::update($sql,$param)){
				return [
					'code'		=> 'ok',
					'uid'		=> $uid,
					'mobile'	=> $mobile,
					'msg'		=> 'success'
				];
			}
			return 100032;
		}


		/**
		 * 修改用户信息
		 * @param Request $request [description]
		 */
		public function setUserInfo(Request $request){
			$uid = $request->post('uid');
			$username = $request->post('username');
			$nickname = $request->post('nickname');
			$is_auth = $request->post('is_auth');
			$realname = $request->post('realname');
			$idcard = $request->post('idcard');
			$role_id = $request->post('role_id');

			$sql = "UPDATE ".$this->tab." SET ";
			$param = [];
			$str = "";

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$user = $this->getList($request,$uid);

			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			// if(empty($username)){
			// 	return 100101;
			// }

			if(!empty($username)){
				if($this->checkExists(['UserName' => $username],$uid)){
					return 100114;
				}

				$str .= "UserName = ?,";
				array_push($param,$username);
			}

			// if(empty($nickname)){
			// 	return 100116;
			// }

			if(!empty($nickname)){
				if($this->checkExists(['NickName' => $nickname],$uid)){
					return 100117;
				}

				$str .= "NickName = ?,";
				array_push($param,$nickname);
			}

			if(!$user['is_auth']){
				if(!empty($realname)){
					$str .= "RealName = ?,";
					array_push($param,$realname);
				}

				if(!empty($idcard)){
					if($this->checkExists(['Idcard' => $idcard],$uid)){
						return 100222;
					}else{
						$str .= "Idcard = ?,";
						array_push($param,$idcard);
					}
				}
			}

			if(empty($role_id) || !is_numeric($role_id) || !$role_id){
				return 100228;
			}else{
				$str .= "RoleID = ?,";
				array_push($param,$role_id);
			}

			$str = trim($str,",");

			if(empty($str)){
				return 100007;
			}

			$sql .= $str . " WHERE AccountID = ?";
			array_push($param,$uid);

			$result = Db::update($sql,$param);

			if($result !== false){
				return ['code' => 0,'msg' => 'success'];
			}
			return 100032;
			
		}

		/**
		 * 用户充值
		 * @param Request $request [description]
		 */
		public function setCharge(Request $request){
			$uid = $request->post('uid');
			$charge_type = $request->post('charge_type');
			$charge_value = $request->post('charge_value');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$user = $this->getList($request,$uid);

			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			if(!in_array($charge_type,[1,2,3])){
				return 100772;
			}

			if(empty($charge_value) || !is_numeric($charge_value) || !$charge_value){
				return 100771;
			}

			switch($charge_type){
				case 1:
					$sql = "UPDATE ".$this->tab." SET TotalBalance = TotalBalance + ?,Balance = Balance + ? WHERE AccountID = ?";
					$param = [$charge_value,$charge_value,$uid];
					break;
				case 2:
					$sql = "UPDATE ".$this->tab." SET TotalScore = TotalScore + ?,Score = Score + ? WHERE AccountID = ?";
					$param = [$charge_value,$charge_value,$uid];
					break;
				case 3:
					$sql = "UPDATE ".$this->tab." SET TotalCoin = TotalCoin + ?,Coin = Coin + ? WHERE AccountID = ?";
					$param = [$charge_value,$charge_value,$uid];
					break;
				default:
					return 100007;
			}

			if(Db::update($sql,$param)){
				return ['code' => 0,'msg' => 'success'];
			}else{
				return 100032;
			}
		}

		/**
		 * 用户锁定
		 * @param Request $request [description]
		 */
		public function setLocked(Request $request){
			$uid = $request->post('uid');
			$mobile = $request->post('mobile');
			$lock_type = $request->post('lock_type');
			$lock_time = $request->post('lock_time');
			$lock_date_type = $request->post('lock_date_type');
			$lock_reason = $request->post('lock_reason');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$user = $this->getList($request,$uid);

			if(!$user){
				return 100007;
			}

			if($lock_type == '' || !in_array($lock_type,[0,1])){
				return 100007;
			}

			// if(!$lock_type){
				if(!in_array($lock_date_type,[1,2,3,4,5])){
					return 100007;
				}

				if(empty($lock_time) || !is_numeric($lock_time) || !$lock_time){
					return 100007;
				}
			// }

			if(empty($lock_reason)){
				return 100007;
			}

			switch($lock_date_type){
				case 1:
					$lock_time *= 60;
					break;
				case 2:
					$lock_time *= 3600;
					break;
				case 3:
					$lock_time *= 3600 * 24;
					break;
				case 4:
					$lock_time *= 3600 * 24 * 30;
					break;
				case 5:
					$lock_time *= 3600 * 24 * 365;
					break;
				default:
			}

			if($lock_type){
				$sql = "UPDATE ".$this->tab." SET IsLocked = 1,LockedTime = ?,LockedReason = ?,IsDel = 1 WHERE AccountID = ?";
				$param = [time()+3600*24*365*100,$lock_reason,$uid];
			}else{
				$sql = "UPDATE ".$this->tab." SET IsLocked = 1,LockedTime = ?,LockedReason = ? WHERE AccountID = ?";
				$param = [time()+$lock_time,$lock_reason,$uid];
			}

			$result = Db::update($sql,$param);
			if($result !== false){
				return ['code' => 0,'msg' => 'success'];
			}else{
				return ['code' => 1,'msg' => 'fail'];
			}
		}

		/**
		 * 解锁用户
		 * @param Request $request [description]
		 */
		public function setUnLocked(Request $request,$id = 0){
			$uid = $id;

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			// $user = $this->getList($request,$uid);

			// if(!$user){
			// 	return 100007;
			// }

			$sql = "UPDATE ".$this->tab." SET IsLocked = 0,LockedTime = 0,LockedReason = '' WHERE AccountID = ?";
			$param = [$uid];

			$result = Db::update($sql,$param);

			if($result !== false){
				return ['code' => 0,'msg' => 'success'];
			}else{
				return ['code' => 1,'msg' => 'fail'];
			}
		}

		/**
		 * 删除用户
		 * @param Request $request [description]
		 */
		public function setDel(Request $request){
			$uid = $request->post('uid');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$user = $this->getList($request,$uid);

			if(!$user){
				return 100007;
			}

			$sql = "UPDATE ".$this->tab." SET IsDel = 1 WHERE AccountID = ?";
			$param = [$uid];

			$result = Db::update($sql,$param);

			if($result !== false){
				return ['code' => 0,'msg' => 'success'];
			}else{
				return ['code' => 1,'msg' => 'fail'];
			}
		}

		/**
		 * 检查登录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		public function checkUserLogin(Request $request){
			$uid = $request->post('uid');
			if(!$uid || empty($uid)){
				return false;
			}

			$token = $request->post('token');
            if(empty($token) || strlen($token) < 27){
                return false;
            }

            $token = Token::decrypt($token);
            $arr = explode('_',$token);
            if(count($arr) < 3){
                return false;
            }
            // var_dump($arr);
            $where = [
                ['AccountID','=',$arr[0]],
                ['Sign','=',$arr[1]],
                ['Token','=',$arr[2]]
            ];
            
            try{
                $result = Db::table('user')
                            ->join('role','RoleID','=','role.ID')
                            ->select('AccountID as uid','IsAdmin as is_admin','Sign as sign','Token as token','IsValid as is_valid','IsLocked as is_locked')
                            ->where($where)
                            ->first();
                
                if(!$result || !$result->is_valid || $result->is_locked || $result->uid != $uid){
                    return false;
                }

                $service = new OrderModel();
                $data = $service->getList($request,'user');
                return $data;
            }catch(\Exception $e){
                return false;
            }


		}

		// 获取所有用户列表
		protected function getAllList(Request $request){
			$thead = [];

			$user = $this->tab;
			$role = $this->prex.'role';

			$field = [
				"user.ID as id",
				"AccountID as uid",
				"UserName as username",
				"NickName as nickname",
				"RealName as realname",
				"Mobile as mobile",
				"Email as email",
				"Face as face",
				"Gender as gender",
				"Idcard as idcard",
				"Birth as birth",
				"IsAuth as is_auth",
				"Score as score",
				"Coin as coin",
				"Balance as balance",
				"Token as token",
				"OpenidWechat as openid",
				"ParentID as parent_id",
				"DirectShare as direct_share",
				"TotalShare as total_share",
				"BuyGoodsCount as buy_goods_count",
				"AirdropGoodsCount as airdrop_goods_count",
				"TransferGoodsCount as transfer_goods_count",
				"ComposeGoodsCount as compose_goods_count",
				"BuyBlindCount as buy_blind_count",
				"AirdropBlindCount as airdrop_blind_count",
				"TransferBlindCount as transfer_blind_count",
				"OpenBlindCount as open_blind_count",
				"BuyTotalCount as buy_total_count",
				"AirdropTotalCount as airdrop_total_count",
				"TransferTotalCount as transfer_total_count",
				"IsTransferTotalCount as is_transfer_total_count",
				"BuyGoodsNumber as buy_goods_number",
				"BuyBlindNumber as buy_blind_number",
				"BuyTotalNumber as buy_total_number",
				"OrderCount as order_count",
				"OrderNumber as order_number",
				"OrderTotal as order_total",
				"OrderTotalAmount as order_amount",
				"Title as title",
				"Sign as sign",
				"InviteCode as invite_code",
				"user.CreateTime as create_time",
				"RegIP as regip",
				"IpAddress as ip_address",
				"IsValid as is_valid",
				"IsLocked as is_locked",
				"LockedTime as locked_time",
				"user.IsDel as is_del"
			];
			$whereRaw = '1 = 1';
			$where = [];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				$whereRaw .= " AND (`AccountID` LIKE ? OR `Mobile` LIKE ? OR `RealName` LIKE ?)";
				array_push($param,$keyword,$keyword,$keyword);
			}
			$start_time = trim($request->input('start_time',''));
			if(!empty($start_time)){
				$whereRaw .= " AND $user.CreateTime >= ?";
				array_push($param,strtotime($start_time));
			}
			$end_time = trim($request->input('end_time',''));
			if(!empty($end_time)){
				$whereRaw .= " AND $user.CreateTime <= ?";
				array_push($param,strtotime($end_time));
			}
			$pid = $request->input('pid');
			if(!empty($pid) && $pid){
				$whereRaw .= " AND PID IN (?)";
				array_push($param,$pid);
			}
			$role_id = $request->input('role_id');
			if(!empty($role_id) && $role_id){
				$whereRaw .= " AND RoleID IN (?)";
				array_push($param,$role_id);
			}

			$status = $request->input('status');
			if(!empty($status)){
				switch($status){
					case 1:		// 已实名
						$whereRaw .= " AND IsAuth = 1";
						break;
					case 2:		// 未实名
						$whereRaw .= " AND IsAuth = 0";
						break;
					case 3:		// 已锁定
						$whereRaw .= " AND IsLocked = 1";
						break;
					case 4:		// 已删除
						$whereRaw .= " AND IsDel = 1";
						break;
					default:
				}
			}

			$sort_time = $request->input('sort_time',0);
			$sort_goods = $request->input('sort_goods',0);
			$sort_blind = $request->input('sort_blind',0);
			$sort_amount = $request->input('sort_amount',0);
			$sort_share = $request->input('sort_share',0);

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->join('role','RoleID','=','role.ID')
						->select(...$field)
						->whereRaw($whereRaw,$param)
						->count();

				$object = Db::table($this->table)
						->join('role','RoleID','=','role.ID')
						->select(...$field)
						->whereRaw($whereRaw,$param)
						->orderby("user.CreateTime",$sort_time ? "DESC" : "ASC")
						->orderby("BuyGoodsCount",$sort_goods ? "DESC" : "ASC")
						->orderby("BuyBlindCount",$sort_blind ? "DESC" : "ASC")
						->orderby("OrderTotalAmount",$sort_amount ? "DESC" : "ASC")
						->orderby("DirectShare",$sort_share ? "DESC" : "ASC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['face'] = $this->setImg($result[$i]['face'],'user/face');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						$result[$i]['token'] = Token::encrypt($result[$i]['uid'].'_'.$result[$i]['sign'].'_'.$result[$i]['token']);
						
					}
				}
				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		// 导出
		protected function getExportList(Request $request){
			$field = $request->input('field');
			$type = $request->input('type',0);
			$role_id = $request->input('role_id',0);
			$is_auth = $request->input('is_auth',0);
			$start_time = $request->input('start_time');
			$end_time = $request->input('end_time');
			$count = $request->input('count',0);
			$order = $request->input('order',0);
			$name = $request->input('name',time());

			// var_dump($field);

			if(!is_numeric($type)){
				return Json::show(110786);
			}
			if(!is_numeric($role_id)){
				return Json::show(110787);
			}
			if(!is_numeric($count)){
				return Json::show(110788);
			}
			if(!in_array($order,[0,1,'0','1'])){
				return Json::show(110789);
			}

			$fields = "";
			$title = [];
			if(empty($field)){
				$fields = 'AccountID,NickName,RealName,Mobile,Gender,Face,Idcard,Birth,ChainAddress,ParentID,RoleID,IsAuth';
			}else{
				$map = $this->getList($request,'map');
				$mapkey = array_keys($map);
				$mapval = array_values($map);
				
				$temp = $field;
				foreach($temp as $val){
					if(in_array($val,$mapkey)){
						$fields .= "`{$map[$val]}`,";
					}else{
						if(in_array($val,$mapval)){
							$fields .= "`{$val}`,";
						}
					}
				}
				$fields = trim($fields,",");
			}

			if(empty($fields)){
				$fields = 'AccountID,NickName,RealName,Mobile,Gender,Face,Idcard,Birth,ChainAddress,ParentID,RoleID,IsAuth';
			}

			$where = "1 = 1";
			if($type){
				$where .= " ADN RegSource = $type";
			}
			if($role_id){
				$where .= " AND RoleID = $role_id";
			}
			
			if(!empty($is_auth) && $is_auth > 1){
				$is_auth = (int)$is_auth;
				if($is_auth === 2){
					$where .= " AND IsAuth = 1";
				}else{
					$where .= " AND IsAuth = 0";
				}
			}

			if(!empty($start_time)){
				$where .= " AND CreateTime >= ".strtotime($start_time);
			}

			if(!empty($end_time)){
				$where .= " AND CreateTime <= ".strtotime($end_time);
			}

			$orderby = !$order ? "ID ASC" : ($order === 1 ? "ID ASC" : "ID DESC");
			$sql = "SELECT $fields FROM ".$this->prex.$this->table." WHERE $where ORDER BY $orderby";
			if($count){
				$sql .= " LIMIT $count";
			}

			$object = Db::select($sql);
			$result = $this->objectToArray($object);
			if($result){
				for($i=0;$i<count($result);$i++){
					$result[$i]['Mobile'] .= " ";
					$result[$i]['Idcard'] .= " ";
				}
			}

			$field = array('AccountID','NickName','RealName','Mobile','Gender','Face','Idcard','Birth','ChainAddress','ParentID','RoleID','IsAuth');
			
			Office::export($request,$field,$result,$name);

			return ['file'=> $this->host['api'].'upload/export/'.$name.'.xlsx'];
		}

		// 获取单个用户数据
		protected function getListById(Request $request){
			$args = func_get_args();
			$id = isset($args[1]) ? $args[1] : 0;
			$user = $this->tab;
			$role = $this->prex.'role';

			$field = [
				"user.ID as id",
				"AccountID as uid",
				"UserName as username",
				"NickName as nickname",
				"RealName as realname",
				"Mobile as mobile",
				"Email as email",
				"Face as face",
				"Gender as gender",
				"Idcard as idcard",
				"Birth as birth",
				"IsAuth as is_auth",
				"Score as score",
				"Coin as coin",
				"Balance as balance",
				"Token as token",
				"OpenidWechat as openid",
				"SecurityPassWord as is_secure",
				"ParentID as parent_id",
				"DirectShare as direct_share",
				"TotalShare as total_share",
				"PID as is_admin",
				"RoleID as role_id",
				"Title as title",
				"Sign as sign",
				"IsAllowLogin as is_allow_login",
				"InviteCode as invite_code",
				"user.CreateTime as create_time",
				"RegIP as regip",
				"IpAddress as ip_address",
				"IsValid as is_valid",
				"IsLocked as is_locked",
				"LockedTime as locked_time",
				"user.IsDel as is_del"
			];
			$whereRaw = "AccountID = ?";
			$where = [];
			$orWhere = [];
			$param = [$id];
			
			try{
				$object = Db::table($this->table)
						->join('role','RoleID','=','role.ID')
						->select(...$field)
						->whereRaw($whereRaw,$param)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['face'] = $this->setImg($result['face']);
					$result['age'] = $this->getAge($result['birth']);
					if($result['is_admin'] == 2){
						$result['is_admin'] = 1;
					}else{
						$result['is_admin'] = 0;
					}
					$result['is_secure'] = !empty($result['is_secure']) ? 1 : 0;
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
					$result['token'] = Token::encrypt($result['uid'].'_'.$result['sign'].'_'.$result['token']);
				}
				return isset($result) ? $result : [];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 验证安全密码
		 * @param  [type] $uid      [description]
		 * @param  [type] $password [description]
		 * @return [type]           [description]
		 */
		public function checkSecurePassword($uid,$password){
			if(Preg::isMobile($uid)){
				$object = Db::table($this->table)->select('')->where('Mobile',$uid)->first();
			}else{
				$object = Db::table($this->table)->select('SecurityPassWord')->where('AccountID',$uid)->first();
			}

			if(!$object){
				return false;
			}

			if(!password_verify($password,$object->SecurityPassWord)){
				return false;	// 密码错误
			}
			return true;
		}

		// 通过手机号码获取单个用户数据
		protected function getMobileList(Request $request,$mobile = 0){
			if(trim($mobile) == '' || !$mobile){
				return [];
			}

			$user = $this->tab;
			$role = $this->prex.'role';

			$field = [
				"user.ID as id",
				"AccountID as uid",
				"UserName as username",
				"NickName as nickname",
				"RealName as realname",
				"Mobile as mobile",
				"Email as email",
				"Face as face",
				"ChainAddress as chain_id",
				"Gender as gender",
				"Idcard as idcard",
				"Birth as birth",
				"IsAuth as is_auth",
				"Score as score",
				"Coin as coin",
				"Balance as balance",
				"Token as token",
				"OpenidWechat as openid",
				"ParentID as parent_id",
				"DirectShare as direct_share",
				"TotalShare as total_share",
				"BuyGoodsCount as buy_goods_count",
				"AirdropGoodsCount as airdrop_goods_count",
				"TransferGoodsCount as transfer_goods_count",
				"ComposeGoodsCount as compose_goods_count",
				"BuyBlindCount as buy_blind_count",
				"AirdropBlindCount as airdrop_blind_count",
				"TransferBlindCount as transfer_blind_count",
				"OpenBlindCount as open_blind_count",
				"BuyTotalCount as buy_total_count",
				"AirdropTotalCount as airdrop_total_count",
				"TransferTotalCount as transfer_total_count",
				"IsTransferTotalCount as is_transfer_total_count",
				"BuyGoodsNumber as buy_goods_number",
				"BuyBlindNumber as buy_blind_number",
				"BuyTotalNumber as buy_total_number",
				"OrderCount as order_count",
				"OrderNumber as order_number",
				"OrderTotal as order_total",
				"OrderTotalAmount as order_amount",
				"Title as title",
				"Sign as sign",
				"InviteCode as invite_code",
				"user.CreateTime as create_time",
				"RegIP as regip",
				"IpAddress as ip_address",
				"IsValid as is_valid",
				"IsLocked as is_locked",
				"LockedTime as locked_time",
				"user.IsDel as is_del"
			];
			$whereRaw = 'Mobile = ?';
			$where = [];
			$orWhere = [];
			$param = [$mobile];
			
			try{
				$object = Db::table($this->table)
						->join('role','RoleID','=','role.ID')
						->select(...$field)
						->whereRaw($whereRaw,$param)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['face'] = $this->setImg($result['face']);
					$result['age'] = $this->getAge($result['birth']);
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
					$result['token'] = Token::encrypt($result['uid'].'_'.$result['sign'].'_'.$result['token']);
				}
				return isset($result) ? $result : [];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 通过邀请码获取记录
		 * @return [type] [description]
		 */
		protected function getInviteList(Request $request,$invite){
			$field = "AccountID as uid";
			$where = "InviteCode = ?";
			$sql = "SELECT $field FROM ".$this->tab." WHERE $where LIMIT 1";
			$param = [strtoupper($invite)];
			$object = Db::select($sql,$param);
			$res = $this->objectToArray($object);
			return isset($res[0]) ? $res[0] : array(); 
		}

		/**
		 * 用户认证
		 * @param Request $request [description]
		 */
		public function setAuth(Request $request){

			$uid = $request->post('uid');
			// var_dump('uid: '.$uid);
			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100131;
			}
			$user = $this->getList($request,$uid);
			if(!$user){
				return 100132;
			}
			// var_dump($user);
			// if(!$user['is_valid_mobile']){
			// 	$mobile = trim($request->post('mobile'));
			// 	if(empty($mobile)){
			// 		return 100120;
			// 	}
			// 	if(!Preg::isMobile($mobile)){
			// 		return 100121;
			// 	}
			// }
			$type = $request->post('type');
			if(empty($type)){
				$type = 1;	// 个人认证
			}

			// 
			switch(strtolower($type)){
				case '1':
					return $this->setPersonalAuth($request);	// 个人认证
				case '2':
					return $this->setParentAuth($request);		// 家长认证
				case '3':
					return $this->setStudentAuth($request);		// 学生认证
				case '4':
					return $this->setTeacherAuth($request);		// 教师认证
				case '5':
					return $this->setExaminerAuth($request);	// 考官认证
				case '6':
					return $this->setEnterpriseAuth($request);	// 机构认证(企业中心)
				case '7':
					return $this->setCenterAuth($request);		// 考级中心认证
				default:
					return $this->setPersonalAuth($request);	// 个人认证
			}
		}

		// 个人认证
		private function setPersonalAuth(Request $request){
			$uid = $request->post('uid');
			// $type = $request->post('type');
			// 
			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$token = $request->header('Authorization');
			$token = Token::decrypt($token);

			// var_dump('token: '.$token);

			$user = $this->getList($request,$uid);
			if(!$user){
				return 100007;
			}
			// var_dump($user);
			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			if($user['is_auth']){
				return 100198;
			}

			$realname = $request->post('realname');
			if(empty($realname)){
				return 100118;
			}
			$idcard = $request->post('idcard');
			if(empty($idcard)){
				return 100133;
			}
			if(!Preg::isIdcard($idcard)){
				return 100134;
			}

			$count = $this->getList($request,'idcard',$idcard);
			if($this->config['MaxIdcardRegCount']){
				if($this->config['MaxIdcardRegCount'] == 1){
					if($count >= 1){
						return 100222;
					}
				}else{
					if($count >= $this->config['MaxIdcardRegCount']){
						return 100223;
					}
				}
			}

			/*
			$service = new TencentModel();
			$result = $service->VerifyIdcard($request);
			if(isset($result['error_code'])){
				if($result['result']['isok']){
					// 身份证核验二要素通过
				}else{
					return Json::show($result['error_code'],$result);
				}
			}else{
				if(isset($result['message'])){
					return Json::show(1,$result['message']);
				}
			}
			*/

			// 核验身份证
			$birth = $request->post('birth');
			if(empty($birth)){
				$birth = $this->getBirth($idcard);
			}
			$age = $this->getAge($birth);
			// var_dump('age: '.$age);
			if($age < $this->config['AuthMinAge']){
				return 100199;
			}
			if($age > $this->config['AuthMaxAge']){
				return 100200;
			}
			$gender = $request->post('gender');
			if(empty($gender)){
				$gender = $this->getGender($idcard);
			}

			// var_dump('birth: '.$birth);
			// var_dump('gender: '.$gender);
			$service = new AliyunModel();
			$result = $service->checkThirdIdcard($idcard,$realname);

			// var_dump($result);
			if($result && $result['error_code'] === 0 && $result['result']['isok']){
				$sql = "UPDATE ".$this->tab." SET RealName = ?,Idcard = ?,Birth = ?,Gender = ?,IsAuth = ?,AuthTime = ? WHERE AccountID = ?";
				$param = array($realname,$idcard,$birth,$gender,1,time(),$uid);
				// var_dump('sql: '.$sql);
				// var_dump($param);
				$result = Db::update($sql,$param);
				if($result !== false){
					// 分配链接地址
					$service = new AvataModel();
					$res = $service->create($uid);
					// var_dump('avata res:');
					// var_dump($res);
					if(isset($res['data']) && isset($res['data']['account'])){
						$this->updateContact($uid);
						$this->updateChainID($uid,$res);
					}

					return array(
						'uid'		=> $uid,
						'realname'	=> $realname,
						'idcard'	=> $idcard,
						'birth'		=> $birth,
						'gender'	=> $gender == 1 ? '男' : '女',
						'is_auth'	=> 'ok'
					);
				}
				return 100135;
			}else{
				return 100135;
			}

			// var_dump('birth: '.$birth);
			// var_dump('gender: '.$gender);
			
		}

		// 家长认证
		private function setParentAuth(Request $request){
			$uid = $request->post('uid');
			$type = $request->post('type');

			$realname = $request->post('realname');
			if(empty($realname)){
				return 100118;
			}
			$idcard = $request->post('idcard');
			if(empty($idcard)){
				return 100133;
			}
			if(!Preg::isIdcard($idcard)){
				return 100134;
			}

			// 核验身份证
			$birth = $request->post('birth');
			if(empty($birth)){
				$birth = substr($idcard,6,4).'-'.substr($idcard,10,2).'-'.substr($idcard,12,2);
			}
			$gender = $request->post('gender');
			if(empty($gender)){
				$gender = substr($idcard,strlen($idcard)-1,1);
				$gender = $gender % 2 == 0 ? 2 : 1;
			}

			$sql = "UPDATE ".$this->tab." SET RealName = ?,Idcard = ?,Birth = ?,Gender = ?,IsAuth = ?,AuthTime = ? WHERE AccountID = ?";
			$param = array($realname,$idcard,$birth,$gender,$type,time(),$uid);
			$result = Db::update($sql,$param);
			if($result !== false){
				return array(
					'uid'		=> $uid,
					'type'		=> $type,
					'realname'	=> $realname,
					'idcard'	=> $idcard,
					'birth'		=> $birth,
					'gender'	=> $gender == 1 ? '男' : '女',
					'is_auth'	=> 'ok'
				);
			}
			return 100135;
		}

		// 学生认证
		private function setStudentAuth(Request $request){
			$uid = $request->post('uid');
			$type = $request->post('type');

			$realname = $request->post('realname');
			if(empty($realname)){
				return 100118;
			}
			$idcard = $request->post('idcard');
			if(empty($idcard)){
				return 100133;
			}
			if(!Preg::isIdcard($idcard)){
				return 100134;
			}

			// 核验身份证
			$birth = $request->post('birth');
			if(empty($birth)){
				$birth = substr($idcard,6,4).'-'.substr($idcard,10,2).'-'.substr($idcard,12,2);
			}
			$gender = $request->post('gender');
			if(empty($gender)){
				$gender = substr($idcard,strlen($idcard)-2,1);
				$gender = $gender % 2 == 0 ? 2 : 1;
			}

			$sql = "UPDATE ".$this->tab." SET RealName = ?,Idcard = ?,Birth = ?,Gender = ?,IsAuth = ?,AuthTime = ? WHERE AccountID = ?";
			$param = array($realname,$idcard,$birth,$gender,$type,time(),$uid);
			$result = Db::update($sql,$param);
			if($result !== false){
				return array(
					'uid'		=> $uid,
					'type'		=> $type,
					'realname'	=> $realname,
					'idcard'	=> $idcard,
					'birth'		=> $birth,
					'gender'	=> $gender == 1 ? '男' : '女',
					'is_auth'	=> 'ok'
				);
			}
			return 100135;
		}

		// 教师认证
		private function setTeacherAuth(Request $request){
			
		}

		// 考官认证
		private function setExaminerAuth(Request $request){
			
		}

		// 机构认证
		private function setEnterpriseAuth(Request $request){
			
		}

		// 考级中心认证
		private function setCenterAuth(Request $request){
			
		}

		// 查询身份证认证次数
		protected function getIdcardList(Request $request,$idcard = ''){
			$sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE Idcard = ? AND IsAuth = 1";
			$param = [$idcard];

			$object = Db::select($sql,$param);

			return $object[0]->count;
		}

		/**
		 * 设置安全密码
		 * @param Request $request [description]
		 */
		public function setSecure(Request $request){
			$uid = $request->post('uid');
			$password = trim($request->post('password',''));
			$checkpwd = trim($request->post('checkpwd',''));
			$mobile = $request->post('mobile');
			$smscode = $request->post('smscode');

			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100007;
			}

			$user = $this->getList($request,$uid);
			if(!$user){
				return 100007;
			}

			if(!$user['is_valid'] || $user['is_locked'] || $user['is_del']){
				return 100007;
			}

			if(empty($password)){
				return 100190;
			}

			if(strlen($password) < 6 || strlen($password) > 16){
				return 100191;
			}

			if(empty($checkpwd)){
				return 100192;
			}

			if($checkpwd != $password){
				return 100193;
			}

			if(empty($mobile)){
				return 100194;
			}

			if(!Preg::isMobile($mobile)){
				return 100195;
			}

			if(empty($smscode)){
				return 100196;
			}

			if(!$this->checkValidCode($request,$smscode,'smscode')){
				return 100197;
			}

			$result = $this->updateSecure($request);

		}

		// 更新用户邀请人实名信息
		private function updateContact($uid){
			$sql = "UPDATE ".$this->prex."user_contact SET IsAuth = 1 WHERE ChildID = ?";
			$param = [$uid];

			return Db::update($sql,$param);
		}

		// 更新链账户
		private function updateChainID($uid,$data){
			$sql = "UPDATE ".$this->tab." SET ChainAddress = ? WHERE AccountID = ?";
			$param = [$data['data']['account'],$uid];

			return Db::update($sql,$param);
		}

		// 修改安全密码
		private function updateSecure(Request $request){
			$uid = $request->post('uid');
			$password = trim($request->post('password',''));
			$password = Encrypt::create($password);
			$sql = "UPDATE ".$this->tab." SET SecurityPassWord = ? WHERE AccountID = ?";
			$param = [$password,$uid];

			return Db::update($sql,$param);
		}

		// 设置session
		private function setSession($token,$data){
			$token = $data['token'];
			Http::session($token,'uid',$data['uid']);
			Http::session($token,'nickname',$data['nickname']);
			Http::session($token,'face',$data['face']);
			Http::session($token,'sign',$data['sign']);
			Http::session($token,'token',$data['token']);

			Http::redis($token,'uid',$data['uid']);
			Http::redis($token,'nickname',$data['nickname']);
			Http::redis($token,'face',$data['face']);
			Http::redis($token,'sign',$data['sign']);
			Http::redis($token,'token',$data['token']);

			// var_dump('登录信息：');
			// var_dump('uid: '.Http::redis($token,'uid'));
			// var_dump('token: '.Http::redis($token,'token'));
			// var_dump('sign: '.Http::redis($token,'sign'));

			/*
			// set session
			$request->session()->set($data['token'].'_uid',$data['uid']);
			$request->session()->set($data['token'].'_nickname',$data['nickname']);
			$request->session()->set($data['token'].'_face',$data['face']);
			$request->session()->set($data['token'].'_sign',$data['sign']);
			$request->session()->set($data['token'].'_token',$data['token']);

			// set redis
			Redis::set($data['token'].'_uid',$data['uid']);
			Redis::set($data['token'].'_nickname',$data['nickname']);
			Redis::set($data['token'].'_face',$data['face']);
			Redis::set($data['token'].'_sign',$data['sign']);
			Redis::set($data['token'].'_token',$data['token']);
			*/
		}

		/**
		 * [setAppend description]
		 * @param [type] $data [description]
		 */
		public function setAppend(Request $request,$data){
			$user = $this->getList($request,'login',$data['openid'],'wechat');
			// var_dump($data);
			// var_dump($user);
			if(!$user){
				// var_dump('没有用户，注册新用户');
				try{
					$result = $this->setRequest($request);
					// var_dump($result);
					$data = array_merge($data,$result);
					// var_dump($data);
					$sql = "INSERT INTO ".$this->tab." (`AccountID`,`Uuid`,`Token`,`InviteCode`,`RegIP`,`CreateTime`,`Authentication`,`RoleID`,`OpenidWechat`,`UnionidWechat`,`NickName`,`Face`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
					$param = [
						$data['uid'],
						$data['uuid'],
						$data['token'],
						$data['invite_code'],
						$data['regip'],
						$data['create_time'],
						$data['password'],
						$data['role_id'],
						$data['openid'],
						$data['unionid'],
						$data['nickname'],
						$data['face']
					];
					$res = Db::insert($sql,$param);
					// var_dump($res);
					return [
						'uid'		=> $data['uid'],
						'username'	=> '',
						'nickname'	=> $data['nickname'],
						'face'		=> $data['face'],
						'token'		=> Token::encrypt($data['token']),
						'title'		=> 'VIP0'
					];
				}catch(\Exception $e){
					// var_dump('error:');
					// var_dump($e->getCode());
					// var_dump($e->getMessage());
					return $e->getMessage();
				}
			}else{
				return [
					'uid'		=> $user['uid'],
					'username'	=> $user['username'],
					'nickname'	=> $user['nickname'],
					'face'		=> $user['face'],
					'token'		=> Token::encrypt($user['token']),
					'title'		=> 'VIP0'
				];
			}
		}

		/**
		 * 设置联系人
		 * @param Request $request [description]
		 */
		public function setContact(Request $request){
			$uid = $request->post('uid');
			if(empty($uid) || !is_numeric($uid) || !$uid){
				return 100132;
			}

			$service = new UserModel();
			$user = $service->getList($request,$uid);
			if(!$user){
				return 100132;
			}
			// var_dump($user);
			if($user['is_locked']){
				return 100151;
			}

			if($user['is_del']){
				return 100152;
			}

			$data = $request->post('contact');
			if($data){
				$data = json_decode($data,true);
				for($i=0;$i<count($data);$i++){
					if(!isset($data[$i]['uid']) || !$data[$i]['uid']){
						$data[$i]['uid'] = $uid;
					}
					$item = $data[$i];
					if(trim($item['realname']) == ''){
						return '第'.($i+1).'位观众姓名不能为空';
					}
					if(trim($item['idcard']) == ''){
						return '第'.($i+1).'位观众身份证号码不能为空';
					}
					if(!Preg::isIdcard(trim($item['idcard']))){
						return '第'.($i+1).'位观众身份证号码格式不正确';
					}
					if($i == 0){
						if(trim($item['mobile']) == ''){
							return '第'.($i+1).'位观众手机号码不能为空';
						}
						if(!Preg::isMobile(trim($item['mobile']))){
							return '第'.($i+1).'位观众手机号码格式不正确';
						}
					}

					if($item['relation_id']){
						$birth = substr($item['idcard'],6,4).'-'.substr($item['idcard'],10,2).'-'.substr($item['idcard'],12,2);
						$gender = substr($item['idcard'],strlen($item['idcard'])-2,1);
						$gender = $gender % 2 == 0 ? 2 : 1;

						$sql = "UPDATE ".$this->tab." SET RealName = ?,Mobile = ?,Idcard = ?,Birth = ?,Gender = ? WHERE AccountID = ?";
						Db::update($sql,[$item['realname'],$item['mobile'],$item['idcard'],$birth,$gender,$uid]);
					}
				}

				$service = new UserContactModel();
				$result = $service->setAppend($data);
				return $result ? $data : 100032;
			}
			return 100001;
		}	

		// 检查验证码是否正确
		private function checkValidCode($request,$code,$type = 'numcode'){
			// return true;
			$token = $request->input('token');
			$mobile = $request->input('mobile');
			if(empty($mobile)){
				$mobile = $request->input('username');
			}
			// var_dump('mobile: '.$mobile);
			// var_dump('code: '.$code);
			// var_dump('type: '.$type);
			// var_dump('token: '.$token);
			switch($type){
				case 'numcode':
					$captcha = Redis::get($token.'_numcode');
					break;
				case 'smscode':
					$captcha = Redis::get('smscode_'.MD5($mobile));
					break;
				default:
					$captcha = Redis::get($token.'_numcode');
			}
			
			// var_dump('captcha: '.$captcha . ' code: '.$code);
			if(empty($captcha) || empty($code)){
				return false;
			}
			if(strtolower($captcha) !== strtolower($code)){
				return false;
			}else{
				switch($type){
					case 'numcode':
						Redis::del($token.'_numcode');
						break;
					case 'smscode':
						Redis::del('smscode_'.MD5($mobile));
						break;
					default:
						Redis::del($token.'_numcode');
				}
				return true;
			}
		}

		/**
		 * 检查token
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		// public function checkToken(Request $request,$flag = false){
		// 	$flag = false;

  //           $arr = [
  //               ['controller' => 'app\controller\Captcha','action' => 'index'],
  //               ['controller' => 'app\controller\User\Reg','action' => 'index'],
  //               ['controller' => 'app\controller\User\Login','action' => 'index'],
  //               ['controller' => 'app\controller\User\User','action' => 'forget'],
  //               ['controller' => 'app\controller\User\User','action' => 'pass'],
  //               ['controller' => 'app\controller\Login','action' => 'index'],
  //               ['controller' => 'app\controller\Reg','action' => 'index'],
  //           ];
            
  //           foreach($arr as $val){
  //               if($request->controller == $val['controller'] && $request->action == $val['action']){
  //                   $flag = true;
  //                   break;
  //               }
  //           }

  //           if($flag){
  //               return true;
  //           }

		// 	$temp = trim($request->header('Authorization',''));
			
		// 	if(empty($temp)){
		// 		return false;
		// 	}

		// 	$temp = Token::decrypt($temp);
			
  //           $token = explode('_',$temp);
  //           if(count($token) < 3 || strlen($temp) < 27){
  //               return false;
  //           }
  //           $where = [
  //               ['AccountID','=',$token[0]],
  //               ['Sign','=',$token[1]],
  //               ['Token','=',$token[2]]
  //           ];
            
  //           $result = Db::table('user')
  //                       ->join('role','RoleID','=','role.ID')
  //                       ->select('AccountID as uid','Sign as sign','Token as token')
  //                       ->where($where)
  //                       ->first();

  //           if(!$result){
  //               return false;
  //           }
  //           // var_dump($result);
  //           $uid = $request->input('uid');
  //           if(!empty($uid)){
  //           	if($result->uid == '83176150'){
  //           		return true;
  //           	}

  //           	if($result->uid != $uid){
	 //                return false;
	 //            }
  //           }
            
  //           return $flag ? ['uid'=>$result->uid,'sign'=>$result->sign,'token'=>$result->token] : true;
		// }

		// 加密token
		private function encryptToken($data){
			$str = $data['uid'].'_'.$data['sign'].'_'.$data['token'];
			$token = Token::encrypt($str);

			return $token;
		}

		private function checkDisableKeyword($str){
			$arr = ['admin','admins','master','root','manage','administrator'];
			$keyword = explode(',',$this->config['DisableKeyword']);
			$arr = array_merge($arr,$keyword);

			$flag = false;

			foreach($arr as $val){
				$val = trim($val);
				if(!empty($val) && strrpos($str,$val) !== false){
					$flag = true;
					break;
				}
			}

			return $flag;
		}

		/**
		 * 获取用户展示列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getShowList(Request $request){
			
			// var_dump('post data:');
			// var_dump($request->post());
			try{
				$thead = $this->getList($request,'map');

				$user = $this->prex.'user';
				$role = $this->prex.'role';

				$table = "$user,$role";
				$field = "$user.ID as id,AccountID as uid,UserName as username,NickName as nickname,RealName as realname,Mobile as mobile,Face as face,Idcard as idcard,Birth as birth,Gender as gender,Score as score,Balance as balance,Coin as coin,ParentID as parent_id,Invite as invite,DirectShare as direct_share,Title as title,$user.CreateTime as create_time,RegIP as regip,IpAddress as ip_address,IsLocked as is_locked";
				$where = "RoleID = $role.ID AND $user.IsDel = 0";
				$param = [];
				$orderby = "$user.ID DESC";

				$keyword = $request->input('keyword','');
				if(!empty($keyword)){
					$where .= " AND (AccountID LIKE ? OR UserName LIKE ? OR RealName LIKE ? OR NickName LIKE ? OR Mobile LIKE ? OR Idcard LIKE ?)";
					array_push($param,$keyword,$keyword,$keyword,$keyword,$keyword,$keyword);
				}

				$role_id = $request->input('role_id');
				if($role_id != '' && is_numeric($role_id) && $role_id){
					$where .= " AND RoleID = ?";
					array_push($param,$role_id);
				}

				$pid = $request->input('pid');
				if($pid != '' && is_numeric($pid) && $pid){
					$where .= " AND PID = ?";
					array_push($param,$pid);
				}

				$start_time = $request->input('start_time');
				if(!empty($start_time)){
					$where .= " AND $user.CreateTime >= ?";
					array_push($param,strtotime($start_time));
				}

				$end_time = $request->input('end_time');
				if(!empty($end_time)){
					$where .= " AND $user.CreateTime <= ?";
					array_push($param,strtotime($end_time));
				}

				$is_auth = $request->input('is_auth');
				if($is_auth != '' && in_array($is_auth,[0,1])){
					$where .= " AND IsAuth = ?";
					array_push($param,$is_auth);
				}

				$parent_id = $request->input('parent_id');
				if($parent_id != '' && is_numeric($parent_id) && $parent_id){
					$where .= " AND ParentID = ?";
					array_push($param,$parent_id);
				}
			
				$sql = "SELECT COUNT($user.ID) as count FROM $table WHERE $where";
				$object = Db::select($sql,$param);
				$this->rows = $object[0]->count;

				$limit = $this->getLimit($request);

				$result = [];
				$sql = "SELECT $field FROM $table WHERE $where ORDER BY $orderby LIMIT $limit[0],$limit[1]";

				$object = Db::select($sql,$param);
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['face'] = $this->setImg($result[$i]['face'],'user/face');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						switch($result[$i]['gender']){
							case 0:
								$result[$i]['gender'] = '未知';
								break;
							case 1:
								$result[$i]['gender'] = '男';
								break;
							case 2:
								$result[$i]['gender'] = '女';
								break;
							default:
								$result[$i]['gender'] = '未知';
						}
					}
				}
				
				$arr = [
    			    'title' => $this->title,
    			    'table' => strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $this->table)),
    			    'layer' => 1,
    			    'thead' => $this->getList($request,'map'),
    			    'rows'  => $this->rows,
    			    'data'  => $result
    			];
    
    			return $arr;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}

			/*
			
			$thead = $this->getList($request,'map');

			$user = $this->tab;

			$field = [
				"ID as id",
				"AccountID as uid",
				"UserName as username",
				"RealName as realname",
				// "NickName as nickname",
				"Mobile as mobile",
				// "Email as email",
				"Face as face",
				"Idcard as idcard",
				"Birth as birth",
				"Gender as gender",
				"Score as score",
				"Balance as balance",
				"Coin as coin",
				"Invite as parent_id",
				"DirectShare as direct_share",
				// "ChainAddress as chain_id",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"?"]);
				$whereRaw .= " AND (`RealName` LIKE ? OR `Mobile` LIKE '%{$keyword}%' OR `Idcard` LIKE '%{$keyword}%')";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			// $pid = $request->input('pid');
			// if(!empty($pid) && is_numeric($pid) && $pid){
			// 	$whereRaw .= "RoleID = ?";
			// 	array_push($param,$pid);
			// }

			$role_id = $request->input('role_id');
			// var_dump('user show role_id: '.$role_id);
			if(!empty($role_id) && is_numeric($role_id) && $role_id){
				$whereRaw .= " AND RoleID = $role_id";
				// array_push($param,$role_id);
			}

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->count();

				$object = Db::table($this->table)
						->select(...$field)
						->whereRaw($whereRaw)
						->orderby("CreateTime","DESC")
						->offset($limit[0])
						->limit($limit[1])
						->get();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					for($i=0;$i<count($result);$i++){
						$result[$i]['face'] = $this->setImg($result[$i]['face'],'user/face');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
						switch($result[$i]['gender']){
							case 0:
								$result[$i]['gender'] = '未知';
								break;
							case 1:
								$result[$i]['gender'] = '男';
								break;
							case 2:
								$result[$i]['gender'] = '女';
								break;
							default:
								$result[$i]['gender'] = '未知';
						}
						
					}
				}
				return ['thead' => $thead,'rows' => $this->rows,'data' => $result];
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
			*/
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$username = $request->post('username');
			$nickname = $request->post('nickname');
			$password = $request->post('password');
			$mobile = $request->post('mobile');
			$realname = $request->post('realname');
			$idcard = $request->post('idcard');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100920;
				}
			}
			
			if(empty($username)){
				return 100101;
			}

			
			if($this->checkDisableKeyword($username)){
				return 100136;
			}

			// if(strlen($username) < $this->config['UsernameMinLength'] || strlen($username) > $this->config['UsernameMaxLength']){
			// 	return '用户名长度大于'.$this->config['UsernameMinLength'].'小于'.$this->config['UsernameMaxLength'];
			// }
			// var_dump($this->config['preg_username']);
			// if(!preg_match($this->config['preg_username'],$username)){
			// 	return 100113;
			// }

			$preg = "/^[a-zA-Z][a-zA-Z0-9_.]{".$this->config['UsernameMinLength'].",".$this->config['UsernameMaxLength']."}$/";

			if(!preg_match($preg,$username)){
				return 100113;
			}
			
			if($this->checkExists(['UserName' => $username])){
				return 100114;
			}
			
			if(Preg::isMobile($username) && $this->checkExists(['Mobile' => $username])){
				return 100128;
			}
			
			if(Preg::isEmail($username) && $this->checkExists(['Email' => $username])){
				return 100129;
			}

			if(empty($nickname)){
				return 100116;
			}

			if($this->checkExists(['NickName' => $nickname])){
				return 100117;
			}

			if(empty($password)){
				return 100102;
			}
			if(strlen($password) < $this->config['PasswordMinLength'] || strlen($password) > $this->config['PasswordMaxLength']){
				return '密码长度大于'.$this->config['PasswordMinLength'].'小于'.$this->config['PasswordMaxLength'];
			}
			// if(!empty($this->config['preg_password']) && !preg_match($this->config['preg_password'],$password)){
			// 	return 100114;
			// }
			
			$preg = "/^[a-zA-Z0-9_.]{".$this->config['PasswordMinLength'].",".$this->config['PasswordMaxLength']."}$/";
			if(!preg_match($preg,$password)){
				return 100114;
			}

			if(empty($mobile)){
				return 100120;
			}

			if(!preg_match("/^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/",$mobile)){
				return 100121;
			}

			if($this->checkExists(['Mobile' => $mobile])){
				return 100137;
			}

			if(empty($realname)){
				return 100118;
			}

			if(empty($idcard)){
				return 100133;
			}
			if(!Preg::isIdcard($idcard)){
				return 100134;
			}

			$count = $this->getList($request,'idcard',$idcard);
			if($this->config['MaxIdcardRegCount']){
				if($this->config['MaxIdcardRegCount'] == 1){
					if($count >= 1){
						return 100222;
					}
				}else{
					if($count >= $this->config['MaxIdcardRegCount']){
						return 100223;
					}
				}
			}

			$data['birth'] = $this->getBirth($idcard);
			$data['gender'] = $this->getGender($idcard);
			$data['is_auth'] = 1;

			return $data;
		}

		protected function getFieldList(Request $request){
			return [
				'id'				=> 'ID',
				'uuid'				=> 'Uuid',
				'uid'				=> 'AccountID',
				'token'				=> 'Token',
				'username'			=> 'UserName',
				'nickname'			=> 'NickName',
				'realname'			=> 'RealName',
				'face'				=> 'Face',
				'qq'				=> 'QQ',
				'openid_qq'			=> 'OpenidQq',
				'openid_wechat'		=> 'OpenidWechat',
				'unionid_wechat'	=> 'UnionidWechat',
				'openid_weibo'		=> 'OpenidWeibo',
				'openid_alipay'		=> 'OpenidAlipay',
				'openid_taobao'		=> 'OpenidTaobao',
				'password'			=> 'Authentication',
				'pay_password'		=> 'PayPassWord',
				'security_password'	=> 'SecurityPassWord',
				'email'				=> 'Email',
				'is_valid_email'	=> 'IsValidEmail',
				'mobile'			=> 'Mobile',
				'is_valid_mobile'	=> 'IsValidMobile',
				'gender'			=> 'Gender',
				'idcard'			=> 'Idcard',
				'birth'				=> 'Birth',
				'idcard_front'		=> 'IdcardFont',
				'idcard_back'		=> 'IdcardBack',
				'native_pid'		=> 'NativePID',
				'native_cid'		=> 'NativeCID',
				'native_did'		=> 'NativeDID',
				'native_address'	=> 'NativeAdddress',
				'hobby'				=> 'Hobby',
				'parent_id'			=> 'ParentID',
				'direct_share'		=> 'DirectShare',
				'total_share'		=> 'TotalShare',
				'rank_level'		=> 'RankLevel',
				'sub_rank'			=> 'SubRank',
				'role_id'			=> 'RoleID',
				'is_auth'			=> 'IsAuth',
				'auth_code'			=> 'AuthCode',
				'auto_time'			=> 'AuthTime',
				'total_score'		=> 'TotalScore',
				'score'				=> 'Score',
				'total_coin'		=> 'TotalCoin',
				'coin'				=> 'Coin',
				'total_balance'		=> 'TotalBalance',
				'balance'			=> 'Balance',
				'invite_code'		=> 'InviteCode',
				'invite'			=> 'Invite',
				'regip'				=> 'RegIP',
				'ip_address'		=> 'IpAddress',
				'reg_os'			=> 'RegOs',
				'reg_os_version'	=> 'RegOsVersion',
				'reg_agent'			=> 'RegAgent',
				'reg_agent_version'	=> 'RegAgentVersion',
				'reg_device'		=> 'RegDevice',
				'is_mobile_reg'		=> 'IsMobileReg',
				'reg_source'		=> 'RegSource',
				'visitorid'			=> 'Visitorid',
				'last_login_time'	=> 'LastLoginTime',
				'last_login_ip'		=> 'LastLoginIP',
				'login_count'		=> 'LoginCount',
				'is_online'			=> 'IsOnline',
				'online_time'		=> 'OnlineTime',
				'is_valid'			=> 'IsValid',
				'is_locked'			=> 'IsLocked',
				'locked_time'		=> 'LockedTime',
				'is_del'			=> 'IsDel',
				'create_time'		=> 'CreateTime',
				'update_time'		=> 'UpdateTime',
				'delete_time'		=> 'DeleteTime',
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'uid','field'=>'AccountID','type'=>'varchar','length'=>'250','default'=>'','title'=>'账号ID','width'=>120],
				['map'=>'username','field'=>'UserName','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户名','width'=>150],
				['map'=>'nickname','field'=>'NickName','type'=>'varchar','length'=>'250','default'=>'','title'=>'昵称','width'=>150],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'250','default'=>'','title'=>'真实姓名','width'=>150],
				['map'=>'face','field'=>'Face','type'=>'pic','length'=>'1','default'=>'0','title'=>'头像','width'=>0],
				['map'=>'gender','field'=>'Gender','type'=>'varchar','length'=>'250','default'=>'','title'=>'性别','width'=>0],
				['map'=>'mobile','field'=>'Mobile','type'=>'varchar','length'=>'1','default'=>'0','title'=>'手机号码','width'=>180],
				// ['map'=>'email','field'=>'Email','type'=>'varchar','length'=>'1','default'=>'0','title'=>'邮箱地址','width'=>0],
				['map'=>'idcard','field'=>'Idcard','type'=>'varchar','length'=>'1','default'=>'0','title'=>'身份证号','width'=>180],
				['map'=>'birth','field'=>'Birth','type'=>'varchar','length'=>'1','default'=>'0','title'=>'出生日期','width'=>120],
				['map'=>'score','field'=>'Score','type'=>'int','length'=>'1','default'=>'0','title'=>'积分','width'=>0],
				['map'=>'balance','field'=>'Balance','type'=>'int','length'=>'1','default'=>'0','title'=>'余额','width'=>0],
				// ['map'=>'balance','field'=>'Balance','type'=>'int','length'=>'1','default'=>'0','title'=>'金币','width'=>0],
				['map'=>'parent_id','field'=>'ParentID','type'=>'int','length'=>'1','default'=>'0','title'=>'推荐人','width'=>120],
				['map'=>'direct_share','field'=>'DirectShare','type'=>'int','length'=>'1','default'=>'0','title'=>'分享数','width'=>0],
				// ['map'=>'buy_goods_count','field'=>'BuyGoodsCount','type'=>'int','length'=>'1','default'=>'0','title'=>'藏品','width'=>0],
				// ['map'=>'buy_blind_count','field'=>'BuyBlindCount','type'=>'int','length'=>'1','default'=>'0','title'=>'盲盒','width'=>0],
				// ['map'=>'airdrop_total_count','field'=>'AirdropTotalCount','type'=>'int','length'=>'1','default'=>'0','title'=>'空投','width'=>0],
				// ['map'=>'transfer_blind_count','field'=>'TransferGoodsCount','type'=>'int','length'=>'1','default'=>'0','title'=>'转赠','width'=>0],
				// ['map'=>'is_transfer_total_count','field'=>'IsTransferTotalCount','type'=>'int','length'=>'1','default'=>'0','title'=>'收赠','width'=>0],
				// ['map'=>'order_total','field'=>'OrderTotal','type'=>'int','length'=>'1','default'=>'0','title'=>'订单数','width'=>0],
				// ['map'=>'order_amount','field'=>'OrderTotalAmount','type'=>'int','length'=>'1','default'=>'0','title'=>'消费金额','width'=>0],
				// ['map'=>'title','field'=>'Title','type'=>'int','length'=>'1','default'=>'0','title'=>'角色','width'=>0],
				['map'=>'regip','field'=>'RegIP','type'=>'varchar','length'=>'1','default'=>'0','title'=>'注册IP','width'=>150],
				['map'=>'ip_address','field'=>'IpAddress','type'=>'varchar','length'=>'1','default'=>'0','title'=>'注册地','width'=>150],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'注册时间','width'=>180]
			];
		}

		protected function getInvitorList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'uid','field'=>'AccountID','type'=>'varchar','length'=>'250','default'=>'','title'=>'账号ID','width'=>120],
				// ['map'=>'username','field'=>'UserName','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户名','width'=>150],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'250','default'=>'','title'=>'真实姓名','width'=>150],
				['map'=>'face','field'=>'Face','type'=>'pic','length'=>'1','default'=>'0','title'=>'头像','width'=>0],
				['map'=>'gender','field'=>'Gender','type'=>'varchar','length'=>'250','default'=>'','title'=>'性别','width'=>0],
				['map'=>'mobile','field'=>'Mobile','type'=>'varchar','length'=>'1','default'=>'0','title'=>'手机号码','width'=>180],
				['map'=>'idcard','field'=>'Idcard','type'=>'varchar','length'=>'1','default'=>'0','title'=>'身份证号','width'=>180],
				['map'=>'birth','field'=>'Birth','type'=>'varchar','length'=>'1','default'=>'0','title'=>'出生日期','width'=>120],
				['map'=>'age','field'=>'Age','type'=>'int','length'=>'1','default'=>'0','title'=>'年龄','width'=>0],
				['map'=>'is_auth','field'=>'IsAuth','type'=>'int','length'=>'1','default'=>'0','title'=>'实名','width'=>0],
				['map'=>'direct_share','field'=>'DirectShare','type'=>'int','length'=>'1','default'=>'0','title'=>'分享数','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'注册时间','width'=>180]
			];
		}
	}
?>