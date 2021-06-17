<?php
class Dakiya_Handlers_TemplateFileHandler{
	
	public function readTemplateFile($templateFileURL){
		
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			$templateFile = fopen($templateFileURL, "r");
	 		
			if($templateFile == false){
				Mage::throwException('Template File Not Found !');
			}
			
	 		$templateFileDataObjs= array();
	 		while (!feof($templateFile)){
	 			$row = fgets($templateFile);
	 			if($row == null){
	 				continue;
	 			}
	 			$templateFileRowObj = explode(Dakiya_VO_Master_System_SystemConfig_SystemConfigVO::$TEMPLATE_FILE_COLUMN_SEPARATOR, $row);
 				$templateFileDataObj['ColumnName'] = $templateFileRowObj[0];
	 			$templateFileDataObj['ColumnException'] = $templateFileRowObj[1];
	 			$templateFileDataObjs[] = $templateFileDataObj;
	 		}
	 		fclose($templateFile);
	 		$responseVO->setResponseData($templateFileDataObjs);
	 	}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
		
	}
	
}