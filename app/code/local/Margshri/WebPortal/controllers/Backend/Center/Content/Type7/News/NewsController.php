<?php 
class Margshri_WebPortal_Backend_Center_Content_Type7_News_NewsController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type7_News_News");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentNewsVO', $DTO);
    	return Mage::registry('CurrentNewsVO');
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("News");
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$VO = $this->_init();
    	
    	if($VO == null){
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type7_News_News_Buttons')
    			->setTemplate('webportal/center/content/type7/news/news/info.phtml')
    			->setID($VO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type7_News_News_Grid');
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
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
    		$newsVO      = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
    		
    		
    		$newsVO->setID($post['ID']);
    		$newsVO->setValue($post['Value']);
    		$newsVO->setCode($post['Code']);
    		$newsVO->setUserID($post['UserID']);
    		$newsVO->setOrder($post['Order']);
    		$newsVO->setWebsiteLink($post['WebsiteLink']);
    		$newsVO->setIsPaid(0);
    		$newsVO->setTinNumber($post['TinNumber']);
    		$newsVO->setPANNumber($post['PANNumber']);
    		$newsVO->setDescription($post['Description']);
    		$newsVO->setDescription2($post['Description2']);
    		$newsVO->setNewsDate($post['NewsDate']);
    		$newsVO->setLaunchDate($post['LaunchDate']);
    		$newsVO->setEndDate($post['EndDate']);
    		
    		if($post['Category1ID'] != null && $post['Category1ID'] != ''){
    			$newsVO->setCategory1ID($post['Category1ID']);
    			$newsVO->setCategory1Value($post['Category1Value']);
    		}
    		
    		if($post['Category2ID'] != null && $post['Category2ID'] != ''){
    			$newsVO->setCategory2ID($post['Category2ID']);
    			$newsVO->setCategory2Value($post['Category2Value']);
    		}
    		
    		if($post['Category3ID'] != null && $post['Category3ID'] != ''){
    			$newsVO->setCategory3ID($post['Category3ID']);
    			$newsVO->setCategory3Value($post['Category3Value']);
    		}
    		
    		
    		$newsVO->setStatusID($post['StatusID']);
    		$newsVO->setLandLineNumber($post['LandLineNumber']);
    		$newsVO->setMobileNumber1($post['MobileNumber1']);
    		$newsVO->setMobileNumber2($post['MobileNumber2']);
    		$newsVO->setEmail($post['Email']);
    		$newsVO->setPinCode($post['PinCode']);
    		$newsVO->setAddress($post['Address']);
    		$newsVO->setCountryID(1);
    		
    		if($post['StateID'] == null || $post['StateID'] == ''){
    			$newsVO->setStateID(null);
    		}else{
    			$newsVO->setStateID($post['StateID']);
    		}
    			
    		if($post['DistrictID'] == null || $post['DistrictID'] == ''){
    			$newsVO->setDistrictID(null);
    		}else{
    			$newsVO->setDistrictID($post['DistrictID']);
    		}
    			
    		if($post['CityID'] == null || $post['CityID'] == ''){
    			$newsVO->setCityID(null);
    		}else{
    			$newsVO->setCityID($post['CityID']);
    		}
    		
    		
    		if($newsVO->getMobileNumber1() != null && $newsVO->getMobileNumber1() != '' &&
    				$newsVO->getMobileNumber2() != null && $newsVO->getMobileNumber2() != ''){
	    		if($newsVO->getMobileNumber1() == $newsVO->getMobileNumber2()){
	    			Mage::getSingleton('adminhtml/session')->addError("Both Mobile Number Can`t Be Same !");
	    			$this->_redirect('*/*/edit', array("ID"=>$newsVO->getID()));
	    			return;
	    		}
    		}	
    		
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type7_News_News");
    		
    		if( ($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != '') &&
	    			($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != '') &&
	    			($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != '') ){
    			
    				$response = $model->getResource()->saveDB($newsVO, $_FILES['Image'], $_FILES['PersonImage'], $_FILES['Person2Image']);
    			
    		}elseif(($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != '') &&
	    			($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != '') ){
    			
    				$response = $model->getResource()->saveDB($newsVO, $_FILES['Image'], $_FILES['PersonImage'], null);
    			
    		}elseif(($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != '') &&
    				 ($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != '')){
    				 
    				$response = $model->getResource()->saveDB($newsVO, null, $_FILES['PersonImage'], $_FILES['Person2Image']);
    		}elseif(($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != '') &&
    				 ($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != '')){
    						
    				$response = $model->getResource()->saveDB($newsVO, $_FILES['Image'], null, $_FILES['Person2Image']);

    		}elseif($_FILES['Image']['tmp_name'] != null && $_FILES['Image']['tmp_name'] != ''){
    				$response = $model->getResource()->saveDB($newsVO, $_FILES['Image'], null, null);
    				
    		}elseif($_FILES['PersonImage']['tmp_name'] != null && $_FILES['PersonImage']['tmp_name'] != ''){
    				$response = $model->getResource()->saveDB($newsVO, null, $_FILES['PersonImage'], null);

    		}elseif($_FILES['Person2Image']['tmp_name'] != null && $_FILES['Person2Image']['tmp_name'] != ''){
    				$response = $model->getResource()->saveDB($newsVO, null, null, $_FILES['Person2Image']);
    			
    		}else{
    				$response = $model->getResource()->saveDB($newsVO, null, null,null);
    		}
    		
    
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
    			$this->_redirect('*/*/index');
    		}else{
    			$adapter->getAdapter()->rollBack();
    			Mage::getSingleton('adminhtml/session')->addError($response['message']);
    			$this->_redirect('*/*/edit', array("ID"=>$newsVO->getID()));
    				
    		}
    
    	} catch (Exception $e) {
    		$adapter->getAdapter()->rollBack();
    		Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		$this->_redirect('*/*/edit', array("ID"=>$newsVO->getID()));
    	}
    	return;
    }
    
}
