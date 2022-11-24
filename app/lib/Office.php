<?php
	namespace app\lib;

	ini_set("display_errors", "On");  
	error_reporting(E_ALL); 

	use support\Request;

	use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	use \PhpOffice\PhpSpreadsheet\Reader\Xls;
	use \PhpOffice\PhpSpreadsheet\IOFactory;
	use \PhpOffice\PhpSpreadsheet\Cell\Coordinate;
	use \PhpOffice\PhpSpreadsheet\Spreadsheet;
	use \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
	use \PhpOffice\PhpSpreadsheet\Cell\DataType;
	use \PhpOffice\PhpSpreadsheet\Style\Fill;
	use \PhpOffice\PhpSpreadsheet\Style\Color;
	use \PhpOffice\PhpSpreadsheet\Style\Alignment;
	use \PhpOffice\PhpSpreadsheet\Style\Border;
	use \PhpOffice\PhpSpreadsheet\Style\NumberFormat;

	class Office{
		/**
		 * 导出
		 * @param  [type] $data [description]
		 * @param  [type] $head [description]
		 * @param  string $file [description]
		 * @param  string $type [description]
		 * @return [type]       [description]
		 */
		public static function export(Request $request,$head,$data,$file='',$option=[],$type='excel'){
			switch(strtolower($type)){
				case '':
				case 'excel':
					return self::exportExcel($request,$head,$data);
				case 'word':
					return self::exportWord($request,$data,$file);
				case 'pdf':
					return self::exportPDF($request,$data,$file);
				default:
					return false;
			}
		}

		/**
		 * 使用PHPEXECL导入
		 *
		 * @param string $file      文件地址
		 * @param int    $sheet     工作表sheet(传0则获取第一个sheet)
		 * @param int    $columnCnt 列数(传0则自动获取最大列)
		 * @param array  $options   操作选项
		 *                          array mergeCells 合并单元格数组
		 *                          array formula    公式数组
		 *                          array format     单元格格式数组
		 *
		 * @return array
		 * @throws Exception
		 */
		public static function importeds(string $file = '', int $sheet = 0, int $columnCnt = 0, &$options = []){
			try{
				// 文件转码
				$file = iconv("utf-8", "gb2312", $file);
				if(empty($file) OR !is_file($file)){
					return "文件不存在";
				}

				/** @var Xlsx $objRead */
        		$objRead = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        		if(!$objRead->canRead($file)){
        			/** @var Xls $objRead */
            		$objRead = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            		if(!$objRead->canRead($file)){
            			return "只支持导入Excel文件";
            		}
        		}
        		/* 如果不需要获取特殊操作，则只读内容，可以大幅度提升读取Excel效率 */
        		empty($options) && $objRead->setReadDataOnly(true);
        		/* 建立excel对象 */
        		$obj = $objRead->load($file);
        		/* 获取指定的sheet表 */
        		$currSheet = $obj->getSheet($sheet);
        		if((isset($options['mergeCells']))){
        			/* 读取合并行列 */
        			$options['mergeCells'] = $currSheet->getMergeCells();
        		}
        		if(0 == $columnCnt){
        			/* 取得最大的列号 */
		            $columnH = $currSheet->getHighestColumn();
		            /* 兼容原逻辑，循环时使用的是小于等于 */
		            $columnCnt = Coordinate::columnIndexFromString($columnH);
        		}
        		/* 获取总行数 */
		        $rowCnt = $currSheet->getHighestRow();
		        $data   = [];
		        /* 读取内容 */
        		for($_row=1;$_row<=$rowCnt;$_row++){
        			$isNull = true;
        			for($_column=1;$_column<=$columnCnt;$_column++){
        				$cellName = Coordinate::stringFromColumnIndex($_column);
        				$cellId   = $cellName . $_row;
                		$cell     = $currSheet->getCell($cellId);
                		if(isset($options['format'])){
		                    /* 获取格式 */
		                    $format = $cell->getStyle()->getNumberFormat()->getFormatCode();
		                    /* 记录格式 */
		                    $options['format'][$_row][$cellName] = $format;
		                }
		                if (isset($options['formula'])) {
                            /* 获取公式，公式均为=号开头数据 */
                            $formula = $currSheet->getCell($cellId)->getValue();

                            if (0 === strpos($formula, '=')) {
                                $options['formula'][$cellName . $_row] = $formula;
                            }
                        }
                        if (isset($format) && 'm/d/yyyy' == $format) {
                            /* 日期格式翻转处理 */
                            $cell->getStyle()->getNumberFormat()->setFormatCode('yyyy/mm/dd');
                        }
                        $data[$_row][$cellName] = trim($currSheet->getCell($cellId)->getFormattedValue());
                        if(!empty($data[$_row][$cellName])){
		                    $isNull = false;
		                }
        			}
        			/* 判断是否整行数据为空，是的话删除该行数据 */
		            if ($isNull) {
		                unset($data[$_row]);
		            }
        		}
        		return $data;
			}catch(\Exception $e){
				dump($e);
				return $e;
			}

			/* 简要处理
			$ext = self::getFiletype($file);
			if(empty($ext)){
				return false;
			}

			# 创建读操作
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($ext);
			# 打开文件、载入excel表格
			$spreadsheet = $reader->load($file);
			# 获取活动工作薄
			$sheet = $spreadsheet->getActiveSheet()->toArray();
			return $sheet;*/
		}

		/**
		 * Excel导出，TODO 可继续优化
		 *
		 * @param array  $datas      导出数据，格式['A1' => 'XXXX公司报表', 'B1' => '序号']
		 * @param string $fileName   导出文件名称
		 * @param array  $options    操作选项，例如：
		 *                           bool   print       设置打印格式
		 *                           string freezePane  锁定行数，例如表头为第一行，则锁定表头输入A2
		 *                           array  setARGB     设置背景色，例如['A1', 'C1']
		 *                           array  setWidth    设置宽度，例如['A' => 30, 'C' => 20]
		 *                           bool   setBorder   设置单元格边框
		 *                           array  mergeCells  设置合并单元格，例如['A1:J1' => 'A1:J1']
		 *                           array  formula     设置公式，例如['F2' => '=IF(D2>0,E42/D2,0)']
		 *                           array  format      设置格式，整列设置，例如['A' => 'General']
		 *                           array  alignCenter 设置居中样式，例如['A1', 'A2']
		 *                           array  bold        设置加粗样式，例如['A1', 'A2']
		 *                           string savePath    保存路径，设置后则文件保存到服务器，不通过浏览器下载
		 */
		protected static function exportExcel(Request $request,array $title,array $data, $name = '', $remark = '', $down = false): bool{
			$spreadsheet = new Spreadsheet();
			$worksheet = $spreadsheet->getActiveSheet();

			// 设置工作表标题名称
			$worksheet->setTitle('sheet1');
			$name = time();

			foreach($title as $key => $val){
				$worksheet->setCellValueByColumnAndRow($key+1,1,$val);
			}
			$row = 2;
			foreach($data as $item){
				$colum = 1;
				foreach($item as $value){
					$worksheet->setCellValueByColumnAndRow($colum,$row,$value);
					$colum++;
				}
				$row++;
			}

	        // $request->header('Content-Type','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	        // $request->header('Content-Disposition','attachment;filename='.$name);
	        // $request->header('Cache-Control','max-age=0');
	        // $request->header('Cache-Control','cache, must-revalidate');
	        // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	        // $writer->save('php://output');
	        // $spreadsheet->disconnectWorksheets();
	        // unset($spreadsheet);

	        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(public_path().'/upload/export/'.$name.'.xlsx');
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
	        
	        return true;

	        foreach ($data as $index => $row) {
	            for ($j = 0; $j < $colcounter; $j++) {
	                if ($j >= 26) {
	                    $cell = chr(65 + $j / 26 - 1) . chr(65 + $j % 26);
	                } else {
	                    $cell = chr(65 + $j);
	                }
	                if (is_numeric($row[$keys[$j]]) && strlen($row[$keys[$j]]) > 10) {
	                    $sheet->getCell($cell . ($index + 2))->setValueExplicit($row[$keys[$j]], 's');
	                } else {
	                    $sheet->setCellValue($cell . ($index + 2), $row[$keys[$j]]);
	                }
	            }
	        }

	        for ($k = 0; $k < $colcounter; $k++) {
                if ($k >= 26) {
                    $cell = chr(65 + $k / 26 - 1) . chr(65 + $k % 26);
                } else {
                    $cell = chr(65 + $k);
                }
                $sheet->getColumnDimension($cell)->setAutoSize(true);
            }
            if ($remark) {
                $sheet->setCellValue('A' . ($index + 3), $remark);
                $sheet->getStyle('A' . ($index + 3))->getAlignment()->setWrapText(true);
            }

            $name .= '.xlsx';
            if ($down) {
                $request->header('Content-Type','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		        $request->header('Content-Disposition','attachment;filename='.$name);
		        $request->header('Cache-Control','max-age=0');
		        $request->header('Cache-Control','cache, must-revalidate');

                $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
                
            } else {
                $writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save($name);
                $spreadsheet->disconnectWorksheets();
                unset($spreadsheet);
            }
            return true;
		}

		// 导出Word
		protected static function exportWord(Request $request,$data,$head,$file){
			
		}

		// 导出PDF
		protected static function exportPDF(Request $request,$data,$head,$file){
			
		}

		public static function pdf($html,$footer){
			$config = [
				'mode'=>'utf-8',
				'format'=>'A4',
				'useSubstitutions'=>true,
				'useAdobeCJK'=>true,
				'autoScriptToLang'=>true,
				'autoLangToFont'=>true,
				'mgl'=>15,
				'mgr'=>15,
				'mgt'=>16,
				'mgb'=>16,
				'mgh'=>9,
				'mgf'=>9,
				'orientation'=>'P',
				'tempDir'=>APP_PATH . '/upload/tmp'
			];
			$mpdf=new \Mpdf\Mpdf($config);  
		    $mpdf->WriteHTML($html);
		    $mpdf->SetFooter($footer);
		    $mpdf->Output(); 
		}

		// 获取文件格式
		private static function getFiletype($file){
			if($file){
				$temp = explode('.',$file);
				$ext = $temp ? strtolower(end($temp)) : '';
				return ucfirst($ext);
			}
			return '';
		}
	}
?>