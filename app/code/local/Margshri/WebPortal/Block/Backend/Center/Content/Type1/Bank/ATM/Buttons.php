<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type1_Bank_ATM_Buttons extends Mage_Adminhtml_Block_Template
{

    public function __construct()
    {
        parent::__construct();
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
                    'onclick'   => 'formJS.submit(); ',
                    'class' => 'save'
                ))
        );

        $this->setChild('entropy',
            $this->getLayout()->createBlock('webportal/Backend_Center_Content_Type1_Bank_ATM_Info') );

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
        return $this->getChildHtml('entropy');
    }

    public function getHTMLFormID()
    {
    	   return 'ATM';
    }

}
