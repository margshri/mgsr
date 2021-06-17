<?php
class Dakiya_VO_Email_SendEmail_SendEmailVO extends Dakiya_VO_BaseVO{
	
	protected $_db;
	protected $_name;
	protected $_primary = 'SentEmailID';
	
	private $_SentEmailID;
	private $_EmailTemplateID;
	private $_EmailConfigID;
	private $_RequestID;
	private $_UserID;
	private $_ReceiverEmail;
	private $_Remarks;
	private $_StatusID;
	private $_CreatedAt;
	private $_CreatedBy;
	private $_UpdatedAt;
	private $_UpdatedBy;
	
	private $_HostName;
	private $_UserEmail;
	private $_UserPass;
	private $_SMTPSecure;
	private $_Port;
	
	private $_SenderEmail;
	private $_SenderName;
	private $_ReplyToEmail;
	private $_ReplyToName;
	
	private $_ReceiverEmailAddress;
	private $_ReceiverCCAddress;
	private $_ReceiverBCCAddress;
	
	private $_EmailBody;
	private $_EmailSubject;
	
	private $_TemplateName;
	private $_ConfigName;
	private $_AdminUserName;
	private $_EmailContent;
	
	private $_PNRNumber;
	private $_PaymentLink;
	private $_CollectibleAmount;
	
	private $_EmailTemplateVO;

	private $_CancellationWarningHours;
	private $_CancellationWarningAmount;
	
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function getSentEmailID() {
		return $this->_SentEmailID;
	}
	public function setSentEmailID($value) {
		$this->_SentEmailID = $value;
	}
	  
	
	public function getEmailTemplateID() {
		return $this->_EmailTemplateID;
	}
	public function setEmailTemplateID($value) {
		$this->_EmailTemplateID = $value;
		$this->set('EmailTemplateID' , $value);
	}
	
	
	public function getEmailConfigID() {
		return $this->_EmailConfigID;
	}
	public function setEmailConfigID($value) {
		$this->_EmailConfigID = $value;
		$this->set('EmailConfigID' , $value);
	}
	
	public function getRequestID() {
		return $this->_RequestID;
	}
	public function setRequestID($value) {
		$this->_RequestID = $value;
		$this->set('RequestID' , $value);
	}
	
	
	public function getUserID() {
		return $this->_UserID;
	}
	public function setUserID($value) {
		$this->_UserID = $value;
		$this->set('UserID' , $value);
	}
	
	public function getReceiverEmail() {
		return $this->_ReceiverEmail;
	}
	public function setReceiverEmail($value) {
		$this->_ReceiverEmail = $value;
		$this->set('ReceiverEmail' , $value);
	}
	
