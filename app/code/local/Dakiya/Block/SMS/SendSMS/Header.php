<?php
class Dakiya_Block_SMS_SendSMS_Header extends Mage_Adminhtml_Block_Template{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('sms/sendsms/header.phtml');
	}
	
	public function getGridHtml(){
		return $this->getChild('grid')->toHtml();
	}
	
}
