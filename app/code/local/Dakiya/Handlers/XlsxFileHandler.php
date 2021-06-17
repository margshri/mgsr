<?php

class Dakiya_Handlers_XlsxFileHandler {

	public function createFlatFile($flatFileUrl,$recordFile){
		
		try {
			$responseVO = new Dakiya_VO_BaseVO();
			
			require_once(Mage::getBaseDir('app') . '/code/local/Dakiya/API/SpreadsheetReader/php-excel-reader/excel_reader2.php');
			require_once(Mage::getBaseDir('app') . '/code/local/Dakiya/API/SpreadsheetReader/SpreadsheetReader.php');
			
			//$Spreadsheet = new SpreadsheetReader($recordFile['tmp_name']);
			$Spreadsheet = new SpreadsheetReader(Mage::getBaseDir('app') . '/code/local/Dakiya/API/BlueDart.xlsx');
			$Sheets = $Spreadsheet -> Sheets();
			//exit;
			//foreach ($Sheets as $Index => $Name){
			for($index=0; $j < sizeof($Sheets); $index++){
				$Spreadsheet -> ChangeSheet($index);
				$handle = fopen($flatFileUrl, 'a+'); 
				foreach ($Spreadsheet as $Key => $row){
					for($i=0; $i < sizeof($row) ; $i++){
						
						$r = $row[$i];
						
						
						
						$data = $row[$i] . Dakiya_VO_Master_System_SystemConfig_SystemConfigVO::$FLAT_FILE_COLUMN_SEPARATOR;
						fwrite($handle, $data);
					}
					fwrite($handle, "\n");
				}
				fclose($handle);
			}
			 
			if( ! (($index > sizeof($Sheets)) && file_exists($flatFileUrl) ) ){
				Mage::throwException('Spreadsheet not readable !');
			}	
			
		}catch(Exception $e){
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	}
	
	
}
