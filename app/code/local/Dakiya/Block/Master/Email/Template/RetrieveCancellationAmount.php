<?php
class Dakiya_Block_Master_Email_Template_RetrieveCancellationAmount extends Mage_Adminhtml_Block_Template{

	public function __construct(){
		parent::__construct();
		$this->setTemplate('master/email/template/retrievecancellationamount.phtml');
	}
	
}