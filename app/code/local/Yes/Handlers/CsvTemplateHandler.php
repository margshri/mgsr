<?php
class Yes_Handlers_CsvTemplateHandler 
{
	public function readTemplate($templateUrl)
	{
		
		$file = fopen($templateUrl, "r");
 		
 		$templateArray = array();
 		
 		while (!feof($file))
 		{
 			$row = fgets($file);
 			
 			if($row == NULL)
 				continue;
 				
	 			$data = explode(Yes_ApplicationConstant::$TEMPLATE_COLUMN_SEPARATOR, $row);
	 			
	 			$templateVO = new Yes_VO_Template_TemplateVO();
	 			//for($i =0 ; $i < count($data) ; $i++)
	 			//{
					$templateVO->setColumnName($data[0]);
					$templateVO->setColumnKey($data[1]) ;
					$templateVO->setColumnException($data[2]);
					$templateVO->setColumnLength($data[3]);
					$templateVO->setAttributeID($data[4]);
	 			//}
	 			$templateArray[] = $templateVO;
 			
 		}
 		fclose($file);
 		
 		//echo $templateArray[0]->getColumnName();
 		
 		//echo "<pre>";
 		//var_dump($templateArray);
 		//echo "</pre>";
 		//exit;
 		
 		
 		
 		return $templateArray;
		
	}
	
	
}