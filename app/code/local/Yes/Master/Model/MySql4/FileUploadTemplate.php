<?php
class Yes_Master_Model_Mysql4_FileUploadTemplate extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('yesmaster/fileuploadtemplate', 'TemplateID');
    }
    
    
    public function getById(Mage_Core_Model_Abstract $model, $templateId  )
    {
    	
    	$read = $this->_getReadAdapter();

    	$select = $read->select()
    	->from($this->getMainTable())
    	->where('TemplateID=?',$templateId );
    	$row=  $read->fetchRow($select);
    
        //return $row;
        
    	if ($row) {
    		$model->setData($row);
    	}
    
    	$this->_afterLoad($model);
    	
    	return $this;
    	
    }

}


