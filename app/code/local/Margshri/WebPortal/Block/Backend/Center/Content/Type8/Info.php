<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type8_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('News Info');
    }

    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareLayout()
    {
    	$this->setChild('addProductButton',
    			$this->getLayout()->createBlock('adminhtml/widget_button')
    			->setData(array(
    					'label'     => Mage::helper('catalog')->__('Add Product'),
    					'onclick'   => 'return productJS.addItem(event)',
    					'class'     => 'add'
    			))
    	);
    }
    
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('webportal/center/content/type8/entropy.phtml');
    }

    public function getType8VO(){
        return Mage::registry('CurrentType8VO');
    }
    
    public function getTableCode(){
    	return Mage::registry("CurrentTableCode");
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
    
    
    /*
    public function getCountryOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_CountryList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }

    public function getStateOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_StateList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getDistrictOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_DistrictList');
    	$options = $model->getResource()->getOptions();
    	return $options;
   	}
   	
   	public function getCityOptions(){
   		$options = array();
   		$model = Mage::getModel('webportal/Directory_CityList');
   		$options = $model->getResource()->getOptions();
   		return $options;
   	}
   	*/

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
    
    
    public function getHTMLFormID(){
    	return 'Type8';
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
    		
    		if($this->isEdit()){ 
    			if($VO->getCode() == $this->getTableCode()){
    				$VOs[] = $VO;
    				break;
    			}	
    			
    		}else{
	    		if($VO->getStatusID() == Margshri_WebPortal_VO_StatusVO::$ACTIVE && 
	    			$VO->getTableTypeID() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE8 ){ 
	    			$VOs[] = $VO;  
	    		}
    		}	
    	}
    	return $VOs;
    }
}