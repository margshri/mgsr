<?php

class Yes_Services_FileManagementServices
{
	public function is_ValidFileSize($fileSize)
	{
		if($fileSize <= Yes_ApplicationConstant::$DATA_FILE_SIZE_LIMIT)
			return true;
		else
			return false;
	}
	public function is_ValidFileExtension($fileExt)
	{
		if (($fileExt == Yes_ApplicationConstant::$XLS_FILE_EXT)
				|| ($fileExt == Yes_ApplicationConstant::$XLSX_FILE_EXT)
		)
			return true;
		else
			return false;
	
	}
	
	public function is_ValidFileType($fileType)
	{
		if (($fileType == Yes_ApplicationConstant::$XLS_FILE_TYPE)
				|| ($fileType == Yes_ApplicationConstant::$XLSX_FILE_TYPE)
		)
			return true;
		else
			return false;
	}
	
	
	public static function  fileOpen($fileName){
		
		return fopen($fileName, 'a+');
	}
        
	public static function fileWrite($file , $value){
		fwrite($file, $value);
	}
	
	public static function fileClose($file){
		fclose($file);
	}
}