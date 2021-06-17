<?php
class Dakiya_Master_Email_EmailTemplate_EmailTemplateController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='dakiya/Master_Email_EmailTemplate_EmailTemplate_Grid';
	private $buttonsBlock ='dakiya/Master_Email_EmailTemplate_EmailTemplate_Buttons';
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_setActiveMenu('master');
		$this->_title('Email-Template');
		return $this;
	}
	
	
	protected function _init($templateID){
	
		if($templateID !=null){
			$model   = Mage::getModel('dakiya/Master_Email_EmailTemplate');
			$dataObj = $model->getResource()->getByID($templateID);
			
			if($dataObj !== false){
				$emailTemplateDTO = new Dakiya_VO_Master_Email_EmailTemplateVO();
				$emailTemplateVO  = Dakiya_Helper_Utility::setVO($emailTemplateDTO, $dataObj);
			}
		}
		
		Mage::register('CurrentEmailTemplateVO', $emailTemplateVO);
		return Mage::registry('CurrentEmailTemplateVO');
	
	}
	
	
	public function indexAction(){
		$this->_initAction();
		$this->renderLayout();
	}

	
	public function editAction(){
		$emailTemplateID = $this->getRequest()->getParam('TemplateID');
		$emailTemplateVO = $this->_init($emailTemplateID);
		if($emailTemplateVO == null){
			$emailTemplateVO = new Dakiya_VO_Master_Email_EmailTemplateVO();
		}
		
		$this->_initAction();
		$this->_addContent(
				$this->getLayout()->createBlock($this->buttonsBlock)
				->setTemplateID($emailTemplateVO->getTemplateID())
		);
		$this->renderLayout();
	}
	
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	
	
	public function saveAction(){
		
	
		try {
			
			$responseVO = new Dakiya_VO_Master_Email_EmailTemplateVO();
			$adapter = new Dakiya_VO_Master_Email_EmailTemplateVO();
			$post = $this->getRequest()->getPost();
			
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
				
			$emailTemplateDataObj = json_decode($post["EmailTemplateDataObj"],true);
			
			$emailTemplateDTO = new Dakiya_VO_Master_Email_EmailTemplateVO();
			/* @var $emailTemplateVO Dakiya_VO_Master_Email_EmailTemplateVO */
			$emailTemplateVO  = Dakiya_Helper_Utility::setVO($emailTemplateDTO, $emailTemplateDataObj);
			
			if($emailTemplateVO->getTemplateName() == null){
				Mage::throwException($this->__('Please Enter Template Name !'));
			}
			
			if($emailTemplateVO->getTemplateCode() == null){
				Mage::throwException($this->__('Please Enter Template Code !'));
			}
			
			if($emailTemplateVO->getStatusID() == null){
				Mage::throwException($this->__('Please Select Status !'));
			}
			
			$adapter->getAdapter()->beginTransaction();
			$model   = Mage::getModel("dakiya/Master_Email_EmailTemplate");
			/* @var $queryResponseVO Dakiya_VO_Master_Email_EmailTemplateVO */
			$queryResponseVO = $model->getResource()->saveDB($emailTemplateVO);
			
			
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