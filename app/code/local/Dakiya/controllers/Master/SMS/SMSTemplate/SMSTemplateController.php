<?php
class Dakiya_Master_SMS_SMSTemplate_SMSTemplateController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='dakiya/Master_SMS_SMSTemplate_SMSTemplate_Grid';
	private $buttonsBlock ='dakiya/Master_SMS_SMSTemplate_SMSTemplate_Buttons';
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_setActiveMenu('master');
		$this->_title('SMS-Template');
		return $this;
	}
	
	
	protected function _init($templateID){
	
		if($templateID !=null){
			$model   = Mage::getModel('dakiya/Master_SMS_SMSTemplate');
			$dataObj = $model->getResource()->getByID($templateID);
			
			if($dataObj !== false){
				$smsTemplateDTO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
				$smsTemplateVO  = Dakiya_Helper_Utility::setVO($smsTemplateDTO, $dataObj);
			}
		}
		
		Mage::register('CurrentSMSTemplateVO', $smsTemplateVO);
		return Mage::registry('CurrentSMSTemplateVO');
	
	}
	
	
	public function indexAction(){
		$this->_initAction();
		$this->renderLayout();
	}

	
	public function editAction(){
		$smsTemplateID = $this->getRequest()->getParam('TemplateID');
		$smsTemplateVO = $this->_init($smsTemplateID);
		if($smsTemplateVO == null){
			$smsTemplateVO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
		}
		
		$this->_initAction();
		$this->_addContent(
				$this->getLayout()->createBlock($this->buttonsBlock)
				->setTemplateID($smsTemplateVO->getTemplateID())
		);
		$this->renderLayout();
	}
	
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	
	
	public function saveAction(){
		
	
		try {
			
			$responseVO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
			$adapter = new Dakiya_VO_Master_SMS_SMSTemplateVO();
			$post = $this->getRequest()->getPost();
			
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
				
			$smsTemplateDataObj = json_decode($post["SMSTemplateDataObj"],true);
			
			$smsTemplateDTO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
			/* @var $smsTemplateVO Dakiya_VO_Master_SMS_SMSTemplateVO */
			$smsTemplateVO  = Dakiya_Helper_Utility::setVO($smsTemplateDTO, $smsTemplateDataObj);
			
			if($smsTemplateVO->getTemplateName() == null){
				Mage::throwException($this->__('Please Enter Template Name !'));
			}
			
			if($smsTemplateVO->getTemplateCode() == null){
				Mage::throwException($this->__('Please Enter Template Code !'));
			}
			
			if($smsTemplateVO->getStatusID() == null){
				Mage::throwException($this->__('Please Select Status !'));
			}
			
			$adapter->getAdapter()->beginTransaction();
			$model   = Mage::getModel("dakiya/Master_SMS_SMSTemplate");
			/* @var $queryResponseVO Dakiya_VO_Master_SMS_SMSTemplateVO */
			$queryResponseVO = $model->getResource()->saveDB($smsTemplateVO);
			
			
			if(sizeof($queryResponseVO->getErrorMessage()) > 0 ){
				$adapter->getAdapter()->rollBack();
				$responseVO->setErrorMessage($queryResponseVO->getErrorMessage());
			}else{
				$adapter->getAdapter()->commit();
				$responseVO->setSuccessMessage($queryResponseVO->getSuccessMessage());
				Mage::getSingleton('core/session')->addSuccess($responseVO->getSuccessMessage());
			}
				
		}catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			$responseVO->setErrorMessage(array($e->getMessage()));
		}
		
		$this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	}
	 
}