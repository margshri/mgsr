<?php 
class Margshri_WebPortal_Frontend_Right_BidPointController extends Mage_Core_Controller_Front_Action {
	
	
	protected $customerID = null;
	protected $purchasePoints = 0;
	protected $recordID  = null;
	protected $tableCode  = null;
	
	
	private function init(){
		$bidID = $this->getRequest()->getParam('BidID');
		$bidVO = new Margshri_WebPortal_VO_Master_Right_BidVO();
		if($bidID != null){
	
			$bidModel = Mage::getModel("webportal/Master_Right_Bid");
			$bidDataObj = $bidModel->getResource()->getByID($bidID);
	
			if($bidDataObj !== false){
				$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
				/* @var $bidVO Margshri_WebPortal_VO_Master_Right_BidVO */
				$bidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
				 
				
				$bidTypeModel = Mage::getModel("webportal/Master_Right_BidType");
				$bidTypeDataObj = $bidTypeModel->getResource()->getByID($bidVO->getTypeID());
				$bidTypeDTO = new Margshri_WebPortal_VO_Master_Right_BidTypeVO();
				/* @var $bidTypeVO Margshri_WebPortal_VO_Master_Right_BidTypeVO */
				$bidTypeVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidTypeDTO, $bidTypeDataObj);
				$bidVO->setBidTypeName($bidTypeVO->getValue());
				
				
				// CHECK IF CUSTOMER LOGIN OR NOT
				if(Mage::getSingleton('customer/session')->isLoggedIn()){
					$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
					$this->customerID = $customerDataObj->getId();
					
					$customerCLPPoints = '';
					$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
					$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
					if($clpPointsDataObj !== false){
						$customerCLPPoints = '';
						$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
						$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
						if($clpPointsDataObj === false){
							Mage::throwException("Customer CLP Points Not Found.");
						}
							
						$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
						$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);
						
						// CHECK BID TYPE
						if($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$DAILY_BID){
							$customerCLPPoints = $clpPointsVO->getDailyPoints();
						}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$WEEKLY_BID){
							$customerCLPPoints = $clpPointsVO->getWeeklyPoints();
						}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$MONTHLY_BID){
							$customerCLPPoints = $clpPointsVO->getMonthlyPoints();
						}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$SPECIAL_BID){
							$customerCLPPoints = $clpPointsVO->getSpecialPoints();
						}

