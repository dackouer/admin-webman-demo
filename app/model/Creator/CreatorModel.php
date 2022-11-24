<?php
	namespace app\model\Creator;

	use support\Request;
	use support\Db;
	use support\Redis;
	use app\lib\Preg;
	use app\model\Model;

	class CreatorModel extends Model{
		public $table = 'creator';
		public $title = '创作者管理';

		protected function getShowList(Request $request){
			$thead = $this->getList($request,'map');

			$user = $this->tab;

			$field = [
				"ID as id",
				"RealName as realname",
				"NickName as nickname",
				"Mobile as mobile",
				"Email as email",
				"Avatar as avatar",
				"Idcard as idcard",
				"Birth as birth",
				"Gender as gender",
				"Introduction as intro",
				"ChainAddress as chain_id",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND (`RealName` LIKE ? OR `Mobile` LIKE ? OR `Idcard` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
				$this->rows = Db::table($this->table)
						->select(...$field)
						->where($where)
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
						$result[$i]['avatar'] = $this->setImg($result[$i]['avatar'],'creator');
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
		}

		/**
		 * 获取发行方列表
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getAllList(Request $request){
			$thead = [];

			$user = $this->tab;

			$field = [
				"ID as id",
				"RealName as realname",
				"NickName as nickname",
				"Mobile as mobile",
				"Email as email",
				"Avatar as avatar",
				"Idcard as idcard",
				"Birth as birth",
				"Gender as gender",
				"Introduction as intro",
				"ChainAddress as chain_id",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			$whereRaw = 'IsDel = 0';
			$where = [['IsDel','=',0]];
			$orWhere = [];
			$param = [];

			$keyword = trim($request->input('keyword',''));
			if(!empty($keyword)){
				// array_push($where,['Title','LIKE',"'%{$keyword}%'"]);
				$whereRaw .= " AND (`RealName` LIKE ? OR `Mobile` LIKE ? OR `Idcard` LIKE ?)";
				// array_push($param,$keyword,$keyword,$keyword);
			}

			$limit = $this->getLimit($request);
			
			try{
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
						$result[$i]['avatar'] = $this->setImg($result[$i]['avatar'],'creator');
						$result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
					}
				}
				return $result;
			}catch(\Exception $e){
				return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
			}
		}

		/**
		 * 获取发行方单条记录
		 * @param  Request $request [description]
		 * @return [type]           [description]
		 */
		protected function getListById(Request $request){
			$args = func_get_args();
			$id = isset($args[1]) ? $args[1] : 0;

			$field = [
				"ID as id",
				"RealName as realname",
				"NickName as nickname",
				"Mobile as mobile",
				"Email as email",
				"Avatar as avatar",
				"Idcard as idcard",
				"Birth as birth",
				"Gender as gender",
				"Introduction as intro",
				"ChainAddress as chain_id",
				"CreateTime as create_time",
				"IsValid as is_valid"
			];
			
			$where = [['IsDel','=',0],['ID','=',$id]];
			$orWhere = [];
			$param = [];
			
			try{
				$object = Db::table($this->table)
						->select(...$field)
						->where($where)
						->first();

				$result = [];
				if($object){
					$result = $this->objectToArray($object);
					$result['avatar'] = $this->setImg($result['avatar'],'creator');
					$result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
				}
				return $result;
			}catch(\Exception $e){
				var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}

		protected function setRequest(Request $request,$flag = false){
			if(!$flag){
				// $idcard = $request->post('idcard');
				// $birth = $request->post('birth');
				// $gender = $request->post('gender');
				// if(empty($birth)){
				// 	$data['birth'] = $this->getBirth($idcard);
				// }
				// if(empty($gender)){
				// 	$data['gender'] = $this->getGender($idcard);
				// }
				$data['create_time'] = time();
                $data['create_ip'] = $request->getRealIp($safe_mode=true);
                $data['update_time'] = time();
                $data['update_ip'] = $request->getRealIp($safe_mode=true);

				return $data;
			}
			return [];
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$realname = $request->post('realname');
			$nickname = $request->post('nickname');
			$mobile = $request->post('mobile');
			$email = $request->post('email');
			$mobile = $request->post('mobile');
			$avatar = $request->post('avatar');
			$idcard = $request->post('idcard');
			$chain_id = $request->post('chain_id');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100720;
				}
			}
			
			if(empty($realname)){
				return 100721;
			}
			
			if(empty($nickname)){
				return 100722;
			}

			if($this->checkExists(['NickName'=>$nickname],$id)){
				return 100723;
			}
			
			// if(empty($mobile)){
			// 	return 100724;
			// }

			// if(!Preg::isMobile($mobile)){
			// 	return 100725;
			// }

			// if($this->checkExists(['Mobile'=>$mobile],$id)){
			// 	return 100726;
			// }
			
			// if(empty($email)){
			// 	return 100727;
			// }
			
			// if(!Preg::isEmail($email)){
			// 	return 100728;
			// }

			// if($this->checkExists(['Email'=>$email],$id)){
			// 	return 100729;
			// }
			
			if(empty($avatar)){
				return 100730;
			}
			
			// if(empty($idcard)){
			// 	return 100731;
			// }
			
			// if(!Preg::isIdcard($idcard)){
			// 	return 100732;
			// }

			// if($this->checkExists(['Idcard'=>$idcard],$id)){
			// 	return 100733;
			// }
			
			// if(empty($chain_id)){
			// 	return 100734;
			// }

			// if($this->checkExists(['ChainAddress'=>$chain_id],$id)){
			// 	return 100735;
			// }

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'realname'				=> 'RealName',
				'nickname'				=> 'NickName',
				'mobile'				=> 'Mobile',
				'email'					=> 'Email',
				'avatar'				=> 'Avatar',
				'idcard'				=> 'Idcard',
				'birth'					=> 'Birth',
				'gender'				=> 'Gender',
				'intro'					=> 'Introduction',
				'chain_id'				=> 'ChainAddress',
				'Content'				=> 'Content',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'update_time'			=> 'UpdateTime',
				'is_valid'				=> 'IsValid'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'250','default'=>'','title'=>'创作者姓名','width'=>120],
				['map'=>'nickname','field'=>'NickName','type'=>'varchar','length'=>'2048','default'=>'','title'=>'昵称','width'=>120],
				['map'=>'mobile','field'=>'Mobile','type'=>'varchar','length'=>'2048','default'=>'','title'=>'手机号码','width'=>130],
				['map'=>'email','field'=>'Email','type'=>'varchar','length'=>'2048','default'=>'','title'=>'邮箱地址','width'=>180],
				['map'=>'avatar','field'=>'Avatar','type'=>'pic','length'=>'250','default'=>'','title'=>'头像','width'=>0],
				['map'=>'idcard','field'=>'Idcard','type'=>'varchar','length'=>'2048','default'=>'','title'=>'身份证号码','width'=>180],
				['map'=>'birth','field'=>'Birth','type'=>'varchar','length'=>'2048','default'=>'','title'=>'出生日期','width'=>120],
				['map'=>'gender','field'=>'Gender','type'=>'varchar','length'=>'2048','default'=>'','title'=>'性别','width'=>0],
				['map'=>'chain_id','field'=>'ChainAddress','type'=>'varchar','length'=>'2048','default'=>'','title'=>'链地址','width'=>150],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>180],
				['map'=>'is_valid','field'=>'IsValid','type'=>'switch','length'=>'10','default'=>'','title'=>'状态','width'=>0]
			];
		}
	}
?>