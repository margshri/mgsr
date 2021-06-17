<?php 
class Margshri_WebPortal_Backend_Center_SubPage_SubPageController extends Mage_Adminhtml_Controller_Action{
	
	protected $tableCode;
	protected $recordID;
	protected $previousControllerName;
	protected $prefix;
	
	public function indexAction(){
	
		$this->recordID  = $this->getRequest()->getParam("RecordID");
		$this->tableCode = $this->getRequest()->getParam("TableCode");
		
		$entityModel   = Mage::getModel("webportal/Master_SubPage_Entity");
		$entityDataObj = $entityModel->getResource()->getByTableCode($this->tableCode);
		 
		if($entityDataObj !== false){
	
			$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
			/* @var $entityVO  Margshri_WebPortal_VO_Master_SubPage_EntityVO */
			$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $entityDataObj);
	
			$entityAttributeModel    = Mage::getModel("webportal/Master_SubPage_EntityAttribute");
			$entityAttributeDataObjs = $entityAttributeModel->getResource()->getActiveRecordByEntityID($entityVO->getID());
	
			$newSubPageVOs = array();
			foreach ($entityAttributeDataObjs as $entityAttributeDataObj){
				
				$entityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
				/* @var $entityAttributeVO  Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO */
				$entityAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityAttributeDTO, $entityAttributeDataObj);
				
				// GET ATTRIBUTE VO
				$attributeModel = Mage::getModel("webportal/Master_SubPage_Attribute");
				$attributeDataObj = $attributeModel->getResource()->getActiveRecordByID($entityAttributeVO->getAttributeID());
				
				if($attributeDataObj === false){
					continue;
				}
				$attributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
				/* @var $attributeVO Margshri_WebPortal_VO_Master_SubPage_AttributeVO */
				$attributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($attributeDTO, $attributeDataObj);
				
				// GET ATTRIBUTE TYPE VO
				$attributeTypeModel = Mage::getModel("webportal/Master_SubPage_AttributeType");
				$attributeTypeDataObj = $attributeTypeModel->getResource()->getByID($attributeVO->getTypeID());
				 
				$attributeTypeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO();
				/* @var $attributeTypeVO Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO */
				$attributeTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($attributeTypeDTO, $attributeTypeDataObj);
					
				 
				// GET SUB PAGE VO
				$newSubPageVO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
				$newSubPageVO->setEntityAttributeID($entityAttributeVO->getID());
				$newSubPageVO->setRecordID($this->recordID);
				$newSubPageVO->setAttributeCode($attributeVO->getCode());
				$newSubPageVO->setAttributeName($attributeVO->getValue());
				$newSubPageVO->setAttributeTypeID($attributeVO->getTypeID());
				$newSubPageVO->setAttributeDataTypeID($attributeVO->getDataTypeID());
				 
				$subPageModel = Mage::getModel("webportal/Center_SubPage_SubPage");
				$subPageDataObj = $subPageModel->getResource()->getByRecordIDAndEntityAttributeID($newSubPageVO->getRecordID(), $newSubPageVO->getEntityAttributeID());
				
				 
				if($subPageDataObj !== false){
					$subPageDTO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
					/* @var $subPageVO Margshri_WebPortal_VO_Center_SubPage_SubPageVO */
					$subPageVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($subPageDTO, $subPageDataObj);
					$newSubPageVO->setID($subPageVO->getID());
					$newSubPageVO->setValue($subPageVO->getValue());
					$newSubPageVO->setStatusID($subPageVO->getStatusID());
					
					$newSubPageVO->setPersonName($subPageVO->getPersonName());
					$newSubPageVO->setPost1ID($subPageVO->getPost1ID());
					$newSubPageVO->setPost2ID($subPageVO->getPost2ID());
				}
				$newSubPageVOs[] = $newSubPageVO;
			}
			
			foreach ($newSubPageVOs as $newSubPageVO){
				$attributeTypeID = $newSubPageVO->getAttributeTypeID();
				break;
			}
			
