<?php

class Yes_CatalogUpload_Model_FileUpload extends Mage_Core_Model_Abstract  {


	/**
	 * Initialize resource model
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->_init('yescatalogupload/fileUpload');
	}
	
	
}