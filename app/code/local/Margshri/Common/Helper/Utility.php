<?php
class Margshri_Common_Helper_Utility extends Mage_Core_Helper_Abstract {
    
 	public static function getServerPath(){
 		$urlParse = parse_url($_SERVER['REQUEST_URI']);
 		$path = explode('/',$urlParse ['path']);
 		
 		if($path[1] == 'index.php'){
 			$serverPath = $_SERVER['DOCUMENT_ROOT'];
 		}else{
 			$serverPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $path[1];
 		}
 		
 		return $serverPath;
 	}

 	
 	public static function getServerURL(){
 		$urlParse = parse_url($_SERVER['REQUEST_URI']);
 		$path = explode('/',$urlParse ['path']);
 		$serverURL = "http://" . $_SERVER['HTTP_HOST'] . "/" . $path[1];
 		return $serverURL;
 	}

 	
 	public static function setVO($instance, $associcativeArray){
 	    
 	    if(!is_array($associcativeArray)){
 	        $associcativeArray = $associcativeArray->toArray();
 	    }
 	    foreach(  $associcativeArray as $key=>$value ){
 	        
 	        $functionName = "set{$key}";
 	        $instance->$functionName($value);
 	    }
 	    return $instance;
 	}
 	
 	
 	public static function callInstanceFunction($instance, $associativeArray){
 	    if(!is_array($associativeArray)){
 	        $associativeArray = $associativeArray->toArray();
 	    }
 	    foreach($associativeArray as $key=>$value){
 	        $functionName = "set{$key}";
 	        $instance->$functionName($value);
 	    }
 	    return $instance;
 	}
 	
 
 	public static function jsonEncode($valueToEncode, $cycleCheck = false, $options = array()){
 	    $json = Zend_Json::encode($valueToEncode, $cycleCheck, $options);
 	    /* @var $inline Mage_Core_Model_Translate_Inline */
 	    $inline = Mage::getSingleton('core/translate_inline');
 	    if ($inline->isAllowed()) {
 	        $inline->setIsJson(true);
 	        $inline->processResponseBody($json);
 	        $inline->setIsJson(false);
 	    }
 	    return $json;
 	}
 	
 	
 	public static function isACLAllowed($resourceLookup){
 	    try {
 	        $role  = Mage::getSingleton('admin/session')->getUser()->getRole();
 	        if($role->getData('role_id') == 1){
 	            //admin role
 	            return true;
 	        }
 	        $session = Mage::getSingleton('admin/session');
 	        $resourceId = $session->getData('acl')->get($resourceLookup)->getResourceId();
 	        if (!$session->isAllowed($resourceId)) {
 	            throw new Exception('');
 	        }
 	        return true;
 	    }
 	    catch (Exception $e) {
 	        //$this->_forward('denied');
 	        return false;
 	    }
 	}
}