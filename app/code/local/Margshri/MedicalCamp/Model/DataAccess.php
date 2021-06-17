<?php
class Margshri_MedicalCamp_Model_DataAccess{
	
	public static function callInstanceFunction($instance, $associcativeArray){
		
		 if(!is_array($associcativeArray)){
		 	$associcativeArray = $associcativeArray->toArray();
		 }
		foreach(  $associcativeArray as $key=>$value ){
	
			$functionName = "set{$key}";
			$instance->$functionName($value);
		}
		return $instance;
	}
	
}
