<?php
	namespace app\controller;
	
	use support\Request;
	use support\Redis;
	use app\lib\Json;
	use Gregwar\Captcha\CaptchaBuilder;

	class Captcha{
		private $key = 'numcode';

		public function index(Request $request,$token = ''){
			$token = $request->input('token');
			if(empty($token)){
				return Json::show(100010);
			}

			$builder = new CaptchaBuilder();
			// 生成验证码
			$builder->build();
			// 获取code
			$code = strtolower($builder->getPhrase());
			Redis::set($token.'_numcode',$code);
			// var_dump($token.'_numcode: '.$code);
			// 获取图片二进制数据
			$img = $builder->get();
			return response($img,200,['Content-Type' => 'image/jpeg']);






			// $token = $request->get('token');
			// if(empty($token) || $token == null){
			// 	return json(['code' => 10100, 'msg' => '无效的token']);
			// }
			// $this->key = $token . '_numcode';
			// // var_dump('key: '.$this->key);
			// // 初始化验证码类
	  //       $builder = new CaptchaBuilder;
	  //       // 生成验证码
	  //       $builder->build();
	        
	  //       // 将验证码的值存储到session中
	  //       // $request->session()->set($this->key, strtolower($builder->getPhrase()));
	  //       // var_dump('session:'.$request->session()->get($this->key));
	       
	  //       // 将验证码的值存储到redis中
	  //       Redis::set($this->key, strtolower($builder->getPhrase()));
	  //       // var_dump('numcode '.$this->key.': '.Redis::get($this->key));
	        
	  //       // 获得验证码图片二进制数据
	  //       $img_content = $builder->get();
	  //       // 输出验证码二进制数据
	  //       return response($img_content, 200, ['Content-Type' => 'image/jpeg']);
		}

		public function check(Request $request){
			// 获取post请求中的captcha字段
	        $captcha = $request->post($this->key);
	        // var_dump($request->session());
	        // 对比session中的captcha值
	        if (strtolower($captcha) !== $request->session()->get($this->key)) {
	            return false;
	        }
	        return true;
		}
	}
?>