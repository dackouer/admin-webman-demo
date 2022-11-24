<?php
	namespace app\controller;

	use support\Request;
	use support\Db;
	use app\lib\Json;

	class Query{
		public function index(Request $request){
			$sql = trim($request->post('sql',''));
			$type = 'select';

			if(empty($sql)){
				return Json::show('SQL语句不能为空');
			}

			$sql = trim($sql,";");
			$temp = explode(" ",$sql);
			if(!in_array(strtolower($temp[0]),['select','insert','update','delete','alter','desc','show','create','drop','truncate'])){
				return Json::show('无效的SQL语句');
			}

			$type = strtolower($temp[0]);

			switch($type){
				case 'select':
					$result = Db::select($sql);
					$result = json_decode(json_encode($result),true);
					break;
				case 'insert':
					$result = Db::insert($sql);
					$result = $result !== false ? '执行成功'	: '执行失败';
					break;
				case 'update':
					$result = Db::update($sql);
					$result = $result !== false ? '执行成功'	: '执行失败';
					break;
				case 'delete':
					$result = Db::delete($sql);
					$result = $result !== false ? '执行成功'	: '执行失败';
					break;
				case 'desc':
					$result = Db::select($sql);
					$result = json_decode(json_encode($result),true);
					break;
				case 'alter':
					$result = Db::select($sql);
					$result = $result !== false ? '执行成功'	: '执行失败';
					break;
				case 'show':
					$result = Db::select($sql);
					$result = json_decode(json_encode($result),true);
					break;
				case 'create':
					$result = Db::select($sql);
					$result = $result !== false ? '执行成功'	: '执行失败';
					break;
				case 'drop':
					$result = Db::select($sql);
					$result = $result !== false ? '执行成功'	: '执行失败';
					break;
				case 'truncate':
					$result = Db::select($sql);
					$result = $result !== false ? '数据已清空'	: '执行失败';
					break;
				default:
					$result = '无效的SQL语句';
			}
			
			if($type == 'select'){
				$thead = [];
				if(strrpos($sql,'from') !== false){
				    $temp = explode(" from",substr($sql,7));
				}elseif(strrpos($sql,'FROM') !== false){
				    $temp = explode(" FROM",substr($sql,7));
				}else{
				    $temp = explode(" From",substr($sql,7));
				}
				
				if($temp[0] == '*'){
					$table = explode(" ",trim($temp[1]," "));
					$table = explode(",",$table[0]);
					$resp = Db::select("SHOW FULL FIELDS FROM ".$table[0]);
					$resp = json_decode(json_encode($resp),true);
					foreach($resp as $key => $val){
						array_push($thead,['field'=>$val['Field'],'title'=> empty($val['Comment']) ? $val['Field'] : $val['Comment']]);
					}
					// var_dump($resp);
				}else{
					$temp = explode(",",$temp[0]);

					foreach($temp as $val){
						array_push($thead,['field'=>$val,'title'=>$val]);
					}
				}

				$result = ['thead' => $thead,'rows' => count($result),'data' => $result];
			}
			
			if($type == 'desc'){
				$thead = [
					['field' => 'Field','title' => 'Field'],
					['field' => 'Type','title' => 'Type'],
					['field' => 'Null','title' => 'Null'],
					['field' => 'Key','title' => 'Key'],
					['field' => 'Default','title' => 'Default'],
					['field' => 'Extra','title' => 'Extra']
				];

				$result = ['thead' => $thead,'rows' => count($result),'data' => $result];
			}
			
			if($type == 'show'){
				if(strtolower($temp[1]) == 'tables'){
					$thead = [
						['field' => 'Tables_in_yitea','title' => 'Tables_in_yitea'],
					];
				}else{
					$thead = [
						['field' => 'Field','title' => 'Field'],
						['field' => 'Type','title' => 'Type'],
						['field' => 'Collation','title' => 'Collation'],
						['field' => 'Null','title' => 'Null'],
						['field' => 'Key','title' => 'Key'],
						['field' => 'Default','title' => 'Default'],
						['field' => 'Extra','title' => 'Extra'],
						['field' => 'Privileges','title' => 'Privileges'],
						['field' => 'Comment','title' => 'Comment']
					];
				}
				

				$result = ['thead' => $thead,'rows' => count($result),'data' => $result];
			}

			var_dump($result);
			return Json::show($result);
		}
	}
?>