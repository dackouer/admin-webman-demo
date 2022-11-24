<?php
	namespace app\controller\Role;

	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use app\controller\Controller;
	use app\model\Role\RoleModel;

	class Role extends Controller{
		protected $table = 'Role';
		
		public function index(Request $request,$id = 0){
			if($id){
				$service = new RoleModel();
				$result = $service->getList($request,$id);
			}else{
				$service = new RoleModel();
				$result = $service->getList($request);
			}
			
			return Json::show($result);
		}
	}
?>