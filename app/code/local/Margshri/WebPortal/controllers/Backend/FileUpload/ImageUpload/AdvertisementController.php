<?php 
class Margshri_WebPortal_Backend_FileUpload_ImageUpload_AdvertisementController extends Mage_Adminhtml_Controller_Action{
	
	private static $counter = 0;
	
	protected function _init(){
		 
		if($this->entityID !=null){
			$model   = Mage::getModel("webportal/FileUpload_ImageUpload_Advertisement");
			$dataObj = $model->getResource()->getByID($this->entityID);
	
			if($dataObj !== false){
				$DTO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
				$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
			}
		}
	
		Mage::register('CurrentAdvertisementVO', $DTO);
		return Mage::registry('CurrentAdvertisementVO');
	}
	
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_title($this->__('File Upload'));
		$this->getLayout()->getBlock('head')->setTitle("Image Upload");
		$this->_setActiveMenu('managedate');
		return $this;
	}
	
	public function indexAction(){
		$this->_initAction();
	    $this->renderLayout();
	}
	
	
	public function editAction(){
		 
		$this->entityID  = $this->getRequest()->getParam("ID");
		$VO = $this->_init();
		 
		if($VO == null){
			$VO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
		}
	
		$this->loadLayout();
		 
		$this->_addContent(
				$this->getLayout()->createBlock('webportal/Backend_FileUpload_ImageUpload_Advertisement_Buttons')
				->setTemplate('webportal/fileupload/imageupload/advertisement/info.phtml')
				->setID($VO->getID())
		);
		$this->renderLayout();
	}
	
	public function gridAction()
	{
		$gridBlock =$this->getLayout()->createBlock('webportal/Backend_FileUpload_ImageUpload_Advertisement_Grid');
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	
	public function saveAction(){
		try {
	
			$post = $this->getRequest()->getPost();
	
			$errorMsg = array();
			$response = array();
	
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
	
			$adapter     = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
			$responseVO  = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
			$advertisementVO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
	
	
			$advertisementVO->setID($post['ID']);
			$advertisementVO->setValue($post['Value']);
			$advertisementVO->setCode($post['Code']);
			$advertisementVO->setTypeID($post['TypeID']);
			$advertisementVO->setStatusID($post['StatusID']);
			$advertisementVO->setMobileNumber1($post['MobileNumber1']);
			$advertisementVO->setPinCode($post['PinCode']);
			$advertisementVO->setAddress($post['Address']);
			$advertisementVO->setCountryID(1);
			$advertisementVO->setOrder($post['Order']);
			$advertisementVO->setTableCode($post['TableCode']);
			$advertisementVO->setWebsiteLink($post['WebsiteLink']);
			
			$advertisementVO->setIsTemp(0);
			if(array_key_exists("IsTemp",$post)){
				if($post['IsTemp'] == 'on'){
					$advertisementVO->setIsTemp(1);
				}
			}
			
			$advertisementVO->setLaunchDate($post['LaunchDate']);
			$advertisementVO->setEndDate($post['EndDate']);
			
			if($post['StateID'] == null || $post['StateID'] == ''){
				$advertisementVO->setStateID(null);
			}else{
				$advertisementVO->setStateID($post['StateID']);
			}
			
			if($post['DistrictID'] == null || $post['DistrictID'] == ''){
				$advertisementVO->setDistrictID(null);
			}else{
				$advertisementVO->setDistrictID($post['DistrictID']);
			}
			
			if($post['CityID'] == null || $post['CityID'] == ''){
				$advertisementVO->setCityID(null);
			}else{
				$advertisementVO->setCityID($post['CityID']);
			}
			
			 
			$adapter->getAdapter()->beginTransaction();
			$model = Mage::getModel("webportal/FileUpload_ImageUpload_Advertisement");
	
			if($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != ''){
				$response = $model->getResource()->saveDB($advertisementVO, $_FILES['Image']);
			}else{
				$response = $model->getResource()->saveDB($advertisementVO, null);
			}
	
	
			if($response['status'] == "SUCCESS"){
				$adapter->getAdapter()->commit();
				Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
				$this->_redirect('*/*/index');
			}else{
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('adminhtml/session')->addError($response['message']);
				$this->_redirect('*/*/edit', array("ID"=>$advertisementVO->getID()));
	
			}
	
		} catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*/edit', array("ID"=>$advertisementVO->getID()));
		}
		return;
	}	
	
}// end class