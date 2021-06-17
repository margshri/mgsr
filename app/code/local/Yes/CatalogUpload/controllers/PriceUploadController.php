<?php 
class Yes_CatalogUpload_PriceUploadController extends Mage_Adminhtml_Controller_Action
{
	private static $counter = 0;
	
	
	
	public function indexAction(){
		  $this->_title($this->__('Catalog Price Upload'));
		  $this->loadLayout();
		  $this->_setActiveMenu('catalog');
		  $headerBlock= $this->getLayout()->createBlock('yescatalogupload/price_header')->setTemplate('Yes/CatalogUpload/Price/Header.phtml');
		  $gridBlock= $this->getLayout()->createBlock('yescatalogupload/price_grid_fileUploaded',"yescatalogupload.price.grid.fileUploaded") ;
		  $headerBlock->setChild('grid',$gridBlock);
		  $this->getLayout()->getBlock('content')->append($headerBlock);
		  $this->renderLayout();
	}

	public function priceUploadPageAction(){
		
		$this->_title($this->__('Price Upload'));
		$this->loadLayout();
		$headerBlock= $this->getLayout()->createBlock('yescatalogupload/price_buttons')->setTemplate('Yes/CatalogUpload/Price/info.phtml');
		$this->getLayout()->getBlock('content')->append($headerBlock);
		$this->renderLayout();
	}
	
 	public function uploadAction()
    {
    	if(!empty($_FILES["file"]))
    	{ 	
    		$model = Mage::getModel('yescatalogupload/priceUpload');
    		$response = $model->fileProcessing($_FILES["file"]);
    	}
    	
    	if ($response['status'] == 'FAIL')
    		Mage::getSingleton('core/session')->addError($response['message']);
    	else if($response['status'] == 'SUCCESS')
    		Mage::getSingleton('core/session')->addSuccess($response['message']);
    	$this->_redirect("*/*/priceUploadPage");
    }// end upload action
    
   
   public function gridAction()
   {
   		$this->loadLayout();
   		$this->getResponse()->setBody($this->getLayout()->createBlock('yescatalogupload/price_grid_fileUploaded',"yescatalogupload.product.grid.fileUploaded")->toHtml() );
   }
	
	
}// end class