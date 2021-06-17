<?php
class Yes_CatalogUpload_Model_Mysql4_ProductUpload extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('yescatalogupload/fileupload', 'UploadID');
    }

    public function getSkuByCode(Mage_Core_Model_Abstract $model, $skuCode)
    {
    	$read = $this->_getReadAdapter();
    	$select = $read->select()
    	->from($this->getTable('yescatalogupload/catalogproductentity'))
    	->where('sku=?',  $skuCode );
    	$row=  $read->fetchRow($select);

    	if ($row) {
    		$model->setData($row);
    	}
    	$this->_afterLoad($model);
    	return $this;
    }
    
    public function getStoreIdByCode(Mage_Core_Model_Abstract $model, $storeCode)
    {
    	$read = $this->_getReadAdapter();
    	$select = $read->select()
    	->from($this->getTable('yescatalogupload/corestore'))
    	->where('code=?',  $storeCode );
    	$row=  $read->fetchRow($select);
    
    	if ($row) {
    		$model->setData($row);
    	}
    	$this->_afterLoad($model);
    	return $this;
    }
    
    public function getWebsiteIdByCode(Mage_Core_Model_Abstract $model, $websiteCode)
    {
    	$read = $this->_getReadAdapter();
    	$select = $read->select()
    	->from($this->getTable('yescatalogupload/corewebsite'))
    	->where('code=?',  $websiteCode );
    	$row=  $read->fetchRow($select);
    
    	if ($row) {
    		$model->setData($row);
    	}
    	$this->_afterLoad($model);
    	return $this;
    }
    
    public function getCategoryIdByCode(Mage_Core_Model_Abstract $model, $catagoryCode)
    {
    	$read = $this->_getReadAdapter();
    	$select = $read->select()
    	->from($this->getTable('yescatalogupload/catalogcategoryentityvarchar'))
    	->where('value=?',  $catagoryCode );
    	$row=  $read->fetchRow($select);
    
    	if ($row) {
    		$model->setData($row);
    	}
    	$this->_afterLoad($model);
    	return $this;
    }
    public function getBackendTypeByID(Mage_Core_Model_Abstract $model, $attributeId)
    {
    	$read = $this->_getReadAdapter();
    	$select = $read->select()
    	->from($this->getTable('yescatalogupload/eavattribute'))
    	->where('attribute_id=?',  $attributeId );
    	$row=  $read->fetchRow($select);
    
    	if ($row) {
    		$model->setData($row);
    	}
    	$this->_afterLoad($model);
    	return $this;
    }
    
    
    public function saveCatalogFileUpload(Mage_Core_Model_Abstract $model, $catalogFileUploadVO)
    {
    	$tableName=$this->getTable('yescatalogupload/catalogfileupload');
    	$newcatalogFileUploadVO = new Yes_VO_Catalog_CatalogFileUploadVO();
    	 
    	if($catalogFileUploadVO->getCatalogFileUploadID()>0){
    		$rowSet =$newcatalogFileUploadVO->find($catalogFileUploadVO->getCatalogFileUploadIDget());
    		$row= $rowSet['_data'];
    	}  else {
    		$row = $newcatalogFileUploadVO->fetchNew();
    	}
    
    	foreach($catalogFileUploadVO->getDataArray() as $key=>$value){
    		$row[$key] = $value;
    	}
    	$row->save();
    	 
    	return $newcatalogFileUploadVO->getAdapter()->lastInsertId($tableName);
    }
    
    
    public function saveCatalogProductEntity(Mage_Core_Model_Abstract $model, $catalogProductEntityVO)
    {
		$tableName=$this->getTable('yescatalogupload/catalogproductentity');
    	$newCatalogProductEntityVO = new Yes_VO_Catalog_CatalogProductEntityVO();
    	
    	if($catalogProductEntityVO->getSku()>0){
    		$rowSet =$newCatalogProductEntityVO->find($catalogProductEntityVO->getSku());
    		$row= $rowSet['_data'];
    	}  else {
    		$row = $newCatalogProductEntityVO->fetchNew();
    	}
    	 
    	foreach($catalogProductEntityVO->getDataArray() as $key=>$value){
    		$row[$key] = $value;
    	}
    	$row->save();
    	
    	return $newCatalogProductEntityVO->getAdapter()->lastInsertId($tableName);
      }
    
      
      
      public function saveCatalogCategoryProduct(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogCategoryProductVO $catalogCategoryProductVO)
      {
      	
      	//$tableName=$this->getTable('yescatalogupload/catalogcategoryproduct');
      	
      	
      	$newCatalogCategoryProductVO = new Yes_VO_Catalog_CatalogCategoryProductVO();
      	
      	
      	 
      		$row = $newCatalogCategoryProductVO->fetchNew();
      	
      	
      	foreach($catalogCategoryProductVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      	
      	
      	
      }
      
  
      public function saveCatalogProductEntityMediaGallery(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityMediaGalleryVO $mediaGalleryVO)
      {
      	//$tableName=$this->getTable('yescatalogupload/catalogcategoryentitymediagallery');
      	$newMediaGalleryVO = new Yes_VO_Catalog_CatalogProductEntityMediaGalleryVO();
      	if($mediaGalleryVO->getValueId()> 0  ){
      		$rowSet =$newMediaGalleryVO->find($mediaGalleryVO->getValueId());
      		$row= $rowSet['_data'];
      	}  else {
      		$row = $newMediaGalleryVO->fetchNew();
      	}
      	foreach($mediaGalleryVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      	return $newMediaGalleryVO->getAdapter()->lastInsertId($tableName);
      }
      
      public function saveCatalogProductEntityMediaGalleryValue(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO $mediaGalleryValueVO)
      {
      	$newmediaGalleryValueVO = new Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO();
      	$row = $newmediaGalleryValueVO->fetchNew();
      	foreach($mediaGalleryValueVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      }
      
     
      public function saveCatalogProductEntityVarchar(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityVarcharVO $varCharVO){
		       
		      	$newVarCharVO = new Yes_VO_Catalog_CatalogProductEntityVarcharVO();
	
		      	if($varCharVO->getValueId()> 0  ){
		      		$rowSet =$newVarCharVO->find( array($varCharVO->getValueId())  );
		      		$row= $rowSet['_data'];
		      	}  else {
		      		$row = $newVarCharVO->fetchNew();
		      	}
		      	
		      	foreach($varCharVO->getDataArray() as $key=>$value){
		      		$row[$key] = $value;
		      	}
		      	$row->save();
      }
      
      public function saveCatalogProductEntityText(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityTextVO $textVO){
      	//$tableName=$this->getTable('yescatalogupload/catalogcategoryentitytext');
      	$newTextVO = new Yes_VO_Catalog_CatalogProductEntityTextVO();
      	 
      	if($textVO->getValueId()> 0  ){
      		$rowSet =$newTextVO->find( array($textVO->getValueId())  );
      		$row= $rowSet['_data'];
      	}  else {
      		$row = $newTextVO->fetchNew();
      	}
      	 
      	foreach($textVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      }
      
      
      public function saveCatalogProductEntityDecimal(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityDecimalVO $decimalVO){
      	//$tableName=$this->getTable('yescatalogupload/catalogcategoryentitydecimal');
      	$newDecimalVO = new Yes_VO_Catalog_CatalogProductEntityDecimalVO();
      
      	if($decimalVO->getValueId()> 0  ){
      		$rowSet =$newDecimalVO->find( array($decimalVO->getValueId())  );
      		$row= $rowSet['_data'];
      	}  else {
      		$row = $newDecimalVO->fetchNew();
      	}
      
      	foreach($decimalVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      }
      
      
      public function saveCatalogProductEntityDateTime(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityDateTimeVO $dateTimeVO){
      	//$tableName=$this->getTable('yescatalogupload/catalogcategoryentitydatetime');
      	$newDateTimeVO = new Yes_VO_Catalog_CatalogProductEntityDateTimeVO();
      
      	if($dateTimeVO->getValueId()> 0  ){
      		$rowSet =$newDateTimeVO->find( array($dateTimeVO->getValueId())  );
      		$row= $rowSet['_data'];
      	}  else {
      		$row = $newDateTimeVO->fetchNew();
      	}
      
      	foreach($dateTimeVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      }
      
      
      public function saveCatalogProductEntityInt(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityIntVO $intVO){
      	//$tableName=$this->getTable('yescatalogupload/catalogcategoryentityint');
      	$newIntVO = new Yes_VO_Catalog_CatalogProductEntityIntVO();
      
      	if($intVO->getValueId()> 0  ){
      		$rowSet =$newIntVO->find( array($intVO->getValueId())  );
      		$row= $rowSet['_data'];
      	}  else {
      		$row = $newIntVO->fetchNew();
      	}
      
      	foreach($intVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      }
      
      
      public function saveCatalogProductWebsite(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductWebsiteVO $catalogProductWebsiteVO){
      	
      	$newCatalogProductWebsiteVO = new Yes_VO_Catalog_CatalogProductWebsiteVO;
      
      	$row = $newCatalogProductWebsiteVO->fetchNew();
      	
      	foreach($catalogProductWebsiteVO->getDataArray() as $key=>$value){
      		$row[$key] = $value;
      	}
      	$row->save();
      }
      
      
      
  
     
    

}


