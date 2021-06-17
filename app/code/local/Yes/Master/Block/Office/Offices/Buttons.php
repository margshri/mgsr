<?php

class Yes_Master_Block_Office_Offices_Buttons extends Mage_Adminhtml_Block_Template
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
                    'label'     => Mage::helper('adminhtml')->__('Save Office'),
                    'onclick'   => 'officeJS.submit(); ',
                    'class' => 'saveOffice'
                    //'onclick'   => 'productForm.submit();return false;',
                ))
        );

        $this->setChild('deleteButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Delete Office'),
                    'onclick'   => 'deleteConfirm(\'' . Mage::helper('adminhtml')->__('Are you sure you want to do this?') . '\', \'' . $this->getUrl('*/*/delete', array('OfficeID' => $this->getRequest()->getParam('OfficeID'))) . '\')',
                    'class' => 'delete'
                ))
        );
        
        $this->setChild('officeEntropy',
            $this->getLayout()->createBlock('yesmaster/office_offices_tab_officeInfo') );

        $this->setChild('officeTerminal',
            $this->getLayout()->createBlock('yesmaster/office_offices_tab_officeTerminal') );
            
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

    public function getDeleteButtonHtml()
    {
        if( intval($this->getRequest()->getParam('OfficeID')) == 0 ) {
            return;
        }
        return $this->getChildHtml('deleteButton');
    }

    public function getUser()
    {
        return Mage::registry('user_data');
    }

    
   public function getOfficeEntropy()
   {
        return $this->getChildHtml('officeEntropy');           
   } 
   
   public function getOfficeTerminal()
   {
        return $this->getChildHtml('officeTerminal');           
   } 
   
   
   public function getHtmlId()
    {
    	   return 'Office';
     }       

   
}