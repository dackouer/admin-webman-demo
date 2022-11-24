<?php
	namespace app\model\Poster;

	use support\Request;
	use support\Redis;
	use support\Db;
	use app\model\Model;

    use \app\lib\PhpQrcode\FrameFiller;
	use \app\lib\PhpQrcode\QRbitstream;
	use \app\lib\PhpQrcode\QRcode;
	use \app\lib\PhpQrcode\QRencode;
	use \app\lib\PhpQrcode\Qrimage;
	use \app\lib\PhpQrcode\QRinput;
	use \app\lib\PhpQrcode\QRinputItem;
	use \app\lib\PhpQrcode\QRmask;
	use \app\lib\PhpQrcode\QRrawcode;
	use \app\lib\PhpQrcode\QRrs;
	use \app\lib\PhpQrcode\QRrsblock;
	use \app\lib\PhpQrcode\QRrsItem;
	use \app\lib\PhpQrcode\QRspec;
	use \app\lib\PhpQrcode\QRsplit;
	use \app\lib\PhpQrcode\Qrstr;
	use \app\lib\PhpQrcode\QRtools;

	class PosterModel extends Model{
		public $table = 'poster';
		public $title = '海报管理';

		protected function getListById(Request $request,$id = 0){
			$fields = $this->getList($request,'field');
			$field = [];
			foreach($fields as $key => $val){
				array_push($field,"{$val} as {$key}");
			}
			$object = Db::table($this->table)->select(...$field)->where('ID',$id)->first();
			$result = [];
			if($object){
				$result = $this->objectToArray($object);

				if($result['url']){
					$invite = trim($request->input('invite',''));
					if(!empty($invite)){
						$url = urldecode($result['url'].'?invite='.$invite);
					}else{
						$url = urldecode($result['url']);
					}
					ob_start();	
					$res = QRcode::png($url);
					$imgString = base64_encode(ob_get_contents());
					ob_end_clean();

					$result['qrcode'] = 'data:image/png;base64,'.$imgString;
				}
			}

			return $result;
		}

		protected function validate(Request $request,$flag = false){
			$id = $request->input('id',0);
			$title = $request->post('title');
			$pic = $request->post('pic');
			$url = $request->post('url');
			$width = $request->post('width');
			$height = $request->post('height');
			$axisx = $request->post('axisx');
			$axisy = $request->post('axisy');

			if($flag){
				if(empty($id) || !is_numeric($id) || !$id){
					return 100007;
				}

				$resp = $this->getList($request,$id);
				if(!$resp){
					return 100970;
				}
			}
			
			if(empty($title)){
				return 100971;
			}

			if($this->checkExists(['Title'=>$title],$id)){
				return 100972;
			}
			
			if(empty($pic)){
				return 100973;
			}
			
			if(empty($url)){
				return 100974;
			}

			// if(strtolower(substr($url,0,4)) != 'http' || strtolower(substr($url,0,6)) != '/pages'){
			// 	return 100975;
			// }

			if(empty($width)){
				return 100976;
			}

			if(!is_numeric($width) || !$width){
				return 100977;
			}

			if(empty($height)){
				return 100978;
			}

			if(!is_numeric($height) || !$height){
				return 100979;
			}

			if($axisx == ''){
				return 100980;
			}

			if(!is_numeric($axisx)){
				return 100981;
			}

			if($axisy == ''){
				return 100982;
			}

			if(!is_numeric($axisy)){
				return 100983;
			}

			return true;
		}

		protected function getFieldList(Request $request){
			return [
				'id'					=> 'ID',
				'title'					=> 'Title',
				'pic'					=> 'Pic',
				'url'					=> 'Url',
				'width'					=> 'Width',
				'height'				=> 'Height',
				'axisx'					=> 'Axisx',
				'axisy'					=> 'Axisy',
				'create_time'			=> 'CreateTime',
				'update_time'			=> 'UpdateTime'
			];
		}

		protected function getMapList(Request $request){
			return [
				['map'=>'id','field'=>'ID','type'=>'id','length'=>'8','default'=>'','title'=>'ID','width'=>0],
				['map'=>'title','field'=>'Title','type'=>'varchar','length'=>'250','default'=>'','title'=>'标题','width'=>180],
				['map'=>'pic','field'=>'Pic','type'=>'pic','length'=>'250','default'=>'','title'=>'背景图','width'=>0],
				['map'=>'url','field'=>'Url','type'=>'url','length'=>'250','default'=>'','title'=>'链接地址','width'=>0],
				['map'=>'width','field'=>'Width','type'=>'int','length'=>'10','default'=>'','title'=>'二维码宽度','width'=>0],
				['map'=>'height','field'=>'Height','type'=>'int','length'=>'10','default'=>'','title'=>'二维码高度','width'=>0],
				['map'=>'axisx','field'=>'Axisx','type'=>'int','length'=>'10','default'=>'','title'=>'X轴偏移值','width'=>0],
				['map'=>'axisy','field'=>'Axisy','type'=>'int','length'=>'10','default'=>'','title'=>'Y轴偏移值','width'=>0],
				['map'=>'create_time','field'=>'CreateTime','type'=>'varchar','length'=>'10','default'=>'','title'=>'创建时间','width'=>0]
			];
		}
	}
?>