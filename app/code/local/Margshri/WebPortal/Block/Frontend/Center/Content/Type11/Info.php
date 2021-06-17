<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type11_Info extends Mage_Core_Block_Template{

	protected $tableCode;
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type11/entropy.phtml');
				
		$this->tableCode = Mage::registry("CurrentTableCode");
		$model = Mage::helper('webportal/Data')->getType11Model($this->tableCode);
		$collection = $model->getCollection();
		
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value", "WebsiteLink"=>"main_table.WebsiteLink", "HelpLineNumber"=>"main_table.HelpLineNumber", "Email"=>"main_table.Email"  ));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$collection->getSelect()->Order('main_table.Value Asc');
		$this->setCollection($collection);
	}

	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setAvailableLimit(array(20=>20));
		$pager->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		return $this;
	}
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}

	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	
	
	public function getTableCode(){
		return $this->tableCode;
	}
}
