<?php

class Yes_Master_Block_Office_OfficeType_Buttons extends Mage_Adminhtml_Block_Template
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
                    'label'     => Mage::helper('adminhtml')->__('Save'),
                    'onclick'   => 'officeTypeJS.submit(event); ',
                    'class' => 'save'
                    //'onclick'   => 'productForm.submit();return false;',
                ))
        );
        

         
        $this->setChild('officeTypeEntropy',
            $this->getLayout()->createBlock('yesmaster/office_officeType_tab_info') );

             
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

  
   
    
   public function getEntropy()
   {
        return $this->getChildHtml('officeTypeEntropy');           
   } 
   
    
   
   public function getHtmlId()
    {
    	   return 'OfficeType';
     }       

   
}