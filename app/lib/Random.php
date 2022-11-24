<?php
	namespace app\lib;

	class Random{
		/**
		 * 生成随机数
		 * @param  integer $len  [description]
		 * @param  integer $type [description]
		 * @return [type]        [description]
		 */
		public static function create($length = 6,$type = 1){
			$arr = array();
   			for($i=0;$i<50;$i++){
   				$arr[] = md5(uniqid(md5(microtime(true)),true));
   			}
   			$val = array_values($arr);
   			$temp = [];
   			foreach($val as $k => $v){
   				if($v > 1){
   					$ten = '';
   					$len = strlen($v);
   					for($i=1;$i<=$len;$i++){
   						$char = substr($v,0-$i,1);//反向获取单个字符
   						$int = is_numeric($char) ? $char : ord($char);
   						$ten .= $int;
   					}

   					$temp[$k] = $ten;
   				}
   			}
        
   			$str = '786325719';
   			$temp_val = $temp[array_rand($temp)];
   			$temp_str = str_shuffle($str);
   			$num = $temp_str[mt_rand(0,8)];
   			for($i=0;$i<$length-1;$i++){
	   			$num .= $temp_val[mt_rand(0,strlen($temp_val)-1)];
   			}

			return $num;
		}

    // 创建随机字符串
    public static function character($length = 16){
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $str = "";
      for($i=0;$i<$length;$i++){
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
      }
      return $str;
    }

    // 创建token
    public static function token($length = 32,$str = 'LasdDFdlksdflksdls'){
        $chars = uniqid(mt_rand(), true) . '-' . $str;
        $chars = md5($chars);   
        return $chars;
    }

      /**
       * 生成uuid
       * @param  string $str [description]
       * @return [type]      [description]
       */
      public static function uuid($str = 'jlkLuewBm'){
         $chars = uniqid(mt_rand(), true) . '-' . $str;
         $chars = md5($chars);  
          $uuid = substr ( $chars, 0, 8 ) . '-'
                  . substr ( $chars, 8, 4 ) . '-' 
                  . substr ( $chars, 12, 4 ) . '-'
                  . substr ( $chars, 16, 4 ) . '-'
                  . substr ( $chars, 20, 12 );  
          return $uuid;
      }

      /**
       * 生成邀请码
       * @param  string $str [description]
       * @return [type]      [description]
       */
      public static function invite($str = '',$salt = 'jlkLuewBm'){
          if(empty($str)){
            $str = uniqid(mt_rand(), true);
          }
          // var_dump('str: '.$str);
          $str = str_replace("-","",$str) . $salt;
          $str = str_shuffle($str);

          $str1 = substr($str, floor(strlen($str) / 7),6);
          $str2 = substr($str, floor(strlen($str) / 6),6);
          $str3 = substr($str, floor(strlen($str) / 5),6);
          $str4 = substr($str, floor(strlen($str) / 4),6);
          $str5 = substr($str, floor(strlen($str) / 3),6);
          $str6 = substr($str, floor(strlen($str) / 2),6);

          $code = substr(ltrim($str1,0),0,1)
              .substr($str2,1,1)
              .substr($str3,2,1)
              .substr($str4,3,1)
              .substr($str5,4,1)
              .substr($str3,3,1)
              .substr($str5,1,1);
              //.substr($str6,5,1);

          return strtoupper($code);
      }

      /**
       * 生成Token
       * @param  string $str [description]
       * @return [type]      [description]
       */
      // public static function token($str = 'jlkLuewBm'){
      //    $chars = uniqid(mt_rand(), true) . '-' . $str;
      //    $chars = md5($chars);  
      //     $uuid = substr ( $chars, 0, 8 ) . '-'
      //             . substr ( $chars, 8, 4 ) . '-' 
      //             . substr ( $chars, 12, 4 ) . '-'
      //             . substr ( $chars, 16, 4 ) . '-'
      //             . substr ( $chars, 20, 12 );  
      //     return $uuid;
      // }
	}
?>