<?php

class Dakiya_Services_TemplateManagementServices{
	
	public function isValidFileTemplate($templateFileDataObjs, $flatFileColumnNameDataObj){
		try{
			
			$responseVO = new Dakiya_VO_BaseVO();
			if (sizeof($templateFileDataObjs) == sizeof($flatFileColumnNameDataObj)){
				for($i=0 ; $i < sizeof($templateFileDataObjs); $i++){
					if ( trim($templateFileDataObjs[$i]['ColumnName']) !== trim($flatFileColumnNameDataObj[$i]) ){
						Mage::throwException("Column Name Not Match With Template !");
					}
				}
			}else{
				Mage::throwException("Number Of Column Not Match With Template !");
			}
			
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	}
	
}