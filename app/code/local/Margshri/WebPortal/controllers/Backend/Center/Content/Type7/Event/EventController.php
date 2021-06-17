<?php 
class Margshri_WebPortal_Backend_Center_Content_Type7_Event_EventController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type7_Event_Event");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentEventVO', $DTO);
    	return Mage::registry('CurrentEventVO');
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Event");
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$VO = $this->_init();
    	
    	if($VO == null){
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type7_Event_Event_Buttons')
    			->setTemplate('webportal/center/content/type7/event/event/info.phtml')
    			->setID($VO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type7_Event_Event_Grid');
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
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
    		$eventVO     = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
    		
    		
    		$eventVO->setID($post['ID']);
    		$eventVO->setValue($post['Value']);
    		$eventVO->setCode($post['Code']);
    		$eventVO->setUserID($post['UserID']);
    		$eventVO->setOrder($post['Order']);
    		$eventVO->setWebsiteLink($post['WebsiteLink']);
    		$eventVO->setIsPaid(0);
    		$eventVO->setTinNumber($post['TinNumber']);
    		$eventVO->setPANNumber($post['PANNumber']);
    		$eventVO->setDescription($post['Description']);
    		$eventVO->setDescription2($post['Description2']);
    		$eventVO->setEventDate($post['EventDate']);
    		$eventVO->setLaunchDate($post['LaunchDate']);
    		$eventVO->setEndDate($post['EndDate']);
    		
    		if($post['Category1ID'] != null && $post['Category1ID'] != ''){
    			$eventVO->setCategory1ID($post['Category1ID']);
    			$eventVO->setCategory1Value($post['Category1Value']);
    		}
    		
    		if($post['Category2ID'] != null && $post['Category2ID'] != ''){
    			$eventVO->setCategory2ID($post['Category2ID']);
    			$eventVO->setCategory2Value($post['Category2Value']);
    		}
    		
    		if($post['Category3ID'] != null && $post['Category3ID'] != ''){
    			$eventVO->setCategory3ID($post['Category3ID']);
    			$eventVO->setCategory3Value($post['Category3Value']);
    		}
    		
    		
    		$eventVO->setStatusID($post['StatusID']);
    		$eventVO->setLandLineNumber($post['LandLineNumber']);
    		$eventVO->setMobileNumber1($post['MobileNumber1']);
    		$eventVO->setMobileNumber2($post['MobileNumber2']);
    		$eventVO->setEmail($post['Email']);
    		$eventVO->setPinCode($post['PinCode']);
    		$eventVO->setAddress($post['Address']);
    		$eventVO->setCountryID(1);
    		
    		if($post['StateID'] == null || $post['StateID'] == ''){
    			$eventVO->setStateID(null);
    		}else{
    			$eventVO->setStateID($post['StateID']);
    		}
    			
    		if($post['DistrictID'] == null || $post['DistrictID'] == ''){
    			$eventVO->setDistrictID(null);
    		}else{
    			$eventVO->setDistrictID($post['DistrictID']);
    		}
    			
    		if($post['CityID'] == null || $post['CityID'] == ''){
    			$eventVO->setCityID(null);
    		}else{
    			$eventVO->setCityID($post['CityID']);
    		}
    		
    		
    		if($eventVO->getMobileNumber1() != null && $eventVO->getMobileNumber1() != '' &&
    				$eventVO->getMobileNumber2() != null && $eventVO->getMobileNumber2() != ''){
	    		if($eventVO->getMobileNumber1() == $eventVO->getMobileNumber2()){
	    			Mage::getSingleton('adminhtml/session')->addError("Both Mobile Number Can`t Be Same !");
	    			$this->_redirect('*/*/edit', array("ID"=>$eventVO->getID()));
	    			return;
	    		}
    		}	
    		
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type7_Event_Event");
    		
    		if( ($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != '') &&
    				($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != '') &&
	    			($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != '') ){
    			$response = $model->getResource()->saveDB($eventVO, $_FILES['Image'], $_FILES['PersonImage'], $_FILES['Person2Image']);

    		}elseif( ($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != '') && 
	    			($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != '')){
    			$response = $model->getResource()->saveDB($eventVO, $_FILES['Image'], $_FILES['PersonImage'], null);
    				
    		}elseif(($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != '')  &&
    				($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != '')){
    			$response = $model->getResource()->saveDB($eventVO, null, $_FILES['PersonImage'], $_FILES['Person2Image']);

    		}elseif(($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != '') &&
    				($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != '')){
    			$response = $model->getResource()->saveDB($eventVO, $_FILES['Image'], null, $_FILES['Person2Image']);
    			
    		}elseif($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != ''){
    			$response = $model->getResource()->saveDB($eventVO, $_FILES['Image'], null, null);
    			
    		}elseif($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != ''){
    			$response = $model->getResource()->saveDB($eventVO, null, $_FILES['PersonImage'], null);
    			
    		}elseif($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != ''){
    			$response = $model->getResource()->saveDB($eventVO, null, null, $_FILES['Person2Image']);
    			
    		}else{
    			$response = $model->getResource()->saveDB($eventVO, null, null, null);
    		}
    
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
    			$this->_redirect('*/*/index');
    		}else{
    			$adapter->getAdapter()->rollBack();
    			Mage::getSingleton('adminhtml/session')->addError($response['message']);
    			$this->_redirect('*/*/edit', array("ID"=>$eventVO->getID()));
    				
    		}
    
    	} catch (Exception $e) {
    		$adapter->getAdapter()->rollBack();
    		Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		$this->_redirect('*/*/edit', array("ID"=>$eventVO->getID()));
    	}
    	return;
    }
    
}
