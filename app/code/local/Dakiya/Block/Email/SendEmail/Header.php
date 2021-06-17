<?php
class Dakiya_Block_Email_SendEmail_Header extends Mage_Adminhtml_Block_Template{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('email/sendemail/header.phtml');
	}
	
	public function getGridHtml(){
		return $this->getChild('grid')->toHtml();
	}
	
}
