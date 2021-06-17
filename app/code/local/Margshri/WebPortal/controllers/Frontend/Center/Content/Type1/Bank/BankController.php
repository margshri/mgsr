<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type1_Bank_BankController extends Mage_Core_Controller_Front_Action {
	
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	public function bankAction(){
		$this->loadLayout();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type1_Bank_Bank_Info');
		$block->setTemplate('webportal/center/content/type1/bank/bank/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function branchAction(){
		$this->loadLayout();
	
		$id = $this->getRequest()->getParam("ID");
		Mage::register("CurrentBankID", $id);
		
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type1_Bank_Branch_Info');
		$block->setTemplate('webportal/center/content/type1/bank/branch/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		 
		$this->renderLayout();
	}
	
	
	public function atmAction(){
		$this->loadLayout();
	
		$id = $this->getRequest()->getParam("ID");
		Mage::register("CurrentBankID", $id);
		
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type1_Bank_ATM_Info');
		$block->setTemplate('webportal/center/content/type1/bank/atm/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
			
		$this->renderLayout();
	}

	public function safetyAction(){
		$this->loadLayout();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type1_Bank_ATM_Safety');
		$block->setTemplate('webportal/center/content/type1/bank/atm/safety.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
    
}
