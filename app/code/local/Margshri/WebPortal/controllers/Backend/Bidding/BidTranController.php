<?php 
class Margshri_WebPortal_Backend_Bidding_BidTranController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Bid Tran');
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Bidding_BidTran_Grid');
    	$this->getResponse()->setBody($gridBlock->toHtml());
    }

}
