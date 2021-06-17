<?php
class Margshri_WebPortal_Model_DataAccess{
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

	
	public static function jsonSerialize($instance)
	{
		$json = array();
		$classMethods = get_class_methods($instance);
	
		if(method_exists($instance,"getDataArray")){
				$json=$instance->getDataArray();
		}
// 		foreach($classMethods as $classMethod){
// 			if( substr($classMethod ,0,3)=="get"){
// 				$json[substr($classMethod ,3) ] = $instance->$classMethod();
// 			}
// 		}
		return $json;
	}
	
	
	public static function convertVOInArray($voClassName, $instance)
	{
		$json = array();
		$class =   new ReflectionClass($voClassName);
		 
		foreach($class->getMethods() as $classMethod){
			$methodClassName =(String)$classMethod->class ; 
			if ($methodClassName == $voClassName || $methodClassName=='Swapp_VO_BaseVO') {
				$methodName= $classMethod->name;
				if( substr($methodName ,0,3)=="get"  &&  $methodName !="getDataArray"   &&   $methodName !="getBaseDataArray" ){
					$json[substr($methodName ,3) ] = $instance->$methodName();
				}
			}
			 
			
		}
		return $json;
	}
	
	
	
	
}
