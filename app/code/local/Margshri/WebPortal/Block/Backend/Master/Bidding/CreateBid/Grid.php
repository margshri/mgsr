<?php
class Margshri_WebPortal_Block_Backend_Master_Bidding_CreateBid_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('createbid');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			
			
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5);
			
			$mobileCollection = Mage::getModel('customer/customer')->getCollection();
			$mobileQuery = $mobileCollection->getSelect()->reset()->from(array("main_table"=>$mobileCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 139);
			
			$collection =  Mage::getModel("webportal/Master_Right_Bid")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.BidName"=>"main_table.BidName", "main_table.TypeID"=>"main_table.TypeID", "main_table.BidCode"=>"main_table.BidCode", "main_table.BiddingDate"=>"main_table.BiddingDate", "main_table.BiddingTime"=>"main_table.BiddingTime", "main_table.CounterTime"=>"main_table.CounterTime",  "main_table.StatusID"=> "main_table.StatusID", "main_table.edit"=> new Zend_Db_Expr(" case when statusid = 1 then 'Edit' else '' end ") ));
			$collection->getSelect()->joinLeft(array("cev"=>$firstNameQuery), 'main_table.WinnerID = cev.entity_id', array("cev.value"=>"cev.value"));
			$collection->getSelect()->joinLeft(array("cevm"=>$mobileQuery), 'main_table.WinnerID = cevm.entity_id', array("cevm.mobileno"=>"cevm.value"));
			$collection->getSelect()->Order('main_table.ID Desc');
			$this->setCollection($collection);
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns()
	{

		$this->addColumn('ID', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.ID',
				'align'     => 'right',
				'width'    => '50px'
		));

		
		$this->addColumn('BidName', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Name'),
				'index'     =>'main_table.BidName',
		));
		
		
		$this->addColumn('BidCode', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Code'),
				'index'     =>'main_table.BidCode',
		));
		
		
		$this->addColumn('BiddingDate', array(
				'header'    =>Mage::helper('adminhtml')->__('Bidding Date'),
				'index'     =>'main_table.BiddingDate',
				'filter'    => false,
				'sortable'  => false
		));
		
		$this->addColumn('BiddingTime', array(
				'header'    =>Mage::helper('adminhtml')->__('Bidding Time'),
				'index'     =>'main_table.BiddingTime',
				'filter'    => false,
				'sortable'  => false
		));
		
		
		$this->addColumn('CounterTime', array(
				'header'    =>Mage::helper('adminhtml')->__('Counter Time'),
				'index'     =>'main_table.CounterTime',
				'filter'    => false,
				'sortable'  => false
		));
		
		 
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Type'),
				'type'  => 'options',
				'index' => 'main_table.TypeID',
				'options' => Mage::getModel('webportal/Master_Right_BidType')->getResource()->getOptions()
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
				'index' => 'main_table.StatusID',
				'options' => Mage::getModel('webportal/Master_Right_BidStatus')->getResource()->getOptions()
		));
		
		$this->addColumn('value', array(
				'header'    =>Mage::helper('adminhtml')->__('Winner Name'),
				'index' => 'cev.value',
				'renderer'  => 'webportal/Backend_Master_Bidding_CreateBid_Renderer',
		));
		
		$this->addColumn('mobileno', array(
				'header'    =>Mage::helper('adminhtml')->__('Winner Mobile'),
				'index' => 'cevm.mobileno',
				'sortable'  => false,
				'filter'    => false,
		));
		
		
		$this->addColumn('edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'    => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Master_Bidding_CreateBid_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

