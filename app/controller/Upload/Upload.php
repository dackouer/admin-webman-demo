<?php
	namespace app\controller\Upload;

	use support\Request;
	use app\lib\Json;
	use app\lib\Lang;
	use app\lib\Upload as UploadModel;

	class Upload{
		private $type = 1;

		public function index(Request $request){
			$grace = $request->input('grace',0);
			if($this->type){
				$res = $this->uploadOos($request);
			}else{
				$res = $this->uploadLocation($request);
			}
// 			var_dump($res);
			if(isset($res['line'])){
				if(!$grace){
					return Json::show(1,$res['msg']);
				}else{
					return json_encode(['status'=>'error','data'=>$res['msg']]);
				}
			}
			if(!$grace){
				return Json::show($res);
			}else{
				return json_encode(['status'=>'ok','data'=>$res['url'],'result'=>$res]);
			}
		}

		private function uploadLocation(Request $request){
			$service = new UploadModel();
			$res = $service->upload($request);
			return $res;
		}

		private function uploadOos(Request $request){
			try{
				\Tinywan\Storage\Storage::config(); // 初始化。 默认为本地存储：local，阿里云：oss，腾讯云：cos，七牛：qiniu
				$res = \Tinywan\Storage\Storage::uploadFile();
				if(count($res) == 1){
					return $res[0];
				}
				return $res;
			}catch(\Exception $e){
				// var_dump($e);
				return ['code'=>$e->getCode(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
			}
		}
	}
?>