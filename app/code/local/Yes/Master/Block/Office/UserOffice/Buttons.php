<?php

class Yes_Master_Block_Office_UserOffice_Buttons extends Mage_Adminhtml_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        //$this->setTemplate('yesmaster/products_tab_productsalestax');
    }

    protected function _prepareLayout()
    {
        $this->setChild('backButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Back'),
                    'onclick'   => 'window.location.href=\''.$this->getUrl('*/*/').'\'',
                    'class' => 'back'
                ))
        );

        $this->setChild('resetButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Reset'),
                    'onclick'   => 'window.location.reload()'
                ))
        );

        $this->setChild('saveButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Save User Office'),
                    'onclick'   => 'userOfficeJS.submit(); ',
                    'class' => 'save'
                    //'onclick'   => 'productForm.submit();return false;',
                ))
        );

       
        
        $this->setChild('userOfficeEntropy',
            $this->getLayout()->createBlock('yesmaster/office_userOffice_tab_userOfficeInfo') );            
        
        return parent::_prepareLayout();
    }

    public function getBackButtonHtml()
    {
        return $this->getChildHtml('backButton');
    }

    public function getResetButtonHtml()
    {
        return $this->getChildHtml('resetButton');
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('saveButton');
    }

    public function getUser()
    {
        return Mage::registry('user_data');
    }

    
   public function getUserOfficeEntropy()
   {
        return $this->getChildHtml('userOfficeEntropy');  	        
   } 
   
  
   public function getHtmlId()
    {
        return 'useroffice';
    }       

   
}