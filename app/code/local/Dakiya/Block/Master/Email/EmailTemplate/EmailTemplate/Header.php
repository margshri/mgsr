<?php
class Dakiya_Block_Master_Email_EmailTemplate_EmailTemplate_Header extends Mage_Adminhtml_Block_Template{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('master/email/emailtemplate/emailtemplate/header.phtml');
	}
		
	/**
	 * Get URL of adding new record
	 */
	public function getAddNewUrl(){
		return $this->getUrl('*/*/edit');
	}

	/**
	 * Get grid HTML
	 */
	public function getGridHtml(){
		return $this->getChild('grid')->toHtml();
	}
	 
}