	public function getRemarks() {
		return $this->_Remarks;
	}
	public function setRemarks($value) {
		$this->_Remarks = $value;
		$this->set('Remarks' , $value);
	}
	
	
	public function getStatusID() {
		return $this->_StatusID;
	}
	public function setStatusID($value) {
		$this->_StatusID = $value;
		$this->set('StatusID' , $value);
	}
	
	
	public function getCreatedAt() {
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value) {
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getCreatedBy() {
		return $this->_CreatedBy;
	}
	public function setCreatedBy($value) {
		$this->_CreatedBy = $value;
		$this->set('CreatedBy' , $value);
	}
	
	
	public function getUpdatedAt() {
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value) {
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	
	public function getUpdatedBy() {
		return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value) {
		$this->_UpdatedBy = $value;
		$this->set('UpdatedBy' , $value);
	}
	
	
	
	public function getHostName() {
		return $this->_HostName;
	}
	public function setHostName($value) {
		$this->_HostName = $value;
	}
	
	
	public function getUserEmail() {
		return $this->_UserEmail;
	}
	public function setUserEmail($value) {
		$this->_UserEmail = $value;
	}
	
	
	public function getUserPass() {
		return $this->_UserPass;
	}
	public function setUserPass($value) {
		$this->_UserPass = $value;
	}
	
	
	public function getSMTPSecure() {
		return $this->_SMTPSecure;
	}
	public function setSMTPSecure($value) {
		$this->_SMTPSecure = $value;
	}
	
	
	public function getPort() {
		return $this->_Port;
	}
	public function setPort($value) {
		$this->_Port = $value;
	}
	
	
	public function getSenderEmail() {
		return $this->_SenderEmail;
	}
	public function setSenderEmail($value) {
		$this->_SenderEmail = $value;
	}
	
	
	public function getSenderName() {
		return $this->_SenderName;
	}
	public function setSenderName($value) {
		$this->_SenderName = $value;
	}
	
	
	public function getReplyToEmail() {
		return $this->_ReplyToEmail;
	}
	public function setReplyToEmail($value) {
		$this->_ReplyToEmail = $value;
	}
	
	
	public function getReplyToName() {
		return $this->_ReplyToName;
	}
	public function setReplyToName($value) {
		$this->_ReplyToName = $value;
	}
	
	
	public function getReceiverEmailAddress() {
		return $this->_ReceiverEmailAddress;
	}
	public function setReceiverEmailAddress($value) {
		$this->_ReceiverEmailAddress = $value;
	}
	
	
	public function getReceiverCCAddress() {
		return $this->_ReceiverCCAddress;
	}
	public function setReceiverCCAddress($value) {
		$this->_ReceiverCCAddress = $value;
	}
	
	
	public function getReceiverBCCAddress() {
		return $this->_ReceiverBCCAddress;
	}
	public function setReceiverBCCAddress($value) {
		$this->_ReceiverBCCAddress = $value;
	}

	
	public function getEmailBody() {
		return $this->_EmailBody;
	}
	public function setEmailBody($value) {
		$this->_EmailBody = $value;
	}
	
	
	public function getEmailSubject() {
		return $this->_EmailSubject;
	}
	public function setEmailSubject($value) {
		$this->_EmailSubject = $value;
	}
	
	
	public function getTemplateName() {
		return $this->_TemplateName;
	}
	public function setTemplateName($value) {
		$this->_TemplateName = $value;
	}
	
	
	public function getConfigName() {
		return $this->_ConfigName;
	}
	public function setConfigName($value) {
		$this->_ConfigName = $value;
	}
	 
	public function getAdminUserName() {
		return $this->_AdminUserName;
	}
	public function setAdminUserName($value) {
		$this->_AdminUserName = $value;
	}
	
	public function getEmailContent() {
		return $this->_EmailContent;
	}
	public function setEmailContent($value) {
		$this->_EmailContent = $value;
	}
	
	
	public function getPNRNumber() {
		return $this->_PNRNumber;
	}
	public function setPNRNumber($value) {
		$this->_PNRNumber= $value;
	}
	
	public function getPaymentLink() {
		return $this->_PaymentLink;
	}
	public function setPaymentLink($value) {
		$this->_PaymentLink= $value;
	}

	public function getCollectibleAmount() {
		return $this->_CollectibleAmount;
	}
	public function setCollectibleAmount($value) {
		$this->_CollectibleAmount= $value;
	}
	
	public function getEmailTemplateVO() {
		return $this->_EmailTemplateVO;
	}
	public function setEmailTemplateVO($value) {
		$this->_EmailTemplateVO = $value;
	}
	
	
	public function getCancellationWarningHours() {
		return $this->_CancellationWarningHours;
	}
	public function setCancellationWarningHours($value) {
		$this->_CancellationWarningHours= $value;
	}
	
	
	public function getCancellationWarningAmount() {
		return $this->_CancellationWarningAmount;
	}
	public function setCancellationWarningAmount($value) {
		$this->_CancellationWarningAmount = $value;
	}
	
	
	
	
	public function __construct(){
		$model = Mage::getModel("dakiya/Email_SendEmail_SendEmail");
		$tableName = $model->getResource()->getMainTable();
	
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
	}
	
	
	
	public function setTableName($tableName){
		$this->_name =$tableName;
		parent::_setupTableName();
	}
	
	public function getTableName(){
		return $this->_name;
	}
	
}	
	 
	