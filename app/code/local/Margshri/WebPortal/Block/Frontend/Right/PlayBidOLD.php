<?php
class Margshri_WebPortal_Block_Frontend_Right_PlayBid extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
	}

	public function getBidProductDetail(){

		
		$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
		$BID_NUMBER_OF_RECORD_SHOW = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_NUMBER_OF_RECORD_SHOW);
		$BID_REFRESH_TIME_IN_SEC = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_REFRESH_TIME_IN_SEC);
		$DEFAULT_BID_COMPLETE_TIME_IN_SEC = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_COMPLETE_TIME_IN_SEC);
		$BID_GRACE_PERIOD_TIME_IN_SEC = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_GRACE_PERIOD_TIME_IN_SEC);
		
		
		$bidProductDetail = array();
		$bidProductDetail['BID_REFRESH_TIME_IN_SEC'] = $BID_REFRESH_TIME_IN_SEC;
		$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $DEFAULT_BID_COMPLETE_TIME_IN_SEC;
		$bidProductDetail['BID_GRACE_PERIOD_TIME_IN_SEC'] = $BID_GRACE_PERIOD_TIME_IN_SEC;
		
		$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
		
		$bidID = $this->getRequest()->getParam('BidID');
		if($bidID != null){
	
			$bidModel = Mage::getModel("webportal/Master_Right_Bid");
			$bidDataObj = $bidModel->getResource()->getByID($bidID);
	
			if($bidDataObj !== false){
				$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
				/* @var $bidVO Margshri_WebPortal_VO_Master_Right_BidVO */
				$bidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
				
				
				// GET CUSTOMER CLP POINTS VO
				$customerCLPPoints = '';
				$clpPointsModel = Mage::getModel('webportal/Right_CLPPoints');
				$clpPointsDataObj = $clpPointsModel->getResource()->getByCustomerID($customerDataObj->getId());
				if($clpPointsDataObj !== false){
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
				}
				
				$bidTypeModel = Mage::getModel('webportal/Master_Right_BidType');
				$bidTypeDataObj = $bidTypeModel->getResource()->getByID($bidVO->getTypeID());
				if($bidTypeDataObj !== false){
					$bidTypeDTO = new Margshri_WebPortal_VO_Master_Right_BidTypeVO();
					$bidTypeVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidTypeDTO, $bidTypeDataObj);
					$bidProductDetail['BidType'] = $bidTypeVO->getValue();
				}
				
				
				$bidProductDetail['BidID'] = $bidVO->getID();
				$bidProductDetail['BidName'] = $bidVO->getBidName();
				$bidProductDetail['BiddingDate'] = $bidVO->getBiddingDate();
				$bidProductDetail['BiddingTime'] = $bidVO->getBiddingTime();
				$bidProductDetail['CustomerCLPPoints'] = $customerCLPPoints;
				
				// GET LAST BID TRAN
				/*
				$bidTranModel = Mage::getModel('webportal/Right_BidTran');
				$bidTranDataObj = $bidTranModel->getResource()->getLastByBidID($bidVO->getID());
				if($bidTranDataObj !== false){
					$bidStartTimeStamp = $bidTranDataObj['CreatedAt'];
				}else{
					$bidStartTimeStamp = strtotime($bidVO->getBiddingDate() . " " . $bidVO->getBiddingTime());
				}
				
				$currentTimeStamp = Mage::getModel('core/date')->timestamp(time());
				
				$diffTimeInSec = 0;
				if($currentTimeStamp > $bidStartTimeStamp){
					$diffTimeStr = date("H:i:s", $currentTimeStamp - $bidStartTimeStamp);
					$diffTimeSplit = explode(':', $diffTimeStr);
					$diffTimeInSec = ($diffTimeSplit[0] * 3600) + ($diffTimeSplit[1] * 60) + $diffTimeSplit[2];
				}	
				
				if($diffTimeInSec <= 0){
					$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $DEFAULT_BID_COMPLETE_TIME_IN_SEC;
				}else if($diffTimeInSec > $DEFAULT_BID_COMPLETE_TIME_IN_SEC){
					
					if($bidTranDataObj !== false){
						$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $BID_GRACE_PERIOD_TIME_IN_SEC;
					}else{
						$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $DEFAULT_BID_COMPLETE_TIME_IN_SEC;
					}
					
				}else{ 
					$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $diffTimeInSec;
				}
				*/
				
				$bidStartTimeStamp = strtotime($bidVO->getBiddingDate() . " " . $bidVO->getBiddingTime());
				$currentTimeStamp = Mage::getModel('core/date')->timestamp(time());
				
				$diffTimeInSec = 0;
				if($currentTimeStamp > $bidStartTimeStamp){
					$diffTimeStr = date("H:i:s", $currentTimeStamp - $bidStartTimeStamp);
					$diffTimeSplit = explode(':', $diffTimeStr);
					$diffTimeInSec = ($diffTimeSplit[0] * 3600) + ($diffTimeSplit[1] * 60) + $diffTimeSplit[2];
				}
				
				/*
				if($diffTimeInSec > $DEFAULT_BID_COMPLETE_TIME_IN_SEC){
					$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $BID_GRACE_PERIOD_TIME_IN_SEC;
				}else if($diffTimeInSec > 0 && $diffTimeInSec < $DEFAULT_BID_COMPLETE_TIME_IN_SEC){
					$bidProductDetail['BID_COMPLETE_TIME_IN_SEC'] = $diffTimeInSec;
				}
				*/

				$bidFinishDateTime = date("Y-m-d H:i:s", $currentTimeStamp + $bidProductDetail['BID_COMPLETE_TIME_IN_SEC']);
				$bidProductDetail['BID_FINISH_DATE_TIME'] = $bidFinishDateTime;
				
				
				
				
				
				$bidProductsModel = Mage::getModel("webportal/Master_Right_BidProducts");
				$bidProductsDataObj = $bidProductsModel->getResource()->getLastActiveByBidID($bidVO->getID());
				 
				if($bidProductDataObj !== false){
					$bidProductsDTO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
					/* @var $bidProductsVO Margshri_WebPortal_VO_Master_Right_BidProductsVO */
					$bidProductsVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidProductsDTO, $bidProductsDataObj);
	
					$productsDetailDataObj = $bidProductsModel->getResource()->getProductDetailByProductID($bidProductsVO->getProductID());
	
					if(sizeof($productsDetailDataObj) > 0){
						$bidProductDetail['ProductID'] = $productsDetailDataObj['ProductID'];
						$bidProductDetail['ProductName'] = $productsDetailDataObj['ProductName'];
						$bidProductDetail['ProductSKU'] = $productsDetailDataObj['ProductSKU'];
						$bidProductDetail['ProductImage'] = $productsDetailDataObj['ProductImage'];
						$bidProductDetail['ProductDescription'] = $productsDetailDataObj['ProductDescription'];
						$bidProductDetail['ProductPrice'] = $productsDetailDataObj['ProductPrice'];
						$bidProductDetail['ProductWeight'] = $productsDetailDataObj['ProductWeight'];
						$bidProductDetail['ProductWeigntUnit'] = $productsDetailDataObj['ProductWeigntUnit'];
					}
				}
				
				
				
				$bidTranModel = Mage::getModel("webportal/Right_BidTran");
				$bidTranDataObjs = $bidTranModel->getResource()->getCurrentBidTranByBidID($bidVO->getID());
				
				$newBidTranDataObjs = array();
				if(sizeof($bidTranDataObjs) > 0){
					
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
						$newBidTranDataObjs[] = $newBidTranDataObj;
						
						if($counter == $BID_NUMBER_OF_RECORD_SHOW){
							break;
						}
						
						$counter++;
					}
				}
				$bidProductDetail['LastBidding'] = $newBidTranDataObjs;
				
			}
		}
	
		return $bidProductDetail;
	}
	
}