						$bidVO->setCustomerCLPPoints($customerCLPPoints);
					}
				}
				
				$bidProductsModel = Mage::getModel("webportal/Master_Right_BidProducts");
				$bidProductsDataObjs = $bidProductsModel->getResource()->getLastActiveByBidID($bidVO->getID());
				 
				$bidProductsVOs = array();
				foreach($bidProductsDataObjs as $bidProductsDataObj){
					$bidProductsDTO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
					/* @var $bidProductsVO Margshri_WebPortal_VO_Master_Right_BidProductsVO */
					$bidProductsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidProductsDTO, $bidProductsDataObj);
					$bidProductsVOs[] = $bidProductsVO;
				}
				$bidVO->setBidProductVOs($bidProductsVOs);
			}
		}
		Mage::register('CurrentBidVO', $bidVO);
		return Mage::registry('CurrentBidVO');
	}
	
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
	
	public function getCLPPointsAction(){
		try {
				
			$errorMsg = array();
			$responseVO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$adapter = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			$todayDate  = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
			$dailyPoints = 0; $weeklyPoints = 0; $monthlyPoints = 0; $specialPoints = 0; $earnedPoints = 0;
			$persistedDailyPoints = 0; $persistedWeeklyPoints = 0; $persistedMonthlyPoints = 0; $persistedSpecialPoints = 0; $persistedEarnedPoints = 0;
			$clpPointsTranModel = Mage::getModel('webportal/Right_CLPPointsTran');
			
			// CHECK IF CUSTOMER LOGIN OR NOT
			if(!Mage::getSingleton('customer/session')->isLoggedIn()){
				$errorMsg[] = 'NotLoggedIn';
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}else{
				$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
				$this->customerID = $customerDataObj->getId();
			}
				
			// CHECK FORM DATA VALID OR NOT
			$post = $this->getRequest()->getPost();
			if(empty($post)){
				$errorMsg[] = 'Invalid form data.';
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}
				
				
			// SET TABLE CODE
			$bidPointObj = json_decode($post["BidPointObj"],true);
			$this->tableCode = $bidPointObj['TableCode'];
			if($this->tableCode == null){
				$this->tableCode = 'apctwebhome';
			}
	
			// GET TABLE VO BY TABLE CODE
			$tableModel = Mage::getModel('webportal/Master_Table_Table');
			$dataObj= $tableModel->getResource()->getByCode($this->tableCode);
			if($dataObj !== false){
				$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
				/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
				$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $dataObj);
			}
				
			// CHECK THIS TABLE CODE(FILE) USED FOR CLP OR NOT
			if($tableVO->getUseInCLP() == 0){ // 0 for no
				$errorMsg[] = "You Have Got ".$this->purchasePoints." Points. To Get More Points Visit Another Page.";
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}
				
				
			// GET CURRENT CLP CONFIG VO
			$clpConfigModel   = Mage::getModel('webportal/Master_Right_CLPConfig');
			$clpConfigDataObj = $clpConfigModel->getResource()->getActiveRecord();
				
			if($clpConfigDataObj !== false){
				$clpConfigDTO = new Margshri_WebPortal_VO_Master_Right_CLPConfigVO();
				/* @var $clpConfigVO Margshri_WebPortal_VO_Master_Right_CLPConfigVO */
				$clpConfigVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpConfigDTO, $clpConfigDataObj);
			}else{
				$errorMsg[] = "You Have Got ".$this->purchasePoints." Points. To Get More Points Visit Another Page.";
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}


			$customerID = $this->customerID;
			$entityTransactionID = $tableVO->getID();
			$createdAt = $todayDate;
			$clpPointsTranDataObjs = $clpPointsTranModel->getResource()->getRecordForEarnCLPPoints($customerID, $entityTransactionID, $createdAt);
			
			if(sizeof($clpPointsTranDataObjs) > 0){
				$errorMsg[] = "You Have Already Got Points For This Page. To Get More Points Visit Another Page.";
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}
				
			// CHECK CUSTOMER FIRST TIME GET CLP POINTS
			$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
			$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
			 
			$clpPointsVO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$clpPointsVO->setCustomerID($this->customerID);
			
			if($clpPointsDataObj === false){
				$clpPointsVO->setID(0);
				$specialPoints = $clpConfigVO->getJoiningPoints();
				
			}else{
				$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
				/* @var $clpPointsVO Margshri_WebPortal_VO_Right_CLPPointsVO */
				$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);
			}
			
			  
			if($clpPointsVO->getDailyPoints() != null && $clpPointsVO->getDailyPoints() != 0 && $clpPointsVO->getDailyPoints() != ""){
				$persistedDailyPoints = $clpPointsVO->getDailyPoints();
			}
			
			if($clpPointsVO->getWeeklyPoints() != null && $clpPointsVO->getWeeklyPoints() != 0 && $clpPointsVO->getWeeklyPoints() != ""){
				$persistedWeeklyPoints = $clpPointsVO->getWeeklyPoints();
			}
			
			if($clpPointsVO->getMonthlyPoints() != null && $clpPointsVO->getMonthlyPoints() != 0 && $clpPointsVO->getMonthlyPoints() != ""){
				$persistedMonthlyPoints = $clpPointsVO->getMonthlyPoints();
			}
			
			if($clpPointsVO->getSpecialPoints() != null && $clpPointsVO->getSpecialPoints() != 0 && $clpPointsVO->getSpecialPoints() != ""){
				$persistedSpecialPoints = $clpPointsVO->getSpecialPoints();
			}
			
			if($clpPointsVO->getEarnedPoints() != null && $clpPointsVO->getEarnedPoints() != 0 && $clpPointsVO->getEarnedPoints() != ""){
				$persistedEarnedPoints = $clpPointsVO->getEarnedPoints();
			}
			
			$randomNumber = mt_rand($tableVO->getMinCLPPoint(),$tableVO->getMaxCLPPoint());
			
			if($randomNumber != null && $randomNumber != 0 && $randomNumber != ""){
				$dailyPoints = $randomNumber * 5;
				$weeklyPoints = $randomNumber * 3;
				$monthlyPoints = $randomNumber * 2;
				
				if($clpPointsDataObj === false){
					$earnedPoints = $dailyPoints + $weeklyPoints + $monthlyPoints + $specialPoints;
				}else{
					$earnedPoints = $dailyPoints + $weeklyPoints + $monthlyPoints;
				}	
			}
			
			
			// SET CLP POINTS VO
			$clpPointsVO->setDailyPoints($persistedDailyPoints + $dailyPoints);
			$clpPointsVO->setWeeklyPoints($persistedWeeklyPoints + $weeklyPoints);
			$clpPointsVO->setMonthlyPoints($persistedMonthlyPoints + $monthlyPoints);
			$clpPointsVO->setSpecialPoints($persistedSpecialPoints + $specialPoints);
			$clpPointsVO->setEarnedPoints($persistedEarnedPoints + $earnedPoints);
				
			$adapter->getAdapter()->beginTransaction();
			$response = $clpPointsModel->getResource()->saveDB($clpPointsVO);
			
			$errorFlag = false;
			
			if($response['status'] == "SUCCESS"){
				
				$adapter->getAdapter()->commit();
				
				$newClpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
				
				$clpPointID = $newClpPointsDataObj['ID'];
				
				$clpPointsVO->setID($clpPointID);
				
				$clpPointsTypeModel = Mage::getModel('webportal/Master_Right_CLPPointsType');
				$clpPointsTypeDataObjs = $clpPointsTypeModel->getResource()->getAll();
				
				$adapter->getAdapter()->beginTransaction();
				
				if(sizeof($clpPointsTypeDataObjs) > 0){
					foreach($clpPointsTypeDataObjs as $clpPointsTypeDataObj){
						$newClpPointsTypeDTO = new Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO();
						/* @var $newClpPointsTypeVO Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO */
						$newClpPointsTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newClpPointsTypeDTO, $clpPointsTypeDataObj);
						$typeID = $newClpPointsTypeVO->getID();
						$entityID = Margshri_WebPortal_VO_Master_Right_EntityVO::$CLP_PAGE_VISIT;
						$points = 0;
						  
						if($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$DAILY_POINTS){
							$points = $dailyPoints;
						}elseif($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$WEEKLY_POINTS){
							$points = $weeklyPoints;
						}elseif($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$MONTHLY_POINTS){
							$points = $monthlyPoints;
						}elseif($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$SPECIAL_POINTS){
							
							if($clpPointsDataObj === false){
								$entityID = Margshri_WebPortal_VO_Master_Right_EntityVO::$CLP_JOINING;
								$points = $specialPoints;
							}else{
								continue;
							}
								
						}else{
							continue;
						}
						
						$clpPointsTranVO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
						$clpPointsTranVO->setID(0);
						$clpPointsTranVO->setCustomerID($this->customerID);
						$clpPointsTranVO->setCLPPointID($clpPointsVO->getID());
						$clpPointsTranVO->setEntityID($entityID);
						$clpPointsTranVO->setTypeID($typeID);
						$clpPointsTranVO->setModeID(Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$EARN);
						$clpPointsTranVO->setPoints($points);
						$clpPointsTranVO->setEntityTransactionID($tableVO->getID());
						
						$clpPointsTranVO->setMinCLPPoints($tableVO->getMinCLPPoint());
						$clpPointsTranVO->setMaxCLPPoints($tableVO->getMaxCLPPoint());
						$clpPointsTranVO->setRandomPoints($randomNumber);
						
						$clpPointsTranVO->setCreatedAt($serverDate);
						$response = $clpPointsTranModel->getResource()->saveDB($clpPointsTranVO);
						
						if($response['status'] == "SUCCESS"){
							continue;
						}else{
							$errorFlag = true;
							$adapter->getAdapter()->rollBack();
							$errorMsg[] = $response['message'];
							$responseVO->setErrorMessage($errorMsg);
							break;
						}
						
					}
				}
				
				
			}else{
				$adapter->getAdapter()->rollBack();
				$errorMsg[] = $response['message'];
				$responseVO->setErrorMessage($errorMsg);
			}
			
			if($errorFlag == false){
				$adapter->getAdapter()->commit();
				$responseVO->setSuccessMessage("You Have Got ". $earnedPoints ." Points. To Get More Points Visit Another Page.");
			}			
	
		} catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			$responseVO->setErrorMessage($e->getMessage());
		}
		$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	}
	
	
	
	public function showBidOuterTermsAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidOuterTerms');
		$block->setTemplate('webportal/right/bidouterterms.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function showBidHowToPlayAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidHowToPlay');
		$block->setTemplate('webportal/right/bidhowtoplay.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function showBidListAction(){
	    $this->_initAction();
	    $block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidList');
	    $block->setTemplate('webportal/right/bidlist.phtml');
	    $this->getLayout()->getBlock('content')->append($block);
	    $this->renderLayout();
	}
	
	
	public function showBidDetailAction(){
		$this->init();
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidDetail');
		$block->setTemplate('webportal/right/biddetail.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function showBidTermsAction(){
		
		$post = $this->getRequest()->getPost();
		$bidID = $post['BidID']; 
		
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidTerms');
		$block->setTemplate('webportal/right/bidterms.phtml')->setBidID($bidID);
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function preShowPlayBidAction(){
		
		try{
			$errorMsg = array();
			$errorFlag = false;
			$adapter = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$responseVO = new Margshri_WebPortal_VO_BaseVO();
			$clpPointsTypeID = null;
			$isStartTransaction = false;
			$isCstmrPlayCurrBidFirstTime = true;
			$totalDailyPoint = 0; $totalWeeklyPoint = 0; $totalMonthlyPoint = 0; $totalSpecialPoint = 0;
			$minPointsToPlay = 0; $cnvrtToSpclPoint = 0; $totalRedeemPoint = 0; $totalEarnedPoint = 0;
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			
			// GET SYSTEM CONFIG VALUES
			$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
			$BID_DAILY_TO_SPECIAL_CONVERT_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_DAILY_TO_SPECIAL_CONVERT_POINT);
			$BID_WEEKLY_TO_SPECIAL_CONVERT_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_WEEKLY_TO_SPECIAL_CONVERT_POINT);
			$BID_MONTHLY_TO_SPECIAL_CONVERT_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_MONTHLY_TO_SPECIAL_CONVERT_POINT);
			$BID_PLAY_WITH_MIN_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_PLAY_WITH_MIN_POINT);
			
			
			// CHECK IF CUSTOMER LOGIN OR NOT
			if(!Mage::getSingleton('customer/session')->isLoggedIn()){
				$responseVO->setErrorKey("NotLoggedIn");
				Mage::throwException("Customer Not Login.");
			}
			$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
			$this->customerID = $customerDataObj->getId();
			
			
			// GET FORM POST DATA
			$post = $this->getRequest()->getPost();
			if(empty($post)){
				Mage::throwException("Invalid Form Data.");
			}
			
			// GET BID VO FROM POST
			$newBidDataObj = json_decode($post["BidDataObj"],true);
			$newBidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
			$newBidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newBidDTO, $newBidDataObj);
			
			// GET BID VO By Bid ID
			$bidModel = Mage::getModel('webportal/Master_Right_Bid');
			$bidDataObj = $bidModel->getResource()->getByID($newBidVO->getID());
			if($bidDataObj === false){
				Mage::throwException("Bid Not Found.");
			}
			$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
			$bidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
			

			// GET CUSTOMER CLP POINTS VO
			$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
			$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
			if($clpPointsDataObj === false){
				Mage::throwException("Customer CLP Points Not Found.");
			}
			$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);

			
			// CHECK CUSTOMER FIRST TIME PLAY CURRENT BID OR NOT
			/*
			$bidTranModel = Mage::getModel('webportal/Right_BidTran');
			$bidTranDataObjs = $bidTranModel->getResource()->getByBidIDAndCustomerID($bidVO->getID(), $this->customerID);
			if(sizeof($bidTranDataObjs) > 0){
				$isCstmrPlayCurrBidFirstTime = false;
			}
			*/
			
			
			
			// CHECK BID TYPE
			if($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$DAILY_BID){
				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$DAILY_POINTS;
				$isCstmrPlayCurrBidFirstTime = $this->isCstmrPlayCurrBidFirstTime($clpPointsTypeID, $bidVO->getID()); 
				if($isCstmrPlayCurrBidFirstTime){
					$minPointsToPlay = $BID_DAILY_TO_SPECIAL_CONVERT_POINT + $BID_PLAY_WITH_MIN_POINT;
				}else{
					$minPointsToPlay = $BID_PLAY_WITH_MIN_POINT;
				}	 
				
				if($clpPointsVO->getDailyPoints() < $minPointsToPlay){
					$errorFlag = true;
				}else{
					$cnvrtToSpclPoint = $BID_DAILY_TO_SPECIAL_CONVERT_POINT;
					$totalDailyPoint = $clpPointsVO->getDailyPoints() - $BID_DAILY_TO_SPECIAL_CONVERT_POINT;
					$clpPointsVO->setDailyPoints($totalDailyPoint);
				}
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$WEEKLY_BID){
				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$WEEKLY_POINTS;
				$isCstmrPlayCurrBidFirstTime = $this->isCstmrPlayCurrBidFirstTime($clpPointsTypeID, $bidVO->getID());
				if($isCstmrPlayCurrBidFirstTime){	
					$minPointsToPlay = $BID_WEEKLY_TO_SPECIAL_CONVERT_POINT + $BID_PLAY_WITH_MIN_POINT;
				}else{
					$minPointsToPlay = $BID_PLAY_WITH_MIN_POINT;
				}
					
				if($clpPointsVO->getWeeklyPoints() < $minPointsToPlay){
					$errorFlag = true;
				}else{
					$cnvrtToSpclPoint = $BID_WEEKLY_TO_SPECIAL_CONVERT_POINT;
					$totalWeeklyPoint = ($clpPointsVO->getWeeklyPoints() - $BID_WEEKLY_TO_SPECIAL_CONVERT_POINT);
					$clpPointsVO->setWeeklyPoints($totalWeeklyPoint);
				}
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$MONTHLY_BID){
				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$MONTHLY_POINTS;
				$isCstmrPlayCurrBidFirstTime = $this->isCstmrPlayCurrBidFirstTime($clpPointsTypeID, $bidVO->getID());
				if($isCstmrPlayCurrBidFirstTime){
					$minPointsToPlay = $BID_MONTHLY_TO_SPECIAL_CONVERT_POINT + $BID_PLAY_WITH_MIN_POINT;
				}else{
					$minPointsToPlay = $BID_PLAY_WITH_MIN_POINT;
				}	
				if($clpPointsVO->getMonthlyPoints() < $minPointsToPlay){
					$errorFlag = true;
				}else{
					$cnvrtToSpclPoint = $BID_MONTHLY_TO_SPECIAL_CONVERT_POINT;
					$totalMonthlyPoint = ($clpPointsVO->getMonthlyPoints() - $BID_MONTHLY_TO_SPECIAL_CONVERT_POINT);
					$clpPointsVO->setMonthlyPoints($totalMonthlyPoint);
						
				}
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$SPECIAL_BID){
				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$SPECIAL_POINTS;
				$isCstmrPlayCurrBidFirstTime = $this->isCstmrPlayCurrBidFirstTime($clpPointsTypeID, $bidVO->getID());
				if($isCstmrPlayCurrBidFirstTime){
					$minPointsToPlay = $BID_PLAY_WITH_MIN_POINT;
				}else{
					$minPointsToPlay = $BID_PLAY_WITH_MIN_POINT;
				}	
				
				if($clpPointsVO->getSpecialPoints() < $minPointsToPlay){
					$errorFlag = true;
				}
			}else{
				Mage::throwException("Bid Type Not Found.");
			}
			
			if($errorFlag == true){
				Mage::throwException("You Have Not Sufficient Point To Play This Bid. Please Earn More Points, Visit Sites Pages.");
			}
			
			if($isCstmrPlayCurrBidFirstTime == true){
			
				// SET CLP POINTS VO
				$totalSpecialPoint = $clpPointsVO->getSpecialPoints() + $cnvrtToSpclPoint;
				$totalEarnedPoint = $clpPointsVO->getEarnedPoints() + $cnvrtToSpclPoint;
				$totalRedeemPoint = $clpPointsVO->getRedeemedPoints() + $cnvrtToSpclPoint;
					
				$clpPointsVO->setSpecialPoints($totalSpecialPoint);
				$clpPointsVO->setEarnedPoints($totalEarnedPoint);
				$clpPointsVO->setRedeemedPoints($totalRedeemPoint);
				
				
				// Update Customer CLP Points
				$adapter->getAdapter()->beginTransaction();
				$isStartTransaction = true;
				$response = $clpPointsModel->getResource()->saveDB($clpPointsVO);
				if($response['status'] == "ERROR"){
					Mage::throwException("Error In Insert Into CLP Points Table.");
				}
					
					
				// Insert Customer CLP Points Tran To Earn Points
				$clpPointsTranModel = Mage::getModel('webportal/Right_CLPPointsTran');
				$clpPointsTranVO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
				$clpPointsTranVO->setCustomerID($clpPointsVO->getCustomerID());
				$clpPointsTranVO->setTypeID(Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$SPECIAL_POINTS);
				$clpPointsTranVO->setCLPPointID($clpPointsVO->getID());
				$clpPointsTranVO->setModeID(Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$EARN);
				$clpPointsTranVO->setEntityID(Margshri_WebPortal_VO_Master_Right_EntityVO::$PLAY_BIDDING);
				$clpPointsTranVO->setEntityTransactionID($bidVO->getID());
				$clpPointsTranVO->setPoints($cnvrtToSpclPoint);
				$clpPointsTranVO->setCreatedAt($serverDate);
				$response = $clpPointsTranModel->getResource()->saveDB($clpPointsTranVO);
				if($response['status'] == "ERROR"){
					Mage::throwException("Error In Earn Insert Into CLP Points Tran Table.");
				}
				
					
				// Insert Customer CLP Points Tran To REDEEM Points
				$clpPointsTranModel = Mage::getModel('webportal/Right_CLPPointsTran');
				$clpPointsTranVO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
				$clpPointsTranVO->setCustomerID($clpPointsVO->getCustomerID());
				$clpPointsTranVO->setTypeID($clpPointsTypeID);
				$clpPointsTranVO->setCLPPointID($clpPointsVO->getID());
				$clpPointsTranVO->setModeID(Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$REDEEM);
				$clpPointsTranVO->setEntityID(Margshri_WebPortal_VO_Master_Right_EntityVO::$PLAY_BIDDING);
				$clpPointsTranVO->setEntityTransactionID($bidVO->getID());
				$clpPointsTranVO->setPoints($cnvrtToSpclPoint);
				$clpPointsTranVO->setCreatedAt($serverDate);
				$response = $clpPointsTranModel->getResource()->saveDB($clpPointsTranVO);
				if($response['status'] == "ERROR"){
					Mage::throwException("Error In Redeem Insert Into CLP Points Tran Table.");
				}
				
				$adapter->getAdapter()->commit();
			}	
			
			$responseVO->setSuccessMessage("Successfully Passed.");
			
		}catch (Exception $e) {
			if($isStartTransaction == true){
				$adapter->getAdapter()->rollBack();
			}
			$errorMsg[] = $e->getMessage();
			$responseVO->setErrorMessage($errorMsg);
		}
		
		$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
		return;
		
	}

	
	private function isCstmrPlayCurrBidFirstTime($typeID, $bidID){
		$clpPointsTranVO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
		$clpPointsTranVO->setCustomerID($this->customerID);
		$clpPointsTranVO->setTypeID($typeID);
		$clpPointsTranVO->setModeID(Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$REDEEM);
		$clpPointsTranVO->setEntityID(Margshri_WebPortal_VO_Master_Right_EntityVO::$PLAY_BIDDING);
		$clpPointsTranVO->setEntityTransactionID($bidID);
		$clpPointsTranVO->setCreatedAt(date("Y-m-d", Mage::getModel('core/date')->timestamp(time())));
		$clpTranModel = Mage::getModel('webportal/Right_CLPPointsTran');
		$clpTranDataObjs = $clpTranModel->getResource()->getByVO($clpPointsTranVO);
		if($clpTranDataObjs !== false){
			return false;
		}else{
			return true;
		}
	}
	
	
	public function showPlayBidAction(){
		$this->init();
		$bidVO = Mage::registry('CurrentBidVO');
		
		$this->_initAction();
		// CHECK BID STATUS
		if($bidVO->getStatusID() == Margshri_WebPortal_VO_Master_Right_BidStatusVO::$COMPLETED){
			$block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidList');
			$block->setTemplate('webportal/right/bidlist.phtml');
		}else{
			$block = $this->getLayout()->createBlock('webportal/Frontend_Right_PlayBid');
			$block->setTemplate('webportal/right/playbid.phtml');
		}
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	public function showBidWinnersAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Right_BidWinners');
		$block->setTemplate('webportal/right/bidwinners.phtml')->setBidID($bidID);
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function playBidAction(){
		try {
	
			$errorMsg = array();
			$errorFlag = false;
			$bidTranHTML = array();
			$isStartTransaction = false;
			$responseVO = new Margshri_WebPortal_VO_Right_BidTranVO();
			$adapter = new Margshri_WebPortal_VO_Right_BidTranVO();
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			$bidValueDifference = 0;
			$totalDailyPoint = 0; $totalWeeklyPoint = 0; $totalMonthlyPoint = 0; $totalSpecialPoint = 0;
			$totalRedeemPoint = 0; $totalEarnedPoint = 0;
			$clpPointsTypeID = null;
			
			// GET SYSTEM CONFIG VALUES
			$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
			$BID_DAILY_TO_SPECIAL_CONVERT_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_DAILY_TO_SPECIAL_CONVERT_POINT);
			$BID_WEEKLY_TO_SPECIAL_CONVERT_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_WEEKLY_TO_SPECIAL_CONVERT_POINT);
			$BID_MONTHLY_TO_SPECIAL_CONVERT_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_MONTHLY_TO_SPECIAL_CONVERT_POINT);
			$BID_PLAY_WITH_MIN_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_PLAY_WITH_MIN_POINT);
			$BID_PLAY_WITH_MAX_POINT = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_PLAY_WITH_MAX_POINT);
				
			
			// CHECK IF CUSTOMER LOGIN OR NOT
			if(!Mage::getSingleton('customer/session')->isLoggedIn()){
				$responseVO->setErrorKey("NotLoggedIn");
				Mage::throwException("Customer Not Login.");
			}
			$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
			$this->customerID = $customerDataObj->getId();
			
			
			// CHECK FORM DATA VALID OR NOT
			$post = $this->getRequest()->getPost();
			if(empty($post)){
				Mage::throwException("Invalid Form Data.");
			}
	
			$bidTranObj = json_decode($post["BidTranObj"],true);
			$bidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
			$bidTranVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidTranDTO, $bidTranObj);
			$bidTranVO->setCustomerID($this->customerID);
			$bidTranVO->setCreatedAt($serverDate);

			// FORM VALIDATION
			if($bidTranVO->getBidValue() == null || $bidTranVO->getBidValue() == "" || $bidTranVO->getBidValue() < 1 ){
				$responseVO->setErrorKey("InvalidBidValue");
				Mage::throwException("Invalid Bid Value.");
			}
			
			
			// GET BID VO
			$bidModel = Mage::getModel('webportal/Master_Right_Bid');
			$bidDataObj = $bidModel->getResource()->getByID($bidTranVO->getBidID());
			if($bidDataObj === false){
				Mage::throwException("Bid Not Found.");
			}
			$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
			$bidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
			
			
			// CHECK BID STATUS			
			if($bidVO->getStatusID() == Margshri_WebPortal_VO_Master_Right_BidStatusVO::$COMPLETED){
				$responseVO->setErrorKey("BidFinished");
				Mage::throwException("Sorry This Bid Completed! Please Wait For Next Bid.");
			}
			
			
			// GET CUSTOMER CLP POINTS VO
			$customerCLPPoints = '';
			$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
			$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
			if($clpPointsDataObj === false){
				Mage::throwException("Customer CLP Points Not Found.");
			}
			$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);
			
			// CHECK BID TYPE
			if($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$DAILY_BID){
				$customerCLPPoints = $clpPointsVO->getDailyPoints();
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$WEEKLY_BID){
				$customerCLPPoints = $clpPointsVO->getWeeklyPoints();
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$MONTHLY_BID){
				$customerCLPPoints = $clpPointsVO->getMonthlyPoints();
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$SPECIAL_BID){
				$customerCLPPoints = $clpPointsVO->getSpecialPoints();
			}
				
				
			// GET Customer TOTAL BID VALUE FOR CURRENT BID
			$customerTotalBidValue = 0;
			$bidTranModel = Mage::getModel('webportal/Right_BidTran');
			$bidTranDataObjs = $bidTranModel->getResource()->getByBidIDAndCustomerID($bidVO->getID(), $this->customerID);
			if(sizeof($bidTranDataObjs) > 0){
				foreach($bidTranDataObjs as $bidTranDataObj){
					$customerTotalBidValue = $customerTotalBidValue + $bidTranDataObj['BidValue'];
				}
			}
			
			if(($bidTranVO->getBidValue() > $customerCLPPoints) ){
				$responseVO->setErrorKey("InvalidBidValue");
				Mage::throwException("You Have Insufficient Bid Point To Continue Collect More..");
			}
			
			
			$bidTranModel = Mage::getModel('webportal/Right_BidTran');
			$bidTranDataObj = $bidTranModel->getResource()->getLastByBidID($bidVO->getID());
			if($bidTranDataObj !== false){
				$newBidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
				$newBidTranVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newBidTranDTO, $bidTranDataObj);

				if($bidTranVO->getCustomerID() == $newBidTranVO->getCustomerID()){
					$responseVO->setErrorKey("InvalidBidValue");
					Mage::throwException("Last Bid Was Yours, Please Wait For Another Bid.");
				}
				
				
				if($bidTranVO->getBidValue() <= $newBidTranVO->getBidValue()){
					$responseVO->setErrorKey("InvalidBidValue");
					Mage::throwException("Bid Value Must Be Greater Then Last Bid.");
				}
				
				$bidValueDifference = $bidTranVO->getBidValue() - $newBidTranVO->getBidValue();
				if($newBidTranVO->getBidValue() <= 1000){
					if($bidValueDifference < 1 || $bidValueDifference > 100){
						$responseVO->setErrorKey("InvalidBidValue");
						Mage::throwException("You Can Add Only 1-100 In Last Bid Value.");
					}
				}else if($newBidTranVO->getBidValue() > 1000 && $newBidTranVO->getBidValue() <= 2000){
					if($bidValueDifference < 1 || $bidValueDifference > 200){
						$responseVO->setErrorKey("InvalidBidValue");
						Mage::throwException("You Can Add Only 1-200 In Last Bid Value.");
					}
				}else if($newBidTranVO->getBidValue() > 2000 && $newBidTranVO->getBidValue() <= 3000){
					if($bidValueDifference < 1 || $bidValueDifference > 300){
						$responseVO->setErrorKey("InvalidBidValue");
						Mage::throwException("You Can Add Only 1-300 In Last Bid Value.");
					}
				}else if($newBidTranVO->getBidValue() > 3000 && $newBidTranVO->getBidValue() <= 4000){
					if($bidValueDifference < 1 || $bidValueDifference > 400){
						$responseVO->setErrorKey("InvalidBidValue");
						Mage::throwException("You Can Add Only 1-400 In Last Bid Value.");
					}
				}else if($newBidTranVO->getBidValue() > 4000 && $newBidTranVO->getBidValue() <= 5000){
					if($bidValueDifference < 1 || $bidValueDifference > 500){
						$responseVO->setErrorKey("InvalidBidValue");
						Mage::throwException("You Can Add Only 1-500 In Last Bid Value.");
					}
				}else{
					if($bidValueDifference < 1 || $bidValueDifference > 500){
						$responseVO->setErrorKey("InvalidBidValue");
						Mage::throwException("You Can Add Only 1-500 In Last Bid Value.");
					}
				}
				
				
			}else{
				
				// FOUND FIRST BID TRAN SO BID STATUS CHANGED IN RUNNING
				$adapter->getAdapter()->beginTransaction();
				$bidVO->setStatusID(Margshri_WebPortal_VO_Master_Right_BidStatusVO::$RUNNING);
				$response = $bidModel->getResource()->frontendSaveDB($bidVO);
				if($response['status'] == "ERROR"){
					Mage::throwException("Error In Redeem Insert Into Bid Table To Change Status Running.");
				}
				$adapter->getAdapter()->commit();
				
				$bidValueDifference = $bidTranVO->getBidValue();
			} 
			
			
			// GET CUSTOMER CLP POINTS
			$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
			$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($bidTranVO->getCustomerID());
			if($clpPointsDataObj === false){
				Mage::throwException("Customer CLP Points Not Found.");
			}
			$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);

			
			// CHECK BID TYPE
			if($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$DAILY_BID){

				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$DAILY_POINTS;
				$totalDailyPoint = $clpPointsVO->getDailyPoints() - $bidValueDifference;
				$clpPointsVO->setDailyPoints($totalDailyPoint);
				
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$WEEKLY_BID){
				
				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$WEEKLY_POINTS;
				$totalWeeklyPoint = $clpPointsVO->getWeeklyPoints() - $bidValueDifference; 
				$clpPointsVO->setWeeklyPoints($totalWeeklyPoint);
				
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$MONTHLY_BID){
				
				$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$MONTHLY_POINTS;
				$totalMonthlyPoint = $clpPointsVO->getMonthlyPoints() - $bidValueDifference;
				$clpPointsVO->setMonthlyPoints($totalMonthlyPoint);
				
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$SPECIAL_BID){
				// Special Bid Pendding
				// $clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$SPECIAL_POINTS;
				// $clpPointsVO->setSpecialPoints($clpPointsVO->getSpecialPoints() + $BID_MONTHLY_TO_SPECIAL_CONVERT_POINT);
			}else{
				$errorMsg[] = 'Bid Type Not Found.';
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}

			$totalRedeemPoint = $clpPointsVO->getRedeemedPoints() + $bidValueDifference;
			$clpPointsVO->setRedeemedPoints($totalRedeemPoint);
			
			$response = $bidTranModel->getResource()->saveDB($bidTranVO);
			if($response['status'] == "ERROR"){
				Mage::throwException("Error In Insert Into Bid Tran Table.");
			}
			
			$adapter->getAdapter()->commit();
			
			$responseVO->setSuccessMessage("Bid Submitted");
			// $bidTranHTML = $this->getLastNBidTranHTML($bidTranVO->getBidID(), "PlayBid");
			$bidTranHTML['BidTranHTML'] = "";
			$bidTranHTML['IsWinner'] = "NO";
			$responseVO->setResponseData($bidTranHTML);			
			
		}catch (Exception $e) {
			if($isStartTransaction == true){
				$adapter->getAdapter()->rollBack();
			}
			$errorMsg[] = $e->getMessage();
			$responseVO->setErrorMessage($errorMsg);
		}
	
		$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	}
	
	
	
	public function refreshBidAction(){
		try {
	
			$errorMsg = array();
			$errorFlag = false;
			$bidTranHTML = array();
			$responseData = array();
			$responseVO = new Margshri_WebPortal_VO_Right_BidTranVO();
			$adapter = new Margshri_WebPortal_VO_Right_BidTranVO();
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
			$BID_COMPLETE_TIME_IN_SEC  = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_COMPLETE_TIME_IN_SEC);
			$BID_GRACE_PERIOD_TIME_IN_SEC  = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_GRACE_PERIOD_TIME_IN_SEC);
			
			$responseData['LeftPoints'] = "";
			$responseData['IsShowBidFinishedTimer'] = "NO";
			$responseData['BidFinishedDateTimeStr'] = "";
			$responseData["IsWinner"] = "NO";
			$responseData["OpenWinnerModal"] = "";
			
			// CHECK IF CUSTOMER LOGIN OR NOT
			if(!Mage::getSingleton('customer/session')->isLoggedIn()){
				$responseVO->setErrorKey("NotLoggedIn");
				Mage::throwException("Customer Not Login.");
			}
			$customerDataObj = Mage::getSingleton('customer/session')->getCustomer();
			$this->customerID = $customerDataObj->getId();
			
			// CHECK FORM DATA VALID OR NOT
			$post = $this->getRequest()->getPost();
			if(empty($post)){
				Mage::throwException("Invalid Form Data.");
			}
	
			$bidTranObj = json_decode($post["BidTranObj"],true);
			$bidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
			$bidTranVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidTranDTO, $bidTranObj);
			
			$bidModel = Mage::getModel('webportal/Master_Right_Bid');
			$bidDataObj = $bidModel->getResource()->getByID($bidTranVO->getBidID());
			if($bidDataObj === false){
				Mage::throwException("BidVO Not Found.");
			}
			$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
			$bidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
			
			if($bidVO->getStatusID() == Margshri_WebPortal_VO_Master_Right_BidStatusVO::$COMPLETED && $bidVO->getWinnerID() != null ){
				$responseData["IsWinner"] = "YES";
				if($this->customerID == $bidVO->getWinnerID()){
					$responseData["OpenWinnerModal"] = "WinnerOwnModal";
				}else{
					$responseData["OpenWinnerModal"] = "WinnerOtherModal";
				}
			}	
			
			// GET CUSTOMER CLP POINTS VO
			$customerCLPPoints = '';
			$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
			$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
			if($clpPointsDataObj === false){
				Mage::throwException("Customer CLP Points Not Found.");
			}
			$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);
			// CHECK BID TYPE
			if($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$DAILY_BID){
				$customerCLPPoints = $clpPointsVO->getDailyPoints();
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$WEEKLY_BID){
				$customerCLPPoints = $clpPointsVO->getWeeklyPoints();
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$MONTHLY_BID){
				$customerCLPPoints = $clpPointsVO->getMonthlyPoints();
			}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$SPECIAL_BID){
				$customerCLPPoints = $clpPointsVO->getSpecialPoints();
			}
			// GET Customer TOTAL BID VALUE FOR CURRENT BID
			
			$bidTranModel = Mage::getModel('webportal/Right_BidTran');
			/*
			$customerTotalBidValue = 0;
			$bidTranDataObjs = $bidTranModel->getResource()->getByBidIDAndCustomerID($bidVO->getID(), $this->customerID);
			if(sizeof($bidTranDataObjs) > 0){
				foreach($bidTranDataObjs as $bidTranDataObj){
					$customerTotalBidValue = $customerTotalBidValue + $bidTranDataObj['BidValue'];
				}
			}
			$responseData['LeftPoints'] = $customerCLPPoints - $customerTotalBidValue;
			*/
			
			$customerLastBidValue = 0;
			$bidTranDataObj = $bidTranModel->getResource()->getLastByBidIDAndCustomerID($bidVO->getID(), $this->customerID);
			if($bidTranDataObj !== false){
				$customerLastBidValue = $bidTranDataObj['BidValue'];
			}
			$responseData['LeftPoints'] = $customerCLPPoints - $customerLastBidValue;
			
			
			
			// GET LAST BID TRAN
			$bidTranHTML["BidTranHTML"] = "";
			$bidTranDataObj = $bidTranModel->getResource()->getLastByBidID($bidVO->getID());
			if($bidTranDataObj !== false){
				$bidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
				$bidTranVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidTranDTO, $bidTranDataObj);
				$bidTranHTML = $this->getLastNBidTranHTML($bidVO->getID(), "RefreshBid");
			}
			
			
			$biddingStartDateTimeStr = $bidVO->getBiddingDate() . " " . $bidVO->getBiddingTime();
			$currentDateTimeStr = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			$bidStartAndCurrTimeDiffInSec = strtotime($currentDateTimeStr) - strtotime($biddingStartDateTimeStr);
				
			if($bidStartAndCurrTimeDiffInSec > $BID_COMPLETE_TIME_IN_SEC){
				
				if($bidTranVO->getID() != null && $bidTranVO->getIsWin() != 1){
					
					$lastBidTranDateTimeStr = date("Y-m-d H:i:s", strtotime($bidTranVO->getCreatedAt()) + $BID_GRACE_PERIOD_TIME_IN_SEC);
					$currentDateTimeStr = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
					$lastBidTranDateTimeSec = strtotime($lastBidTranDateTimeStr);
					$currentDateTimeSec = strtotime($currentDateTimeStr);
					
					if($lastBidTranDateTimeSec > $currentDateTimeSec){
						$bidFinishedDateTimeStr = date("Y-m-d H:i:s", $lastBidTranDateTimeSec);
						$responseData['IsShowBidFinishedTimer'] = 'YES';
						$responseData['BidFinishedDateTimeStr'] = $bidFinishedDateTimeStr;
					}else{
						
						if($bidVO->getStatusID() == Margshri_WebPortal_VO_Master_Right_BidStatusVO::$RUNNING){
							
							$winnerTotalBidValue = $bidTranVO->getBidValue();
							
							$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($bidTranVO->getCustomerID());
							if($clpPointsDataObj === false){
								Mage::throwException("Customer CLP Points Not Found.");
							}
							$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
							$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);
							
							// CHECK BID TYPE
							if($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$DAILY_BID){
								$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$DAILY_POINTS;
								$totalDailyPoint = $clpPointsVO->getDailyPoints() - $winnerTotalBidValue;
								$clpPointsVO->setDailyPoints($totalDailyPoint);
							}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$WEEKLY_BID){
								$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$WEEKLY_POINTS;
								$totalWeeklyPoint = $clpPointsVO->getWeeklyPoints() - $winnerTotalBidValue;
								$clpPointsVO->setWeeklyPoints($totalWeeklyPoint);
							}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$MONTHLY_BID){
								$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$MONTHLY_POINTS;
								$totalMonthlyPoint = $clpPointsVO->getMonthlyPoints() - $winnerTotalBidValue;
								$clpPointsVO->setMonthlyPoints($totalMonthlyPoint);
							}elseif($bidVO->getTypeID() == Margshri_WebPortal_VO_Master_Right_BidTypeVO::$SPECIAL_BID){
								$clpPointsTypeID = Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$SPECIAL_POINTS;
								$totalSpecialPoint = $clpPointsVO->getSpecialPoints() - $winnerTotalBidValue;
								$clpPointsVO->setSpecialPoints($totalSpecialPoint);
							}else{
								Mage::throwException("Bid Type Not Found.");
							}
							
							$totalRedeemPoint = $clpPointsVO->getRedeemedPoints() + $winnerTotalBidValue;
							$clpPointsVO->setRedeemedPoints($totalRedeemPoint);
							
								
							// Update Customer CLP Points
							$adapter->getAdapter()->beginTransaction();
							$isStartTransaction = true;
							$response = $clpPointsModel->getResource()->saveDB($clpPointsVO);
							if($response['status'] == "ERROR"){
								Mage::throwException("Error In Insert Into CLP Points Table.");
							}
							
								
							// Insert Customer CLP Points Tran To REDEEM Points
							$clpPointsTranModel = Mage::getModel('webportal/Right_CLPPointsTran');
							$clpPointsTranVO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
							$clpPointsTranVO->setCustomerID($bidTranVO->getCustomerID());
							$clpPointsTranVO->setTypeID($clpPointsTypeID);
							$clpPointsTranVO->setCLPPointID($clpPointsVO->getID());
							$clpPointsTranVO->setModeID(Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$REDEEM);
							$clpPointsTranVO->setEntityID(Margshri_WebPortal_VO_Master_Right_EntityVO::$PLAY_BIDDING);
							$clpPointsTranVO->setEntityTransactionID($bidVO->getID());
							$clpPointsTranVO->setPoints($winnerTotalBidValue);
							$clpPointsTranVO->setCreatedAt($serverDate);
							$response = $clpPointsTranModel->getResource()->saveDB($clpPointsTranVO);
							if($response['status'] == "ERROR"){
								Mage::throwException("Error In Redeem Insert Into CLP Points Tran Table.");
							}
							
							
							// Update Bid Status and winner
							$bidVO->setStatusID(Margshri_WebPortal_VO_Master_Right_BidStatusVO::$COMPLETED);
							$bidVO->setWinnerID($bidTranVO->getCustomerID());
								
							
							$response = $bidModel->getResource()->frontendSaveDB($bidVO);
							if($response['status'] == "ERROR"){
								Mage::throwException("Error In Insert Into Bid Table.");
							}
							
							
							// Update Bid tran iswinner
							$bidTranVO->setIsWin(1);
							$response = $bidTranModel->getResource()->frontendSaveDB($bidTranVO);
							if($response['status'] == "ERROR"){
								Mage::throwException("Error In Insert Into Bid Tran Table.");
							}
							
							$adapter->getAdapter()->commit();
							
							
							$responseData["IsWinner"] = "YES";
							if($this->customerID == $bidTranVO->getCustomerID()){
								$responseData["OpenWinnerModal"] = "WinnerOwnModal";
							}else{
								$responseData["OpenWinnerModal"] = "WinnerOtherModal";
							}
							
							$responseVO->setSuccessMessage("Bid Completed Successfully.");
							$bidTranHTML = $this->getLastNBidTranHTML($bidTranVO->getBidID(), "CompleteBid");
						}
							
					}
					
				} // Bid Tran Not Started Then Nothing To Do
			}
			
			
			
			$responseData["BidTranHTML"] = $bidTranHTML["BidTranHTML"];
			$responseVO->setResponseData($responseData);
			$responseVO->setSuccessMessage("Bid Refreshed Successfully.");
			
		}catch (Exception $e) {
			if($isStartTransaction == true){
				$adapter->getAdapter()->rollBack();
			}
			$errorMsg[] = $e->getMessage();
			$responseVO->setErrorMessage($errorMsg);
		}
	
		$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	}
	
	
	public function getLastNBidTranHTML($bidID, $methodCallingAction){
		
		$bidTranModel = Mage::getModel("webportal/Right_BidTran");
		$bidTranDataObjs = $bidTranModel->getResource()->getCurrentBidTranByBidID($bidID);
		
		$newBidTranDataObjs = array();
		if(sizeof($bidTranDataObjs) > 0){
			
			$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
			$BID_NUMBER_OF_RECORD_SHOW = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_NUMBER_OF_RECORD_SHOW);
				
			$bidTranDataObjs = array_reverse($bidTranDataObjs);
			$counter = 1;
			foreach($bidTranDataObjs as $bidTranDataObj){
				$newBidTranDataObj = array();
				$bidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
				/* @var $bidTranVO Margshri_WebPortal_VO_Right_BidTranVO */
				$bidTranVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidTranDTO, $bidTranDataObj);
		
				$customer = Mage::getModel('customer/customer')->load($bidTranVO->getCustomerID());
		
				
				$firstName = $customer->getfirstname();
				$lastName = $customer->getlastname();
				
				if($firstName != null && $firstName != '' ){
					$firstName = ucfirst(strtolower($firstName));
				}
				
				if($lastName != null && $lastName != '' ){
					$lastName = ucfirst(strtolower($lastName));
				}
				
				$newBidTranDataObj['CustomerName'] = $firstName . " " . $lastName;
				$newBidTranDataObj['CityName'] = "";
				
				$customerAddressModel = Mage::getModel("common/Customer_Address");
				$customerAddressDataObj = $customerAddressModel->getResource()->getByCustomerIDAndTypeID($customer->getId(), Margshri_Common_VO_Customer_AddressTypeVO::$RESIDENCE_ADDRESS);
				
				if($customerAddressDataObj !== false){
					$rAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
					/* @var $rAddressVO Margshri_Common_VO_Customer_AddressVO */
					$rAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($rAddressDTO, $customerAddressDataObj);
						
					$cityListModel = Mage::getModel('webportal/Directory_CityList');
					$cityListDataObj = $cityListModel->getResource()->getByID($rAddressVO->getCityID());
						
					if($cityListDataObj !== false){
						$newBidTranDataObj['CityName'] = $cityListDataObj['Value'];
					}
				}
				
				$newBidTranDataObj['BidValue'] = $bidTranVO->getBidValue();
				$newBidTranDataObj['IsWinner'] = "NO";
				
				// GET BID VO BY BID ID
				$bidModel = Mage::getModel('webportal/Master_Right_Bid');
				$bidDataObj = $bidModel->getResource()->getByID($bidID);
				if($bidDataObj !== false){
					$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
					$bidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
					
					if($bidVO->getWinnerID() != null && $bidVO->getWinnerID() != ""){
						// if($bidVO->getWinnerID() == $bidTranVO->getCustomerID()){
							$newBidTranDataObj['IsWinner'] = "YES";
						// }
					}	
				}
				
				
				$newBidTranDataObjs[] = $newBidTranDataObj;
		
				if($counter == $BID_NUMBER_OF_RECORD_SHOW){
					break;
				}
				$counter++;
			}
		}
		
		
		$responseData = array();
		$bidTranHTML = '';
		$isWinner = false;
		if(sizeof($newBidTranDataObjs) > 0){
			
			$bidTranHTML .= '<table>';
			$bidTranHTML .= '<colgroup>';
			$bidTranHTML .= '<col width="150">';
			$bidTranHTML .= '<col width="200">';
			$bidTranHTML .= '<col width="100">';
			$bidTranHTML .= '<col width="100">';
			$bidTranHTML .= '</colgroup>';
			
			$bidTranHTML .= '<thead>';
			$bidTranHTML .= '<tr>';
			$bidTranHTML .= '<th><span class="record">Bid Value</span></th>';
			$bidTranHTML .= '<th><span class="record">Player Name</span></th>';
			$bidTranHTML .= '<th><span class="record">City</span></th>';
			$bidTranHTML .= '<th><span class="record"></span></th>';
			$bidTranHTML .= '</tr>';
			$bidTranHTML .= '</thead>';
			
			
			$bidTranHTML .= '<tbody>';

			$counter = 0;
			foreach($newBidTranDataObjs as $bidTranDataObj){
				
				$counter++;
				
				$bidTranHTML .= '<tr>';
				$bidTranHTML .= '<td style="border-bottom:none;">';
				$bidTranHTML .= '<span class="record">'.$bidTranDataObj['BidValue'].'</span>';
				$bidTranHTML .= '</td>';
					
				$bidTranHTML .= '<td style="border-bottom:none;">';
				$bidTranHTML .= '<span class="record">'.$bidTranDataObj['CustomerName'].'</span>';
				$bidTranHTML .= '</td>';
					
				$bidTranHTML .= '<td style="border-bottom:none;">';
				$bidTranHTML .= '<span class="record">'.$bidTranDataObj['CityName'].'</span>';
				$bidTranHTML .= '</td>';
				
				$bidTranHTML .= '</tr>';
				
			}
			
			$bidTranHTML .= '</tbody>';
			$bidTranHTML .= '</table>';
			
		}
		
		$responseData['BidTranHTML'] = $bidTranHTML;
		if($isWinner == true){
			$responseData['IsWinner'] = "YES";
		}	
		return $responseData;
	}	
	
	
	public function showSubPageListAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Right_SubPageList');
		$block->setTemplate('webportal/right/subpagelist.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	

	public function getSubPageBonusPointAction(){
		try {
	
			$errorMsg = array();
			$errorFlag = false;
			$responseVO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$adapter = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			$todayDate  = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
			$dailyPoints = 0; $weeklyPoints = 0; $monthlyPoints = 0; $earnedPoints = 0;
			$persistedDailyPoints = 0; $persistedWeeklyPoints = 0; $persistedMonthlyPoints = 0; $persistedEarnedPoints = 0;
			$clpPointsTranModel = Mage::getModel('webportal/Right_CLPPointsTran');
				
			// CHECK IF CUSTOMER LOGIN OR NOT
			if(!Mage::getSingleton('customer/session')->isLoggedIn()){
				$errorMsg[] = 'NotLoggedIn';
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}else{
				$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
				$this->customerID = $customerDataObj->getId();
			}
	
			// CHECK FORM DATA VALID OR NOT
			$post = $this->getRequest()->getPost();
			if(empty($post)){
				$errorMsg[] = 'Invalid form data.';
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}
	
	
			// SET TABLE CODE
			$firmObj = json_decode($post["FirmObj"],true);
	
			$this->recordID  = $firmObj["ID"];
			
			// GET FIRM VO BY FIRMID
			$firmModel = Mage::getModel('webportal/Firm_Firm_Firm');
			$firmDataObj= $firmModel->getResource()->getByID($firmObj["ID"]);
			if($firmDataObj !== false){
				$firmDTO = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
				/* @var $firmVO Margshri_WebPortal_VO_Firm_Firm_FirmVO */
				$firmVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($firmDTO, $firmDataObj);
			}
	
			$this->tableCode = $firmVO->getSubPageTableCode();
	
			// GET CURRENT CLP CONFIG VO
			$clpConfigModel = Mage::getModel('webportal/Master_Right_CLPConfig');
			$clpConfigDataObj = $clpConfigModel->getResource()->getActiveRecord();
	
			if($clpConfigDataObj !== false){
				$clpConfigDTO = new Margshri_WebPortal_VO_Master_Right_CLPConfigVO();
				/* @var $clpConfigVO Margshri_WebPortal_VO_Master_Right_CLPConfigVO */
				$clpConfigVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpConfigDTO, $clpConfigDataObj);
			}else{
				$errorMsg[] = "You Have Got ".$this->purchasePoints." Bonus Points. To Get More Bonus Points Click Another One.";
				$responseVO->setErrorMessage($errorMsg);
				$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
				return;
			}
	
				
			$clpPointsTranDataObj = $clpPointsTranModel->getResource()->getLastRecordByCustomerID($this->customerID);
			if($clpPointsTranDataObj !== false){
				$newClpPointsTranDTO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
				/* @var $newClpPointsTranVO Margshri_WebPortal_VO_Right_CLPPointsTranVO */
				$newClpPointsTranVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newClpPointsTranDTO, $clpPointsTranDataObj);
	
				if($newClpPointsTranVO->getEntityTransactionID() == $firmVO->getID() &&
						date("Y-m-d", Mage::getModel('core/date')->timestamp($newClpPointsTranVO->getCreatedAt())) == $todayDate &&
						$newClpPointsTranVO->getCustomerID() == $this->customerID){
	
					$errorMsg[] = "You Have Already Got Bonus Points For This Click. To Get More Bonus Points Click Another One.";
					$responseVO->setErrorMessage($errorMsg);
					$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
					return;
				}
			}
	
			// CHECK CUSTOMER FIRST TIME GET CLP POINTS
			$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
			$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
	
			$clpPointsVO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
			$clpPointsVO->setCustomerID($this->customerID);
				
			if($clpPointsDataObj === false){
				$clpPointsVO->setID(0);
			}else{
				$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
				/* @var $clpPointsVO Margshri_WebPortal_VO_Right_CLPPointsVO */
				$clpPointsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $clpPointsDataObj);
			}
				
			if($clpPointsVO->getDailyPoints() != null && $clpPointsVO->getDailyPoints() != 0 && $clpPointsVO->getDailyPoints() != ""){
				$persistedDailyPoints = $clpPointsVO->getDailyPoints();
			}
			
			if($clpPointsVO->getWeeklyPoints() != null && $clpPointsVO->getWeeklyPoints() != 0 && $clpPointsVO->getWeeklyPoints() != ""){
				$persistedWeeklyPoints = $clpPointsVO->getWeeklyPoints();
			}
			
			if($clpPointsVO->getMonthlyPoints() != null && $clpPointsVO->getMonthlyPoints() != 0 && $clpPointsVO->getMonthlyPoints() != ""){
				$persistedMonthlyPoints = $clpPointsVO->getMonthlyPoints();
			}
			
				
			if($clpPointsVO->getEarnedPoints() != null && $clpPointsVO->getEarnedPoints() != 0 && $clpPointsVO->getEarnedPoints() != ""){
				$persistedEarnedPoints = $clpPointsVO->getEarnedPoints();
			}

			$dailyPoints = 250;
			$weeklyPoints = 150;
			$monthlyPoints = 100;
			$earnedPoints = $dailyPoints + $weeklyPoints + $monthlyPoints;
				
			// SET CLP POINTS VO
			$clpPointsVO->setDailyPoints($persistedDailyPoints + $dailyPoints);
			$clpPointsVO->setWeeklyPoints($persistedWeeklyPoints + $weeklyPoints);
			$clpPointsVO->setMonthlyPoints($persistedMonthlyPoints + $monthlyPoints);
			$clpPointsVO->setEarnedPoints($persistedEarnedPoints + $earnedPoints);
	
			$adapter->getAdapter()->beginTransaction();
			$response = $clpPointsModel->getResource()->saveDB($clpPointsVO);
			
			if($response['status'] == "SUCCESS"){
	
				$adapter->getAdapter()->commit();
				$newClpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($this->customerID);
				$clpPointID = $newClpPointsDataObj['ID'];
				$clpPointsVO->setID($clpPointID);
	
				$clpPointsTypeModel = Mage::getModel('webportal/Master_Right_CLPPointsType');
				$clpPointsTypeDataObjs = $clpPointsTypeModel->getResource()->getAll();
				if(sizeof($clpPointsTypeDataObjs) > 0){
				
					$adapter->getAdapter()->beginTransaction();
				
					foreach($clpPointsTypeDataObjs as $clpPointsTypeDataObj){
						$newClpPointsTypeDTO = new Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO();
						/* @var $newClpPointsTypeVO Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO */
						$newClpPointsTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newClpPointsTypeDTO, $clpPointsTypeDataObj);
						$typeID = $newClpPointsTypeVO->getID();
						$entityID = Margshri_WebPortal_VO_Master_Right_EntityVO::$SUB_PAGE_VISIT;
						$points = 0;
						
						if($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$DAILY_POINTS){
							$points = $dailyPoints;
						}elseif($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$WEEKLY_POINTS){
							$points = $weeklyPoints;
						}elseif($newClpPointsTypeVO->getID() == Margshri_WebPortal_VO_Master_Right_CLPPointsTypeVO::$MONTHLY_POINTS){
							$points = $monthlyPoints;
						}else{
							continue;
						}
		
						$clpPointsTranVO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
						$clpPointsTranVO->setID(0);
						$clpPointsTranVO->setCustomerID($this->customerID);
						$clpPointsTranVO->setCLPPointID($clpPointsVO->getID());
						$clpPointsTranVO->setEntityID($entityID);
						$clpPointsTranVO->setTypeID($typeID);
						$clpPointsTranVO->setModeID(Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$EARN);
						$clpPointsTranVO->setPoints($points);
						$clpPointsTranVO->setEntityTransactionID($firmVO->getID());
						$clpPointsTranVO->setCreatedAt($serverDate);
						$response = $clpPointsTranModel->getResource()->saveDB($clpPointsTranVO);
		
						if($response['status'] != "SUCCESS"){
							$errorFlag = true;
							break;
						}
						
					}
				}
			
			}else{
				$errorFlag = true;
				$errorMsg[] = $response['message'];
			}
	
		}catch (Exception $e) {
			$errorFlag = true;
			$errorMsg[] = $e->getMessage();
		}
		
		if($errorFlag == true){
			$adapter->getAdapter()->rollBack();
			$responseVO->setErrorMessage($errorMsg);
		}else{
			$adapter->getAdapter()->commit();
			$responseVO->setSuccessMessage("You Have Got ". $earnedPoints ." Bonus Points. To Get More Bonus Points Click Another One.");
		}
		
		
		$subPageHTML = $this->getSubPageHtml();
		
		//$subPageHTML = "<h1>vipin</h1>";
		$responseVO->setResponseData($subPageHTML);
		
		$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	}
	
	
	public function getSubPageHtml(){
	
		$this->setCurrentSubPageVOs();
		// $this->_initAction();
	
		$model = Mage::getModel('webportal/Master_SubPage_Entity');
		$dataObj = $model->getResource()->getByTableCode($this->tableCode);
	
		$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
		/* @var $entityVO Margshri_WebPortal_VO_Master_SubPage_EntityVO */
		$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $dataObj);
	
	
		switch ($entityVO->getTypeID()){
			case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE1:
				$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type1_BonusPoint');
				$block->setTemplate('webportal/center/subpage/type1/bonuspoint.phtml');
				break;
	
			case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE2:
				$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type2_BonusPoint');
				$block->setTemplate('webportal/center/subpage/type2/bonuspoint.phtml');
				break;
	
			case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE3:
				$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type3_BonusPoint');
				$block->setTemplate('webportal/center/subpage/type3/bonuspoint.phtml');
				break;
	
			case Margshri_WebPortal_VO_Master_SubPage_SubPageTypeVO::$TYPE4:
				$block = $this->getLayout()->createBlock('webportal/Frontend_Center_SubPage_Type4_BonusPoint');
				$block->setTemplate('webportal/center/subpage/type4/bonuspoint.phtml');
				break;
				 
		}
		return $block->toHtml();
		// $this->renderLayout();
		 
	}
	
	
	
	protected function setCurrentSubPageVOs(){
	
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
								
							// IF PERSON IMAGE NOT APPEAR THEN RECORD NOT SHOW
							if($subPageVO->getValue() != null){
								$subPageVO->setPersonName(ucwords($subPageVO->getPersonName()));
								$subPageVOs[] = $subPageVO;
							}
								
						}else{
							// IF PERSON IMAGE NOT APPEAR THEN RECORD NOT SHOW
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
		return Mage::registry('CurrentSubPageVOs');
	}
	
	
	
