<?php 
class Margshri_WebPortal_Frontend_Footer_AdvertisementController extends Mage_Core_Controller_Front_Action {
	
	
	public function getVisitorCounterAction(){
		try{
			 
			
			$response = array();
			$response['status'] = null;
			$response['message'] = null;
			$response['data'] = null;
			
			
			$post = $this->getRequest()->getPost();
			if(empty($post)){
				Mage::throwException("Invalid Form Data.");
			}
			
			$visitorCounterObj = json_decode($post["VisitorCounterObj"],true);
			$clientIP = Margshri_WebPortal_Helper_Data::getClientIP();
			
			$visitorCounterModel = Mage::getModel("webportal/Footer_VisitorCounter");
			
			if($visitorCounterObj['VisitorIP'] == null){
				$visitorCounterVO = new Margshri_WebPortal_VO_Footer_VisitorCounterVO();
				$visitorCounterVO->setID(0);
				$visitorCounterVO->setVisitorIP($clientIP);
				$saveResponse = $visitorCounterModel->getResource()->frontendSaveDB($visitorCounterVO);
				if($saveResponse == null || $saveResponse == "" || sizeof($saveResponse) == 0){
					Mage::throwException($this->__('Counld not save'));
				}
			}else{
				$visitorCounterDataObj = $visitorCounterModel->getResource()->getLast();
				if($visitorCounterDataObj !== false){
					$lastInsertDateTime = $visitorCounterDataObj['CreatedAt'];
					$lastInsertTime = strtotime($lastInsertDateTime);
					
					$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
					$currentTime = strtotime($serverDate);
					
					if( ($currentTime - $lastInsertTime) > 100 ){
						$visitorCounterVO = new Margshri_WebPortal_VO_Footer_VisitorCounterVO();
						$visitorCounterVO->setID(0);
						$visitorCounterVO->setVisitorIP($clientIP);
						$saveResponse = $visitorCounterModel->getResource()->frontendSaveDB($visitorCounterVO);
						if($saveResponse == null || $saveResponse == "" || sizeof($saveResponse) == 0){
							Mage::throwException($this->__('Counld not save'));
						}
					}
					
				}	 
			}		
			
			
			// $visitorCounterDataObjs = $visitorCounterModel->getResource()->getAll();
			$visitorCounterDataObj = $visitorCounterModel->getResource()->getLast();
			//$visitorCounter = sizeof($visitorCounterDataObjs); 
			//if($visitorCounter > 0){
			if($visitorCounterDataObj !== false){
				$response['status'] = 'SUCCESS';
				$response['message'] = 'Get Visitor Successfully';
				$response['data'] = array("VisitorCounter"=>$visitorCounterDataObj['ID'], "VisitorIP"=>$clientIP);
			}
			
			
		}catch (Exception $e){
			$response['status'] ='ERROR';
			$response['message']= $e->getMessage();
		}

		return 	$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));		
	}
	
	 
    
}
