<?php
    namespace app\model;

    use support\Request;
    use support\Redis;
    use support\Db;
    use support\Log;
    use app\lib\Token;
    use Webman\Config;

    class Model extends \support\Model{
        /**
         * The table associated with the model.
         *
         * @var string
         */
        protected $table = '';

        /**
         * The title associated with the model.
         *
         * @var string
         */
        protected $title = '';

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'ID';

        /**
         * Indicates if the model should be timestamped.
         *
         * @var bool
         */
        public $timestamps = false;

        /**
         * 表前缀
         * @var string
         */
        public $prex = '';

        /**
         * 带前缀表名
         * @var string
         */
        public $tab = '';

        /**
         * 记录条数
         * @var integer
         */
        public $rows = 0;

        /**
         * 表类型
         * @var integer
         */
        public $tabtype = 1;

        /**
         * 表层级
         * @var integer
         */
        public $layer = 1;

        /**
         * Host
         * @var integer
         */
        public $host = [];
        
        /**
         * 系统配置项
         * @var array
         */
        public $conf = array();
        
        /**
         * 模块配置项
         * @var array
         */
        public $config = array();

        /**
         * Redis开关
         * @var boolean
         */
        protected $is_redis = true;

        /**
         * Token开关
         * @var boolean
         */
        protected $is_token = false;

        /**
         * 构造函数
         */
        public function __construct(){
            $config = Config::get('database');
            $this->prex = $config['connections']['mysql']['prefix'];
            $this->tab = $this->prex.$this->table;
            $this->setSystemConfig();

            if(method_exists($this,'_init')){
                $this->_init();
            }

            $this->host = [
                'www'  => 'https://www.yijiantea.cn/',
                'img'  => 'https://img.yijiantea.cn/',
                'api'  => 'https://api.yijiantea.cn/',
                'image'  => 'https://image.yijiantea.cn/'
            ];
        }

        /**
         * 查询总入口
         * @return [type] [description]
         */
        public function getList(){
            $args = func_get_args();
            $key = $this->tab;
            $result = array();

            // 第一个参数是Request
            if(isset($args[0])){
                $request = $args[0];
                $key = $this->tab.'_'.MD5(json_encode($request->all()));
                // var_dump($key);
            }

            if(!$this->checkToken($args[0])){
                return 100011;
            }

            // 没有参数或只有一个参数
            if(count($args) == 0 || count($args) == 1){
                $key = $this->table.'_'.MD5($key . '_all');
                Redis::del($key);
                $result = Redis::exists($key) ? Redis::get($key) : false;
                if($result){
                    $this->setLog($request,'redis');
                    $result = json_decode($result,true);
                }else{
                    $this->setLog($request,'mysql');
                    $result = $this->getAllList($request);
                    Redis::set($key,json_encode($result));
                }
                return $result;
            }

            // 有第二个参数
            if(isset($args[1])){
                $arg = $args;
                array_shift($arg);
                if(is_numeric($args[1])){       // 第二个参数为数字
                    $key = $this->table.'_'.MD5($key . '_single' . implode('_',$this->objectToArray($arg)));
                    Redis::del($key);
                    $result = Redis::exists($key) ? Redis::get($key) : false;
                    if($result){
                        $this->setLog($request,'redis');
                        $result = json_decode($result,true);
                    }else{
                        $this->setLog($request,'mysql');
                        $result = $this->getListById(...$args);
                        Redis::set($key,json_encode($result));
                    }
                    return $result;
                }elseif(is_array($args[1])){    // 第二个参数为数组
                    $key = $this->table.'_'.MD5($key . '_search' . implode('_',$this->objectToArray($arg)));
                    Redis::del($key);
                    $result = Redis::exists($key) ? Redis::get($key) : false;
                    if($result){
                        $this->setLog($request,'redis');
                        $result = json_decode($result,true);
                    }else{
                        $this->setLog($request,'mysql');
                        $result = $this->getSearchList(...$args);
                        Redis::set($key,json_encode($result));
                    }
                    return $result;
                }elseif(is_string($args[1])){   // 第二个参数是字符串
                    $sign = ucfirst(strtolower($args[1]));
                    $class_name = 'get'.$sign.'List';
                    array_shift($arg);
                    $key = $this->table.'_'.MD5($key . '_' . $sign . implode('_',$this->objectToArray($arg)));
                    Redis::del($key);
                    $result = Redis::exists($key) ? Redis::get($key) : false;
                    if($result){
                        $this->setLog($request,'redis');
                        $result = json_decode($result,true);
                    }else{
                        $this->setLog($request,'mysql');
                        array_splice($args,1,1);
                        $result = $this->$class_name(...$args);
                        Redis::set($key,json_encode($result));
                    }
                    return $result;
                }else{                          // 第二个参数为其它类型
                    $key = $this->table.'_'.MD5($key . '_all' . implode('_',$this->objectToArray($arg)));
                    Redis::del($key);
                    $result = Redis::exists($key) ? Redis::get($key) : false;
                    if($result){
                        $this->setLog($request,'redis');
                        $result = json_decode($result,true);
                    }else{
                        $this->setLog($request,'mysql');
                        $result = $this->getAllList($request);
                        Redis::set($key,json_encode($result));
                    }
                    return $result;
                }
            }
        }

        /**
         * 新增数据总入口
         * @param Request $request [description]
         */
        public function add(Request $request,$flag = false){
            if(!$this->checkToken($request)){
                return 100011;
            }

            $method = $request->method();
            if(empty($method) || strtolower($method) != 'post'){
                return 100000;
            }

            $data = $request->post();
            $data = $this->objectToArray($data);

            if(method_exists($this,'validate')){
                $code = $this->validate($request);
                if(is_array($code)){
                    $data = array_merge($data,$code);
                }elseif($code !== true){
                    return $code;
                }
            }

            if(method_exists($this,'setRequest')){
                $res = $this->setRequest($request);
                if($res && is_array($res)){
                    $data = array_merge($data,$res);
                }
            }
            if($data){
                // if(isset($data['goods'])){
                //     $data['goods'] = json_encode($data['goods']);
                // }
                // var_dump($data);
                // Db::connection()->beginTransaction();
                // try{
                    $map = $this->getList($request,'Field');
                    $mapkey = array_keys($map);
                    $mapval = array_values($map);

                    $keys = "";
                    $vals = "";
                    $param = array();

                    foreach($data as $key => $val){
                        if(strtolower($key) != 'id'){
                            if(in_array($key,$mapkey)){
                                $keys .= "`".$map[$key]."`,";
                                $vals .= "?,";
                                array_push($param,$val);
                            }else{
                                if(in_array($key,$mapval)){
                                    $keys .= "`{$key}`,";
                                    $vals .= "?,";
                                    array_push($param,$val);
                                }
                            }
                        }
                    }
                    $keys = trim($keys,",");
                    $vals = trim($vals,",");
                    $sql = "INSERT INTO ".$this->prex.$this->table." ({$keys}) VALUES ({$vals})";
                    $this->setLog($request,'mysql:'.$sql,$param);
                    // var_dump($sql);
                    // var_dump($param);
                    $result = Db::insert($sql,$param);
                    
                    if($result){
                        $this->removeRedis();
                        $data['id'] = Db::getPdo()->lastInsertId();
                        if($this->layer > 1){
                            $this->setIncrement($data['pid'],'Number');
                        }
                        if(method_exists($this,'setExcute')){
                            $resp = $this->setExcute($request,$data,false);
                            if($resp === true){
                                $this->setLog($request,'mysql: setExcute 0');
                                $this->isClean();
                                return $data;    //  插入数据并回调成功返回数据
                            }else{
                                // var_dump('resp: '.$resp);
                                return $resp;  // 插入数据后回调函数失败
                            }
                        }else{
                            $this->setLog($request,'mysql: setExcute 1');
                            $this->isClean();
                            return $data;    // 无回调函数插入成功
                        }
                    }
                // }catch(\Exception $exception){
                //     var_dump('rollback');
                //     Db::connection()->rollback();//数据库回滚
                // }
            }else{
                $this->setLog($request,'mysql: setExcute -1');
                return 100001;
            }
        }

        /**
         * 直接插入数据
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function insert(Request $request){
            // var_dump('begin reg');
            if(!$this->checkToken($request)){
                return 100011;
            }

            $data = $request->post();
            $data = $this->objectToArray($data);
            // var_dump($data);
            if(method_exists($this,'setRequest')){
                $res = $this->setRequest($request);
                if($res){
                    $data = array_merge($data,$res);
                }
            }
            
            if($data){
                // Db::connection()->beginTransaction();
                // try{
                    $map = $this->getList($request,'Field');
                    $mapkey = array_keys($map);
                    $mapval = array_values($map);

                    $keys = "";
                    $vals = "";
                    $param = array();

                    foreach($data as $key => $val){
                        if(in_array($key,$mapkey)){
                            $keys .= "`".$map[$key]."`,";
                            $vals .= "?,";
                            array_push($param,$val);
                        }else{
                            if(in_array($key,$mapval)){
                                $keys .= "`{$key}`,";
                                $vals .= "?,";
                                array_push($param,$val);
                            }
                        }
                    }
                    $keys = trim($keys,",");
                    $vals = trim($vals,",");
                    $sql = "INSERT INTO ".$this->prex.$this->table." ({$keys}) VALUES ({$vals})";
                    $result = Db::insert($sql,$param);
                    // var_dump('reg sql:'.$sql);
                    // var_dump($result);
                    if($result){
                        $this->removeRedis();
                        return $data;
                    }
                    return false;
                // }catch(\Exception $exception){
                //     Db::connection()->rollback();//数据库回滚
                // }
            }

        }

        /**
         * 直接插入数据
         * @param  [type] $data [description]
         * @return [type]       [description]
         */
        public function setAppend(Request $request,$data){
            // var_dump($data);
            $field = $this->getFieldList($request);
            $keys = array_keys($field);
            $vals = array_values($field);

            $key = "";
            $val = "";
            $param = [];
            foreach($data as $k => $v){
                if(in_array($k,$keys)){
                    $key .= "`{$field[$k]}`,";
                    $val .= "?,";
                    array_push($param,$v);
                }else{
                    if(in_array($k,$vals)){
                        $key .= "`{$k}`,";
                        $val .= "?,";
                        array_push($param,$v);
                    }
                }
            }
            $key = rtrim($key,",");
            $val = rtrim($val,",");
            // var_dump('key: '.$key);
            // var_dump('val: '.$val);
            if(!empty($key) && !empty($val)){
                try{
                    $sql = "INSERT INTO ".$this->prex.$this->table." ({$key}) VALUES ({$val})";
                    $result = Db::insert($sql,$param);
                    // var_dump($result);
                    if($result){
                        // $this->removeRedis();
                        return $data;
                    }
                    return false;
                }catch(\Exception $e){
                    return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
                }
            }else{
                return false;
            }
        }

        /**
         * 直接修改数据
         * @param  [type] $data [description]
         * @return [type]       [description]
         */
        public function modify(Request $request,$data,$id = 0){
            if($data && $id){
                $str = '';
                $param = [];
                foreach($data as $key => $val){
                    $str .= "`{$key}` = ?,";
                    array_push($param,$val);
                }
                $str = trim($str,",");

                if(!empty($str)){
                    if(is_array($id)){
                        $where = '1 = 1';
                        foreach($id as $key => $val){
                            $where .= " AND `{$key}` = ?";
                            array_push($param,$val);
                        }
                    }else{
                        $where = $this->primaryKey . " = ?";
                        array_push($param,$id);
                    }

                    $sql = "UPDATE ".$this->tab." SET $str WHERE $where";
                    // var_dump('modify sql: '.$sql);
                    // array_push($param,$id);

                    $result = Db::update($sql,$param);
                    return $result;
                }
            }
            return false;
        }

        /**
         * 修改数据总入口
         * @param Request $request [description]
         */
        public function mod(Request $request,$flag = false){
            // var_dump('mod data:');
            // var_dump($request->post());
            if(!$this->checkToken($request)){
                return 100011;
            }
            // var_dump('realname: '.$request->input('realname'));
            if($this->tabtype == 2){
                $id = 1;
            }else{
                $id = $request->input(strtolower($this->primaryKey));
            }

            if(empty($id)){
                return 100007;
            }
            // var_dump('mod id: '.$id);
            $method = $request->method();
            if(empty($method) || strtolower($method) != 'post'){
                return 100000;
            }

            $data = $request->post();
            if(method_exists($this,'validate')){
                $code = $this->validate($request,true);
                if(is_array($code)){
                    $data = array_merge($data,$code);
                }elseif($code !== true){
                    return $code;
                }
            }
            // var_dump($data);
            // // $data = $this->objectToArray($data);
            // if(count($data) != count($data, 1)){
            //     $data = $data['_value'];
            // }
            
            if(method_exists($this,'setRequest')){
                $res = $this->setRequest($request,true);
                if($res && is_array($res)){
                    $data = array_merge($data,$res);
                }
            }
            
            if($data){
                // Db::connection()->beginTransaction();
                // try{
                    $map = $this->getList($request,'field');
                    // array_shift($map);
                    $mapkey = array_keys($map);
                    $mapval = array_values($map);

                    $sql = "UPDATE ".$this->prex.$this->table." SET ";
                    $param = array();
                    $str = '';
                    foreach($data as $key => $val){
                        if(!in_array($key,['id','ID',$this->primaryKey,strtolower($this->primaryKey)])){
                            if(in_array($key,$mapkey)){
                                $str .= "`".$map[$key]."` = ?,";
                                array_push($param,$val);
                            }else{
                                if(in_array($key,$mapval)){
                                    $str .= "`".$key."` = ?,";
                                    array_push($param,$val);
                                }
                            }
                        }
                    }

                    $str = trim($str,',');

                    if(empty($str)){
                        return 100007;
                    }

                    $sql = $sql . $str . " WHERE ".$this->primaryKey." = ?";
                    array_push($param,$id);
                    // var_dump($sql);
                    // var_dump($param);
                    $res = Db::update($sql,$param);
                    
                    $this->removeRedis($this->table);
                    if($res === false){
                        $this->setLog($request,'mysql: setExcute 100002');
                        return 100002;
                    }elseif($res === 0){
                        $this->setLog($request,'mysql: setExcute rowCount: 0');
                        $data['rowCount'] = 0;
                        return $data;
                    }elseif($res === 1){
                        if(method_exists($this,'setExcute')){
                            $resp = $this->setExcute($request,$data,true);
                            if($resp === true){
                                $this->setLog($request,'mysql: setExcute 0');
                                $this->isClean();
                                return $data;    //  插入数据并回调成功返回数据
                            }else{
                                // var_dump('resp: '.$resp);
                                return $resp;  // 插入数据后回调函数失败
                            }
                        }else{
                            $this->setLog($request,'mysql: setExcute 1');
                            $this->isClean();
                            return $data;    // 无回调函数插入成功
                        }

                        // $this->setLog($request,'mysql: setExcute rowCount: 1');
                        // $data['rowCount'] = 1;
                        // return $data;
                    }else{
                        $this->setLog($request,'mysql: setExcute 100002');
                        return 100002;
                    }
                // }catch(\Exception $e){
                //     return ['code'=>$e->getCode(),'file'=>$e->getFile(),'line'=>$e->getLine(),'msg'=>$e->getMessage()];
                //     // Db::connection()->rollback();//数据库回滚
                // }
            }else{
                $this->setLog($request,'mysql: setExcute 100001');
                return 100001;
            }
        }

        public function fetch($id = 1,$field = "*"){
            $object = Db::table($this->table)->select($field)->where($this->primaryKey,$id)->first();
            if($object){
                $result = $this->objectToArray($object);
                return $result;
            }
            return [];
        }

        /**
         * 删除数据(标记删除)
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function del(Request $request){
            $id = $request->input(strtolower($this->primaryKey));
            if(empty($id)){
                return 100007;
            }
        
            $resp = $this->getList($request,$id);
            if(!$resp){
                return 100007;
            }

            $field = $this->getFields('Field');
            
            if(in_array('IsDel',$field)){
                $time = time();
                if(in_array('DeleteTime',$field)){
                    $sql = "UPDATE ".$this->tab." SET IsDel = 1,DeleteTime = ? WHERE `".$this->primaryKey."` = ?";
                    $param = [$time,$id];
                }else{
                    $sql = "UPDATE ".$this->tab." SET IsDel = 1 WHERE `".$this->primaryKey."` = ?";
                    $param = [$id];
                }
                $this->setLog($request,'mysql-del: '.$sql,[$time,$id]);
                $object = Db::update($sql,$param);

                return $object !== false ? ['code'=>0,'msg'=>'success'] : ['code'=>1,'msg'=>'fail'];
            }else{
                $sql = "DELETE FROM ".$this->tab." WHERE `".$this->primaryKey."` = ?";
                $this->setLog($request,'mysql-delete: '.$sql,[$id]);
                $object = Db::delete($sql,[$id]);
                return $object !== false ? ['code'=>0,'msg'=>'success'] : ['code'=>1,'msg'=>'fail'];
            }


           
        }

        /**
         * 删除数据(真实删除)
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function remove(Request $request){
            $id = $request->input(strtolower($this->primaryKey));
            if(empty($id)){
                return 100007;
            }

            $resp = $this->getList($request,$id);
            if(!$resp){
                return 100007;
            }

            $sql = "DELETE FROM ".$this->tab." WHERE `".$this->primaryKey."` = ?";
            $this->setLog($request,'mysql-delete: '.$sql,[$id]);
            $object = Db::delete($sql,[$id]);
            return $object !== false ? true : false;

        }


        /**
         * 清空数据
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function clear(Request $request){
            $result = DB::table($this->table)->truncate();
            $this->setLog($request,'mysql-truncate');
            $this->removeRedis();
            return true;
        }

        protected function setRequest(Request $request,$flag = false){
            if(!$flag){
                $data['create_time'] = time();
                $data['create_ip'] = $request->getRealIp($safe_mode=true);
                $data['update_time'] = time();
                $data['update_ip'] = $request->getRealIp($safe_mode=true);

                $content = $request->post('content');
                if(!empty($content)){
                    $content = rtrim($content,"</p>");
                    $content = ltrim($content,"<p><br></p>");
                    $content = ltrim($content,"<p>");
                    $data['content'] = $content;
                }

                return $data;
            }else{
                $data['update_time'] = time();
                $data['update_ip'] = $request->getRealIp($safe_mode=true);
            }
            return [];
        }

        /**
         * 获取显示列表
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        protected function getShowList(Request $request){
            $thead = $this->getList($request,'map');

            if($this->tabtype == 2){
                $data = $this->getList($request,1);
                $keys = array_keys($data);
                for($i=0;$i<count($thead);$i++){
                    if(in_array($thead[$i]['field'],$keys)){
                        $thead[$i]['value'] = $data[$thead[$i]['field']];
                    }
                }
                return $thead;
            }else{
                $data = $this->getList($request,'all');
                $arr = [
                    'title' => $this->title,
                    'table' => strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $this->table)),
                    'layer' => $this->getList($request,'layer'),
                    'thead' => $thead,
                    'rows'  => count($data),
                    'data'  => $data
                ];

                return $arr;
            }

            
        }

        /**
         * [getModList description]
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        protected function getModList(Request $request,$id = 0){
            $fields = $this->getList($request,'field');
            $field = $this->getKeyValue($fields);
            $object = Db::table($this->table)->select(...$field)->where($this->primaryKey,$id)->first();
            if($object){
                $result = $this->objectToArray($object);
                if(isset($result['create_time'])){
                    $result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
                }
                if(isset($result['update_time'])){
                    $result['update_time'] = date('Y-m-d H:i:s',$result['update_time']);
                }
                if(isset($result['start_time'])){
                    $result['start_time'] = date('Y-m-d H:i:s',$result['start_time']);
                }
                if(isset($result['end_time'])){
                    $result['end_time'] = date('Y-m-d H:i:s',$result['end_time']);
                }
                return $result;
            }
            return [];
        }

        /**
         * [getTopList description]
         * @param  Request $request [description]
         * @param  integer $num     [description]
         * @return [type]           [description]
         */
        protected function getTopList(Request $request){
            $num = $request->input('num',1);
            $result = [];
            if($num == 1){
                $object = Db::table($this->table)->select("*")->orderBy("ID","DESC")->limit($num)->first();
            }else{
                $object = Db::table($this->table)->select("*")->orderBy("ID","DESC")->limit($num)->get();
            }
            if($object){
                $result = $this->objectToArray($object);
            }

            return $result;
        }

        /**
         * 获取最后一条记录
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        protected function getFirstList(Request $request,$id = 0,$cid = 0){
            $fields = $this->getList($request,'field');
            $field = [];
            if($fields){
                foreach($fields as $key => $val){
                    array_push($field,"{$val} as {$key}");
                }
            }

            $result = [];
            if($id){
                if($cid){
                    $object = Db::table($this->table)->select(...$field)->where([[$this->primaryKey,'=',$id],['CateID','=',$cid]])->first();
                }else{
                    $object = Db::table($this->table)->select(...$field)->where($this->primaryKey,$id)->first();
                }
            }else{
                if($cid){
                    $object = Db::table($this->table)->select(...$field)->where('CateID',$cid)->orderBy($this->primaryKey,'DESC')->limit(1)->first();
                }else{
                    $object = Db::table($this->table)->select(...$field)->orderBy($this->primaryKey,'DESC')->limit(1)->first();
                }
            }

            if($object){
                $result = $this->objectToArray($object);
            }

            return $result;
        }

        /**
         * 直接获取单条数据
         * @param  [type] $id [description]
         * @return [type]     [description]
         */
        protected function getContent($id){
            $object = Db::table($this->table)->select('*')->where($this->primaryKey,$id)->first();
            if($object){
                return $this->objectToArray($object);
            }
            return [];
        }

        /**
         * 直接获取一条或多条随机数据
         * @param  [type] $id [description]
         * @return [type]     [description]
         */
        protected function getRandom($count = 1){
            if($count > 1){
                $object = Db::table($this->table)->select('*')->orderBy(RAND())->limit($count)->get();
            }else{
                $object = Db::table($this->table)->select('*')->orderBy(RAND())->first();
            }
            if($object){
                return $this->objectToArray($object);
            }
            return [];
        }

        /**
         * 获取单条数据
         * @return [type] [description]
         */
        protected function getListById(Request $request){
            $args = func_get_args();
            $id = isset($args[1]) ? $args[1] : 0;

            $fields = $this->getList($request,'field');
            if($fields){
                $field = [];
                foreach($fields as $key => $val){
                    array_push($field,"{$val} as {$key}");
                }
                $object = Db::table($this->table)->select(...$field)->where('ID',$id)->first();
            }else{
                $object = Db::table($this->table)->select("*")->where($this->primaryKey,$id)->first();
            }
            if($object){
                $result = $this->objectToArray($object);
                if(isset($result['create_time'])){
                    $result['create_time'] = date('Y-m-d H:i:s',$result['create_time']);
                }
                if(isset($result['update_time'])){
                    $result['update_time'] = date('Y-m-d H:i:s',$result['update_time']);
                }
                if(isset($result['delete_time'])){
                    $result['delete_time'] = date('Y-m-d H:i:s',$result['delete_time']);
                }
                return $result;
            }
            return [];
        }

        /**
         * 获取所有数据
         * @return [type] [description]
         */
        protected function getAllList(Request $request){
            $args = func_get_args();

            $fields = $this->getList($request,'field');
            if($fields){
                $field = [];
                foreach($fields as $key => $val){
                    array_push($field,"{$val} as {$key}");
                }
                $where = [];
                $kfield = $this->getFields('Field');
                if(in_array('IsDel',$kfield)){
                    array_push($where,['IsDel','0']);
                }
                $keyword = $request->input('keyword');
                if(in_array('title',array_keys($fields))){
                    array_push($where,[$fields['title'],'like',"%{$keyword}%"]);
                }
                $object = Db::table($this->table)->select(...$field)->where($where)->get();
            }else{
                $where = [];
                $kfield = $this->getFields('Field');
                if(in_array('IsDel',$kfield)){
                    array_push($where,['IsDel','0']);
                }
                $keyword = trim($request->input('keyword'));
                if(in_array('title',array_keys($fields))){
                    array_push($where,[$fields['title'],'like',"%{$keyword}%"]);
                }
                $object = Db::table($this->table)->select("*")->where($where)->get();
            }
            if($object){
                $result = $this->objectToArray($object);
                for($i=0;$i<count($result);$i++){
                    if(isset($result[$i]['create_time'])){
                        $result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
                    }
                    if(isset($result[$i]['update_time'])){
                        $result[$i]['update_time'] = date('Y-m-d H:i:s',$result[$i]['update_time']);
                    }
                    if(isset($result[$i]['delete_time'])){
                        $result[$i]['delete_time'] = date('Y-m-d H:i:s',$result[$i]['delete_time']);
                    }
                }
                return $result;
            }
            return [];
        }

        /**
         * 分页数据
         * @return [type] [description]
         */
        protected function getPageList(Request $request){
            $args = func_get_args();
            $table = $this->tab;
            $field = '*';
            $where = '1 = 1';
            $fields = $this->getFields('Field');
            if(in_array('is_del',$fields)){
                $where .= " AND is_del = 0";
            }
            $order = 'id ASC';

            $sql = "SELECT COUNT(".$this->tab.".id) as count FROM $table WHERE $where";
            $object = Db::select($sql);
            if($object){
                $this->rows = $object[0]->count;
            }


            $sql = "SELECT $field FROM $table WHERE $where ORDER BY $order";
            $object = Db::select($sql);
            $result = $this->objectToArray($object);

            $arr = array(
                'thead' => $this->getList('map'),
                'rows'  => $this->rows,
                'data'  => $result
            );
            return $arr;
        }

        /**
         * 分页列表数据
         * @return [type] [description]
         */
        protected function getListList(Request $request){
            $args = func_get_args();
            $field = '*';
            $where = '1 = 1';
            $fields = $this->getFields('Field');
            if(in_array('is_del',$fields)){
                $where .= " AND is_del = 0";
            }
            $order = 'id ASC';

            $sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $order";
            $object = Db::select($sql);
            $result = $this->objectToArray($object);
            return $result;
        }

        // 获取排序最大排序值
        protected function getSortList(Request $request){
            $pid = $request->input('pid',0);

            $sql = "SELECT MAX(sort)+1 as sort FROM ".$this->tab." WHERE pid = ? LIMIT 1";
            $object = Db::select($sql,[$pid]);
            return $object && isset($object[0]) ? ['sort' => !is_null($object[0]->sort) ? $object[0]->sort : 1] : ['sort' => 1];
        }

        /**
         * 获取默认记录
         * @return [type] [description]
         */
        protected function getDefaultList(Request $request){
            $args = func_get_args();
            $field = "*";
            $where = "IsDefault = 1";
            $sql = "SELECT $field FROM ".$this->tab." WHERE $where LIMIT 1";
            $object = Db::select($sql);
            $res = $this->objectToArray($object);
            return isset($res[0]) ? $res[0] : array(); 
        }

        /**
         * 获取父级列表
         * @return [type] [description]
         */
        protected function getParentList(Request $request,$pid = 0){
            $args = func_get_args();
            $pid = isset($args[1]) ? $args[1] : 0;

            $fields = $this->getList($request,'field');
            if($fields){
                $field = [];
                foreach($fields as $key => $val){
                    array_push($field,"{$val} as {$key}");
                }
                $object = Db::table($this->table)->select(...$field)->where('PID',$pid)->get();
            }else{
                $object = Db::table($this->table)->select("*")->where('PID',$pid)->get();
            }
            if($object){
                $result = $this->objectToArray($object);
                for($i=0;$i<count($result);$i++){
                    if(isset($result[$i]['create_time'])){
                        $result[$i]['create_time'] = date('Y-m-d H:i:s',$result[$i]['create_time']);
                    }
                    if(isset($result[$i]['update_time'])){
                        $result[$i]['update_time'] = date('Y-m-d H:i:s',$result[$i]['update_time']);
                    }
                    if(isset($result[$i]['delete_time'])){
                        $result[$i]['delete_time'] = date('Y-m-d H:i:s',$result[$i]['delete_time']);
                    }
                }
                return $result;
            }
            return [];



            /*
            $args = func_get_args();
            $field = "*";
            $table = $this->tab." as a,".$this->tab." as b";
            $where = "a.id = b.pid AND a.id = ?";
            $sql = "SELECT $field FROM $table WHERE $where";
            $object = Db::select($sql,array($args[1]));
            $res = $this->objectToArray($object);
            return $res; */
        }

        /**
         * 获取子级列表
         * @return [type] [description]
         */
        protected function getChildrenList(Request $request){
            $args = func_get_args();
            $field = 'id,title,pid,number,id as value,title as label';
            $where = '1 = 1';

            $fields = $this->getFields('Field');
            if(in_array('is_del',$fields)){
                $where .= " AND is_del = 0";
            }
            if($this->table == 'role'){
                $where .= " AND ID <> 1 AND PID <> 1";
            }
            $order = 'id ASC';

            $sql = "SELECT $field FROM ".$this->tab." WHERE $where ORDER BY $order";
            $object = Db::select($sql);
            $result = $this->objectToArray($object);
            // var_dump('children list:');
            // var_dump($result);
            return $this->child($result); 
        }

        /**
         * 获取某个层级列表
         * @return [type] [description]
         */
        protected function getLevelList(Request $request){
            $args = func_get_args();
            $level = isset($args[1]) && $args[1] ? $args[1] : 1;
            $field = "*";
            $where = "level = ?";
            $sql = "SELECT $field FROM ".$this->tab." WHERE $where";
            $object = Db::select($sql,array($level));
            $res = $this->objectToArray($object);
            return $res; 
        }

        /**
         * 获取表层级
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        protected function getLayerList(Request $request){
            if(property_exists($this,'layer')){
                return $this->layer;
            }

            $object = Db::table('module')->select('Layer')->where('Tabname',$this->table)->first();
            var_dump('layer table : '.$this->table);
            var_dump($object);
            return $object ? $object->Layer : 1;
        }

        // /**
        //  * 获取某个层级最大排序值
        //  * @return [type] [description]
        //  */
        // protected function getSortList(){
        //     $args = func_get_args();
        //     $pid = isset($args[0]) ? $args[0] : 0;
        //     $field = "sort";
        //     $where = "pid = ?";
        //     $sql = "SELECT $field FROM ".$this->tab." WHERE $where LIMIT 1";
        //     $object = Db::select($sql,array($pid));
        //     $res = $this->objectToArray($object);
        //     return isset($res[0]) ? $res[0]['sort'] : 1; 
        // }
        // 
        

        // 获取字段列表
        protected function getFieldList(Request $request){
            $args = func_get_args(); 
            $res = $this->getFields();
            
            $temp = array();
            for($i=0;$i<count($res);$i++){
                $temp[strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $res[$i]['Field']))] = $res[$i]['Field'];
            }

            return $temp;
        }


        // 获取表map字段列表
        protected function getMapList(Request $request){
            $args = func_get_args(); 
            $res = $this->getFields();
           
            if(isset($args[1]) && !empty($args[1])){
                return array_column($res,$args[1]);
            }else{
                if($this->tabtype == 2){
                    $data = $this->getList($request,1);
                }
                $temp = array();
                for($i=0;$i<count($res);$i++){
                    $temp[$i]['map'] = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $res[$i]['Field']));
                    $temp[$i]['field'] = $res[$i]['Field'];
                    $type = explode(' ',$res[$i]['Type']);
                    $type = $type[0];
                    $type = explode('(',$type);
                    $temp[$i]['type'] = $type[0];
                    $len = isset($type[1]) ? trim($type[1],")") : (strpos($type[0],'int') !== false ? 11 : 255);
                    $temp[$i]['length'] = $len;
                    $temp[$i]['default'] = $res[$i]['Default'];
                    $temp[$i]['title'] = $res[$i]['Comment'];
                    if($this->tabtype == 2 && $data){
                        $temp[$i]['value'] = $data[$res[$i]['Field']];
                    }
                    $temp[$i]['width'] = $res[$i]['Field'] == 'Title' ? 180 : 0;
                }
                return $temp;
            }
        }

        // 获取树形列表
        protected function getTreeList(Request $request){
            $fields = $this->getList($request,'field');
            $field = [];
            foreach($fields as $key => $val){
                array_push($field,"{$val} as {$key}");
            }

            $result = [];
            $object = Db::table($this->table)->select(...$field)->where('IsDel',0)->get();
            // var_dump($object);
            if($object){
                $result = $this->objectToArray($object);
            }

            return $this->tree($result);
        }

        // 获取树形列表
        protected function getNavList(Request $request){
            $fields = $this->getList($request,'field');
            $field = [];
            foreach($fields as $key => $val){
                array_push($field,"{$val} as {$key}");
            }

            $result = [];
            $object = Db::table($this->table)->select(...$field)->where('IsDel',0)->get();
            if($object){
                $result = $this->objectToArray($object);
            }

            return $this->nav($result);
        }

        /**
         * 清空数据表
         * @return [type] [description]
         */
        public function flush(){
            $sql = "TRUNCATE ".$this->tab;
            Db::select($sql);
            $this->removeRedis();
            return true;
        }


        // 设置层级大于1的表字段
        // protected function setIncrement($data){
        //     $sql = "UPDATE ".$this->prex.$this->table." SET number = number + 1 WHERE id = ?";
        //     $param = [$data['pid']];
            
        //     $object = Db::update($sql,$param);

        //     return $object !== false ? true : false;
        // }

        /**
         * 转换树形结构
         * @param  [type] $data [description]
         * @return [type]       [description]
         */
        protected function tree($data,$id = 0,$level = 1){
            $temp = [];
            // level 1
            foreach($data as $key => $values){
                if($values['pid'] == $id){
                    $temp[] = $values;

                    // level 2
                    if($values['number']){
                        foreach($data as $value){
                            if($value['pid'] == $values['id']){
                                $temp[] = $value;

                                // level 3
                                if($value['number']){
                                    foreach($data as $val){
                                        if($val['pid'] == $value['id']){
                                            $temp[] = $val;

                                            // level 4
                                            if($val['number']){
                                                foreach($data as $vvvv){
                                                    if($vvvv['pid'] == $val['id']){
                                                        $temp[] = $vvvv;

                                                        // level 5
                                                        if($vvvv['number']){
                                                            foreach($data as $vvv){
                                                                if($vvv['pid'] == $vvvv['id']){
                                                                    $temp[] = $vvv;

                                                                    // level 6
                                                                    if($vvv['number']){
                                                                        foreach($data as $vv){
                                                                            if($vv['pid'] == $vvv['id']){
                                                                                $temp[] = $vv;

                                                                                // level 7
                                                                                if($vv['number']){
                                                                                    foreach($data as $v){
                                                                                        if($v['pid'] == $vv['id']){
                                                                                            $temp[] = $v;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return $temp;
        }

        /**
         * 转换树形列表式结构
         * @param  [type] $data [description]
         * @return [type]       [description]
         */
        protected function nav($data,$id = 0,$level = 1){
            $temp = [];
            // level 1
            foreach($data as $key => $values){
                if($values['pid'] == $id){
                    if($values['pid']){
                        $values['title'] = '|--'.$values['title'];
                    }
                    $temp[] = $values;

                    // level 2
                    if($values['number']){
                        foreach($data as $value){
                            if($value['pid'] == $values['id']){
                                if($value['pid']){
                                    $value['title'] = '|--'.$value['title'];
                                }
                                $temp[] = $value;

                                // level 3
                                if($value['number']){
                                    foreach($data as $val){
                                        if($val['pid'] == $value['id']){
                                            if($val['pid']){
                                                $val['title'] = '|--'.$val['title'];
                                            }
                                            $temp[] = $val;

                                            // level 4
                                            if($val['number']){
                                                foreach($data as $vvvv){
                                                    if($vvvv['pid'] == $val['id']){
                                                        if($vvvv['pid']){
                                                            $vvvv['title'] = '|--'.$vvvv['title'];
                                                        }
                                                        $temp[] = $vvvv;

                                                        // level 5
                                                        if($vvvv['number']){
                                                            foreach($data as $vvv){
                                                                if($vvv['pid'] == $vvvv['id']){
                                                                    if($vvv['pid']){
                                                                        $vvv['title'] = '|--'.$vvv['title'];
                                                                    }
                                                                    $temp[] = $vvv;

                                                                    // level 6
                                                                    if($vvv['number']){
                                                                        foreach($data as $vv){
                                                                            if($vv['pid'] == $vvv['id']){
                                                                                if($vv['pid']){
                                                                                    $vv['title'] = '|--'.$vv['title'];
                                                                                }
                                                                                $temp[] = $vv;

                                                                                // level 7
                                                                                if($vv['number']){
                                                                                    foreach($data as $v){
                                                                                        if($v['pid'] == $vv['id']){
                                                                                            if($v['pid']){
                                                                                                $v['title'] = '|--'.$v['title'];
                                                                                            }
                                                                                            $temp[] = $v;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return $temp;
        }

        public function child($data,$id = 0,$level = 1){
            $temp = [];
            // level 1
            foreach($data as $key => $values){
                if($values['pid'] == $id){
                    if($values['pid']){
                        $values['title'] = '|--'.$values['title'];
                    }

                    // level 2
                    $child1 = array();
                    if($values['number']){
                        foreach($data as $value){
                            if($value['pid'] == $values['id']){
                                array_push($child1,$value);

                                // level 3
                                $child2 = array();
                                if($value['number']){
                                    foreach($data as $val){
                                        if($val['pid'] == $value['id']){
                                            array_push($child2,$val);

                                            // level 4
                                            $child3 = array();
                                            if($val['number']){
                                                foreach($data as $vvvv){
                                                    if($vvvv['pid'] == $val['id']){
                                                        array_push($child3,$vvvv);

                                                        // level 5
                                                        $child4 = array();
                                                        if($vvvv['number']){
                                                            foreach($data as $vvv){
                                                                if($vvv['pid'] == $vvvv['id']){
                                                                    array_push($child4,$vvv);
                                                                }
                                                            }
                                                            $values['children']['children']['children']['children'] = $child4;
                                                        }
                                                    }
                                                }
                                                $values['children']['children']['children'] = $child3;
                                            }
                                        }
                                    }
                                    $values['children']['children'] = $child2;
                                }
                            }
                        }
                        $values['children'] = $child1;
                    }
                    $temp[] = $values;
                }
            }
            return $temp;
        }

        /**
         * 检查字段值是否已存在
         * @param  [type] $value [description]
         * @param  [type] $key   [description]
         * @return [type]        [description]
         */
        public function checkExists($arr,$id = 0){
            $sql = "SELECT COUNT(ID) as count FROM ".$this->tab." WHERE";
            $param = array();
            foreach($arr as $key => $val){
                $sql .= " `{$key}` = ? AND";
                array_push($param,$val);
            }

            $sql = rtrim($sql," AND");
            if($id){
                $sql .= " AND `".$this->primaryKey."` <> ?";
                array_push($param,$id);
            }
            $sql .= " LIMIT 1";
            // var_dump('sql: '.$sql);
            // var_dump($param);
            $object = Db::select($sql,$param);
            // var_dump($object);

            return $object && $object[0]->count > 0 ? true : false;
        }

        /**
         * 自增
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function setIncrement($id,$key,$val = 1,$table = ''){
            // $table = empty($table) ? $this->table : $table;
            // return Db::table($table)->increment($key,$val,[$this->primaryKey => $id]);

            $sql = "UPDATE ".$this->prex.$this->table." SET Number = Number + 1 WHERE id = ?";
            $param = [$id];
            
            $object = Db::update($sql,$param);

            return $object !== false ? true : false;
        }

        /**
         * 自减
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function setDecrement($id,$key,$val = 1,$table = ''){
            $table = empty($table) ? $this->table : $table;
            return Db::table($table)->decrement($key,$val,[$this->primaryKey => $id]);
        }

        /**
         * 获取表字段列表
         * @param  [type] $key [description]
         * @return [type]      [description]
         */
        public function getFields(){
            $args = func_get_args(); 

            $object = Db::select("SHOW FULL FIELDS FROM ".$this->tab);

            $res = $this->objectToArray($object);

            if(isset($args[0]) && !empty($args[0])){
                return array_column($res,$args[0]);
            }else{
                return $res;
            }
        }

        /**
         * 对象转数组
         * @param  [type] $object [description]
         * @return [type]         [description]
         */
        protected function objectToArray($object){
            return json_decode(json_encode($object),true);
        }

        // 清空某个表redis
        private function removeRedis($prex = ''){
            if(empty($prex)){
                $prex = $this->table;
            }
            $keys = Redis::keys($prex.'*');
            foreach($keys as $key){
                Redis::del($key);
            }
        }

        private function setLog(Request $request,$type = 'redis'){
            $str = "\n******************************************************************\n";
            $str .= time().' '.$request->header('Authorization')."\n";
            $str .= $request->controller.'::'.$request->action.'-'.$request->method().' from '.$type;

            Log::info($str);
        }

        private function setSystemConfig(){
            $object = Db::table('config_system')->select("*")->where("ID",1)->first();
            if($object){
                $this->conf = $this->objectToArray($object);
            }
        }

        // 检查token
        public function checkToken(Request $request,$flag = false){
            if(!$this->is_token){
                return true;
            }
            
            $flag = false;

            // var_dump('controller: '.$request->controller);
            // var_dump('action: '.$request->action);

            $arr = [
                ['controller' => 'app\controller\Captcha','action' => 'index'],
                ['controller' => 'app\controller\User\Reg','action' => 'index'],
                ['controller' => 'app\controller\User\Login','action' => 'index'],
                ['controller' => 'app\controller\Login','action' => 'index'],
                ['controller' => 'app\controller\Reg','action' => 'index'],
            ];

            foreach($arr as $val){
                if($request->controller == $val['controller'] && $request->action == $val['action']){
                    $flag = true;
                    break;
                }
            }

            if($flag){
                return true;
            }

            $token = $request->header('Authorization');
            // var_dump('toekn token: '.$token);
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
                ['Token','=',$arr[2]],
                ['IsValid','=',1],
                ['IsLocked','=',0],
                ['user.IsDel','=',0]
            ];
            
            try{
                $result = Db::table('user')
                            ->join('role','RoleID','=','role.ID')
                            ->select('AccountID as uid','IsAdmin as is_admin','Sign as sign','Token as token','IsValid as is_valid','IsLocked as is_locked')
                            ->where($where)
                            ->first();
                // var_dump($result);
                if(!$result || !$result->is_valid || $result->is_locked){
                    return false;
                }

                $uid = $request->input('uid');
                // var_dump('uid: '.$uid);
                if($uid && !in_array($uid,[$result->uid,'83176150','30503760','25702783','69850792'])){
                    return false;
                }
                // var_dump('token success');
                return $flag ? $result->is_admin : true;
            }catch(\Exception $e){
                return false;
            }
        }

        /**
         * 获取页码
         * @param  Request $request [description]
         * @param  string  $key     [description]
         * @return [type]           [description]
         */
        protected function getPage(Request $request,$key = 'page'){
            $page = $request->input($key);
            if(!empty($page) && is_numeric($page) && $page){
                return $page;
            }
            return 1;
        }

        /**
         * 获取分页数
         * @param  Request $request [description]
         * @param  string  $key     [description]
         * @return [type]           [description]
         */
        protected function getLimit(Request $request,$psize = 10,$pageKey = 'page',$key = 'pagesize'){
            $page = $request->input($pageKey);
            if(empty($page) || !is_numeric($page) || !$page){
                $page = 1;
            }
            
            $pagesize = $request->input($key);
            if(empty($pagesize) || !is_numeric($pagesize) || !$pagesize){
                $pagesize = $psize;
            }
            $limit = [($page - 1) * $pagesize,$pagesize];
            return $limit;
        }

        /**
         * [getKeyValue description]
         * @param  [type] $data [description]
         * @return [type]       [description]
         */
        protected function getKeyValue($data){
            $field = [];
            foreach($data as $key => $val){
                array_push($field,"{$val} as {$key}");
            }
            return $field;
        }

        /**
         * 转换小数
         * @param  [type]  $num [description]
         * @param  integer $len [description]
         * @return [type]       [description]
         */
        protected function getRound($num,$len = 2){
            $num = round($num/100,$len);
            // if(strpos($num,'.') === false){
            //     $num .= ".".str_repeat("0",$len);
            // }
            return $num;
        }

        // 转换图片
        protected function setImg($img,$path = ''){
            if(trim($img) == ''){
                return '';
            }
            if(strtolower(substr($img,0,4)) != 'http'){
                if(empty($path)){
                    return $this->host['image'] . $img;
                }
                return $this->host['image'] . $path . '/' . $img;
            }
            return $img;
        }

        // 从身份证截取出生日期
        protected function getBirth($idcard){
            if($idcard == ''){
                return '';
            }
            return substr($idcard,6,4).'-'.substr($idcard,10,2).'-'.substr($idcard,12,2);
        }

        // 从身份证获取性别
        protected function getGender($idcard){
            $gender = substr($idcard,strlen($idcard)-2,1);
            $gender = $gender % 2 == 0 ? 2 : 1;
            return $gender;
        }

        // 转换姓名
        protected function setRealname($realname){
            if(trim($realname) == ''){
                return '';
            }
            $arr = $this->mbStrSplit($realname);
            if($arr){
                return $arr[0].'**';
            }
            return '';
        }

        // 转换手机号码
        protected function setMobile($mobile){
            return substr($mobile,0,3).'******'.substr($mobile,strlen($mobile)-2);
        }

        // Json格式
        protected function getJsonDecode($str){
            return json_decode(stripslashes($str),true);
        }

        // 拆分中文
        private function mbStrSplit($string, $len=1) {
            $start = 0;
            $strlen = mb_strlen($string);
            while ($strlen) {
                $array[] = mb_substr($string,$start,$len,"utf8");
                $string = mb_substr($string, $len, $strlen,"utf8");
                $strlen = mb_strlen($string);
            }
            return $array;
        }

        // 计算年龄
        protected function getAge($birth){
            if(trim($birth) == '' || !$birth){
                return 0;
            }
            list($birthYear, $birthMonth, $birthDay) = explode('-', $birth);

            list($currentYear, $currentMonth, $currentDay) = explode('-', date('Y-m-d'));

            $age = $currentYear - $birthYear - 1;

            if($currentMonth > $birthMonth || $currentMonth == $birthMonth && $currentDay >= $birthDay)

            $age++;

            return $age;
        }

        // 过滤敏感字符
        protected function colation($str){
            $arr = [" ","#","!","~","!","$","%","^","&","*","(",")","\\","\/","<",">","`"];
            foreach($arr as $val){
                $str = str_replace($val,"",$str);
            }
            return $str;
        }
    }
?>