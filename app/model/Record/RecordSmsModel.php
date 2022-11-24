<?php
	namespace app\model\Record;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

	class RecordSmsModel extends Model{
		public $table = 'record_sms';
		public $title = '短信记录';

		protected function getTopList(Request $request,$num = 1){
			$count = $request->post('count',1);
			$uid = $request->post('uid',0);
			$mobile = $request->post('mobile',18944277727);
			$action = $request->post('action','test');

			$tab = $this->tab;
			$user = $this->prex.'user';

			$fields = $this->getList($request,'field');
			$field = $this->getKeyValue($fields);

			$where = [
				['UserID','=',$uid],
				['SmsType','=',$action],
				['Mobile','=',$mobile]
			];

			$orderby = "ID";

			if($count == 1){
				$object = Db::table($this->table)
                        ->select(...$field)
                        ->where($where)
                        ->orderby($orderby,'DESC')
                        ->limit(1)
                        ->first();
                if($object){
                	$result = $this->objectToArray($object);
                	return $result[0];
                }
                return [];
            }else{
            	$object = Db::table($this->table)
                        ->select(...$field)
                        ->where($where)
                        ->orderby($orderby,'DESC')
                        ->limit($count)
                        ->get();
                if($object){
                	$result = $this->objectToArray($object);
                	return $result;
                }
                return [];
            }

		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'uid'					=> 'UserID',
				'type'					=> 'SmsType',
				'template'				=> 'TemplateID',
				'mobile'				=> 'Mobile',
				'code'					=> 'Smscode',
				'state'					=> 'State',
				'is_del'				=> 'IsDel',
				'create_time'			=> 'CreateTime',
				'create_ip'				=> 'CreateIP',
				'expire_time'			=> 'ExpireTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'realname','field'=>'RealName','type'=>'varchar','length'=>'250','default'=>'','title'=>'用户','width'=>0],
				['map'=>'type','field'=>'SmsType','type'=>'varchar','length'=>'2048','default'=>'','title'=>'类型','width'=>0],
				['map'=>'template','field'=>'TemplateID','type'=>'varchar','length'=>'2048','default'=>'','title'=>'模板ID','width'=>0],
				['map'=>'mobile','field'=>'Mobile','type'=>'varchar','length'=>'2048','default'=>'','title'=>'手机号码','width'=>0],
				['map'=>'code','field'=>'Smscode','type'=>'varchar','length'=>'2048','default'=>'','title'=>'验证码','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'发送时间','width'=>0],
				['map'=>'create_ip','field'=>'CreateIP','type'=>'varchar','length'=>'10','default'=>'','title'=>'发送IP','width'=>0],
				['map'=>'expire_time','field'=>'ExpireTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'过期时间','width'=>0],
				['map'=>'state','field'=>'State','type'=>'varchar','length'=>'2048','default'=>'','title'=>'状态','width'=>0]
			];
		}
	}
?>