<?php

class Yes_CatalogUpload_Model_Mysql4_FileUpload_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
/**
     * Initialize orders collection
     *
     */
    protected function _construct()
    {
        $this->_init('yescatalogupload/fileUpload');
    }
 
}