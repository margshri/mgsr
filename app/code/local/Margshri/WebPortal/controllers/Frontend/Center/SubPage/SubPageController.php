<?php 
class Margshri_WebPortal_Frontend_Center_SubPage_SubPageController extends Mage_Core_Controller_Front_Action {
	
	protected $recordID;
	protected $recordName;
	protected $tableCode;
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_title("Sub Page / Aapnicity");
		return $this;
	}

	protected function _init(){
		
		$subPageVOs = array();
		
		// GET ENTITY VO BY TABLE CODE 
		$entityModel   = Mage::getModel("webportal/Master_SubPage_Entity");
		$entityDataObj = $entityModel->getResource()->getActiveRecordByTableCode($this->tableCode);
		
		if($entityDataObj !== false){
			$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
			/* @var $entityVO  Margshri_WebPortal_VO_Master_SubPage_EntityVO */
			$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $entityDataObj);
			
			// GET ENTITY ATTRIBUTE VOs BY ENTITY ID
			$entityAttributeModel    = Mage::getModel("webportal/Master_SubPage_EntityAttribute");
			$entityAttributeDataObjs = $entityAttributeModel->getResource()->getActiveRecordByEntityID($entityVO->getID());
			
			foreach ($entityAttributeDataObjs as $entityAttributeDataObj){
				$entityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
				/* @var $entityAttributeVO  Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO */
				$entityAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityAttributeDTO, $entityAttributeDataObj);
				
				// GET ATTRIBUTE VO BY ATTRIBUTE ID
				$attributeModel = Mage::getModel("webportal/Master_SubPage_Attribute");
				$attributeDataObj = $attributeModel->getResource()->getActiveRecordByID($entityAttributeVO->getAttributeID());
				
				if($attributeDataObj !== false){
					$attributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
					/* @var $attributeVO Margshri_WebPortal_VO_Master_SubPage_AttributeVO */
					$attributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($attributeDTO, $attributeDataObj);
					
					
					// GET SUBPAGE VO BY RECORD ID AND ENTITY ATTRIBUTE ID
					$subPageModel   = Mage::getModel("webportal/Center_SubPage_SubPage");
					$subPageDataObj = $subPageModel->getResource()->getActiveRecordByRecordIDAndEntityAttributeID($this->recordID, $entityAttributeVO->getID());
					
					
					if($subPageDataObj !==  false){
						$subPageDTO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
						/* @var $subPageVO Margshri_WebPortal_VO_Center_SubPage_SubPageVO */
						$subPageVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($subPageDTO, $subPageDataObj);
							
						$subPageVO->setAttributeCode($attributeVO->getCode());
						$subPageVO->setAttributeName($attributeVO->getValue());
						$subPageVO->setAttributeTypeID($attributeVO->getTypeID());
						$subPageVO->setAttributeDataTypeID($attributeVO->getDataTypeID());
						
						if($subPageVO->getAttributeDataTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeDataTypeVO::$DROP_DOWN_LIST_TYPE){
							
							$serviceModel   = Mage::getModel("webportal/Master_SubPage_Service");
							$serviceDataObj = $serviceModel->getResource()->getActiveRecordByID($subPageVO->getValue());
							if($serviceDataObj !== false){
								$serviceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
								/* @var $serviceVO Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
								$serviceVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($serviceDTO, $serviceDataObj);
								$subPageVO->setValue($serviceVO->getImageURL());
								$subPageVOs[] = $subPageVO;
							}
						}else if($subPageVO->getAttributeTypeID() == Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO::$PERSON){
							$post1Model   = Mage::getModel("webportal/Master_SubPage_Post1");
							$post1DataObj = $post1Model->getResource()->getActiveRecordByID($subPageVO->getPost1ID());
							if($post1DataObj !== false){
								$post1DTO = new Margshri_WebPortal_VO_Master_SubPage_Post1VO();
								/* @var $post1VO Margshri_WebPortal_VO_Master_SubPage_Post1VO */
								$post1VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($post1DTO, $post1DataObj);
								$subPageVO->setPost1Name($post1VO->getValue());
								
							}
						
							$post2Model   = Mage::getModel("webportal/Master_SubPage_Post2");
							$post2DataObj = $post2Model->getResource()->getActiveRecordByID($subPageVO->getPost2ID());
							if($post2DataObj !== false){
								$post2DTO = new Margshri_WebPortal_VO_Master_SubPage_Post2VO();
								/* @var $post2VO Margshri_WebPortal_VO_Master_SubPage_Post2VO */
								$post2VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($post2DTO, $post2DataObj);
								$subPageVO->setPost2Name($post2VO->getValue());
							}
							
							if($subPageVO->getValue() != null){
								$subPageVO->setPersonName(ucwords($subPageVO->getPersonName()));
								$subPageVOs[] = $subPageVO;
								
								
								// Get CustomerID from Profile Image URL
								$profileImageURL = $subPageVO->getValue();
								$profileImageSplit1 = explode("/", $profileImageURL);
								$profileImageSplit2 = explode(".", $profileImageSplit1[sizeof($profileImageSplit1)-1]);
								$customerID = $profileImageSplit2[0];
								if($customerID != null){
									$customerObj = Mage::getModel('customer/customer')->load($customerID);
									$customerImg = $customerObj->getData("customerimage"); 
									$subPageVO->setValue($customerImg);
								}
								
							}
							
						}else{
							if($subPageVO->getValue() != null){
								$subPageVOs[] = $subPageVO;
							}
						}
						
						
						
					} // END SUB PAGE IF	
				}	// END ATTRIBUTE IF
			}	// END ENTITY ATTRIBUTE IF
		} // END ENTITY IF

		
		foreach ($subPageVOs as $subPageVO){
			$attributeTypeID = $subPageVO->getAttributeTypeID();
			break;
		}
		
		/*
		$newSubPageVOs = array();
		$newSubPageVO = array();
		foreach ($subPageVOs as $subPageVO){
			if($subPageVO->getAttributeTypeID() != $attributeTypeID){
				$newSubPageVOs[$attributeTypeID]= $newSubPageVO;
				$newSubPageVO = array();
				$attributeTypeID = $subPageVO->getAttributeTypeID();
			}
			$newSubPageVO[] = $subPageVO;
		}
		$newSubPageVOs[$attributeTypeID]= $newSubPageVO;
		*/
		
		$newSubPageVOs = array();
		foreach ($subPageVOs as $subPageVO){
			if($subPageVO->getAttributeTypeID() != $attributeTypeID){
				$attributeTypeID = $subPageVO->getAttributeTypeID();
			}
			$newSubPageVOs[$attributeTypeID][$subPageVO->getAttributeCode()]= $subPageVO;
		}

		
		Mage::register('CurrentSubPageVOs', $newSubPageVOs);
		Mage::register('CurrentPageTitle', $this->recordName);
		
		Mage::register('RecordID', $this->recordID);
		Mage::register('TableCode', $this->tableCode);
		
		return Mage::registry('CurrentSubPageVOs');
	}
	
	
	public function indexAction(){
		
		$this->recordID  = $this->getRequest()->getParam("ID");
		$this->recordName = $this->getRequest()->getParam("RecordName");
		$this->tableCode = $this->getRequest()->getParam("TableCode");
		
		$this->_init();
		$this->_initAction();
		
		
		$model = Mage::getModel('webportal/Master_SubPage_Entity');
		$dataObj = $model->getResource()->getByTableCode($this->tableCode);
		
		$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
		/* @var $entityVO Margshri_WebPortal_VO_Master_SubPage_EntityVO */
		$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $dataObj);
		
		
    	switch ($entityVO->getTypeID()){
    		case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE1:
    			$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type1_Info');
    			$block->setTemplate('webportal/center/subpage/type1/entropy.phtml');
    			$this->getLayout()->getBlock('content')->append($block);
    		break;
    		
    		case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE2:
    			$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type2_Info');
    			$block->setTemplate('webportal/center/subpage/type2/entropy.phtml');
    			$this->getLayout()->getBlock('content')->append($block);
    		break;
    		
    		case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE3:
    			$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type3_Info');
    			$block->setTemplate('webportal/center/subpage/type3/entropy.phtml');
    			$this->getLayout()->getBlock('content')->append($block);
    		break;
    		
    		case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE4:
    			$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type4_Info');
    			$block->setTemplate('webportal/center/subpage/type4/entropy.phtml');
    			$this->getLayout()->getBlock('content')->append($block);
    		break;
    		 
    	}
    	$this->renderLayout();
    	
	}
	
	
	public function showMemberListAction(){
	
		$this->recordID  = $this->getRequest()->getParam("RecordID");
		$this->tableCode = $this->getRequest()->getParam("TableCode");
		$this->recordName = $this->getRequest()->getParam("RecordName");
		
		$this->_init();
		$this->_initAction();
	
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type2_MemberList');
		$block->setTemplate('webportal/center/subpage/type2/memberlist.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		 
		$this->renderLayout();
		 
	}
	
	
	public function showProfileAction(){
	
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Profile_Profile');
		$block->setTemplate('webportal/center/subpage/profile/profile.phtml');
		$this->getLayout()->getBlock('content')->append($block);
			
		$this->renderLayout();
			
	}
    
}
