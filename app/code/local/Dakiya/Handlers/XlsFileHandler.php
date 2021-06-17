<?php

class Dakiya_Handlers_XlsFileHandler {
	
	public function createFlatFile($flatFileUrl,$recordFile){
		  
		  try {
		  		$responseVO = new Dakiya_VO_BaseVO();
		  		require_once(Mage::getBaseDir('app') . '/code/local/Dakiya/API/XlsReader/excel_reader.php');
				
				$excel = new PhpExcelReader();
		
				$excel->read($recordFile['tmp_name']);    
				
				$handle = fopen($flatFileUrl, 'a+') or die('Cannot open file:  '.$flatFileUrl);
				
				$x=1;
		
				    while($x<=$excel->sheets[0]['numRows']) 
				    {
				      
				      $y=1;
				      
				      while($y<=$excel->sheets[0]['numCols']) 
				      {
				        $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
				      	//echo $cell . "<br />";
				      	$data = $cell . "|";
				      		fwrite($handle, $data);
				        $y++;
				      }  
				      fwrite($handle, "\n");
				      $x++;
				    }
			    fclose($handle);
			    
			    if( ! (($x > $excel->sheets[0]['numRows']) && file_exists($flatFileUrl) ) ){
			    	Mage::throwException('excel not readable !');
			    }
		}
		catch(Exception $e){
			$responseVO->setErrorMessage($e->getMessage());
	    }
	    return $responseVO;
	 }// end readXLS function
}// end class 