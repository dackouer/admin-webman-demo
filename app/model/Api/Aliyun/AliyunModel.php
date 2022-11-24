<?php
	namespace app\model\Api\Aliyun;

	use support\Request;
	use app\lib\Preg;

	use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
	use \Exception;
	use AlibabaCloud\Tea\Exception\TeaError;
	use AlibabaCloud\Tea\Utils\Utils;

	use Darabonba\OpenApi\Models\Config;
	use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
	// sms
	use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
	// idcard
	use AlibabaCloud\SDK\Dytnsapi\V20200217\Dytnsapi;
	use AlibabaCloud\SDK\Dytnsapi\V20200217\Models\TwoElementsVerificationRequest;

	class AliyunModel{
		private $accessKeyId = 'LTAI5tQ5aV8Ta9a9xejSgV3B';
		private $accessKeySecret = 'gzd7D22vkGQCZTD2zZtf8Z9LCKPlnf';

		
		/**
	     * 使用AK&SK初始化账号Client
	     * @param string $accessKeyId
	     * @param string $accessKeySecret
	     * @return Dysmsapi Client
	     */
	    public function createClient(){
	        $config = new Config([
	            // 您的 AccessKey ID
	            "accessKeyId" => $this->accessKeyId,
	            // 您的 AccessKey Secret
	            "accessKeySecret" => $this->accessKeySecret
	        ]);
	        // 访问的域名
	        $config->endpoint = "dysmsapi.aliyuncs.com";
	        return new Dysmsapi($config);
	    }

	    /**
	     * @param string[] $args
	     * @return void
	     */
	    public function sendsms(Request $request){
	        $client = self::createClient();
	        $sendSmsRequest = new SendSmsRequest([
	        	"phoneNumbers" 	=> "18944277727",
	            "signName" 		=> "幻壤",
	            "templateCode" 	=> "SMS_247100041",
	            "templateParam" => "{\"code\":\"1234\"}"
	        ]);
	        $runtime = new RuntimeOptions([]);
	        try {
	            // 复制代码运行请自行打印 API 的返回值
	            $result = $client->sendSmsWithOptions($sendSmsRequest, $runtime);
	            // var_dump($result);
	            return $result;
	        }
	        catch (Exception $error) {
	            // if (!($error instanceof TeaError)) {
	            //     $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
	            // }
	            // // 如有需要，请打印 error
	            // Utils::assertAsString($error->message);

	            return [
	            	'code'	=> $error->getCode(),
	            	'file'	=> $error->getFile(),
	            	'line'	=> $error->getLine(),
	            	'msg'	=> $error->getMessage()
	            ];
	        }
	    }

	    /**
	     * 实名认证二要素
	     * @param  Request $request [description]
	     * @return [type]           [description]
	     */
	    public function idcard(Request $request){
	    	$idcard = trim($request->post('idcard',''));
	    	$realname = $request->post('realname');
	    	$mask = $request->post('mask','SHA256');
	    	$code = $request->post('code');

	    	$data = [
	        	"mask" 			=> $mask,			// 加密方式
	            "inputNumber" 	=> $idcard,			// 身份证号码
	            "authCode" 		=> $code,			// 授权码
	            "name" 			=> $realname		// 姓名
	        ];

	    	$client = self::createClient();

	        $twoElementsVerificationRequest = new TwoElementsVerificationRequest($data);
	        $runtime = new RuntimeOptions([]);
	        try {
	            // 复制代码运行请自行打印 API 的返回值
	            $result = $client->twoElementsVerificationWithOptions($twoElementsVerificationRequest, $runtime);
	            return $result;
	        }
	        catch (Exception $error) {
	            // if (!($error instanceof TeaError)) {
	            //     $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
	            // }
	            // // 如有需要，请打印 error
	            // Utils::assertAsString($error->message);

	            return [
	            	'code'	=> $error->getCode(),
	            	'file'	=> $error->getFile(),
	            	'line'	=> $error->getLine(),
	            	'msg'	=> $error->getMessage()
	            ];
	        }
	    }

	    /**
	     * 核验身份证二要素
	     * @return [type] [description]
	     */
	    public function checkIdcard($idcard,$realname,$code = null,$mask = 'NORMAL'){
	    	$data = [
	        	"mask" 			=> $mask,			// 加密方式
	            "inputNumber" 	=> $idcard,			// 身份证号码
	            "authCode" 		=> $code,			// 授权码
	            "name" 			=> $realname		// 姓名
	        ];

	    	$client = self::createClient();

	        $twoElementsVerificationRequest = new TwoElementsVerificationRequest($data);
	        $runtime = new RuntimeOptions([]);
	        try {
	            // 复制代码运行请自行打印 API 的返回值
	            $result = $client->twoElementsVerificationWithOptions($twoElementsVerificationRequest, $runtime);
	            return $result;
	        }
	        catch (Exception $error) {
	            // if (!($error instanceof TeaError)) {
	            //     $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
	            // }
	            // // 如有需要，请打印 error
	            // Utils::assertAsString($error->message);

	            return [
	            	'code'	=> $error->getCode(),
	            	'file'	=> $error->getFile(),
	            	'line'	=> $error->getLine(),
	            	'msg'	=> $error->getMessage()
	            ];
	        }
	    }

	    /**
	     * 阿里云第三方核验身份证二要素
	     * @return [type] [description]
	     */
	    public function checkThirdIdcard($idcard,$realname){
	    	$appKey = '204093453';
	    	$appSecret = '9bleO4DsndQQwC6431LClfXxFOwFERng';
	    	$appcode = 'acf4621f2edc449eb29ed9b3d4906503';
	    	$realname = urlencode($realname);

	    	$host = "https://bcustomer.market.alicloudapi.com";
    	    $path = "/Idcheck/IdPost";
    	    $method = "POST";
    	    $headers = array();
    	    array_push($headers, "Authorization:APPCODE " . $appcode);
    	    //根据API的要求，定义相对应的Content-Type
    	    array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
    	    $querys = "";
    	    $bodys = "cardNo={$idcard}&realName={$realname}";
    	    $url = $host . $path;

    	    $curl = curl_init();
    	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    	    curl_setopt($curl, CURLOPT_URL, $url);
    	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	    curl_setopt($curl, CURLOPT_HEADER, true);
    	    if (1 == strpos("$".$host, "https://"))
    	    {
    	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    	    }
    	    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
    	    $result = curl_exec($curl);
    	    $temp = explode("{",$result);
    	    $result = substr($result,strlen($temp[0]));
    	    // var_dump('原结果：');
    	    // var_dump(json_encode($result));
    	    $result = json_decode($result,true);
    	    // var_dump($result);
    	    return $result;

	    }

	    // http_curl
	    private function http_curl($url,$data,$headers = [],$method = 'POST'){
	    	$curl = curl_init();
    	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    	    curl_setopt($curl, CURLOPT_URL, $url);
    	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	    curl_setopt($curl, CURLOPT_HEADER, true);
    	    if (1 == strpos("$".$host, "https://"))
    	    {
    	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    	    }
    	    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
    	    $result = curl_exec($curl);

    	    return $result;
	    }
	}
?>