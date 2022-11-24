<?php
	namespace app\lib;

	use support\Request;

	class Upload{
		private $file = 'file';				// 表单name
		private $path = 'upload';			// 上传路径
		private $type = 'image';			// 支持上传类型
		private $randname = true;			// 文件重命名
		private $maxsize = 50*1024*1024*8;	// 允许上传大小 5M
		private $base64 = false;			// 使用base64文件编码
		private $file_name;            		// 文件名
		private $file_type;             	// 文件类型(文件后缀)
		private $file_size;             	// 文件大小
		private $file_data;			  		// cli上传数据
		private $new_name;              	// 新文件名
		private $ext = array(
			'image' => array('gif','jpg','jpeg','png','bmp'),
			'images' => array('gif','jpg','jpeg','png','bmp','pdf'),
			'flash' => array('swf','flv'),
			'media' => array('swf','flv','mp3','mp4','wav','wma','wmv','mid','avi','mpg','asf','rm','rmvb'),
			'file' => array('pdf','doc','docx','xls','xlsx','csv','ppt','pptx','htm','html','txt','zip','rar','7z','gz','bz2'),
			'rar' => array('rar','zip','psd'),
			'ppt' => array('ppt','pptx'),
			'wx' => array('pem','p12','cer'),
			'app' => array('apk','ipa')
		);	
		private $url = 'http://rkf3z1cfp.hn-bkt.clouddn.com/';
		private $imageurl = 'http://rkf3z1cfp.hn-bkt.clouddn.com/';
		private $error = 0;					// 错误代码
		private $message = '';				// 提示信息

		// 构造函数
		public function __construct($path = '',$file = '',$type = '',$randname = '',$maxsize = ''){
			if(!empty($file)){
				$this->file = $file;
			}
			if(!empty($path)){
				$this->path = $path;
			}
			$this->path = rtrim($this->path,'/') . '/';
			if(!empty($type)){
				$this->type = strtolower($type);
			}
			if(!empty($randname)){
				$this->randname = $randname;
			}
			if(!empty($maxsize)){
				$this->maxsize = $maxsize * 1024 * 8;
			}

			$this->setConfig();
		}

		private function setConfig(){
			$this->path = './public/' . trim(trim($this->path,'.'),'/') . '/';
		}

		public function setPath($path){
			$this->path = './public/' . trim(trim($this->path,'.'),'/') . '/';
			return $this;
		}

		// 上传
		public function upload(Request $request){
			$type = $request->input('type');
			$path = $request->input('path');
			$host = $request->host(true);
			$url = '';

			if(!empty($type)){
				$this->type = strtolower($type);
			}

			if(!empty($path)){
				if($path == 'images'){
					$this->path = trim($path) . '/' . date('Ymd') . '/';
					$url = $this->imageurl;
				}else{
					$this->path = trim($path) . '/';
					$url = $this->url;
				}
			}

			// var_dump('this path: '.$this->path);
			$file = $request->file($this->file);

			$up_path = public_path().'/upload/'.$this->path;


			if(!is_dir($up_path)){
				@mkdir($up_path);
			}

			if(!is_dir($up_path)){
				var_dump('up_path: '.$up_path);
				return 110104;	// 上传目录不存在
			}

			if(!is_writable($up_path)){
				return 110105;	// 上传目录不可写
			}

			if($file && $file->isValid()){
				$this->file_type = $file->getUploadExtension();

				if(!in_array($this->file_type,$this->ext[$this->type])){
					return 110102;	// 上传文件格式错误
				}

				$size = $file->getSize();
				if($size >  $this->maxsize){
					return 110103;	// 上传文件大小被限制
				}

				$this->new_name = date('YmdHis').'_'.rand(100,999).'.'.$this->file_type;
				$path_name = $this->path.$this->new_name;
				// var_dump($path_name);
				// var_dump('path_name: '.$path_name);

				if($file->move(public_path().'/upload/'.$path_name)){
					return array(
						'filename'	=> $this->new_name,
						'url'		=> $url.str_replace('images/','',$path_name),
						'alt'		=> $this->new_name
					);
				}
        		return 110106;	// 上传失败
				
			}
			return 110101;	// 上传文件错误
		}

		private function getImgurl($host){
			$temp = explode('//',$host);
			$tmp = explode('.',$temp[1]);

			$url = $temp[0].'//'.str_replace($tmp[0],'img',$temp[1]);
			return $url;
		}
	}
?>