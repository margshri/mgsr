<?php

class Yes_Master_Block_Office_OfficeType_Tab_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Office Type');
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


     
         
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('YesMaster/OfficeType/entropy.phtml');
        
    }    

 
     
    public function getInfoData($var)
   {
            $data = Mage::registry('current_officeTypeVO');
                    
   	        return $data->getData($var) ;
   }    
    
	public function getHtmlId(){
		return 'entropy';
	}       
    
}