<?php
class Margshri_WebPortal_Block_Frontend_Right_SubPageList extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
        
    	$collection = Mage::getModel("webportal/Firm_Firm_Firm")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value", "SubPageURL"=>"main_table.SubPageURL"));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$collection->getSelect()->where('main_table.IsPaid =?', 1);
		$collection->getSelect()->where('main_table.UseInCLP =?', 1);
		 // $collection->getSelect()->Order('main_table.Value Asc');
		$this->setCollection($collection);
	}

	/*
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setAvailableLimit(array(20=>20));
		$pager->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		return $this;
	}
	*/
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}

	
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	
	
	public function getTableCode(){
		return $this->tableCode;
	}

    public function getToBeDisabledFirmIDs(){
    	$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
    	$clpPointsTranModel = Mage::getModel("webportal/Right_CLPPointsTran");
    	$clpPointsTranDataObjs = $clpPointsTranModel->getResource()->getTodayToBeDisabled($customerDataObj->getId());
    	
    	$toBeDisabledFirmIDs = array(); 
    	foreach($clpPointsTranDataObjs as $key=> $clpPointsTranDataObj){
	    	$clpPointsTranDTO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
	    	$clpPointsTranVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsTranDTO, $clpPointsTranDataObj);
	    	$toBeDisabledFirmIDs[] = $clpPointsTranVO->getEntityTransactionID(); 
	    }	
    	return $toBeDisabledFirmIDs; 
    }
    
}
