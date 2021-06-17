<?php
class Dakiya_Services_FileManagementServices{
	
	public static function isValidFileSize($fileSize, $validMinFileSize, $validMaxFileSize){
		if( $fileSize >= $validMinFileSize && $fileSize <= $validMaxFileSize )
			return true;
		else
			return false;
	}
	
	public static function isValidFileExtension($fileExtension, $fileExtensionString){
		$fileExtensionArray = explode(Dakiya_VO_Master_System_SystemConfig_SystemConfigVO::$COMMAN_SEPARATOR, $fileExtensionString);
		if(in_array($fileExtension, $fileExtensionArray))
			return true;
		else
			return false;
	}

	public static function isValidFileType($fileType, $fileTypesString){
		$fileTypesArray  = explode(Dakiya_VO_Master_System_SystemConfig_SystemConfigVO::$COMMAN_SEPARATOR, $fileTypesString);
		if(in_array($fileType, $fileTypesArray))
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