<?php
class Margshri_WebPortal_Block_Backend_Firm_Firm_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('webportal/firm/firm/entropy.phtml');
    }

    public function getFirmVO(){
        return Mage::registry('CurrentFirmVO');
    }
    
    public function getCountryOptions(){
    	return Mage::helper('webportal/Data')->getCountryOptions();
    }
    
    public function getStateOptions(){
    	return Mage::helper('webportal/Data')->getStateOptions();
    }
    
    public function getDistrictOptions(){
    	return Mage::helper('webportal/Data')->getDistrictOptions();
    }
    
    public function getCityOptions(){
    	return Mage::helper('webportal/Data')->getCityOptions();
    }
 
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getDynamicColumnOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Table_DynamicColumn');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getPriorityOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Priority_Priority');
    	$options = $model->getResource()->getOptions();
		krsort($options);
    	return $options;
    }
    
    public function getPaymentMethodOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Payment_PaymentMethod');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
	public function getBusinessDayOptions(){
    	$options = array("Mon"=>"Mon", "Tue"=>"Tue", "Wed"=>"Wed", "Thu"=>"Thu", "Fri"=>"Fri", "Sat"=>"Sat", "Sun"=>"Sun");
    	return $options;
    }

    
    public function getHTMLFormID(){
    	return 'Firm';
    }

    public function isEdit(){
    	$type8VO    = $this->getType8VO();
    	if($type8VO != null){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function getTableVOs(){
    	
    	$model = Mage::getModel('webportal/Master_Table_Table');
    	$dataObjs = $model->getResource()->getOrderList("FileName", "Asc");
    	$VOs = array();
    	foreach ($dataObjs as $dataObj){
    		$DTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		/* @var $VO Margshri_WebPortal_VO_Master_Table_TableVO */ 
    		$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		
    		if($VO->getStatusID() == Margshri_WebPortal_VO_StatusVO::$ACTIVE && 
				$VO->getCode() != 'apctwebprivatesector' && $VO->getCode() != 'apctwebgovernmentsector' &&
    			($VO->getTableTypeID() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE8 || 
    				$VO->getTableTypeID() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE10 )){
    			$VOs[] = $VO;  
    		}
    	}
    	return $VOs;
    }
}
