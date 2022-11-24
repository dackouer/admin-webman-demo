<?php
	namespace app\lib;

	class Server{
		

		// 获取时间
		public static function getDate($type = '',$endtime = null,$show = null){
			date_default_timezone_set("Asia/Shanghai");
			$time = "";
			switch(strtolower($type)){
				case '':
					$time = time();
					break;
				case 'all':
				case 'ymdhis':
				case 'y-m-d h:i:s':
				case 'y-m-dh:i:s':
					$time = @date('Y-m-d H:i:s');
					break;
				case 'y/m/d h:i:s':
				case 'y/m/dh:i:s':
					$time = @date('y/m/d H:i:s');
					break;
				case 'y.m.d h:i:s':
				case 'y.m.dh:i:s':
					$time = @date('y.m.d H:i:s');
					break;
				case 'y':
					$time = @date('y');
					break;
				case 'm':
					$time = @date('m');
					break;
				case 'd':
					$time = @date('d');
					break;
				case 't':
					$time = @date('t');
					break;
				default:
			}
			return $time;
		}

		// 获取IP
		public static function getIP(){
			static $realip;
		    if($realip !== NULL){
		        return $realip;
		    }

		    if(isset($_SERVER)){
		        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		            foreach($arr as $ip){
		                $ip = trim($ip);
		                if($ip != 'unknown'){
		                    $realip = $ip;
		                    break;
		                }
		            }
		        }else if(isset($_SERVER['HTTP_CLIENT_IP'])){
		            $realip = $_SERVER['HTTP_CLIENT_IP'];
		        }else if(isset($_SERVER['REMOTE_ADDR'])){
		            $realip = $_SERVER['REMOTE_ADDR'];
		        }else{
		            $realip = '0.0.0.0';
		        }
		    }else if(getenv('HTTP_X_FORWARDED_FOR')){
		        $realip = getenv('HTTP_X_FORWARDED_FOR');
		    }else if(getenv('HTTP_CLIENT_IP')){
		        $realip = getenv('HTTP_CLIENT_IP');
		    }else{
		        $realip = getenv('REMOTE_ADDR');
		    }

		    preg_match('/[\\d\\.]{7,15}/', $realip, $onlineip);
		    $realip = (!empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0');
		    return $realip;
		}


		public static function getIPAddress($ip,$flag = false){
			$ipLocation = new \Gai871013\IpLocation\IpLocation();
			$result = $ipLocation->getLocation($ip);
			return !$flag ? $result['country'] : $result;
		}

		// 判断是否移动端
		public static function isWap(){
			// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
			if(isset($_SERVER['HTTP_X_WAP_PROFILE'])){
				return true;
			} 
			// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
			if(isset($_SERVER['HTTP_VIA'])){ 
				// 找不到为flase,否则为true
				return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
			} 
			// 脑残法，判断手机发送的客户端标志,兼容性有待提高
			if(isset($_SERVER['HTTP_USER_AGENT'])){ 
				$clientkeywords = array(
					'nokia',
					'sony',
					'ericsson',
					'mot',
					'samsung',
					'htc',
					'sgh',
					'lg',
					'sharp',
					'sie-',
					'philips',
					'panasonic',
					'alcatel',
					'lenovo',
					'iphone',
					'ipod',
					'blackberry',
					'meizu',
					'android',
					'netfront',
					'symbian',
					'ucweb',
					'windowsce',
					'palm',
					'operamini',
					'operamobi',
					'openwave',
					'nexusone',
					'cldc',
					'midp',
					'wap',
					'mobile'
					); 
				// 从HTTP_USER_AGENT中查找手机浏览器的关键字
				if(preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
					return true;
				} 
			} 
			// 协议法，因为有可能不准确，放到最后判断
			if(isset($_SERVER['HTTP_ACCEPT'])){ 
				// 如果只支持wml并且不支持html那一定是移动设备
				// 如果支持wml和html但是wml在html之前则是移动设备
				if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
					return true;
				} 
			} 
			return false;
		}

		// 获取域名
		public static function domain(){
			$domain = preg_match('/cli/i',php_sapi_name()) ? 'http://'.$_SERVER['HTTP_HOST']: $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
            $domain = preg_match('/cli/i',php_sapi_name()) ? $domain : rtrim(rtrim($domain,'index.php'),'/');
            return $domain;
		}

		// 获取操作系统
		public static function getOS($type = 'name'){
			if(self::isWap()){
				$ua = $_SERVER['HTTP_USER_AGENT'];
		        if (strpos($ua, 'Android') !== false) {
		            preg_match("/(?<=Android )[\d\.]{1,}/", $ua, $version);
		            return 'Platform:Android OS_Version:'.$version[0];
		        } elseif (strpos($ua, 'iPhone') !== false) {
		            preg_match("/(?<=CPU iPhone OS )[\d\_]{1,}/", $ua, $version);
		            return 'Platform:iPhone OS_Version:'.str_replace('_', '.', $version[0]);
		        } elseif (strpos($ua, 'iPad') !== false) {
		            preg_match("/(?<=CPU OS )[\d\_]{1,}/", $ua, $version);
		            return 'Platform:iPad OS_Version:'.str_replace('_', '.', $version[0]);
		        }
		    }else{
		    	$agent = $_SERVER['HTTP_USER_AGENT'];
    	        $os = false;
    	        if (stristr($agent,'win')) {
    	            $os = 'Windows';
    	        }
    	        else if (stristr($agent,'win') && stristr($agent, '95')) {
    	            $os = 'Windows 95';
    	        }
    	        else if (stristr($agent,'win 9x') && stristr($agent, '4.90')) {
    	            $os = 'Windows ME';
    	        }
    	        else if (stristr($agent,'win') && stristr($agent,'98')) {
    	            $os = 'Windows 98';
    	        }
    	        else if (stristr($agent,'win') && stristr($agent,'nt 5.1')) {
    	            $os = 'Windows XP';
    	        }
    	        else if (stristr($agent,'win') && stristr($agent,'nt 5')) {
    	            $os = 'Windows 2000';
    	        }
    	        else if (stristr($agent,'win') && stristr($agent,'nt')) {
    	            $os = 'Windows NT';
    	        }
    	        else if (stristr($agent,'win') && stristr($agent,'32')) {
    	            $os = 'Windows 32';
    	        } else if (stristr($agent,'linux')) {
    	            $os = 'Linux';
    	        }
    	        else if (stristr($agent,'unix')) {
    	            $os = 'Unix';
    	        }
    	        else if (stristr($agent,'sun') && stristr($agent,'os')) {
    	            $os = 'SunOS';
    	        }
    	        else if (stristr($agent,'ibm') && stristr($agent,'os')) {
    	            $os = 'IBM OS/2';
    	        }
    	        else if (stristr($agent,'Mac')) {
    	            $os = 'Mac OS X';
    	        }
    	        else if (stristr($agent,'PowerPC')) {
    	            $os = 'PowerPC';
    	        }
    	        else if (stristr($agent,'AIX')) {
    	            $os = 'AIX';
    	        }
    	        else if (stristr($agent,'HPUX')) {
    	            $os = 'HPUX';
    	        }
    	        else if (stristr($agent,'NetBSD')) {
    	            $os = 'NetBSD';
    	        }
    	        else if (stristr($agent,'BSD')) {
    	            $os = 'BSD';
    	        }
    	        else if (stristr($agent,'OSF1')) {
    	            $os = 'OSF1';
    	        }
    	        else if (stristr($agent,'IRIX')) {
    	            $os = 'IRIX';
    	        }
    	        else if (stristr($agent,'FreeBSD')) {
    	            $os = 'FreeBSD';
    	        }
    	        else if (stristr($agent,'teleport')) {
    	            $os = 'teleport';
    	        }
    	        else if (stristr($agent,'flashget')) {
    	            $os = 'flashget';
    	        }
    	        else if (stristr($agent,'webzip')) {
    	            $os = 'webzip';
    	        }
    	        else if (stristr($agent,'offline')) {
    	            $os = 'offline';
    	        }
    	        else{
    	            $os = 'Unknown';
    	        }

	    	    return $os;
		    }
		}

		// 获取设备型号
		public static function getDevice(){
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
	        if (stripos($user_agent, "iPhone")!==false) {
	            $brand = 'iPhone';
	        } else if (stripos($user_agent, "SAMSUNG")!==false || stripos($user_agent, "Galaxy")!==false || strpos($user_agent, "GT-")!==false || strpos($user_agent, "SCH-")!==false || strpos($user_agent, "SM-")!==false) {
	            $brand = '三星';
	        } else if (stripos($user_agent, "Huawei")!==false || stripos($user_agent, "Honor")!==false || stripos($user_agent, "H60-")!==false || stripos($user_agent, "H30-")!==false) {
	            $brand = '华为';
	        } else if (stripos($user_agent, "Lenovo")!==false) {
	            $brand = '联想';
	        } else if (strpos($user_agent, "MI-ONE")!==false || strpos($user_agent, "MI 1S")!==false || strpos($user_agent, "MI 2")!==false || strpos($user_agent, "MI 3")!==false || strpos($user_agent, "MI 4")!==false || strpos($user_agent, "MI-4")!==false) {
	            $brand = '小米';
	        } else if (strpos($user_agent, "HM NOTE")!==false || strpos($user_agent, "HM201")!==false) {
	            $brand = '红米';
	        } else if (stripos($user_agent, "Coolpad")!==false || strpos($user_agent, "8190Q")!==false || strpos($user_agent, "5910")!==false) {
	            $brand = '酷派';
	        } else if (stripos($user_agent, "ZTE")!==false || stripos($user_agent, "X9180")!==false || stripos($user_agent, "N9180")!==false || stripos($user_agent, "U9180")!==false) {
	            $brand = '中兴';
	        } else if (stripos($user_agent, "OPPO")!==false || strpos($user_agent, "X9007")!==false || strpos($user_agent, "X907")!==false || strpos($user_agent, "X909")!==false || strpos($user_agent, "R831S")!==false || strpos($user_agent, "R827T")!==false || strpos($user_agent, "R821T")!==false || strpos($user_agent, "R811")!==false || strpos($user_agent, "R2017")!==false) {
	            $brand = 'OPPO';
	        } else if (strpos($user_agent, "HTC")!==false || stripos($user_agent, "Desire")!==false) {
	            $brand = 'HTC';
	        } else if (stripos($user_agent, "vivo")!==false) {
	            $brand = 'vivo';
	        } else if (stripos($user_agent, "K-Touch")!==false) {
	            $brand = '天语';
	        } else if (stripos($user_agent, "Nubia")!==false || stripos($user_agent, "NX50")!==false || stripos($user_agent, "NX40")!==false) {
	            $brand = '努比亚';
	        } else if (strpos($user_agent, "M045")!==false || strpos($user_agent, "M032")!==false || strpos($user_agent, "M355")!==false) {
	            $brand = '魅族';
	        } else if (stripos($user_agent, "DOOV")!==false) {
	            $brand = '朵唯';
	        } else if (stripos($user_agent, "GFIVE")!==false) {
	            $brand = '基伍';
	        } else if (stripos($user_agent, "Gionee")!==false || strpos($user_agent, "GN")!==false) {
	            $brand = '金立';
	        } else if (stripos($user_agent, "HS-U")!==false || stripos($user_agent, "HS-E")!==false) {
	            $brand = '海信';
	        } else if (stripos($user_agent, "Nokia")!==false) {
	            $brand = '诺基亚';
	        } else {
	            $brand = 'Other';
	        }
	        return $brand;
		}

		// 获取客户端浏览器
		public static function getAgent($key = 'name'){
			$sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
			if(stripos($sys, "Firefox/") > 0){
				preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
				$exp[0] = "Firefox";
				$exp[1] = $b[1];  //获取火狐浏览器的版本号
			}elseif(stripos($sys, "Maxthon") > 0){
				preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
				$exp[0] = "傲游";
				$exp[1] = $aoyou[1];
			}elseif(stripos($sys, "MSIE") > 0){
				preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
				$exp[0] = "IE";
				$exp[1] = $ie[1];  //获取IE的版本号
			}elseif(stripos($sys, "OPR") > 0){
				preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
				$exp[0] = "Opera";
				$exp[1] = $opera[1];  
			}elseif(stripos($sys, "Edge") > 0){
				//win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
				preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
				$exp[0] = "Edge";
				$exp[1] = $Edge[1];
			}elseif(stripos($sys, "Chrome") > 0){
				preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
				$exp[0] = "Chrome";
				$exp[1] = $google[1];  //获取google chrome的版本号
			}elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
				preg_match("/rv:([\d\.]+)/", $sys, $IE);
				$exp[0] = "IE";
				$exp[1] = $IE[1];
			}elseif(stripos($sys, "Safari/") > 0){
				preg_match("/Safari\/([^;)]+)+/i", $sys, $safari);
				$exp[0] = "Safari";
				$exp[1] = $safari[1];  //获取Safari浏览器的版本号
			}else{
				$exp[0] = "未知浏览器";
				$exp[1] = ""; 
			}
			switch(strtolower($key)){
				case '':
				case null:
				case 'name':
					return $exp[0];
					break;
				case 'version':
					return $exp[1];
					break;
				case 'all':
					return array('name' => $exp[0],'version' => $exp[1]);
					break;
				default:
					return array('name' => $exp[0],'version' => $exp[1]);
			}
		}
	}
?>