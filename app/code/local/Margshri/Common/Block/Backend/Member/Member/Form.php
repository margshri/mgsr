<?php
class Margshri_Common_Block_Backend_Member_Member_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("common/member/member/form.phtml");
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
    	   return 'MemberForm';
    }
    
    public function getDonationVO(){
        return Mage::registry('CurrentDonationVO');
    }
    
    public function getUserOptions(){
        $options = array();
        $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
        $options = $userModel->getResource()->getOptions();
        return $options;
    }
    
    
    public function getDonationTypeOptions(){
        $options = array();
        $donationTypeModel = Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName);
        $options = $donationTypeModel->getResource()->getOptions();
        return $options;
    }
    
    /*
    public function getReceiptBookOptions(){
        $adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
        $adminUserDataObj = Mage::getModel('admin/user')->load($adminUserID)->getData();
        $adminUserName = $adminUserDataObj["username"];
        
        $options = array();
        $receiptBookModel = Mage::getModel(Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$modelName);
        $options = $receiptBookModel->getResource()->getOpenOptions();
        
        $newOptions = array();
        if($adminUserID != 1){ // 1 for admin
            foreach ($options as $key=>$val){
                
                $firstVal = explode("-", $val); 
                
                if(strtolower(trim($firstVal[0])) == strtolower(trim($adminUserName))){
                    $newOptions[$key] = $val;
                }
            }
        }else{
            $newOptions = $options;
        }
        return $newOptions;
    }
    */
    
    public function getReceiptBookOptions(){
        $adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
        $adminUserDataObj = Mage::getModel('admin/user')->load($adminUserID)->getData();
        $adminUserName = $adminUserDataObj["username"];
        
        $options = array();
        $receiptBookModel = Mage::getModel(Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$modelName);
        $receiptBookDataObjs = $receiptBookModel->getResource()->getList();
        
        
        $options = array();
        if(sizeof($receiptBookDataObjs) > 0){
            foreach ($receiptBookDataObjs as $receiptBookDataObj){
                $receiptBookDTO = new Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO();
                /* @var $receiptBookVO Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO */
                $receiptBookVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($receiptBookDTO, $receiptBookDataObj);
            
                if($adminUserID != 1){ // 1 for admin
                    if(strtolower(trim($receiptBookVO->getBookCode())) == strtolower(trim($adminUserName))){
                        $options[$receiptBookVO->getID()] = $receiptBookVO->getBookName();
                    }
                }else{
                    $options[$receiptBookVO->getID()] = $receiptBookVO->getBookName();
                }
            }
        }
        
        
        return $options;
    }
    
    
    public function getDonationSatusOptions(){
        $options = array();
        $donationStatusModel = Mage::getModel(Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$modelName);
        $options = $donationStatusModel->getResource()->getOptions();
        return $options;
    }
    
}
