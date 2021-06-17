<?php
class Yes_CatalogUpload_Model_Mysql4_PriceUpload extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('yescatalogupload/fileupload', 'UploadID');
    }

    public function getEntityIdBySku(Mage_Core_Model_Abstract $model, $skuCode)
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
    

     public function saveCatalogProductEntityDecimal(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityDecimalVO $decimalVO){
      	
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
      
      
      
      public function saveCatalogProductEntityInt(Mage_Core_Model_Abstract $model, Yes_VO_Catalog_CatalogProductEntityIntVO $intVO){
      	
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
      
 
}


