<?php
class Margshri_WebPortal_Block_Frontend_Right_BidWinners extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$todayDate  = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
    	$currentTime = date("H:i:s", Mage::getModel('core/date')->timestamp(time()));
    	
    	$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
    	$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
    	->where('main_table.attribute_id =?', 5);
    	
    	$collection = Mage::getModel("webportal/Master_Right_Bid")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "BidName"=>"main_table.BidName", "BiddingDate"=>"main_table.BiddingDate", "BiddingTime"=>new Zend_Db_Expr(" CASE WHEN  main_table.BiddingTime <=  '" . $currentTime . "' AND main_table.BiddingDate = '" . $todayDate . "'  THEN  'Running' ELSE main_table.BiddingTime END ") ));
    	$collection->getSelect()->joinLeft(array("type"=>$collection->getTable('webportal/apctwebbidtype') ), 'main_table.TypeID = type.ID', array("TypeName"=>"type.Value"));
    	$collection->getSelect()->joinLeft(array("cev"=>$firstNameQuery), 'main_table.WinnerID = cev.entity_id', array("WinnerName"=>"cev.value"));
		$collection->getSelect()->where('main_table.StatusID = ?', Margshri_WebPortal_VO_Master_Right_BidStatusVO::$COMPLETED);
		$collection->getSelect()->where('main_table.WinnerID !=?', null);
		$collection->getSelect()->where(new Zend_Db_Expr("date(main_table.BiddingDate) > '2018-10-23' "));
		$collection->getSelect()->Order('main_table.ID DESC');
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
	
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
    
}
