<?php
class Dakiya_Block_Master_Email_Template_CODERS extends Mage_Adminhtml_Block_Template{

	public function __construct(){
		parent::__construct();
		$this->setTemplate('master/email/template/coders.phtml');
	}
	
	public function getCommonVO(){
		$commonVO = Mage::registry("CurrentCommonVO");
		//Mage::unregister("CurrentCommonVO");
		return $commonVO; 
	}
}