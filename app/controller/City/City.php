<?php
	namespace app\controller\City;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\City\CityModel;

	class City extends Controller{
		protected $table = 'City';

		public function index(Request $request,$id = 0){
			if($id){
				$service = new CityModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new CityModel();
				$result = $service->getList($request,'level');
			}
			
			return Json::show($result);
		}

		/**
		 * 获取层级列表
		 * @return [type] [description]
		 */
		public function level(Request $request,$level = 1){
			$service = new CityModel();
			$result = $service->getList($request,'level',$level);
			return Json::show($result);
		}

		/**
		 * 获取父级列表
		 * @return [type] [description]
		 */
		public function parent(Request $request,$id = 0){
			$service = new CityModel();
			$result = $service->getList($request,'parent',$id);
			return Json::show($result);
		}

		/**
		 * 获取子级列表
		 * @return [type] [description]
		 */
		public function child(Request $request,$pid = 0){
			$service = new CityModel();
			$result = $service->getList($request,'children',$pid);
			return Json::show($result);
		}

		/**
		 * 获取某层级最大排序值
		 * @return [type] [description]
		 */
		public function sort(Request $request,$pid = 0){
			$service = new CityModel();
			$result = $service->getList($request,'sort',$pid);
			return Json::show($result);
		}

		/**
		 * [save description]
		 * @param Request $request [description]
		 */
		public function save(Request $request){
			$id = $request->input('id');

			if(!$id){
				$service = new CityModel();
				$result = $service->add($request);
				return Json::show($result);
			}else{
				$service = new CityModel();
				$result = $service->mod($request);
				return Json::show($result);
			}
		}
	}
?>