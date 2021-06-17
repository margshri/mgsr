<?php
class Dakiya_Handlers_FlatFileHandler {
	
	public function generateFlatFile($flateFileURL, $fileExtension, $file){
		
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			if($fileExtension == 'xls' ){
				$xlsHandler = new Dakiya_Handlers_XlsFileHandler();
				$responseVO= $xlsHandler->createFlatFile($flateFileURL, $file);
			}
			if($fileExtension == 'xlsx'){
				$xlsxHandler = new Dakiya_Handlers_XlsxFileHandler();
				$responseVO= $xlsxHandler->createFlatFile($flateFileURL, $file);
			}
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	}
	
	public function readFlatFile($flatFileURL){
		
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			$flateFile = fopen($flatFileURL, "r");
			
			if($flateFile == false){
				Mage::throwException('Flate File Not Found !');
			}
			$i = 0;
			$flatFileDataObjs = array();
			while (!feof($flateFile)){
				$row = substr(fgets($flateFile), 0, -2);
				if($row == false){
					continue;
				}
				$data = explode(Dakiya_VO_Master_System_SystemConfig_SystemConfigVO::$FLAT_FILE_COLUMN_SEPARATOR, $row);
				for($j=0 ; $j < count($data) ; $j++){
					$flatFileDataObjs[$i][$j] = $data[$j];
				}
				$i++;
			}
			fclose($flateFile);
			$responseVO->setResponseData($flatFileDataObjs);
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
		
	}
}