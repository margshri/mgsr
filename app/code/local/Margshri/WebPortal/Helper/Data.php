<?php

class Margshri_WebPortal_Helper_Data extends Mage_Core_Helper_Abstract {

	public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array())
    {
    	
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

    public function getType8Model($tableCode){
    	$model = Mage::getModel("webportal/Center_Content_Type8_Type8");
    	$model->getResource()->setInIt($tableCode);
    	return $model;    
    }
    
    public function getType10Model($tableCode){
    	$model = Mage::getModel("webportal/Center_Content_Type10_Type10");
    	$model->getResource()->setInIt($tableCode);
    	return $model;
    }

    public function getType10TypeModel($tableCode){
    	$model = Mage::getModel("webportal/Master_Center_Content_Type10_Type");
    	$model->getResource()->setInIt($tableCode);
    	return $model;
    }

    public function getType11Model($tableCode){
    	$model = Mage::getModel("webportal/Center_Content_Type11_Type11");
    	$model->getResource()->setInIt($tableCode);
    	return $model;
    }
    
    
    public function getTableVOByTableCode($tableCode){
    	 
    	$tableModel   = Mage::getModel("webportal/Master_Table_Table");
    	$tableDataObj = $tableModel->getResource()->getByCode($tableCode);
    
    	if($tableDataObj !== false){
    		$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
    		$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
    	}
    	return $tableVO;
    }
    
    
    
    public function getTableTypeVOByTableCode($tableCode){
    	
    	$tableModel   = Mage::getModel("webportal/Master_Table_Table");
    	$tableDataObj = $tableModel->getResource()->getByCode($tableCode);
    
    	if($tableDataObj !== false){
    		$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
    		$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
    
    		$tableTypeModel   = Mage::getModel("webportal/Master_Table_TableType");
    		$tableTypeDataObj = $tableTypeModel->getResource()->getByID($tableVO->getTableTypeID());
    
    		if($tableTypeDataObj !== false){
    			$tableTypeDTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    			/* @var $tableTypeVO Margshri_WebPortal_VO_Master_Table_TableTypeVO */
    			$tableTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableTypeDTO, $tableTypeDataObj);
    		}
    	}
    	 
    	return $tableTypeVO;
    }
    
    
    
    
    
    public function getContentVO($tableCode){
    	
    	$tableModel   = Mage::getModel("webportal/Master_Table_Table");
    	$tableDataObj = $tableModel->getResource()->getByCode($tableCode);

    	if($tableDataObj !== false){
    		$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
    		$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
    		
    		$tableTypeModel   = Mage::getModel("webportal/Master_Table_TableType");
    		$tableTypeDataObj = $tableTypeModel->getResource()->getByID($tableVO->getTableTypeID());
    		
    		if($tableTypeDataObj !== false){
    			$tableTypeDTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    			/* @var $tableTypeVO Margshri_WebPortal_VO_Master_Table_TableTypeVO */
    			$tableTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableTypeDTO, $tableTypeDataObj);
    		}
    	}
    	
    	$contentVO = null;
    	
    	switch ($tableTypeVO->getCode()){
    		case 'type1':
    			$contentVO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    			break;

    		case 'type2':
    			//$contentVO = new Margshri_WebPortal_VO_Center_Content_Type2_ContentVO($tableCode);
    			break;
    	}
    	
    	return $contentVO;
    }
    
    public static function camelCase($str){
    	$strArray = explode(",", $str);
    	foreach ($strArray as $key=>$val){
    		$strArray[$key] = strtolower($val);
    	}
    	$str = implode(",", $strArray);
    	$str = ucwords($str);
    	return $str;
    }
    
    
    public function getPageTitleByTableCode($tableCode){
    
    	$tableModel   = Mage::getModel("webportal/Master_Table_Table");
    	$tableDataObj = $tableModel->getResource()->getByCode($tableCode);
    	$fileName     = '';
    	
    	if($tableDataObj !== false){
    		$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
    		$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
    		$fileName = $tableVO->getFileName(); 
    	}
    	return $fileName; 
    }
    
    
    
    public function cleanData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    public function setContentTypeForExport($filename, $contentType)
    {
                  header("Content-Disposition: attachment; filename=\"$filename\"");
                  header("Content-Type: " . $contentType);
    }

    
    public function no_to_words($no , $valueType="int")
    {
        $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred ','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
        
        if($valueType=="decimal"){
        	if($no ==0) return "Zero Zero";
            if(array_key_exists("$no",$words)) {
                    return $words["$no"];
            } else { 
                     $unit=$no%10;
                     $ten =(int)($no/10)*10;             
                     return $words["$ten"]." ".$words["$unit"];
            }
        }
        
        if($no == 0){
		          return ' ';
		}
        else {   
               $novalue='';$highno=$no;$remainno=0;$value=100;$value1=1000;        
                while($no>=100)    {
                    if(($value <= $no) &&($no  < $value1))    {
                        $novalue=$words["$value"];
                        $highno = (int)($no/$value);
                        $remainno = $no % $value;
                        break;
                    }
                        $value= $value1;
                        $value1 = $value * 100;
                }        
                if(array_key_exists("$highno",$words)) {
                    return $words["$highno"]." ".$novalue." ". $this->no_to_words($remainno);
                } else { 
                     $unit=$highno%10;
                     $ten =(int)($highno/10)*10;             
                     return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->no_to_words($remainno);
                }
        
    }        
		        
    }
    
    public function renderFilter($filter , $whereClause =null){
	      // $filter = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));	

    	   $keys = array_keys($filter) ;
	        for($cntr=0; $cntr<count($filter); $cntr++)
	        {
	            
	        	
	            if(is_array($filter[$keys[$cntr]] )){
	            	if(array_key_exists('from', $filter[$keys[$cntr]]) || array_key_exists('to', $filter[$keys[$cntr]])  ){	
		                if( $whereClause !=''){
		                        $whereClause .= " and " ;
		                }   
	            	}
	            	
	            	if(array_key_exists('from', $filter[$keys[$cntr]]) && array_key_exists('to', $filter[$keys[$cntr]])  ){
                       	    $whereClause .= "date(" .$keys[$cntr] . ") >= '" . $this->dateString($filter[$keys[$cntr] ]['from'],  $filter[$keys[$cntr]]['locale'] ) . "' and date(" . $keys[$cntr] . ") <= '" . $this->dateString($filter[$keys[$cntr] ]['to'],  $filter[$keys[$cntr]]['locale']  ). "'";  
                       } elseif(array_key_exists('from', $filter[$keys[$cntr]])   ){
                            $whereClause .= "date(" .$keys[$cntr] . ") >= '" . $this->dateString($filter[$keys[$cntr] ]['from'],  $filter[$keys[$cntr]]['locale'] ) . "'" ;   
                       }elseif(array_key_exists('to', $filter[$keys[$cntr]])   ){
                            $whereClause .= "date(" .$keys[$cntr] . ") <= '" . $this->dateString($filter[$keys[$cntr] ]['to'],  $filter[$keys[$cntr]]['locale'] ) . "'" ;   
                       }
                       
	            	
	            } else {
	               if( $whereClause !=''){
                        $whereClause .= " and " ;
                    }   
	            	
                   $col = str_replace("#", ".", $keys[$cntr]);
                   $whereClause .= $col  . " like '%" . $filter[$keys[$cntr]] . "%'" ; 
	               //$whereClause .= $keys[$cntr] . " like '%" . $filter[$keys[$cntr]] . "%'" ;	
	            }
	            
	            
	        } 
            if($whereClause==''){
               $whereClause='0=0';  
            }	        
	        return $whereClause ;
    }
    
    private function dateString($value, $locale)
    {
    	if($locale== 'en_US'){
              return substr($value, 6,2) . "/" . substr($value, 0,2) . "/" . substr($value, 3,2)   ;        
        }
        
    }
    
    public function dateConvertor($dateValue, $convertor)
    {
    	        $strSeparator    = substr( $dateValue  ,2,1) ; //find date separator
                $strValue        = explode($strSeparator, $dateValue);
                if($convertor =="UKtoUS")
                {
                    return $strValue[1]."/". $strValue[0]."/".$strValue[2];
                }             
    	
    }
     
    public function getTokenNumber(){
    	return  uniqid (rand(), true);
    }
     

    public function getCurrentAdminUserID(){
    	return Mage::getSingleton('admin/session')->getUser()->getId(); 
	}
    
    public function getCurrentAdminRoleID(){
    	return implode('', Mage::getSingleton('admin/session')->getUser()->getRoles());
    }
    
    public function getCurrentOfficeVO(){
    	
    	$officeVO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    	
    	$userOfficeModel = Mage::getModel('webportal/Master_Office_UserOffice_UserOffice');
    	$userOfficeDataObj = $userOfficeModel->getResource()->getByAdminUserID($this->getCurrentAdminUserID());
    		
    	if($userOfficeDataObj !== false){
    		
    		$userOfficeDTO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    		/* @var $userOfficeVO  Margshri_WebPortal_VO_Master_Office_UserOfficeVO */
    		$userOfficeVO    = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($userOfficeDTO, $userOfficeDataObj); 
    		
    		$officeModel = Mage::getModel('webportal/Master_Office_Office_Office');
    		$officeDataObj = $officeModel->getResource()->getByID($userOfficeVO->getOfficeID());
    		
    		if($officeDataObj !== false){
    		
    			$officeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    			/* @var $officeVO  Margshri_WebPortal_VO_Master_Office_OfficeVO */
    			$officeVO    = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($officeDTO, $officeDataObj);
    		}	
    		
    	}
    	return $officeVO;
    }
    
	public function getCountryOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_CountryList');
    	$options = $model->getResource()->getOptions();
    	if($this->getCurrentOfficeVO()->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$COUNTRY_TYPE){
    		foreach ($options as $id=>$value){
    			if($id == $this->getCurrentOfficeVO()->getCountryID()){
    				$options = array();
    				$options[$id] = $value;
    				break;
    			}
    		}
    	}
    	return $options;
    }


    public function getStateOptions(){
    	$options = array();
    	$newOptions = array();
    	$model = Mage::getModel('webportal/Directory_StateList');
    	$options = $model->getResource()->getOptions();
    	
    	
    	switch ($this->getCurrentOfficeVO()->getTypeID()){
    		
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$COUNTRY_TYPE:
    			foreach ($options as $id=>$row){
    				if($row["CountryID"] == $this->getCurrentOfficeVO()->getCountryID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "CountryID"=>$row["CountryID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    			
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$STATE_TYPE:
    			foreach ($options as $id=>$row){
    				if($id == $this->getCurrentOfficeVO()->getStateID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "CountryID"=>$row["CountryID"] );
    				}
    			}
    			$options = $newOptions;
    			break;

    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$DISTRICT_TYPE:
    			foreach ($options as $id=>$row){
    				if($id == $this->getCurrentOfficeVO()->getStateID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "CountryID"=>$row["CountryID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    				
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$CITY_TYPE:
    			foreach ($options as $id=>$row){
    				if($id == $this->getCurrentOfficeVO()->getStateID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "CountryID"=>$row["CountryID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    				 
    	}
    	return $options;
    }
    
    public function getDistrictOptions(){
    	$options = array();
    	$newOptions = array();
    	$model = Mage::getModel('webportal/Directory_DistrictList');
    	$options = $model->getResource()->getOptions();
    	
    	switch ($this->getCurrentOfficeVO()->getTypeID()){
    		
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$COUNTRY_TYPE:
    			foreach ($options as $id=>$row){
    				if($id == $this->getCurrentOfficeVO()->getDistrictID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "StateID"=>$row["StateID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    		
    		
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$STATE_TYPE:
    			foreach ($options as $id=>$row){
    				if($row["StateID"] == $this->getCurrentOfficeVO()->getStateID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "StateID"=>$row["StateID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    			
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$DISTRICT_TYPE:
    			foreach ($options as $id=>$row){
    				if($id == $this->getCurrentOfficeVO()->getDistrictID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "StateID"=>$row["StateID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    			
    		case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$CITY_TYPE:
    			foreach ($options as $id=>$row){
    				if($id == $this->getCurrentOfficeVO()->getDistrictID()){
    					$newOptions[$id] = array("Name"=>$row["Name"], "StateID"=>$row["StateID"] );
    				}
    			}
    			$options = $newOptions;
    			break;
    				 
    	}
    	return $options;
   	}
   	
   	public function getCityOptions(){
   		$options = array();
   		$newOptions = array();
   		$model = Mage::getModel('webportal/Directory_CityList');
   		$options = $model->getResource()->getOptions();
   		
   		switch ($this->getCurrentOfficeVO()->getTypeID()){
   			
   			
   			case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$COUNTRY_TYPE:
   				foreach ($options as $id=>$row){
   					if($id == $this->getCurrentOfficeVO()->getCityID()){
   						$newOptions[$id] = array("Name"=>$row["Name"], "DistrictID"=>$row["DistrictID"] );
   					}
   				}
   				$options = $newOptions;
   				break;
   			
   			case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$STATE_TYPE:
   				foreach ($options as $id=>$row){
   					//if($row["DistrictID"] == $this->getCurrentOfficeVO()->getDistrictID()){
   						$newOptions[$id] = array("Name"=>$row["Name"], "DistrictID"=>$row["DistrictID"] );
   					//}
   					/*
   					if($id == $this->getCurrentOfficeVO()->getCityID()){
   						$newOptions[$id] = array("Name"=>$row["Name"], "DistrictID"=>$row["DistrictID"] );
   					}
   					*/
   				}
   				$options = $newOptions;
   				break;
   			
   			case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$DISTRICT_TYPE:
   				$newOptions = array();
   				foreach ($options as $id=>$row){
   					if($row["DistrictID"] == $this->getCurrentOfficeVO()->getDistrictID()){
   						$newOptions[$id] = array("Name"=>$row["Name"], "DistrictID"=>$row["DistrictID"] );
   					}
   				}
   				$options = $newOptions;
   				break;
   				
   			case Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$CITY_TYPE:
   				foreach ($options as $id=>$row){
   					if($id == $this->getCurrentOfficeVO()->getCityID()){
   						$newOptions[$id] = array("Name"=>$row["Name"], "DistrictID"=>$row["DistrictID"] );
   					}
   				}
   				$options = $newOptions;
   				break;
   		}
   		return $options;
   	}
   	
   	
   	public static function  getClientIP() {
   		$ipaddress = '';
   		if (getenv('HTTP_CLIENT_IP'))
   			$ipaddress = getenv('HTTP_CLIENT_IP');
   			else if(getenv('HTTP_X_FORWARDED_FOR'))
   				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
   				else if(getenv('HTTP_X_FORWARDED'))
   					$ipaddress = getenv('HTTP_X_FORWARDED');
   					else if(getenv('HTTP_FORWARDED_FOR'))
   						$ipaddress = getenv('HTTP_FORWARDED_FOR');
   						else if(getenv('HTTP_FORWARDED'))
   							$ipaddress = getenv('HTTP_FORWARDED');
   							else if(getenv('REMOTE_ADDR'))
   								$ipaddress = getenv('REMOTE_ADDR');
   								else
   									$ipaddress = 'UNKNOWN';
   									return $ipaddress;
   	}
   	
    
}