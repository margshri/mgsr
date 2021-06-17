<?php 
class Margshri_WebPortal_Backend_CLP_CLPPoints_CLPPointsController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='webportal/Backend_CLP_CLPPoints_Grid';
 	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	 
}// end class
