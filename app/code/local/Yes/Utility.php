<?php

class Yes_Utility
{
 	
  
 	
 	public static function getUniqueName()
 	{
 		$FileName = rand(100000,999999) . '_' . date("Ymdhis")  ; 
		return $FileName;
 	}
 	
 	/*
 	public static function generateFlatFileUrl($postFixFileName)
 	{
 		$postFixFileName = rand(100000,999999) . '_' . date("Ymdhis") . '_' . $postFixFileName;
 		
 		$flatFileName = self::getServerPath() . "/var/repository/uploadedfiles/catalog/products/" . $postFixFileName;
 		
 		return $flatFileName;
 	}
 	*/
 	
 	public static function getServerPath()
 	{
 		$urlParse = parse_url($_SERVER['REQUEST_URI']);
 		$path = explode('/',$urlParse ['path']);
 		$serverPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $path[1];
 		
 		return $serverPath;
 	}
 	
 	
 	
 	
 	
 	
}