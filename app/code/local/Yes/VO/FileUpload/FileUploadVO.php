<?php

class Yes_VO_FileUpload_FileUploadVO extends Zend_Db_Table_Abstract
{
	
	protected $_db;
	protected $_name;
	protected $_primary = 'UploadID';

	
	private $uploadID;
	private $typeID;
	private $userID;
	private $userOfficeID;
	private $templateID;
	private $fileName;
	private $rowsProcessed;
	private $nRowsSuccessed;
	private $nRowsError;
	private $fileURL;
	private $successFileURL;
	private $errorFileURL;
	private $uploadeddAt;
	private $statusID;
	private $referenceName;
	private $flatFileUrl;
	private $errorFileName;
	
	
	private $fileSize;
	private $fileExtension;
	private $fileFormatType;
	
	
	protected $dataVO = array();
	
	protected function set($name, $value){
		$this->dataVO[$name]=$value;
	}
	
	public function getDataArray(){
		return $this->dataVO;
	}
	
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;
		$this->set('FileName' , $fileName);
	}
	
	public function getFileName()
	{
		return $this->fileName;
	}
	
	
	
	
	public function setFlatFileUrl($flatFileUrl)
	{
		$this->flatFileUrl = $flatFileUrl;
		$this->set('FlatFileURL' , $flatFileUrl);
	}
	
	public function getFlatFileUrl()
	{
		return $this->flatFileUrl;
	}
	
	
	public function setReferenceName($referenceName)
	{
		$this->referenceName = $referenceName;
		$this->set('ReferenceName' , $referenceName);
	}
	
	public function getReferenceName()
	{
		return $this->referenceName;
	}
	
	public function setStatus($statusID)
	{
		$this->statusID = $statusID;
		$this->set('StatusID' , $statusID);
	}
	public function getStatus()
	{
		return $this->statusID;
	}
	
		
	
	
	public function setErrorFileURL($errorFileName){
		$this->errorFileURL= $errorFileName;
		$this->set('ErrorFileURL' , $errorFileName);
	}
	public function getErrorFileURL(){
		return $this->errorFileURL;
	}
	
	
	
	public function setFileURL($fileName){
		$this->fileURL= $fileName;
		$this->set('FileURL' , $fileName);
	}
	public function getFileURL(){
		return $this->fileURL;
	}
	
	
	public function setUploadeddAt($uploadeddAt){
		$this->uploadeddAt= $uploadeddAt;
		$this->set('UploadeddAt' , $uploadeddAt);
	}
	public function getUploadeddAt(){
		return $this->uploadeddAt;
	}
	
	
	public function setUserID($userID){
		$this->userID= $userID;
		$this->set('UserID' , $userID);
	}
	public function getUserID(){
		return $this->userID;
	}
	
	
	
	public function setUserOfficeID($userOfficeID){
		$this->userOfficeID= $userOfficeID;
		$this->set('UserOfficeID' , $userOfficeID);
	}
	public function getUserOfficeID(){
		return $this->userOfficeID;
	}
	
	
	public function setTypeID($typeID){
		$this->typeID= $typeID;
		$this->set('TypeID' , $typeID);
	}
	public function getTypeID(){
		return $this->typeID;
	}
	
	
	
	public function setTemplateID($templateID){
		$this->templateID= $templateID;
		$this->set('TemplateID' , $templateID);
	}
	public function getTemplateID(){
		return $this->templateID;
	}
	
	
	public function setUploadID($uploadID){
		
		$this->uploadID = $uploadID;
		$this->set('UploadID' , $uploadID);
	}
	public function getUploadID(){
		return	$this->uploadID;
	}
	
	public function setErrorFileName($errorFileName){
		$this->errorFileName= $errorFileName;
		$this->set('ErrorFileName' , $errorFileName);
	}
	public function getErrorFileName(){
		return $this->errorFileName;
	}
	
	public function setRowsProcessed($rowsProcessed){
		$this->rowsProcessed= $rowsProcessed;
		$this->set('RowsProcessed' , $rowsProcessed);
	}
	public function getRowsProcessed(){
		 return $this->rowsProcessed;
	}
	
	public function setNRowsSuccessed($nRowsSuccessed){
		$this->nRowsSuccessed= $nRowsSuccessed;
		$this->set('NRowsSuccessed' , $nRowsSuccessed);
	}
	public function getNRowsSuccessed(){
		return $this->nRowsSuccessed;
	}
	
	public function setNRowsError($nRowsError){
		$this->nRowsError= $nRowsError;
		$this->set('NRowsError' , $nRowsError);
	}
	public function getNRowsError(){
		return $this->nRowsError;
	}
	
	public function setSuccessFileURL($successFileURL){
		$this->successFileURL= $successFileURL;
		$this->set('SuccessFileURL' , $successFileURL);
	}
	public function getSuccessFileURL(){
		return $this->successFileURL;
	}
	
	
	
	public function setFileSize($fileSize)
	{
		$this->fileSize = $fileSize;
	}
	
	public function getFileSize()
	{
		return $this->fileSize;
	}
	
	
	public function setFileExtension($fileExtension)
	{
		$this->fileExtension = $fileExtension;
	}
	
	public function getFileExtension()
	{
		return $this->fileExtension;
	}
	
	
	public function setFileFormatType($fileFormatType)
	{
		$this->fileFormatType = $fileFormatType;
	}
	
	public function getFileFormatType()
	{
		return $this->fileFormatType;
	}
	
	
	
	
	public function __construct(){
		
		$model = Mage::getModel('yescatalogupload/fileUpload');
		$tableName=$model->getResource()->getTable('yescatalogupload/fileupload');
		
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