// 	public function saveAction(){
// 		try {
	
// 			$post = $this->getRequest()->getPost();
	
// 			$errorMsg = array();
// 			$response = array();
	
// 			if (empty($post)) {
// 				Mage::throwException($this->__('Invalid form data.'));
// 			}
				
// 			if(Mage::getSingleton('customer/session')->isLoggedIn()) {
// 				$customerData = Mage::getSingleton('customer/session')->getCustomer();
// 				$userID = $customerData->getId();
// 			}else{
// 				$this->_redirect('customer/account/login/');
// 				return;
// 			}
			 
				
// 			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
				
// 			$adapter     = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
// 			$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
// 			$viewerVO     = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
	
	
// 			$viewerVO->setID($post['ID']);
// 			$viewerVO->setValue($post['Value']);
// 			$viewerVO->setStatusID(Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerStatusVO::$PENDING);
// 			$viewerVO->setCreatedAt($serverDate);
// 			$viewerVO->setCreatedBy($userID);
	
// 			$adapter->getAdapter()->beginTransaction();
// 			$model = Mage::getModel("webportal/Center_Content_Type5_Viewer_Viewer");
// 			$response = $model->getResource()->saveDB($viewerVO);
				
// 			if($response['status'] == "SUCCESS"){
// 				$adapter->getAdapter()->commit();
// 				Mage::getSingleton('core/session')->addSuccess($response['message']);
// 				$this->_redirect('*/*/index');
// 			}else{
// 				$adapter->getAdapter()->rollBack();
// 				Mage::getSingleton('core/session')->addError($response['message']);
// 				$this->_redirect('*/*/index');
	
// 			}
	
// 		} catch (Exception $e) {
// 			$adapter->getAdapter()->rollBack();
// 			Mage::getSingleton('core/session')->addError($e->getMessage());
// 			$this->_redirect('*/*/index');
// 		}
// 		return;
// 	}
	 
}
