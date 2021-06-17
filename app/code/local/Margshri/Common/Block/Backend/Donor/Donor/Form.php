<?php
class Margshri_Common_Block_Backend_Donor_Donor_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("common/donor/donor/form.phtml");
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
                    'label'     => Mage::helper('adminhtml')->__('Save'),
                    'onclick'   => 'donationFormJS.submit(); ',
                    'class' => 'save'
                ))
        );
		
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

    public function getHTMLFormID(){
    	   return 'DonationForm';
    }
    
    public function getDonationVO(){
        return Mage::registry('CurrentDonationVO');
    }
    
    public function getUserOptions(){
        $options = array();
        $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
        $options = $userModel->getResource()->getActiveOptions();
        return $options;
    }
    
    
    public function getDonationTypeOptions(){
        $options = array();
        $donationTypeModel = Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName);
        $options = $donationTypeModel->getResource()->getOptions();
        return $options;
    }
    
    
    public function getProgrammeOptions(){
        $options = array();
        $donationTypeModel = Mage::getModel(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName);
        $options = $donationTypeModel->getResource()->getOptions();
        return $options;
    }
    
    
    public function getReceiptBookOptions(){
        $options = array();
        $receiptBookModel = Mage::getModel(Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$modelName);
        $options = $receiptBookModel->getResource()->getOptions();
        return $options;
    }
    
    
    public function getDonationSatusOptions(){
        $options = array();
        $donationStatusModel = Mage::getModel(Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$modelName);
        $options = $donationStatusModel->getResource()->getOptions();
        return $options;
    }
    
}
