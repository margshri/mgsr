<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type2_Professional_Professional_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel(){
        return Mage::helper('adminhtml')->__('Professional Info');
    }

    public function getTabTitle(){
        return $this->getTabLabel();
    }

    public function canShowTab(){
        return true;
    }

    public function isHidden(){
        return false;
    }
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('webportal/center/content/type2/professional/professional/entropy.phtml');
    }

    public function getProfessionalVO(){
        return Mage::registry('CurrentProfessionalVO');
    }
    
    public function getProfessionOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Center_Content_Type2_Profession_Profession');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    

    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'Professional';
    }
    
}