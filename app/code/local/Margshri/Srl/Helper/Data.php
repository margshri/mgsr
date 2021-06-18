<?php

class Margshri_Transport_Helper_Data extends Mage_Core_Helper_Abstract {

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