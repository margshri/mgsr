<?php
class Dakiya_Block_SMS_SendSMS_Buttons extends Mage_Adminhtml_Block_Template{

    public function __construct(){
        parent::__construct();
        $this->setTemplate('sms/sendsms/info.phtml');
    }

    protected function _prepareLayout(){
    	
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
                    'label'     => Mage::helper('adminhtml')->__('Send'),
                    'onclick'   => 'formJS.submit(); ',
                    'class' => 'save'
                ))
        );

        $this->setChild('entropy',
            $this->getLayout()->createBlock('dakiya/SMS_SendSMS_Info') );

        return parent::_prepareLayout();
    }

    public function getBackButtonHtml(){
        return $this->getChildHtml('backButton');
    }

    public function getResetButtonHtml(){
        return $this->getChildHtml('resetButton');
    }

    public function getSaveButtonHtml(){
        return $this->getChildHtml('saveButton');
    }

    public function getEntropy(){
        return $this->getChildHtml('entropy');
    }

    public function getHTMLFormID(){
    	   return 'SendSMS';
    }

}
