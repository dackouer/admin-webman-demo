<?php

namespace app\controller;

use support\Request;
use app\lib\Token;
use app\lib\Json;

class Controller
{
    protected $table;
    private $_class_name;

    public function __construct(){
        if(method_exists($this,'_init')){
            $this->_init();
        }
        if(!empty($this->table)){
            $this->_class_name = '\\app\\model\\'.ucfirst($this->table).'\\'.ucfirst($this->table).'Model';
        }
    }

    /**
     * 检查token是否合法
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function checkToken(Request $request){
        $token = trim($request->header('Authorization'));
        // var_dump('controller token: '.$token);
        if(empty($token)){
            return false; 
        }

        $service = new \app\model\user\UserModel();
        if(!$service->checkToken($token)){
            return false;
        }
        return true;
    }


    /**
     * 获取显示列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function show(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'show');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取所有列表
     * @param  Request $request [description]
     * @return [type] [description]
     */
    public function all(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'all');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取分页列表
     * @param  Request $request [description]
     * @return [type] [description]
     */
    public function list(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'list');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取tree列表
     * @param  Request $request [description]
     * @return [type] [description]
     */
    public function tree(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'tree');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取单条原始数据
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function one(Request $request,$id = 0){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'mod',$id);
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取map字段表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function child(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'children');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取map字段表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function map(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'map');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取最大排序值
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function sort(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'sort');
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 获取父id的列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function parent(Request $request,$pid = 0){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->getList($request,'parent',$pid);
        }else{
            $result = array();
        }
        return Json::show($result);
    }

    /**
     * 新增数据
     * @param Request $request [description]
     */
    public function add(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->add($request);
            return Json::show($result);
        }
        return Json::show(100000);
    }

    /**
     * 修改数据
     * @param Request $request [description]
     */
    public function mod(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->mod($request);
            return Json::show($result);
        }
        return Json::show(100000);
    }

    /**
     * [save description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function save(Request $request){
        $id = $request->input('id');
        // var_dump('save id: '.$id);
        if(!$id){
            // var_dump('a');
            return $this->add($request);
        }else{
            // var_dump('b');
            return $this->mod($request);
        }
    }

    /**
     * 标记删除数据
     * @param Request $request [description]
     */
    public function del(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->del($request);
            return Json::show($result);
        }
        return Json::show(100000);
    }

    /**
     * 真实删除数据
     * @param Request $request [description]
     */
    public function remove(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->remove($request);
            
            if($result === true){
                return Json::show(0,'ok');
            }
            if(is_numeric($result)){
                return Json::show($result);
            }
            return Json::show(100031);
        }
        return Json::show(100000);
    }

    /**
     * 清空数据
     * @param Request $request [description]
     */
    public function clear(Request $request){
        if(class_exists($this->_class_name)){
            $service = new $this->_class_name();
            $result = $service->clear($request);
            if($result !== false){
                return Json::show(0,'数据清空成功');
            }
            return Json::show(100000);
        }
        return Json::show(100000);
    }

    /**
     * [getRequest description]
     * @param  Request $request [description]
     * @param  [type]  $key     [description]
     * @return [type]           [description]
     */
    public function getRequest(Request $request,$str,$value = ''){
        $result = '';
        if(is_array($str)){
            foreach($str as $val){
                $result = $request->get($val);
                if(trim($result) == ''){
                    $result = $request->post($val);
                }
                if(trim($result) != ''){
                    break;
                }
            }
        }else{
            $result = $request->get($str);
            if(trim($result) == ''){
                $result = $request->post($str);
            }
        }
        if(trim($result) == ''){
            $result = $value;
        }
        return trim($result);
    }
}
