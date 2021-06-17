<?php

class Yes_CatalogUpload_Block_Price_Buttons extends Mage_Adminhtml_Block_Template
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
                    'label'     => Mage::helper('adminhtml')->__('Upload'),
                    //'onclick'   => 'productUploadJS();',
                	'onclick'   => 'priceUploadJS();',
                	'class' => 'upload'
                    //'onclick'   => 'productForm.submit();return false;',
                ))
        );
        

         
        $this->setChild('productUploadEntropy',
            $this->getLayout()->createBlock('yescatalogupload/price_tab_info') );

             
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
        return $this->getChildHtml('productUploadEntropy');           
   } 
   
    
   
   public function getHtmlId()
    {
    	   return 'OfficeType';
     }       

   
}