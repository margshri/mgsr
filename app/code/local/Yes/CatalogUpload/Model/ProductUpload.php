<?php
class Yes_CatalogUpload_Model_ProductUpload extends Mage_Core_Model_Abstract  {
	
	private	$fileUploadVO;
	private $templateVO;
	private	$catalogProductWebsiteVO;
	private $catalogCategoryProductVO;
	private $catalogProductEntityVO;
	private $fileManagement;
	private $templateManagement;
	private $recordManagement;
	private $filePath;
	
	private $varcharVO;
	private $decimalVO;
	private $intVO;
	private $textVO;
	private $staticVO;
	private $coreStoreVO;
	private $coreWebsiteVO;
	private $mediaGalleryVO;
	private $mediaGalleryValueVO;
	private $catalogFileUploadVO;
	
	
	
	private $datetimeVO;
	
	/**
	 * Initialize resource model
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->_init('yescatalogupload/productUpload');
	
		$this->fileUploadVO = new Yes_VO_FileUpload_FileUploadVO();
		$this->templateVO = new Yes_VO_Template_TemplateVO();

		$this->coreWebsiteVO = new Yes_VO_Core_CoreWebsiteVO();
		$this->fileManagement = new Yes_Services_FileManagementServices();
		$this->templateManagement = new Yes_Services_TemplateManagementServices();
		$this->recordManagement = new Yes_Services_RecordManagementServices();
		$this->filePath = Yes_Utility::getServerPath() . "/var/repository/uploadedfiles/catalog/products/";
	}
	
	public function fileProcessing($recordFile , $imagesList)
	{
		
		$fileName = Yes_Utility::getUniqueName();
		$sourceFileExtension  	= substr($recordFile['name'], strrpos($recordFile['name'], '.') + 1);
		$sourceFileSize	= $recordFile["size"];
		$sourceFileFormatType   = $recordFile["type"];
		
	    $this->fileUploadVO->setFileName($fileName . ".{$sourceFileExtension}" );
	    $this->fileUploadVO->setErrorFileName($fileName . "error.log");
	    $this->fileUploadVO->setReferenceName(basename($recordFile['name']));
	    $this->fileUploadVO->setFileURL( $this->filePath . ".{$fileName}" );
	    $this->fileUploadVO->setFlatFileUrl( $this->filePath. $fileName . "_PRODUCT.DAT");
	    $this->fileUploadVO->setErrorFileURL($this->filePath.$fileName ."error.log");
	    $this->fileUploadVO->setTemplateID(Yes_VO_Template_TemplateVO::$PRODUCT_UPLOAD_TEMPLATE_ID);
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
		
	    $errorMessage = $this->recordValidation($imagesList);
	    
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
		    $response['message']='Product File Successfully Uploaded';
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
	
	
	public function recordValidation($imagesList)
	{
		$nRowsProcessed = 0;
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
				$this->dataRowProcessing($errorMessage , $templateArray,  $flatFileArray[$rowIndex],$imagesList, $rowIndex);
			}// end if else statement
 		}// end for loop
 		 
 		if($errorMessage != null)
 		{
 			return $errorMessage;
 		}
 		 
			
	} //end recordValidation function

	
	
	private function dataRowProcessing(&$errorMessage, $templateArray, $rowData, $imagesList, $rowIndex){
		
		$nRowsError = 0;
		$error=array();
		
		$model = Mage::getModel('yescatalogupload/productUpload');
		$isDataRowValid=true;		
		
	    $imageNameList = array();
	    
	    $this->catalogCategoryProductVO = new Yes_VO_Catalog_CatalogCategoryProductVO();
	    $this->catalogProductEntityVO = new Yes_VO_Catalog_CatalogProductEntityVO();
	    $this->catalogFileUploadVO = new Yes_VO_Catalog_CatalogFileUploadVO();
	    $this->catalogProductWebsiteVO = new Yes_VO_Catalog_CatalogProductWebsiteVO();
	    
	    //array list is used to hold the attributes value
		$varCharVOList = array();
		$decimalVOList = array();
		$intVOList = array();
		$textVOList = array();
		$dateTimeVOList = array();
		$staticVOList = array();
		$mediaGalleryVOList = array();
		$mediaGalleryValueVOList = array();
		
		
		for($colIndex = 0 ; $colIndex < sizeof($templateArray) ; $colIndex++)
		{
			
			$this->varcharVO = new Yes_VO_Catalog_CatalogProductEntityVarcharVO();
			$this->decimalVO = new Yes_VO_Catalog_CatalogProductEntityDecimalVO();
			$this->intVO = new Yes_VO_Catalog_CatalogProductEntityIntVO();
			$this->textVO = new Yes_VO_Catalog_CatalogProductEntityTextVO();
			$this->staticVO = new Yes_VO_Catalog_CatalogProductEntityStaticVO();
			$this->datetimeVO = new Yes_VO_Catalog_CatalogProductEntityDateTimeVO();
			$this->coreStoreVO = new Yes_VO_Core_CoreStoreVO();
			$this->mediaGalleryVO = new Yes_VO_Catalog_CatalogProductEntityMediaGalleryVO();
			$this->mediaGalleryValueVO = new Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO();
			
				
				$columnKey = null;
				$columnException = explode('~', $templateArray[$colIndex]->getColumnException());

				//Remove dependency key from the array 
				$columnKey = $templateArray[$colIndex]->getColumnKey();
				if(in_array(Yes_VO_Exception_ExceptionVO::$DEPENDENCY_KEY, $columnException ))
				{ 
						$index = array_search(Yes_VO_Exception_ExceptionVO::$DEPENDENCY_KEY, $columnException);
						unset($columnException[$index]);
				}
					
				// check column length
				$isColumnLengthValid = $this->recordManagement->isColumnLengthValid($templateArray[$colIndex]->getColumnLength(), $rowData[$colIndex]);
					
				if(!$isColumnLengthValid)
				{
					$errorMessage[] =  $rowIndex . " exceeds " . $templateArray[$colIndex]->getColumnName() . " " . "column  length" . "\n";
				}
				// image validation
				if($templateArray[$colIndex]->getColumnKey() == Yes_ApplicationConstant::$BASE_IMAGE_TYPE){
					$isImageValid  = $this->recordManagement->isImageValid($templateArray[$colIndex]->getColumnKey(), $rowData[$colIndex], $imagesList);
					if(!$isImageValid) $errorMessage[] = $rowIndex . " " . "Image not valid" . "\n";
				}
				if($templateArray[$colIndex]->getColumnKey() == Yes_ApplicationConstant::$SMALL_IMAGE_TYPE){
					$isImageValid  = $this->recordManagement->isImageValid($templateArray[$colIndex]->getColumnKey(), $rowData[$colIndex] , $imagesList);
					if(!$isImageValid) $errorMessage[] = $rowIndex . " " . "Small image not valid" . "\n";
				}
				if($templateArray[$colIndex]->getColumnKey() == Yes_ApplicationConstant::$THUMBNAIL_IMAGE_TYPE){
					$isImageValid  = $this->recordManagement->isImageValid($templateArray[$colIndex]->getColumnKey(), $rowData[$colIndex], $imagesList);
					if(!$isImageValid) $errorMessage[] = $rowIndex . " " . "Thumbnail image not valid" . "\n";
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
								$sku =  $this->getSkuByCode($rowData[$colIndex]);
								
								if($sku != null){
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Dulicate SkuCode" . "\n";
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
							if($columnKey ==  'website_id')
							{
								$websiteId =  $this->getWebsiteId($rowData[$colIndex]);
								if($websiteId == null)
								{
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Not find website ID" . "\n";
								}
							}
							if($columnKey ==  'category_id')
							{
								$categoryId =  $this->getCategoryId($rowData[$colIndex]);
								if($categoryId == null)
								{
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Not find category ID" . "\n";
								}
							}
							 
							
				}//end dependency if statement					
				
				
				//if data validation failed set error in erroMessage array
				if(sizeof($errorMessage)>0 ){
					
					//	array_merge($errorMessage, $error);
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
				if($backendType == 'varchar'){ 
					$this->varcharVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->varcharVO->setAttributeId($attributeId);
					$this->varcharVO->setStoreId($this->coreStoreVO->getStoreId());
					$this->varcharVO->setValue($rowData[$colIndex]);
					$this->varcharVO->setStoreId($storeId);
					$varCharVOList[]=$this->varcharVO;
				}elseif($backendType == 'decimal'){ 
					//echo " value ".$templateArray[$colIndex]->getColumnKey() .   "attribute Id ". $attributeId . " value ".$rowData[$colIndex]. "<br />";
					$this->decimalVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->decimalVO->setAttributeId($attributeId);
					$this->decimalVO->setValue($rowData[$colIndex]);
					$this->decimalVO->setStoreId($storeId);
					$decimalVOList[]= $this->decimalVO;
				}elseif($backendType == 'int'){ 
					$this->intVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->intVO->setAttributeId($attributeId);
					$this->intVO->setStoreId($this->coreStoreVO->getStoreId());
					$this->intVO->setValue($rowData[$colIndex]);
					$this->intVO->setStoreId($storeId);
					$intVOList[]=$this->intVO;
				}elseif($backendType == 'text'){ 
					$this->textVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->textVO->setAttributeId($attributeId);
					$this->textVO->setStoreId($this->coreStoreVO->getStoreId());
					$this->textVO->setValue($rowData[$colIndex]);
					$this->textVO->setStoreId($storeId);
					$textVOList[]=$this->textVO; 
				}elseif($backendType == 'datetime'){ 
					$this->datetimeVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
					$this->datetimeVO->setAttributeId($attributeId);
					$this->datetimeVO->setStoreId($this->coreStoreVO->getStoreId());
					$this->datetimeVO->setValue($rowData[$colIndex]);
					$this->datetimeVO->setStoreId($storeId);
					$dateTimeVOList[]=$this->datetime;
				} 
				if($backendType == null || $backendType=="static" ){ 
					if($columnKey ==  'sku') $this->catalogProductEntityVO->setSku($rowData[$colIndex]);
					if($columnKey ==  'store_id') $this->coreStoreVO->setStoreId($this->getStoreId($rowData[$colIndex]));
					if($columnKey ==  'website_id') $this->coreWebsiteVO->setWebsiteId($this->getWebsiteId($rowData[$colIndex]));
					if($columnKey ==  'category_id') $this->catalogCategoryProductVO->setCategoryId($rowData[$colIndex]);
					
				}
				if($attributeId == Yes_VO_Attribute_EavAttributeVO::$IMAGE_ATTRIBUTE_ID){ 
					
					$this->mediaGalleryVO->setAttributeId(Yes_VO_Attribute_EavAttributeVO::$MEDIA_GALLERY_IMAGE_ATTRIBUTE_ID);
					$this->mediaGalleryVO->setValue($rowData[$colIndex]);	
					$mediaGalleryVOList[] = $this->mediaGalleryVO;
				}

				//start save Image
				if ((($templateArray[$colIndex]->getColumnKey() == Yes_ApplicationConstant::$BASE_IMAGE_TYPE)
				|| ($templateArray[$colIndex]->getColumnKey() == Yes_ApplicationConstant::$SMALL_IMAGE_TYPE)
				|| ($templateArray[$colIndex]->getColumnKey() == Yes_ApplicationConstant::$THUMBNAIL_IMAGE_TYPE))
				){
					$imageNameList[$templateArray[$colIndex]->getColumnName()]=$rowData[$colIndex];
				}
				//end save image
				
				
		}// end columns for loop

		
		if(!$isDataRowValid){
			 $this->fileUploadVO->setNRowsError( $this->fileUploadVO->getNRowsError() + 1);
			 return;
		}
		foreach ($imageNameList as $key=>$imageName){
				$isImagageSaved = $this->recordManagement->saveImage($imageName, $imagesList);
				if(!$isImagageSaved){
					$errorMessage[] = $rowIndex . "\t" . $key . "\t\t" . "Image not saved" . "\n";
					$isDataRowValid= false;
				}
		}
		if(!$isDataRowValid){
			 $this->fileUploadVO->setNRowsError( $this->fileUploadVO->getNRowsError() + 1);
			return ;
		}
		 
		 	$statusIntVO = new Yes_VO_Catalog_CatalogProductEntityIntVO();
			$statusIntVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
			$statusIntVO->setAttributeId(Yes_VO_Attribute_EavAttributeVO::$STATUS_ATTRIBUTE_ID);
			$statusIntVO->setValue(Yes_VO_Catalog_CatalogProductEntityStaticVO::$STATUS);
			$statusIntVO->setStoreId($storeId);
			$intVOList[]=$statusIntVO;
		
		 	$visibilityIntVO = new Yes_VO_Catalog_CatalogProductEntityIntVO();
			$visibilityIntVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
			$visibilityIntVO->setAttributeId(Yes_VO_Attribute_EavAttributeVO::$VISIBILITY_ATTRIBUTE_ID);
			$visibilityIntVO->setValue(Yes_VO_Catalog_CatalogProductEntityStaticVO::$VISIBILITY);
			$visibilityIntVO->setStoreId($storeId);
			$intVOList[] = $visibilityIntVO;
		 
				//create Product and get entityid to use in its associated tables.
				$this->catalogProductEntityVO->setEntityTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ENTITY_TYPE_ID);
				$this->catalogProductEntityVO->setAttributeSetId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$ATTRIBUTE_SET_ID);
				$this->catalogProductEntityVO->setTypeId(Yes_VO_Catalog_CatalogProductEntityStaticVO::$TYPE_ID);
				$this->catalogProductEntityVO->setCreatedAt(date("Y-m-d h:i:s"));
				$this->catalogProductEntityVO->setUpdatedAt(date("Y-m-d h:i:s"));
				
				
				    $resource = Mage::getModel('yescatalogupload/productUpload')->getResource();
				    
				    Mage::getModel('yescatalogupload/productUpload')->getResource()->beginTransaction();
					
					try {
							$entityId = $model->getResource()->saveCatalogProductEntity($model,$this->catalogProductEntityVO);
							$this->catalogProductEntityVO->setEntityId($entityId);
							
							foreach($varCharVOList as $vo){
								$vo->setEntityId($this->catalogProductEntityVO->getEntityId());
								$model->getResource()->saveCatalogProductEntityVarchar($model , $vo);
							}
							foreach ($textVOList as $vo){
								$vo->setEntityId($this->catalogProductEntityVO->getEntityId());
								$model->getResource()->saveCatalogProductEntityText($model , $vo);
							}
							foreach ($decimalVOList as $vo){
								$vo->setEntityId($this->catalogProductEntityVO->getEntityId());
								$model->getResource()->saveCatalogProductEntityDecimal($model , $vo);
							}
							foreach ($dateTimeVOList as $vo){
								$vo->setEntityId($this->catalogProductEntityVO->getEntityId());
								$model->getResource()->saveCatalogProductEntityDateTime($model , $vo);
							}
							foreach ($intVOList as $vo){
								$vo->setEntityId($this->catalogProductEntityVO->getEntityId());
								$model->getResource()->saveCatalogProductEntityInt($model , $vo);
							}

							$this->catalogProductWebsiteVO->setProductId($this->catalogProductEntityVO->getEntityId());
							$this->catalogProductWebsiteVO->setWebsiteId($websiteId);
							$model->getResource()->saveCatalogProductWebsite($model , $this->catalogProductWebsiteVO);
							
							
							$this->catalogCategoryProductVO->setProductId($this->catalogProductEntityVO->getEntityId());
							$this->catalogCategoryProductVO->setPosition(1);
							$model->getResource()->saveCatalogCategoryProduct($model , $this->catalogCategoryProductVO);

							$this->catalogFileUploadVO->setFileUploadID($this->fileUploadVO->getUploadID());
							$this->catalogFileUploadVO->setSKUEntityID($this->catalogProductEntityVO->getEntityId());
							$catalogFileUploadId = $model->getResource()->saveCatalogFileUpload($model , $this->catalogFileUploadVO);
							$this->catalogFileUploadVO->setCatalogFileUploadID($catalogFileUploadId);
							
							foreach($mediaGalleryVOList as $vo){
								$vo->setEntityId($this->catalogProductEntityVO->getEntityId());
								$valueId = $model->getResource()->saveCatalogProductEntityMediaGallery($model , $vo);
								
								$this->mediaGalleryValueVO->setValueId($valueId);
								$this->mediaGalleryValueVO->setStoreId($storeId);
								$this->mediaGalleryValueVO->setLabel(Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO::$LABEL);
								$this->mediaGalleryValueVO->setPosition(Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO::$POSITION);
								$this->mediaGalleryValueVO->setDisabled(Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO::$DISABLED);
								
								$mediaGalleryValueVOList[]  = $this->mediaGalleryValueVO;
								
							}
							
							foreach($mediaGalleryValueVOList as $vo){
								
								$model->getResource()->saveCatalogProductEntityMediaGalleryValue($model , $vo);
								
							}
															 
							Mage::getModel('yescatalogupload/productUpload')->getResource()->commit();
							//$model->getResource()->_getWriteAdapter()->commit();
					}catch(Exception $e){
						Mage::getModel('yescatalogupload/productUpload')->getResource()->rollBack();
						$errorMessage[] = "Data insertion failed" . "\n";
					} 				
	}// end of data row processing function
	
	
	
	
	public function getSkuByCode($skuCode){
		
		$model = Mage::getModel('yescatalogupload/productUpload');
		$model->getResource()->getSkuByCode($model, $skuCode);
		return $model->getData('sku');
	}
	public function getStoreId($storeCode){
		$model = Mage::getModel('yescatalogupload/productUpload');
		$model->getResource()->getStoreIdByCode($model, $storeCode);
		return $model->getData('store_id');
	}
	public function getWebsiteId($websiteCode){
		$model = Mage::getModel('yescatalogupload/productUpload');
		$model->getResource()->getWebsiteIdByCode($model, $websiteCode);
		return $model->getData('website_id');
	}
	public function getCategoryId($categoryCode){
		$categoryCode = "Books";
		$model = Mage::getModel('yescatalogupload/productUpload');
		$model->getResource()->getCategoryIdByCode($model, $categoryCode);
		return $model->getData('entity_id');
	}
	public function getStatus($statusCode){
		$statusCode = "Enabled";
		if($statusCode == 'Enabled') return 1;
		elseif($statusCode == 'Disabled') return 0;
		else return null; 
	}
	public function getVisibility($visibilityCode){
		$visibilityCode = "Catalog, Search";
		if($visibilityCode == 'Not Visible Individually') return 1;
		elseif($visibilityCode == 'Catalog') return 2;
		elseif($visibilityCode == 'Search') return 3;
		elseif($visibilityCode == 'Catalog, Search') return 4;
		else return null;
	}
	
	// set template file path with name in TemplateVO
	public function setTemplateUrl(){
		$model = Mage::getModel('yesmaster/fileUploadTemplate');
		$model->getResource()->getById($model,Yes_VO_Template_TemplateVO::$PRODUCT_UPLOAD_TEMPLATE_ID);
		$this->templateVO->setTemplateUrl(Yes_Utility::getServerPath() . $model->getData('FileURL'));
		$this->templateVO->setTemplateExt($model->getData('FileExtensions'));
	}// end setTemplateFilePathWithName function
}// end class