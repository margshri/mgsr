<?php

class Yes_Handlers_XlsxFileHandler 
{

	public function createFlatFile($flatFileUrl,$recordFile)
	{
		
		$xlsx = new Yes_API_XlsxReader($recordFile['tmp_name']);

		for($j=1;$j <= $xlsx->sheetsCount();$j++)
		{
			$handle = fopen($flatFileUrl, 'a+'); 
			
			foreach($xlsx->rows($j) as $row)
			{
				for($i=0; $i < sizeof($row) ; $i++)
				{
					$data = $row[$i] . Yes_ApplicationConstant::$FLAT_FILE_COLUMN_SEPARATOR;
					fwrite($handle, $data);
				}
				fwrite($handle, "\n");
				
				/*
				    $row = implode(Yes_ApplicationConstant::$FLAT_FILE_COLUMN_SEPARATOR, $row);
					$row = $row . "\n";
					fwrite($handle, $row);
				
				*/
			}
			fclose($handle);
		}
		if(($j > $xlsx->sheetsCount()) && file_exists($flatFileUrl) )
			return true;
		else
			return false;
	}
	
	
}