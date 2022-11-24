<?php
	namespace app\controller;

	use support\Request;
	use app\lib\Json;

    use \app\lib\PhpQrcode\FrameFiller;
	use \app\lib\PhpQrcode\QRbitstream;
	use \app\lib\PhpQrcode\QRcode;
	use \app\lib\PhpQrcode\QRencode;
	use \app\lib\PhpQrcode\Qrimage;
	use \app\lib\PhpQrcode\QRinput;
	use \app\lib\PhpQrcode\QRinputItem;
	use \app\lib\PhpQrcode\QRmask;
	use \app\lib\PhpQrcode\QRrawcode;
	use \app\lib\PhpQrcode\QRrs;
	use \app\lib\PhpQrcode\QRrsblock;
	use \app\lib\PhpQrcode\QRrsItem;
	use \app\lib\PhpQrcode\QRspec;
	use \app\lib\PhpQrcode\QRsplit;
	use \app\lib\PhpQrcode\Qrstr;
	use \app\lib\PhpQrcode\QRtools;

	class Qr{
		public function index(){
			$url = 'https://www.baidu.com';
			$url = urldecode($url);
			ob_start();
			$res = QRcode::png($url);
			$imgString = base64_encode(ob_get_contents());
			ob_end_clean();
			return view('poster/index',['url'=>'data:image/png;base64,'.$imgString]);

			// $result = Builder::create()
			//     ->writer(new PngWriter())
			//     ->writerOptions([])
			//     ->data('Custom QR code contents')
			//     ->encoding(new Encoding('UTF-8'))
			//     ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
			//     ->size(300)
			//     ->margin(10)
			//     ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
			//     ->logoPath(public_path().'/upload/poster/huanrang.png')
			//     ->labelText('This is the label')
			//     ->labelFont(new NotoSans(20))
			//     ->labelAlignment(new LabelAlignmentCenter())
			//     ->build();

			// return Json::show($result);
		}

		public function user(Request $request){
			$url = 'https://www.baidu.com';
			$url = urldecode($url);
			ob_start();
			$res = QRcode::png($url);
			$imgString = base64_encode(ob_get_contents());
			ob_end_clean();
			return view('poster/index',['url'=>'data:image/png;base64,'.$imgString]);
		}
	}
?>