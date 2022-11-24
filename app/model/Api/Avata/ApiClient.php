<?php

    namespace app\model\Api\Avata;

    use support\Request;

    class ApiClient
    {
        private $product = true;
        private $apiKey = "42E2Q0E8C151q0h9b0N2J5M816F9K00";
        private $apiSecret = "9222D0q8o191e0y9h042G5P8o6S960L";
        private $domain = "https://apis.avata.bianjie.ai";//test
        private $chain_address = "0xF4E18AEFF4BA6220D8310AD0B24470585F4E8D64";//test

        public function __construct(){
            $this->setConfig();
        }

        // 创建链账户示例
        function create(Request $request){
            $title = trim($request->post('title'));
            if(empty($title)){
                return 300201;
            }

            if(strlen($title) < 1 || strlen($title) > 20){
                return 300202;
            }

            $body = [
                "name"         => $title,                   // 链账户名称
                "operation_id" => $this->getOperationId()
            ];

            $res = $this->request("/v1beta1/account", [], $body, "POST");
            // var_dump($res);
            return $res;
        }

        /**
         * 批量创建链账户
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function batch_create(Request $request){
            $count = $request->post('count',1);
            if(empty($count) || !is_numeric($count) || !$count){
                return 300207;
            }

            $path = '/v1beta1/accounts';

            $body = [
                'count'         => (int)$count,                      // 批量创建链账户的数量
                'operation_id'  => $this->getOperationId()      // 操作ID
            ];

            $result = $this->request($path,[],$body,'POST');

            return $result;
        }

        // 查询链账户
        function account(Request $request){
            $offset = $request->input('offset','0');
            $limit = $request->input('limit','10');
            $account = $request->input('account','');
            $start_date = $request->input('start_date','');
            $end_date = $request->input('end_date','');
            $sort_by = $request->input('sort_by','DATE_DESC');
            $title = $request->input('title','天雄星');
            $operation_id = $this->getOperationId();

            $query = [
                'offset'        => $offset,             // 游标，默认为 0
                'limit'         => $limit,              // 每页记录数，默认为 10，上限为 50
                'account'       => $account,            // 链账户地址
                'start_date'    => $start_date,         // 创建日期范围 - 开始，yyyy-MM-dd（UTC 时间）
                'end_date'      => $end_date,           // 创建日期范围 - 结束，yyyy-MM-dd（UTC 时间）
                'sort_by'       => $sort_by,            // 排序规则：DATE_ASC / DATE_DESC
                'operation_id'  => $operation_id,       // 操作 ID
                'name'          => $title,              // 链账户名称，支持模糊查询
            ];
            // var_dump($query);
            $res = $this->request("/v1beta1/accounts", $query, [], "GET");
            return $res;
        }

        /**
         * 查询链账户操作记录
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function account_record(Request $request){
            $path = '/v1beta1/accounts/history';

            $offset = $request->input('offset','0');
            $limit = $request->input('limit','10');
            $account = $request->input('account','');
            $module = $request->input('module','nft');
            $operation = $request->input('operation','transfer_class');
            $start_date = $request->input('start_date','');
            $end_date = $request->input('end_date','');
            $sort_by = $request->input('sort_by','DATE_DESC');
            $tx_hash = $request->input('tx_hash','');

            $query = [
                'offset'        => $offset,             // 游标，默认为 0
                'limit'         => $limit,              // 每页记录数，默认为 10，上限为 50
                'account'       => $account,            // 链账户地址
                'module'        => $module,             // 功能模块：nft / mt
                'operation'     => $operation,          // 操作类型，仅 module 不为空时有效，默认为 "all"， module = nft 时可选：transfer_class / mint / edit / transfer / burn / issue_class module = mt 时可选：transfer_class / issue / mint / edit / transfer / burn / issue_class
                'start_date'    => $start_date,         // 创建日期范围 - 开始，yyyy-MM-dd（UTC 时间）
                'end_date'      => $end_date,           // 创建日期范围 - 结束，yyyy-MM-dd（UTC 时间）
                'sort_by'       => $sort_by,            // 排序规则：DATE_ASC / DATE_DESC
                'tx_hash'       => $tx_hash,            // Tx Hash
            ];

            $result = $this->request($path, $query, [], "GET");
            return $result;
        }

        /**
         * 创建NFT类别
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function create_cate(Request $request){
            $path = '/v1beta1/nft/classes';

            $title = $request->post('title','测试类别一');
            $class_id = $request->post('class_id','');
            $symbol = $request->post('symbol','');
            $description = $request->post('description','');
            $uri = $request->post('uri','');
            $uri_hash = $request->post('uri_hash','');
            $data = $request->post('data','');
            $owner = $request->post('owner',$this->chain_address);
            $tag = $request->post('tag','');
            $operation_id = $this->getOperationId();

            if(empty($title)){
                return 300203;
            }
            var_dump('len: '.strlen($title));
            if(strlen($title) < 1 || strlen($title) > 20){
                return 300204;
            }

            if(empty($owner)){
                return 300208;
            }

            $body = [
                'name'          => $title,
                'class_id'      => $class_id,
                'symbol'        => $symbol,
                'description'   => $description,
                'uri'           => $uri,
                'uri_hash'      => $uri_hash,
                'data'          => $data,
                'owner'         => $owner,
                // 'tag'           => [],
                'operation_id'  => $operation_id,
            ];

            $result = $this->request($path, [], $body, "POST");
            return $result; 

            // $result = [
            //     'task_id'       => 'Txx1660229751',
            //     'operation_id'  => 'Txx1660229751',
            // ];
            // {
            //   "id": "avatarsj1zyrai0ibznssqxvpukvbsoa",
            //   "name": "娴嬭瘯绫诲埆涓€",
            //   "owner": "0xF8AF1F7F4A5FE6F1217B466D94ABE1B804E2E52C",
            //   "tx_hash": "0x086BA256FDE8B93FB3AD2E2CAB41EE696DC028E61302951AA9D9FCE255A21039",
            //   "symbol": "",
            //   "nft_count": 0,
            //   "uri": "",
            //   "timestamp": "2022-08-11 14:55:51 +0000 UTC"
            // }
        }

        /**
         * 查询 NFT 类别
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function get_cate(Request $request){
            $path = '/v1beta1/nft/classes';

            $offset = $request->input('offset','0');
            $limit = $request->input('limit','10');
            $id = $request->input('id','');
            $title = $request->input('title','');
            $owner = $request->input('owner','');
            $start_date = $request->input('start_date','');
            $end_date = $request->input('end_date','');
            $sort_by = $request->input('sort_by','DATE_DESC');
            $tx_hash = $request->input('tx_hash','');

            $query = [
                'offset'        => $offset,             // 游标，默认为 0
                'limit'         => $limit,              // 每页记录数，默认为 10，上限为 50
                'id'            => $id,                 // NFT 类别 ID
                'name'          => $title,              // NFT 类别名称，支持模糊查询
                'owner'         => $owner,              // NFT 类别权属者地址
                'start_date'    => $start_date,         // 创建日期范围 - 开始，yyyy-MM-dd（UTC 时间）
                'end_date'      => $end_date,           // 创建日期范围 - 结束，yyyy-MM-dd（UTC 时间）
                'sort_by'       => $sort_by,            // 排序规则：DATE_ASC / DATE_DESC
                'tx_hash'       => $tx_hash,            // 创建 NFT 类别的 Tx Hash
            ];

            $result = $this->request($path, $query, [], "GET");
            return $result;
        }

        /**
         * 查询交易结果
         * @param  [type] $operation_id [description]
         * @return [type]               [description]
         */
        public function getTransaction(Request $request,$operation_id){
            $path = '/v1beta1/tx/'.$operation_id;
           
            $res = $this->request($path, [], [], "GET");
            return $res;
        }

        /**
         * 直接查询交易结果
         * @param  [type] $operation_id [description]
         * @return [type]               [description]
         */
        public function getTransactionData($operation_id){
            $path = '/v1beta1/tx/'.$operation_id;
           
            $res = $this->request($path, [], [], "GET");
            var_dump($res);
            return $res;
        }

        /**
         * 发行 NFT
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function issue(Request $request){
            $cate_id = $request->input('cate_id');
            $title = $request->input('title');
            $uri = $request->input('uri','');
            $uri_hash = $request->input('uri_hash','');
            $data = $request->input('data','');
            $recipient = $request->input('recipient');
            $tag = $request->input('tag','');
            $flag = $request->input('flag',0);
            $operation_id = $this->getOperationId();

            if(empty($cate_id) || !$cate_id){
                return 300203;
            }

            if(empty($title)){
                return 300205;
            }
            if(strlen($title) < 1 || strlen($title) > 64){
                return 300206;
            }

            $path = '/v1beta1/nft/nfts/'.$cate_id;

            $body = [
                'name'              => $title,            // NFT 名称
                // 'uri'               => $uri,              // 链外数据链接
                // 'uri_hash'          => $uri_hash,         // 链外数据 Hash
                // 'data'              => $data,             // 自定义链上元数据
                // 'recipient'         => $recipient,        // NFT 接收者地址，支持任一文昌链合法链账户地址，默认为 NFT 类别的权属者地址
                // 'tag'               => $tag,              // 交易标签, 自定义 key：支持大小写英文字母和汉字和数字，长度6-12位，自定义 value：长度限制在64位字符，支持大小写字母和数字
                'operation_id'      => $operation_id,     // 操作 ID
            ];

            $result = $this->request($path, [], $body, "POST");
            // var_dump('operation_id: '.$operation_id);
            // var_dump($result);
            if($flag){
                if($result && isset($result['data']['operation_id'])){
                    var_dump('hhhhhh');
                    $result = $this->getTransaction($request,$operation_id);
                    var_dump($result);
                }
            }

            return $result;
        }

        /**
         * 转让 NFT
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function transfer(Request $request){
            $id = $request->post('id');
            $cate_id = $request->post('cate_id');
            $owner = $request->post('owner');

            $recipient = $request->post('recipient');
            $tag = $request->post('tag','');
            $operation_id = $this->getOperationId();

            if(empty($id) || !$id){
                return 300209;
            }

            if(empty($cate_id) || !$cate_id){
                return 300203;
            }

            if(empty($owner) || !$owner){
                return 300208;
            }

            if(empty($recipient) || !$recipient){
                return 300210;
            }

            $path = '/v1beta1/nft/nft-transfers/'.$cate_id.'/'.$owner.'/'.$id;

            $body = [
                'recipient'         => $recipient,        // NFT 名称
                'tag'               => $tag,              // 交易标签
                'operation_id'      => $operation_id,     // 操作 ID
            ];

            $result = $this->request($path, [], $body, "POST");
            return $result;
        }

        /**
         * 编辑 NFT
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function edit(Request $request){
            $id = $request->post('id');
            $cate_id = $request->post('cate_id');
            $owner = $request->post('owner');

            $title = $request->post('title');
            $uri = $request->post('uri');
            $data = $request->post('data');
            $tag = $request->post('tag','');
            $operation_id = $this->getOperationId();

            if(empty($id) || !$id){
                return 300209;
            }

            if(empty($cate_id) || !$cate_id){
                return 300203;
            }

            if(empty($owner) || !$owner){
                return 300208;
            }

            $path = '/v1beta1/nft/nfts/'.$cate_id.'/'.$owner.'/'.$id;

            $body = [
                'name'              => $title,          // NFT 名称
                'uri'               => $uri,            // NFT 名称
                'data'              => $data,           // NFT 名称
                'tag'               => $tag,            // 交易标签
                'operation_id'      => $operation_id,   // 操作 ID
            ];

            $result = $this->request($path, [], $body, "POST");
            return $result;
        }

        /**
         * 销毁 NFT
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function destroy(Request $request){
            $id = $request->post('id');
            $cate_id = $request->post('cate_id');
            $owner = $request->post('owner');

            $tag = $request->post('tag','');
            $operation_id = $this->getOperationId();

            if(empty($id) || !$id){
                return 300209;
            }

            if(empty($cate_id) || !$cate_id){
                return 300203;
            }

            if(empty($owner) || !$owner){
                return 300208;
            }

            $path = '/v1beta1/nft/nfts/'.$cate_id.'/'.$owner.'/'.$id;

            $body = [
                'tag'               => $tag,            // 交易标签
                'operation_id'      => $operation_id,   // 操作 ID
            ];

            $result = $this->request($path, [], $body, "POST");
            return $result;
        }

        /**
         * 查询 NFT
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function get_issue(Request $request){
            $path = '/v1beta1/nft/nfts';

            $offset = $request->input('offset','0');
            $limit = $request->input('limit','10');
            $id = $request->input('id','');
            $title = $request->input('title','');
            $class_id = $request->input('class_id','');
            $owner = $request->input('owner',$this->chain_address);
            $status = $request->input('status','active');
            $start_date = $request->input('start_date','');
            $end_date = $request->input('end_date','');
            $sort_by = $request->input('sort_by','DATE_DESC');
            $tx_hash = $request->input('tx_hash','');

            $query = [
                'offset'        => $offset,             // 游标，默认为 0
                'limit'         => $limit,              // 每页记录数，默认为 10，上限为 50
                'id'            => $id,                 // 链账户地址
                'name'          => $title,              // 功能模块：nft / mt
                'class_id'      => $class_id,           //
                'owner'         => $owner,              //
                'status'        => $status,             //
                'start_date'    => $start_date,         // 创建日期范围 - 开始，yyyy-MM-dd（UTC 时间）
                'end_date'      => $end_date,           // 创建日期范围 - 结束，yyyy-MM-dd（UTC 时间）
                'sort_by'       => $sort_by,            // 排序规则：DATE_ASC / DATE_DESC
                'tx_hash'       => $tx_hash,            // Tx Hash
            ];

            $result = $this->request($path, $query, [], "GET");
            return $result;
        }

        /**
         * 查询 NFT 详情
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function detail(Request $request){

            $class_id = $request->input('class_id','avatarsj1zyrai0ibznssqxvpukvbsoa');
            $id = $request->input('id','2641469');
            $path = '/v1beta1/nft/nfts/'.$class_id.'/'.$id;

            $result = $this->request($path, [], [], "GET");
            return $result;
        }

        /**
         * 购买能量值/业务费
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function order(Request $request){

            $account = trim($request->post('account',''));
            $amount = $request->post('amount');
            $order_type = $request->post('order_type');
            $order_id = $request->post('order_id');

            if(empty($account)){
                return 100734;
            }
            if(empty($amount) || !is_numeric($amount) || !$amount){
                return 100771;
            }
            if(empty($order_type) || !is_array($order_type,['gas','business'])){
                return 100772;
            }
            if(empty($order_id)){
                $order_id = date('Ymd').$this->getMillisecond();
            }

            $path = '/v1beta1/nft/orders';

            $body = [
                'account'        => $account,             // 链账户地址
                'amount'         => $amount,             // 链账户地址
                'order_type'     => $order_type,             // 链账户地址
                'order_id'       => $order_id,             // 链账户地址
            ];

            $result = $this->request($path, [], $body, "POST");
            return $result;
        }

        /**
         * 查询能量值/业务费购买结果列表
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function charges(Request $request){
            $path = '/v1beta1/orders';

            $offset = $request->input('offset','0');
            $limit = $request->input('limit','10');
            $status = $request->input('status','');
            $start_date = $request->input('start_date','');
            $end_date = $request->input('end_date','');
            $sort_by = $request->input('sort_by','DATE_DESC');

            $query = [
                'offset'        => $offset,             // 游标，默认为 0
                'limit'         => $limit,              // 每页记录数，默认为 10，上限为 50
                'status'        => $status,             // 订单状态：success 充值成功 / failed 充值失败 / pending 正在充值
                'start_date'    => $start_date,         // 创建日期范围 - 开始，yyyy-MM-dd（UTC 时间）
                'end_date'      => $end_date,           // 创建日期范围 - 结束，yyyy-MM-dd（UTC 时间）
                'sort_by'       => $sort_by,            // 排序规则：DATE_ASC / DATE_DESC
            ];

            $result = $this->request($path, $query, [], "GET");
            return $result;
        }

        /**
         * 查询能量值/业务费购买结果
         * @param  Request $request [description]
         * @return [type]           [description]
         */
        public function charge(Request $request,$order){

            if(empty($order)){
                return 100773;
            }

            $path = '/v1beta1/orders/'.$order;

            $result = $this->request($path, [], [], "GET");
            return $result;
        }

        /**
         * 生成operation_id
         * @return [type] [description]
         */
        private function getOperationId(){
            return "Txx".$this->getMillisecond();
        }


        function request($path, $query = [], $body = [], $method = 'GET')
        {
            $method = strtoupper($method);
            $apiGateway = rtrim($this->domain, '/') . '/' . ltrim($path,
                    '/') . ($query ? '?' . http_build_query($query) : '');
            $timestamp = $this->getMillisecond();
            $params = ["path_url" => $path];
            if ($query) {
                // 组装 query
                foreach ($query as $k => $v) {
                    $params["query_{$k}"] = $v;
                }
            }
            if ($body) {
                // 组装 post body
                foreach ($body as $k => $v) {
                    $params["body_{$k}"] = $v;
                }
            }
            // 数组递归排序
            $this->SortAll($params);
            $hexHash = hash("sha256", "{$timestamp}" . $this->apiSecret);
            if (count($params) > 0) {
                // 序列化且不编码
                $s = json_encode($params,JSON_UNESCAPED_UNICODE);
                $hexHash = hash("sha256", stripcslashes($s . "{$timestamp}" . $this->apiSecret));
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiGateway);
            $header = [
                "Content-Type:application/json",
                "X-Api-Key:{$this->apiKey}",
                "X-Signature:{$hexHash}",
                "X-Timestamp:{$timestamp}",
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $jsonStr = $body ? json_encode($body) : ''; //转换为json格式
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
                if ($jsonStr) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
                }
            } elseif ($method == 'PATCH') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                if ($jsonStr) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
                }
            } elseif ($method == 'PUT') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                if ($jsonStr) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
                }
            } elseif ($method == 'DELETE') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if ($jsonStr) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
                }
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);

           /*
            * 部分PHP版本curl默认不验证https证书，返回NULL,可添加以下配置或更换版本尝试
            * curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            * curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
            * //默认验证正规CA颁发的https证书
            *
            * */

            return $response;

        }


        function SortAll(&$params){
            if (is_array($params)) {
                ksort($params);
            }
            foreach ($params as &$v){
                if (is_array($v)) {
                    $this->SortAll($v);
                }
            }
        }

        /** get timestamp
         *
         * @return float
         */
        private function getMillisecond()
        {
            list($t1, $t2) = explode(' ', microtime());
            return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)));
        }

        // 设置参数项
        private function setConfig(){
            if(!$this->product){
                $this->config = [
                    'platform'      => '测试链（IRITA-OPB）',                            // 底层链平台
                    'chain_id'      => 'testnet',                                      // Chain ID
                    'pname'         => 'Avata平台测试项目',                              // 项目名称
                    'item_id'       => 'G2W230U7j1y2Q048',                             // 项目 ID
                    'apikey'        => 'p2x2K007o142w008S3m4Y1E7t06744Y',              // API Key
                    'apisecret'     => 'c2x2t0k7b182w0v8s3U4u1e7c0U7W43',              // API Secret
                    'apiurl'        => 'https://stage.apis.avata.bianjie.ai/',         // API 服务请求域名
                    'chain_address' => '0xF8AF1F7F4A5FE6F1217B466D94ABE1B804E2E52C'    // 平台链账户地址
                ];
            }else{
                $this->config = [
                    'platform'      => 'BSN 文昌链-DDC',
                    'chain_id'      => 'wenchangchain',
                    'pname'         => '天雄星',
                    'item_id'       => '82D2R0p8W0t5r0v7',
                    'apikey'        => '42E2Q0E8C151q0h9b0N2J5M816F9K00',
                    'apisecret'     => '9222D0q8o191e0y9h042G5P8o6S960L',
                    'apiurl'        => 'https://apis.avata.bianjie.ai/',
                    'chain_address' => '0xF8AF1F7F4A5FE6F1217B466D94ABE1B804E2E52C'    // 平台链账户地址
                ];
            }

            $this->apiKey = $this->config['apikey'];
            $this->apiSecret = $this->config['apisecret'];
            $this->domain = $this->config['apiurl'];
            $this->chain_address = $this->config['chain_address'];
        }

    }

?>