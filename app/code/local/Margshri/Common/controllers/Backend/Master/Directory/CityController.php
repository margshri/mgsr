<?php 
class Margshri_Common_Backend_Master_Directory_CityController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Master_Directory_City_Grid';
	private $formBlock ='common/Backend_Master_Directory_City_Form';
	
	
	protected function _init(){
	    $cityID = $this->getRequest()->getParam('ID');
	    $cityVO = new Margshri_Common_VO_Directory_CityList_CityListVO();
	    if($cityID != null){
	        $cityModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
	        $cityDataObj = $cityModel->getResource()->getByID($cityID);
	        if($cityDataObj !== false){
	            $cityDTO = new Margshri_Common_VO_Directory_CityList_CityListVO();
	            $cityVO = Margshri_Common_Helper_Utility::callInstanceFunction($cityDTO, $cityDataObj);
			}
		}
		Mage::register('CurrentCityListVO', $cityVO);
		return $cityVO;
	}
	
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	
	
	public function editAction(){
		/* @var $cityVO Margshri_Common_VO_Directory_CityList_CityListVO */ 
	    $cityVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setCityID($cityVO->getID())
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
    		
    		$cityDataObj = json_decode($post["CityDataObj"],true);
    		if($cityDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$cityDTO = new Margshri_Common_VO_Directory_CityList_CityListVO();
    		/* @var $cityVO Margshri_Common_VO_Directory_CityList_CityListVO */
    		$cityVO = Margshri_Common_Helper_Utility::callInstanceFunction($cityDTO, $cityDataObj);
    		
    		$adapter = $cityVO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		$cityModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
    		/* @var $responseVO Margshri_Common_VO_Directory_CityList_CityListVO */
    		$responseVO = $cityModel->getResource()->saveDB($cityVO, $responseVO);
    		
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
