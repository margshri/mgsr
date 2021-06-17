<?php
class Yes_Handlers_FlatFileHandler 
{
	
	public function readFlatFile($flatFileUrl)
	{
	
		$file = fopen($flatFileUrl, "r");
			
		$flatFileArray = array();
			
		$i = 0;
		
		while (!feof($file))
		{
			//if(fgets($file) == "\n")
			//	continue;
			
			$row = substr(fgets($file), 0, -2);
		
			$data = explode(Yes_ApplicationConstant::$FLAT_FILE_COLUMN_SEPARATOR, $row);
		
			for($j=0 ; $j < count($data) ; $j++)
			{
				$flatFileArray[$i][$j] = $data[$j];
			}
			$i++;	
		}
		fclose($file);
		
		return $flatFileArray;
	
	}
	
	
}