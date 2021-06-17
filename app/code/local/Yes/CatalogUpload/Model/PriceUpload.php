<?php
class Yes_CatalogUpload_Model_PriceUpload extends Mage_Core_Model_Abstract  {
	
	private	$fileUploadVO;
	private $templateVO;
	
	private $decimalVO;
	private $intVO;
	private $coreStoreVO;
	private $catalogFileUploadVO;
	
	private $fileManagement;
	private $templateManagement;
	private $recordManagement;
	private $filePath;
	
	/**
	 * Initialize resource model
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->_init('yescatalogupload/priceUpload');
	
		$this->fileUploadVO = new Yes_VO_FileUpload_FileUploadVO();
		$this->templateVO = new Yes_VO_Template_TemplateVO();
		$this->fileManagement = new Yes_Services_FileManagementServices();
		$this->templateManagement = new Yes_Services_TemplateManagementServices();
		$this->recordManagement = new Yes_Services_RecordManagementServices();
		$this->filePath = Yes_Utility::getServerPath() . "/var/repository/uploadedfiles/catalog/price/";
	}
	
	public function fileProcessing($recordFile)
	{
		
		$fileName = Yes_Utility::getUniqueName();
		$sourceFileExtension  	= substr($recordFile['name'], strrpos($recordFile['name'], '.') + 1);
		$sourceFileSize	= $recordFile["size"];
		$sourceFileFormatType   = $recordFile["type"];
		
	    $this->fileUploadVO->setFileName($fileName . ".{$sourceFileExtension}" );
	    $this->fileUploadVO->setErrorFileName($fileName . "error.log");
	    $this->fileUploadVO->setReferenceName(basename($recordFile['name']));
	    $this->fileUploadVO->setFileURL( $this->filePath . ".{$fileName}" );
	    $this->fileUploadVO->setFlatFileUrl( $this->filePath. $fileName . "_PRICE.DAT");
	    $this->fileUploadVO->setErrorFileURL($this->filePath.$fileName ."error.log");
	    $this->fileUploadVO->setTemplateID(Yes_VO_Template_TemplateVO::$PRICE_UPLOAD_TEMPLATE_ID);
	    $this->fileUploadVO->setUploadeddAt(date("Y-m-d h:i:s"));
	    
	    $this->fileUploadVO->setFileSize($sourceFileSize);
	    $this->fileUploadVO->setFileExtension($sourceFileExtension);
	    $this->fileUploadVO->setFileFormatType($sourceFileFormatType);
	    $this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$PENDING);
	    $this->fileUploadVO->setNRowsError(0);
	    $this->fileUploadVO->setRowsProcessed(0);
	    
	    $model= Mage::getModel("yescatalogupload/fileUpload");
	    $uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    $this->fileUploadVO->setUploadID($uploadId);
	   
	  
	    $errorMessage =  $this->preValidation($recordFile);
	    if(sizeof($errorMessage) > 0)  { 
	    	
	    	$errorFile= Yes_Services_FileManagementServices::fileOpen($this->fileUploadVO->getErrorFileURL());
	    	foreach($errorMessage as $value){
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $value);
	    	}
	    	
	    	Yes_Services_FileManagementServices::fileClose($errorFile);
	    	
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$FAILED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	
	    	//return ;
	    	$response['status'] = 'FAIL';
	    	$response['message']='upload process fail. see error log';
	    	return $response;
	    }
	    
	    $errorMessage = $this->generateFlatFile($recordFile); 
	    if(sizeof($errorMessage) > 0)  {
	    	
	    	$errorFile= Yes_Services_FileManagementServices::fileOpen($this->fileUploadVO->getErrorFileURL());
	    	foreach($errorMessage as $value){
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $value);
	    	}
	    	Yes_Services_FileManagementServices::fileClose($errorFile);
	    	 
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$FAILED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	//return ;
	    	
	    	$response['status'] = 'FAIL';
	    	$response['message']='upload process fail. see error log';
	    	return $response;
	    }
		
	    $errorMessage = $this->recordValidation();
	    if(sizeof($errorMessage) > 0)  {
	    	
	    	$errorFile= Yes_Services_FileManagementServices::fileOpen($this->fileUploadVO->getErrorFileURL());
	    		$headingData = "RowNo." . "\t" . "Column Name" . "\t" . "Error Messege" ."\n" ;
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $headingData);
	    	foreach($errorMessage as $value){
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $value);
	    	}
	    	Yes_Services_FileManagementServices::fileClose($errorFile);
	    	 
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$FAILED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	//return ;
	    	
	    	$response['status'] = 'FAIL';
	    	$response['message']='upload process fail. see error log';
	    	return $response;
	    }else {
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$COMPLETED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	
			$response['status'] ='SUCCESS';
		    $response['message']='Price File Successfully Uploaded';
		    return $response;
		 }
	}
	
	public function preValidation($recordFile)
	{
		
		// check fileSize & fileExtension & fleType
		 $isValidFileSize = $this->fileManagement->is_ValidFileSize($this->fileUploadVO->getFileSize());
		 $isValidFileExt = $this->fileManagement->is_ValidFileExtension($this->fileUploadVO->getFileExtension());
		 $isValidFileType = $this->fileManagement->is_ValidFileType($this->fileUploadVO->getFileFormatType());
		 
		 $errorMessage = array();
		 if(!$isValidFileSize )  $errorMessage[] = "File Size exceed the limit(" . (Yes_ApplicationConstant::$DATA_FILE_SIZE_LIMIT/(1000*1000)) . "(MB)" . "\n";
		 if(!$isValidFileExt ) $errorMessage[] = "File Extension not permitted." . "\n" ;
		 if(!$isValidFileType )  $errorMessage[] = "File not parsed." . "\n" ;		 	
		 
		 return $errorMessage;
	}
	
	
	public function generateFlatFile($recordFile)
	{
		
		// get file extension from fileUploadVO
		$fileExt = $this->fileUploadVO->getFileExtension();
		
		if($fileExt == Yes_ApplicationConstant::$XLS_FILE_EXT)
		{
			//$this->setFlatFileUrl();
			$xlsHandler = new Yes_Handlers_XlsFileHandler();
			$isGenerateFlatFile = $xlsHandler->createFlatFile($this->fileUploadVO->getFlatFileUrl(),$recordFile);
		}
		if($fileExt == Yes_ApplicationConstant::$XLSX_FILE_EXT)
		{
			//$this->setFlatFileUrl();
			$xlsxHandler = new Yes_Handlers_XlsxFileHandler();
			$isGenerateFlatFile = $xlsxHandler->createFlatFile($this->fileUploadVO->getFlatFileUrl(),$recordFile);
		}
		$errorMessage = array();
		if(!$isGenerateFlatFile) $errorMessage[] = "Flat file not generated." ."\n"; 
		
		return $errorMessage;
	}
	
	
	public function recordValidation()
	{
		$errorMessage = array();
		
		// Get Template Array
		$this->setTemplateUrl();
		if($this->templateVO->getTemplateExt() == Yes_ApplicationConstant::$CSV_TEMPLATE_EXT)
		{	
			$csvTemplateHandler = new Yes_Handlers_CsvTemplateHandler();
			$templateArray = $csvTemplateHandler->readTemplate($this->templateVO->getTemplateUrl());
		}		
			
		
		// Get Flate File Array
		$flatFileHandler = new Yes_Handlers_FlatFileHandler();
		$flatFileArray = $flatFileHandler->readFlatFile($this->fileUploadVO->getFlatFileUrl());
	
		 
		for($rowIndex=0; $rowIndex < (sizeof($flatFileArray) - 1) ; $rowIndex++ )
		{
			
			$this->fileUploadVO->setRowsProcessed( $this->fileUploadVO->getRowsProcessed() + 1 );
			//First Row For template validation
			if($rowIndex == 0) 
			{
				$isValidTemplate =	$this->templateManagement->is_ValidProductTemplate($templateArray, $flatFileArray[$rowIndex]);
				if(!$isValidTemplate)
				{ 
					$errorMessage[] = "Template not matched" ."\n";
					return $errorMessage;
				}
			}else{
				// Data Validation Starting From Second Row
				$this->dataRowProcessing($errorMessage , $templateArray,  $flatFileArray[$rowIndex], $rowIndex);
			}// end if else statement
 		}// end for loop
 		 
 		if($errorMessage != null)
 		{
 			return $errorMessage;
 		}
 		 
			
	} //end recordValidation function

	
	
	private function dataRowProcessing(&$errorMessage, $templateArray, $rowData, $rowIndex){
		
		
		$isDataRowValid=true;
		$model = Mage::getModel('yescatalogupload/priceUpload');

		//array list is used to hold the attributes value
		$decimalVOList = array();
		$intVOList = array();
		$this->coreStoreVO = new Yes_VO_Core_CoreStoreVO();
		$this->catalogFileUploadVO = new Yes_VO_Catalog_CatalogFileUploadVO();
		
		for($colIndex = 0 ; $colIndex < sizeof($templateArray) ; $colIndex++)
		{
			
			
			$this->decimalVO = new Yes_VO_Catalog_CatalogProductEntityDecimalVO();
			$this->intVO = new Yes_VO_Catalog_CatalogProductEntityIntVO();
			
			
				$columnKey = null;
				$columnException = explode('~', $templateArray[$colIndex]->getColumnException());

				//Remove dependency key from the array 
				if(in_array(Yes_VO_Exception_ExceptionVO::$DEPENDENCY_KEY, $columnException ))
				{ 
						$columnKey = $templateArray[$colIndex]->getColumnKey();
						$index = array_search(Yes_VO_Exception_ExceptionVO::$DEPENDENCY_KEY, $columnException);
						unset($columnException[$index]);
				}
					
				// check column length
				$isColumnLengthValid = $this->recordManagement->isColumnLengthValid($templateArray[$colIndex]->getColumnLength(), $rowData[$colIndex]);
					
				if(!$isColumnLengthValid)
				{
					$errorMessage[] =  $rowIndex . " exceeds " . $templateArray[$colIndex]->getColumnName() . " " . "column  length" . "\n";
				}
				
				// check column type validation
				$isColumnTypeValid = $this->recordManagement->isColumnTypeValid($columnException, $rowData[$colIndex]);
				if($isColumnTypeValid != null)
				{
					$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . $isColumnTypeValid . "\n";
				}
				
				
				// check dependency for duplication and set the value  in respective VO according to  their code
				if($columnKey != null)
				{	
							if($columnKey ==  'sku')
							{
								$entityId =  $this->checkSku($rowData[$colIndex]);
								
								if($entityId == null){
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Sku does not exist." . "\n";
								} 
							}
							if($columnKey ==  'store_id')
							{
								$storeId =  $this->getStoreId($rowData[$colIndex]);
								if($storeId == null)
								{
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Not find Store ID" . "\n";
								}
							
							}
				}//end dependency if statement					
				
				
				//if data validation failed set error in erroMessage array
				if(sizeof($errorMessage)>0 ){
						$isDataRowValid = false;
						continue;
				}	
				
				//set attribute VOs
				$backendType=null;
				$attributeId=$templateArray[$colIndex]->getAttributeID();
				
				//if statement is used to handle value \n it is taking as ascii value 75
				if( $attributeId >0){
					$model->getResource()->getBackendTypeByID($model, $attributeId);
					$backendType = $model->getData('backend_type');
				}	
				
				if($backendType == 'decimal'){ 
					//echo " value ".$templateArray[$colIndex]->getColumnKey() .   "attribute Id ". $attributeId . " value ".$rowData[$colIndex]. "<br />";
					$this->decimalVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->decimalVO->setAttributeId($attributeId);
					$this->decimalVO->setValue($rowData[$colIndex]);
					$decimalVOList[]= $this->decimalVO;
				}elseif($backendType == 'int'){ 
					$this->intVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->intVO->setAttributeId($attributeId);
					$this->intVO->setValue($rowData[$colIndex]);
					$intVOList[]=$this->intVO;
				}elseif($backendType=="static" ){
					if($columnKey ==  'store_id'){
						$this->coreStoreVO->setStoreId($this->getStoreId($rowData[$colIndex]));
					}
				} 
		}// end columns for loop

		if(!$isDataRowValid){
			 $this->fileUploadVO->setNRowsError( $this->fileUploadVO->getNRowsError() + 1);
			 return;
		}
		 	
				    Mage::getModel('yescatalogupload/priceUpload')->getResource()->beginTransaction();
					
					try {
						
						$this->catalogFileUploadVO->setFileUploadID($this->fileUploadVO->getUploadID());
						$this->catalogFileUploadVO->setSKUEntityID($entityId);
						$catalogFileUploadId = $model->getResource()->saveCatalogFileUpload($model , $this->catalogFileUploadVO);
						$this->catalogFileUploadVO->setCatalogFileUploadID($catalogFileUploadId);
							
						
							foreach ($decimalVOList as $vo){
								$vo->setEntityId($entityId);
								$model->getResource()->saveCatalogProductEntityDecimal($model , $vo);
							}
							foreach ($intVOList as $vo){
								$vo->setEntityId($entityId);
								$vo->setStoreId($this->coreStoreVO->getStoreId());
								$model->getResource()->saveCatalogProductEntityInt($model , $vo);
							}

							Mage::getModel('yescatalogupload/priceUpload')->getResource()->commit();
					}catch(Exception $e){
						Mage::getModel('yescatalogupload/priceUpload')->getResource()->rollBack();
						$errorMessage[] =  "data insertion failed" . "\n";
					} 				
	}// end of data row processing function
	
	
	public function checkSku($skuCode){
		
		$model = Mage::getModel('yescatalogupload/priceUpload');
		$model->getResource()->getEntityIdBySku($model, $skuCode);
		return $model->getData('entity_id');
	}
	
	public function getStoreId($storeCode){
		$model = Mage::getModel('yescatalogupload/priceUpload');
		$model->getResource()->getStoreIdByCode($model, $storeCode);
		return $model->getData('store_id');
	}
	public function getTaxClassId($taxClassCode){
		$taxClassCode = 0;
		/*
		$model = Mage::getModel('yescatalogupload/priceUpload');
		$model->getResource()->getStoreIdByCode($model, $storeCode);
		return $model->getData('store_id');
		*/
		return $taxClassCode;
	}
	
	// set template file path with name in TemplateVO
	public function setTemplateUrl(){
		$model = Mage::getModel('yesmaster/fileUploadTemplate');
		$model->getResource()->getById($model,Yes_VO_Template_TemplateVO::$PRICE_UPLOAD_TEMPLATE_ID);
		$this->templateVO->setTemplateUrl(Yes_Utility::getServerPath() . $model->getData('FileURL'));
		$this->templateVO->setTemplateExt($model->getData('FileExtensions'));
	}// end setTemplateFilePathWithName function
}// end class