			$subPageVOs = array();
			foreach ($newSubPageVOs as $newSubPageVO){
				
				/*
				if($newSubPageVO->getAttributeTypeID() != $attributeTypeID){
					$attributeTypeID = $newSubPageVO->getAttributeTypeID();
					$subPageArray[$attributeTypeID] = array();
				}
				*/
				
				$subPageArray[$newSubPageVO->getAttributeTypeID()][] = $newSubPageVO;
			}
			$subPageVOs = $subPageArray;
			
		 
	
		}
		
		Mage::register('CurrentSubPageVOs', $subPageVOs);
		 
		$this->loadLayout();
		 
		$isEdit = null;
		if(sizeof($subPageVOs) > 0){
			$isEdit = 1;
		}
		$this->_addContent(
				$this->getLayout()->createBlock('webportal/Backend_Center_SubPage_Buttons')
				->setTemplate('webportal/center/subpage/info.phtml')
				->setID($isEdit)
				);
		$this->renderLayout();
	} 
	
	
	public function getCustomerDetailAction(){
		try {
			$post = $this->getRequest()->getPost();
			$errorMsg = array();
			$response = array();
	
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
			$responseVO  = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
			
			$subPageDataObj = json_decode($post["SubPageDataObj"],true);
			$subPageDTO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
			/* @var $subPageVO Margshri_WebPortal_VO_Center_SubPage_SubPageVO */
			$subPageVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($subPageDTO, $subPageDataObj);
			
			$model = Mage::getModel("webportal/Center_SubPage_SubPage");
			
			$mobileDataObj = $model->getResource()->getCustomerIDByMobileNumber($subPageVO->getMobileNumber());
			
			
			if($mobileDataObj['CustomerID'] != null){
				$customerDataObj = $model->getResource()->getCustomerDetailByID($mobileDataObj['CustomerID']);
				
				if($customerDataObj['ImagePath'] != null ){
					$responseVO->setSuccessMessage("Successfully Find ");
					$responseVO->setValue($customerDataObj['ImagePath']);
					
					
					$nameTitle = '';
					if($customerDataObj['Gender'] == 1 ){
						$nameTitle = 'Mr. ';
					}else if($customerDataObj['Gender'] == 2){
						if($customerDataObj['DOM'] != null){
							$nameTitle = 'Mrs. ';
						}else{
							$nameTitle = 'Miss. ';
						}
					}        
													        
													        
			        switch ($customerDataObj['ProfessionID'] ){ 
	        			case Margshri_WebPortal_VO_Master_Center_Content_Type2_Profession_ProfessionVO::$DOCTOR:
	        				$nameTitle = "Dr. ";
	        				break;
	        				
	        			case Margshri_WebPortal_VO_Master_Center_Content_Type2_Profession_ProfessionVO::$CHARTER_ACCOUNTANT:
	        				$nameTitle = "CA ";
	        				break;
	        					
	        			case Margshri_WebPortal_VO_Master_Center_Content_Type2_Profession_ProfessionVO::$ENGINEER:
	        				$nameTitle = "Er. ";
	        				break;

        				case Margshri_WebPortal_VO_Master_Center_Content_Type2_Profession_ProfessionVO::$ADVOCATE:
        					$nameTitle = "Adv. ";
        					break;
	        				
	        	    }	
	        	    
			       
					$responseVO->setPersonName($nameTitle . strtolower($customerDataObj['FirstName']) .' '. strtolower($customerDataObj['LastName']) );
				}else{
					$responseVO->setErrorMessage("Person Image Not Uploaded !");
				}	
			}else{
				$responseVO->setErrorMessage("Mobile Number Not Exist !");
			}
			
				
		} catch (Exception $e) {
			$responseVO->setErrorMessage(array($e->getMessage()));
		}
		
		if($responseVO->getErrorMessage() != null){
			$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray() ));
		}else{
			$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getDataArray() ));
		}
		
    	return;
	}
	
	
	public function saveAction(){
		try {
	
			$post = $this->getRequest()->getPost();
			$this->recordID  = $post["RecordID"];
			$this->tableCode = $post["TableCode"];
			$this->previousControllerName = $post["PreviousControllerName"];
			
			$errorMsg = array();
			$response = array();
	
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
	
			$adapter     = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
			$responseVO  = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
			
			
			// GET ENTITY VO
			$entityModel   = Mage::getModel("webportal/Master_SubPage_Entity");
			$entityDataObj = $entityModel->getResource()->getByTableCode($this->tableCode);
			
			
			
			if($entityDataObj !== false){
				
				$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
				/* @var $entityVO  Margshri_WebPortal_VO_Master_SubPage_EntityVO */
				$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $entityDataObj);

				
				// GET ENTITY ATTRIBUTE VOs
				$entityAttributeModel    = Mage::getModel("webportal/Master_SubPage_EntityAttribute");
				$entityAttributeDataObjs = $entityAttributeModel->getResource()->getByEntityID($entityVO->getID());
			
				$subPageVOs = array();
				foreach ($entityAttributeDataObjs as $entityAttributeDataObj){
					
					$entityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
					/* @var $entityAttributeVO  Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO */
					$entityAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityAttributeDTO, $entityAttributeDataObj);
					 
					// SET SUB PAGE VOs
					$subPageVO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
					$this->prefix = $this->recordID.'_'.$entityAttributeVO->getID();
					
					$subPageVO->setRecordID($this->recordID);
					$subPageVO->setEntityAttributeID($entityAttributeVO->getID());
					
					$subPageVO->setID($post[$this->prefix.'_ID']);
					$subPageVO->setAttributeTypeID($post[$this->prefix.'_AttributeTypeID']);
					$subPageVO->setAttributeDataTypeID($post[$this->prefix.'_AttributeDataTypeID']);
					
					if($post[$this->prefix.'_StatusID'] != null && $post[$this->prefix.'_StatusID'] != ''){
						$subPageVO->setStatusID($post[$this->prefix.'_StatusID']);
					}
					
					
					if($subPageVO->getAttributeDataTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeDataTypeVO::$IMAGE_TYPE){
						$imageFileObj = $_FILES[$this->prefix."_File"];
						
						if($subPageVO->getAttributeTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO::$BUILDING){
							$subPageVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
						}
						
						if($subPageVO->getAttributeTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO::$PERSON){
							$subPageVO->setValue($post[$this->prefix.'_Value']);
							$subPageVO->setPersonName($post[$this->prefix.'_PersonName']);
							
							if($post[$this->prefix.'_Post1ID'] != null){
								$subPageVO->setPost1ID($post[$this->prefix.'_Post1ID']);
							}else{
								$subPageVO->setPost1ID(null);
							}
							
							if($post[$this->prefix.'_Post2ID'] != null){
								$subPageVO->setPost2ID($post[$this->prefix.'_Post2ID']);
							}else{
								$subPageVO->setPost2ID(null);
							}
						}else if($imageFileObj["tmp_name"] != null && $imageFileObj["tmp_name"] != ''){
							// CREATE IMAGE PATH AND SET IMAGE PATH
							$imagePath = 'web_portal/frontend/subpage/';
							$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
							$imagePath = $imagePath.$this->prefix.'.'.$ext;
							$subPageVO->setValue($imagePath);
						} 
							
					}
						
					if($subPageVO->getAttributeDataTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeDataTypeVO::$TEXT_TYPE
							|| $subPageVO->getAttributeDataTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeDataTypeVO::$DROP_DOWN_LIST_TYPE
							|| $subPageVO->getAttributeDataTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeDataTypeVO::$VIDEO_TYPE){
						$subPageVO->setValue($post[$this->prefix.'_Value']);
					}
					
					
					
					
					$subPageVOs[] = $subPageVO;
				}
				
				
				
				$adapter->getAdapter()->beginTransaction();
				$model = Mage::getModel("webportal/Center_SubPage_SubPage");
				$response = $model->getResource()->saveDB($subPageVOs);
				
				
				
				
				
				if($response['status'] == "SUCCESS"){
					$adapter->getAdapter()->commit();
					Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
					
					// SAVE IMAGE FILE
					foreach ($subPageVOs as $subPageVO){
						if($subPageVO->getAttributeDataTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeDataTypeVO::$IMAGE_TYPE){
							$this->prefix = $subPageVO->getRecordID().'_'.$subPageVO->getEntityAttributeID();
							$imageFileObj = $_FILES[$this->prefix."_File"];
							if($imageFileObj["tmp_name"] != null && $imageFileObj["tmp_name"] != ''){
								$helper = Mage::helper("margshri/Utility");
								$re = move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $subPageVO->getValue());
							}
						}
					}
					$this->_redirect('*/'.$this->previousControllerName.'/');
				}else{
					$adapter->getAdapter()->rollBack();
					Mage::getSingleton('adminhtml/session')->addError($response['message']);
					$this->_redirect('*/*/', array('RecordID'=> $this->recordID, 'TableCode'=>$this->tableCode, 'PreviousControllerName'=>$this->previousControllerName ));
				}
				
			}
			
		} catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*/', array('RecordID'=> $this->recordID, 'TableCode'=>$this->tableCode, 'PreviousControllerName'=>$this->previousControllerName ));
		}
		return;
	}	
	
}// end class