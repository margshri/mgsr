<?php 
class Margshri_Common_Backend_Customer_ManageCustomer_ManageCustomerController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Customer_ManageCustomer_Grid';
	private $buttonsBlock ='common/Backend_Customer_ManageCustomer_Buttons';
	
	
	protected function _init(){
		$customerVO = new Margshri_Common_VO_Customer_CustomerVO();
		$customerID = $this->getRequest()->getParam('CustomerID');
		if($customerID != null){
		    $customerVO->setID($customerID);
		    
			$customerImage = $this->getRequest()->getParam('CustomerImage');
			if($customerImage != null){
				$customerVO->setCustomerImage($customerImage);
			}
			
			$customerModel = Mage::getModel('common/Customer_Customer');
			$customerDataObj = $customerModel->getResource()->getByCustomerID($customerID);
			if($customerDataObj !== false){
			    $customerVO->setIsShowProfile($customerDataObj['IsShowProfile']);
			}
		}
	
		Mage::register('CurrentCustomerVO', $customerVO);
		return Mage::registry('CurrentCustomerVO');
	
	}
	
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	
	
	public function editAction(){
		$this->_init();		
		$this->loadLayout();
		$this->_addContent(
			$this->getLayout()->createBlock($this->buttonsBlock)
		);
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}	

	public function saveAction(){
		try {
	
			$post = $this->getRequest()->getPost();
	
			// $errorMsg = array();
			// $response = array();
			$adapter = new Margshri_Common_VO_Customer_CustomerVO();
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data!'));
			}
			
			$customerID = $post['ID'];
			$lastPicName = $post['LastPicName'];
			if($customerID == null || $customerID == ""){
				Mage::throwException($this->__('CustomerID Not Found!'));
			}
			
			
			$customerModel = Mage::getModel('common/Customer_Customer');
			$customerDataObj = $customerModel->getResource()->getByCustomerID($customerID);
			if($customerDataObj !== false){
				$customerDTO = new Margshri_Common_VO_Customer_CustomerVO();
				$customerVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($customerDTO, $customerDataObj);
			}else{
				$customerVO = new Margshri_Common_VO_Customer_CustomerVO();
				$customerVO->setID(0);
				$customerVO->setCustomerID($customerID);
			}
			
			if($post['IsShowProfile']){
				$customerVO->setIsShowProfile(1);
			}else{
				$customerVO->setIsShowProfile(0);
			}
				
			
			
			$customerImageObj = $_FILES['CustomerImage'];
			if($customerImageObj['tmp_name'] != null && $customerImageObj['tmp_name'] != ''){
				
				if($lastPicName != null && $lastPicName != ""){
					$lastPicExt = substr(strrchr($lastPicName, '.'), 1);
				}
				$ext = substr(strrchr($customerImageObj["name"], '.'), 1);
				
				$helper = Mage::helper("margshri/Utility");
				$customerImagePath = $helper->getServerPath().'/media/customer/profile_pic/';
				$customerImageFullPath = $customerImagePath.$customerID.".".$ext; 
				$lastImageFullPath = $customerImagePath.$customerID.".".$lastPicExt;
				
				if(!(is_dir($customerImagePath) && is_writable($customerImagePath))) {
					Mage::throwException($this->__('Upload directory is not writable, or does not exist!'));
				}
				
				
				
				
				//database write adapter
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
				$data = array('value' => "customer/profile_pic/".$customerID.".".$ext);
				$where = array(
				    'attribute_id = ?' => 140,
				    'entity_type_id = ?' => 1,
				    'entity_id = ?' => $customerID
				);
				
				$write->update('customer_entity_varchar', $data, $where);

				
				$customerVO->setCustomerImage("customer/profile_pic/".$customerID.".".$ext);
				// if($queryResult){
					
				if(file_exists($lastImageFullPath)){
					unlink($lastImageFullPath);
				}
				// umask();
				$uploadResult = move_uploaded_file($customerImageObj["tmp_name"], $customerImageFullPath);
				if($uploadResult){
					Mage::getSingleton('adminhtml/session')->addSuccess("Successfully Saved.");
				}else{
					Mage::throwException($this->__('Could Not Be Saved!'));
				}
				// }else{
					//Mage::throwException($this->__('Query Result False'));
				//}		
			}
			
			$adapter->getAdapter()->beginTransaction();
			// $isTransactionStart = true;
			$customerModel = Mage::getModel('common/Customer_Customer');
			$customerSaveRes = $customerModel->getResource()->saveDB($customerVO);
			if($customerSaveRes['status'] != "SUCCESS"){
				$adapter->getAdapter()->rollBack();
				Mage::throwException($this->__('Customer Data Not Updated!'));
			}
			$adapter->getAdapter()->commit();
	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		
		$this->_redirect('*/*');
		return;
	} 
	
}// end class
