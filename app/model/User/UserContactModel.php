<?php
	namespace app\model\User;

	use support\Request;
	use app\model\Model;
	use app\lib\Server;
	use app\model\Activity\ActivityModel;

	class UserContactModel extends Model{
		public $table = 'user_contact';

		public function getTopList(Request $request){
			$aid = $request->input('aid',0);
			$num = $request->input('num',20);

			$service = new ActivityModel();
			$arr = $service->getList($request,'first',$aid);
			var_dump($arr);
			if(!$arr){
				return [];
			}

			$start_time = strtotime($arr['start_time']);
			$end_time = strtotime($arr['end_time']);

			var_dump('start_time: '.$start_time);
			var_dump('end_time: '.$end_time);

			$tab = $this->tab;
			$user = $this->prex.'user';

			$sql = "SELECT UserID as uid,COUNT(UserID) as count,(SELECT Face FROM $user WHERE AccountID = UserID LIMIT 1) as face,(SELECT Mobile FROM $user WHERE AccountID = UserID LIMIT 1) as mobile FROM $tab WHERE CreateTime >= ? AND CreateTime <= ? GROUP BY UserID ORDER BY COUNT(UserID) DESC LIMIT ?";
			$param = [$start_time,$end_time,$num];
			$result = [];
			$object = Db::select($sql,$param);
			if($object){
				$result = $this->objectToArray($object);
				for($i=0;$i<count($result);$i++){
					$result[$i]['face'] = $this->setImg($result[$i]['face'],'');
					$result[$i]['mobile'] = $this->setMobile($result[$i]['mobile']);
				}
			}

			return $result;

		}
	}
?>