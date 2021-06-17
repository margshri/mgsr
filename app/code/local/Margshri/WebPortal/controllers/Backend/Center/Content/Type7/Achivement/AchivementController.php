<?php 
class Margshri_WebPortal_Backend_Center_Content_Type7_Achivement_AchivementController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type7_Achivement_Achivement");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentAchivementVO', $DTO);
    	return Mage::registry('CurrentAchivementVO');
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Achivement");
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$VO = $this->_init();
    	
    	if($VO == null){
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type7_Achivement_Achivement_Buttons')
    			->setTemplate('webportal/center/content/type7/achivement/achivement/info.phtml')
    			->setID($VO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type7_Achivement_Achivement_Grid');
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
    
    		// $hospitalDataObj = json_decode($post["HospitalDataObj"],true);
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();
    		$achivementVO     = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();
    		
    		
    		$achivementVO->setID($post['ID']);
    		$achivementVO->setValue($post['Value']);
    		$achivementVO->setCode($post['Code']);
    		$achivementVO->setUserID($post['UserID']);
    		$achivementVO->setOrder($post['Order']);
    		$achivementVO->setWebsiteLink($post['WebsiteLink']);
    		$achivementVO->setIsPaid(0);
    		$achivementVO->setDescription($post['Description']);
    		$achivementVO->setAchivementDate($post['AchivementDate']);
    		$achivementVO->setLaunchDate($post['LaunchDate']);
    		$achivementVO->setEndDate($post['EndDate']);
    		
    		if($post['Category1ID'] != null && $post['Category1ID'] != ''){
    			$achivementVO->setCategory1ID($post['Category1ID']);
    			$achivementVO->setCategory1Value($post['Category1Value']);
    		}
    		
    		if($post['Category2ID'] != null && $post['Category2ID'] != ''){
    			$achivementVO->setCategory2ID($post['Category2ID']);
    			$achivementVO->setCategory2Value($post['Category2Value']);
    		}
    		
    		if($post['Category3ID'] != null && $post['Category3ID'] != ''){
    			$achivementVO->setCategory3ID($post['Category3ID']);
    			$achivementVO->setCategory3Value($post['Category3Value']);
    		}
    		
    		
    		$achivementVO->setStatusID($post['StatusID']);
    		$achivementVO->setLandLineNumber($post['LandLineNumber']);
    		$achivementVO->setMobileNumber1($post['MobileNumber1']);
    		$achivementVO->setMobileNumber2($post['MobileNumber2']);
    		$achivementVO->setEmail($post['Email']);
    		$achivementVO->setPinCode($post['PinCode']);
    		$achivementVO->setAddress($post['Address']);
    		$achivementVO->setCountryID(1);
    		$achivementVO->setStateID($post['StateID']);
    		$achivementVO->setDistrictID($post['DistrictID']);
    		$achivementVO->setCityID($post['CityID']);
    		
    		
    		if($achivementVO->getMobileNumber1() != null && $achivementVO->getMobileNumber1() != '' &&
    				$achivementVO->getMobileNumber2() != null && $achivementVO->getMobileNumber2() != ''){
	    		
	    		if($achivementVO->getMobileNumber1() == $achivementVO->getMobileNumber2()){ 
	    			Mage::getSingleton('adminhtml/session')->addError("Both Mobile Number Can`t Be Same !");
	    			$this->_redirect('*/*/edit', array("ID"=>$achivementVO->getID()));
	    			return;
	    		}
    		}
    		
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type7_Achivement_Achivement");
    		
    		if($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != ''){
    			$response = $model->getResource()->saveDB($achivementVO, $_FILES['Image']);
    		}else{
    			$response = $model->getResource()->saveDB($achivementVO, null);
    		}
    		
    
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
    			$this->_redirect('*/*/index');
    		}else{
    			$adapter->getAdapter()->rollBack();
    			Mage::getSingleton('adminhtml/session')->addError($response['message']);
    			$this->_redirect('*/*/edit', array("ID"=>$achivementVO->getID()));
    				
    		}
    
    	} catch (Exception $e) {
    		$adapter->getAdapter()->rollBack();
    		Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		$this->_redirect('*/*/edit', array("ID"=>$achivementVO->getID()));
    	}
    	return;
    }
    
}
