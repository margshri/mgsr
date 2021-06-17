<?php 
class Margshri_Transport_Backend_Master_Vahicale_CommonController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='transport/Backend_Master_Vahicale_Common_Grid';
	private $formBlock ='transport/Backend_Master_Vahicale_Common_Form';
	
	
	protected function _init(){
	    $commonID = $this->getRequest()->getParam('ID');
	    $commonVO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
	    $vahicaleVO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	    $ownerVO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
	    $driverVO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
	    
	    if($commonVO != null){
	        $commonModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName);
	        $commonDataObj = $commonModel->getResource()->getByID($commonID);
	        if($commonDataObj !== false){
	            $commonDTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
	            $commonVO = Margshri_Common_Helper_Utility::callInstanceFunction($commonDTO, $commonDataObj);
	            
	            $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
	            $vahicaleDataObj = $vahicaleModel->getResource()->getByID($commonVO->getVahicaleID());
	            if($vahicaleDataObj !== false){
	                $vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	                $vahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
	            }
	            
	            
	            $ownerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
	            $ownerDataObj = $ownerModel->getResource()->getByID($commonVO->getOwnerID());
	            if($ownerDataObj !== false){
	                $ownerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
	                $ownerVO = Margshri_Common_Helper_Utility::callInstanceFunction($ownerDTO, $ownerDataObj);
	            }
	            
	            $driverModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName);
	            $driverDataObj = $driverModel->getResource()->getByID($commonVO->getDriverID());
	            if($driverDataObj !== false){
	                $driverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
	                $driverVO = Margshri_Common_Helper_Utility::callInstanceFunction($driverDTO, $driverDataObj);
	            }
			}
		}
		
		$commonVO->setVahicaleVO($vahicaleVO);
		$commonVO->setOwnerVO($ownerVO);
		$commonVO->setDriverVO($driverVO);
		
		Mage::register('CurrentCommonVO', $commonVO);
		return $commonVO;
	}
	
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	 
	
	public function editAction(){
		/* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */ 
	    $commonVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setCommonID($commonVO->getID())
		);
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}	

	
	public function saveAction(){
	    
    	try {
    	    $responseVO = new Margshri_Common_VO_ResponseVO();
    	    $isTransactionStart = false;
    	    
    		$post = $this->getRequest()->getPost();
    		if (empty($post)) {
    			Mage::throwException("Invalid Form Data.");
    		}
    		
    		$commonDataObj = json_decode($post["CommonDataObj"],true);
    		if($commonDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$commonDTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
    		/* @var $commonVO Margshri_Transport_VO_Master_Vahicale_CommonVO */
    		$commonVO = Margshri_Common_Helper_Utility::callInstanceFunction($commonDTO, $commonDataObj);

    		$vahicaleDataObj = $commonVO->getVahicaleVO();
    		$ownerDataObj = $commonVO->getOwnerVO();
    		$driverDataObj = $commonVO->getDriverVO();
    		
    		$vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
    		/* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
    		$vahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
    		
    		$ownerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
    		/* @var $ownerVO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
    		$ownerVO = Margshri_Common_Helper_Utility::callInstanceFunction($ownerDTO, $ownerDataObj);
    		
    		$driverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		/* @var $driverVO Margshri_Transport_VO_Master_Vahicale_DriverVO */
    		$driverVO = Margshri_Common_Helper_Utility::callInstanceFunction($driverDTO, $driverDataObj);
    		
    		
    		if($commonVO->getID() != null && $commonVO->getID() > 0){
    		    if($commonVO->getVahicaleID() == null || $commonVO->getVahicaleID() == ""){
    		        Mage::throwException("Please enter vahicale number.");
    		    }
    		}
    		
    		if($vahicaleVO->getVahicaleNumber() == null || $vahicaleVO->getVahicaleNumber() == "" ){
    		    Mage::throwException("Please enter vahicale number.");
    		}
    		
    		if($vahicaleVO->getTypeID() == null || $vahicaleVO->getTypeID() == "" ){
    		    Mage::throwException("Please select vahicale type.");
    		}
    		
    		$adapter = $commonDTO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		
    		// if($commonVO->getVahicaleID() == null || $commonVO->getVahicaleID() == 0){
        		$vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
        		$vahicaleDataObj = $vahicaleModel->getResource()->getByVahicaleNumber($vahicaleVO->getVahicaleNumber());
        		if($vahicaleDataObj !== false){
        		    $newVahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
        		    /* @var $newVahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
        		    $newVahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($newVahicaleDTO, $vahicaleDataObj);
        		    $commonVO->setVahicaleID($newVahicaleVO->getID());
        		    
    		        $newVahicaleVO->setTypeID($vahicaleVO->getTypeID());
    		        $newVahicaleVO->setVahicaleNumber(str_replace(' ', '', $vahicaleVO->getVahicaleNumber()));
    		        $responseVO = $vahicaleModel->getResource()->saveDB($newVahicaleVO);
        		    
        		    
        		}else{
        		    $vahicaleVO->setVahicaleNumber(str_replace(' ', '', $vahicaleVO->getVahicaleNumber()));
        		    if($vahicaleVO->getOwnerID() == null || $vahicaleVO->getOwnerID() == "" || $vahicaleVO->getOwnerID() == 0){
        		        $vahicaleVO->setOwnerID(null);
        		    }
        		    
        		    $responseVO = $vahicaleModel->getResource()->saveDB($vahicaleVO);
        		    if($responseVO->getErrorMessage() != null){
        		        Mage::throwException($responseVO->getErrorMessage());
        		    }
        		    $responseData = $responseVO->getResponseData();
        		    $vahicaleID = $responseData['ResponseData']['VahicaleID'];
        		    $commonVO->setVahicaleID($vahicaleID);
        		}
    		// }
    		
    		
    		if($ownerVO->getMobileNo() != null && $ownerVO->getMobileNo() != ""){
    		    
    		    if($ownerVO->getName() == null || $ownerVO->getName() == ""){
    		        Mage::throwException("you have enter owner mobile no. so please enter owner name.");
    		    }
    		    
    		    $ownerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
    		    $ownerDataObj = $ownerModel->getResource()->getByMobileNo($ownerVO->getMobileNo());
    		    if($ownerDataObj !== false){
    		        $newOwnerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
    		        /* @var $newOwnerVO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
    		        $newOwnerVO = Margshri_Common_Helper_Utility::callInstanceFunction($newOwnerDTO, $ownerDataObj);
    		        $commonVO->setOwnerID($newOwnerVO->getID());        
    		    }else{
    		        /*
    		        $responseVO->setErrorMessage("ok3");
    		        $this->getResponse()->setBody(Margshri_Common_Helper_Utility::jsonEncode($responseVO->getResponseData()));
    		        return;
    		        */
    		        
    		        $responseVO = $ownerModel->getResource()->saveDB($ownerVO);
    		        
    		        if($responseVO->getErrorMessage() != null){
    		            Mage::throwException($responseVO->getErrorMessage());
    		        }
    		        $responseData = $responseVO->getResponseData();
    		        $ownerID = $responseData['ResponseData']['OwnerID'];
    		        $commonVO->setOwnerID($ownerID);
    		    }
    		}
    		
    		if($driverVO->getMobileNo() != null && $driverVO->getMobileNo() != ""){
    		    
    		    if($driverVO->getName() == null || $driverVO->getName() == ""){
    		        Mage::throwException("you have enter driver mobile no. so please enter driver name.");
    		    }
    		    
    		    $driverModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName);
    		    $driverDataObj = $driverModel->getResource()->getByMobileNo($driverVO->getMobileNo());
    		    if($driverDataObj !== false){
    		        $newDriverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		        /* @var $newDriverVO Margshri_Transport_VO_Master_Vahicale_DriverVO */
    		        $newDriverVO = Margshri_Common_Helper_Utility::callInstanceFunction($newDriverDTO, $driverDataObj);
    		        $commonVO->setDriverID($newDriverVO->getID());
    		    }else{
    		        $responseVO = $driverModel->getResource()->saveDB($driverVO);
    		        if($responseVO->getErrorMessage() != null){
    		            Mage::throwException($responseVO->getErrorMessage());
    		        }
    		        $responseData = $responseVO->getResponseData();
    		        $driverID = $responseData['ResponseData']['DriverID'];
    		        $commonVO->setDriverID($driverID);
    		    }
    		}
    		
    		if($commonVO->getOwnerID() == null || $commonVO->getOwnerID() == "" || $commonVO->getOwnerID() == 0){
    		    $commonVO->setOwnerID(null);
    		}
    		
    		if($commonVO->getDriverID() == null || $commonVO->getDriverID() == "" || $commonVO->getDriverID() == 0){
    		    $commonVO->setDriverID(null);
    		}
    		
    		
    		$commonModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName);
    		/* @var $responseVO Margshri_Transport_VO_Master_Vahicale_CommonVO */
    		$responseVO = $commonModel->getResource()->saveDB($commonVO);
    		
    		if($responseVO->getErrorMessage() != null){
    			Mage::throwException($responseVO->getErrorMessage());
    		}
    		
    		$adapter->commit();
    	
    	} catch (Exception $e) {
    		if($isTransactionStart == true){
    			$adapter->rollBack();
    		}
    		$responseVO->setErrorMessage($e->getMessage());
    	}
    	$this->getResponse()->setBody(Margshri_Common_Helper_Utility::jsonEncode($responseVO->getResponseData()));
    	return;
    
    }	
	
}// end class
