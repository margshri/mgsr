<?php 
class Margshri_Common_Backend_Customer_ManageVisitor_ActualVisitorController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Customer_ManageCustomer_Grid';
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}	
 
}// end class
