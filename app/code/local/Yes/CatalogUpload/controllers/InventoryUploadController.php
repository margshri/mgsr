<?php 
class Yes_CatalogUpload_InventoryUploadController extends Mage_Adminhtml_Controller_Action
{
	private static $counter = 0;
	
	
	
	public function indexAction(){
		  $this->_title($this->__('Catalog Inventory Upload'));
		  $this->loadLayout();
		  
		  $this->_setActiveMenu('catalog');
		  $headerBlock= $this->getLayout()->createBlock('yescatalogupload/inventory_header')->setTemplate('Yes/CatalogUpload/Inventory/Header.phtml');
		  $gridBlock= $this->getLayout()->createBlock('yescatalogupload/inventory_grid_fileUploaded',"yescatalogupload.inventory.grid.fileUploaded") ;
		  
		  $headerBlock->setChild('grid',$gridBlock);
		  $this->getLayout()->getBlock('content')->append($headerBlock);
		  $this->renderLayout();
		  
	}
	public function inventoryUploadPageAction(){
		
		$this->_title($this->__('Inventory Upload'));
		$this->loadLayout();
		
		
		$headerBlock= $this->getLayout()->createBlock('yescatalogupload/inventory_buttons')->setTemplate('Yes/CatalogUpload/Inventory/info.phtml');
		$this->getLayout()->getBlock('content')->append($headerBlock);
		$this->renderLayout();
		
		
	}
	
	public function uploadAction()
    {
    	if(!empty($_FILES["file"]))
    	{
    		$model = Mage::getModel('yescatalogupload/inventoryUpload');
    		$response = $model->fileProcessing($_FILES["file"]);
    		
    	}
    	
    	if ($response['status'] == 'FAIL')
    		Mage::getSingleton('core/session')->addError($response['message']);
    	else if($response['status'] == 'SUCCESS')
    		Mage::getSingleton('core/session')->addSuccess($response['message']);
    	$this->_redirect("*/*/inventoryUploadPage");
   		 	
    }// end save action
    
   
   public function gridAction()
   {
   
   		$this->loadLayout();
   		$this->getResponse()->setBody($this->getLayout()->createBlock('yescatalogupload/inventory_grid_fileUploaded',"yescatalogupload.product.grid.fileUploaded")->toHtml() );
        
   }
	
	
}// end class