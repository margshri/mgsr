<?php

class Yes_Handlers_XlsFileHandler
{
	public function createFlatFile($flatFileUrl,$recordFile)
	{
		  
		  try 
		  {
		  		$handler = Yes_Utility::handlerPath(Yes_ApplicationConstant::$XLS_HANDLER_CLASS_NAME);
				
				$productFlat = Yes_Utility::ceateFlatFileName(Yes_ApplicationConstant::$FLAT_PRODUCT_FILE_POSTFIX);
				
				include_once($handler) or die('can not inculde');
				
				$excel = new Spreadsheet_Excel_Reader();
		
				$excel->read($_FILES['file']['tmp_name']);    
				
				$handle = fopen($productFlat, 'a+') or die('Cannot open file:  '.$productFlat);
				
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
			    
			    if(($j > $excel->sheets[0]['numRows']) && file_exists($productFlat) )
			    {
			    	return true;
			    }
			    else
			    {
			    	return false;
			    }
		}
		catch(Exception $e)
  		{
	    	echo "aa";
  			return false;
	    }
	 }// end readXLS function
}// end class 