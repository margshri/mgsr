<?php
class Dakiya_SMS_SendSMSController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='dakiya/SMS_SendSMS_Grid';
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_setActiveMenu('communication');
		return $this;
	}
	
	
	public function indexAction(){
		$this->_initAction();
		$this->renderLayout();
	}
	
	
	public function sentSMSListAction(){
		$this->_initAction();
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	
	
	public function sendSMSAction(){
		
		try{
			Mage::log('=> Dakiya_SMS_SendSMSController->sendSMSAction method', null, 'system.log', true);
			$responseVO = new Dakiya_VO_BaseVO();
			$post = $this->getRequest()->getPost();
			
			if (empty($post)) {
				Mage::throwException('Invalid form data.');
			}
			
			$sendSMSDataObj = json_decode($post["SendSMSDataObj"],true);
			Mage::log('=> Form Data ->'. $post["SendSMSDataObj"], null, 'system.log', true);
			$sendSMSDTO = new Dakiya_VO_SMS_SendSMS_SendSMSVO();
			/* @var $sendSMSVO Dakiya_VO_SMS_SendSMS_SendSMSVO */
			$sendSMSVO  = Dakiya_Helper_Utility::setVO($sendSMSDTO, $sendSMSDataObj);
			
			if($sendSMSVO->getSMSTemplateID() == null && $sendSMSVO->getSMSContent() == null){
				Mage::throwException('Please Select SMS Template OR Enter SMS Content !');
			}
			
			if($sendSMSVO->getSMSConfigID() == null){
				Mage::throwException('Please Select SMS Sender !');
			}
			
			if($sendSMSVO->getReceiverMobileNO() == null){
				Mage::throwException('Receiver Mobile Number Not Found !');
			}
			
			// SENDING SMS
			$sendSMSModel = Mage::getModel('dakiya/SMS_SendSMS_SendSMS');
			$responseVO = $sendSMSModel->sendSMS($sendSMSVO, "backend");
			
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			
		}catch (Exception $e) {
			$responseVO->setSuccessMessage(null);
			$responseVO->setErrorMessage($e->getMessage());
			Mage::log('=> Dakiya_SMS_SendSMSController->Error'. $e->getMessage(), null, 'system.log', true);
		}
		
		$this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
		return;
		
	}	
	 
}