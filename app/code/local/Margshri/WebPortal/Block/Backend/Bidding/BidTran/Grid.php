<?php
class Margshri_WebPortal_Block_Backend_Bidding_BidTran_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('bidtran');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			
			$dateFilterFlag = false;
			$filter = $this->getParam($this->getVarNameFilter(), null);
			$createdAtFromDate = null; $createdAtToDate = null;
			
				
			if(empty($filter) && is_string($filter)){
				// when reset filter is tigger
			}else if(is_string($filter)){
				$filterDataObjs = $this->helper('adminhtml')->prepareFilterString($filter);
				if(sizeof($filterDataObjs) > 0){
					$dateFilterFlag = true;
						
					if(array_key_exists('CreatedAt', $filterDataObjs)){
						if(array_key_exists('from', $filterDataObjs['CreatedAt'])){
							$createdAtFromDate = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['from']));
						}
			
						if(array_key_exists('to', $filterDataObjs['CreatedAt'])){
							$createdAtToDate   = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['to']));
						}
					}
						
					if(sizeof($filterDataObjs) == 1){
						if($createdAtFromDate == null && $createdAtToDate == null){
							$dateFilterFlag = false;
						}
					}
				}
			}
			
			
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5);
			
			
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7);
			
			$collection =  Mage::getModel("webportal/Right_BidTran")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.CustomerID"=>"main_table.CustomerID", "main_table.BidID"=>"main_table.BidID", "main_table.BidValue"=>"main_table.BidValue", "main_table.IsWin"=> "main_table.IsWin" /* new Zend_Db_Expr(" CASE WHEN main_table.IsWin = 1 THEN 'YES' ELSE 'NO' END ") */, "main_table.CreatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) "), "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("bid"=>$collection->getTable('webportal/apctwebbid')), 'main_table.BidID = bid.ID', array("bid.BidName"=>"bid.BidName", "bid.StatusID"=>"bid.StatusID", "bid.TypeID"=>"bid.TypeID"));
			
			$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "main_table.CustomerID = firstname.entity_id", array("firstname.value"=>"firstname.value"));
			$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "main_table.CustomerID = lastname.entity_id", array("lastname.value"=>"lastname.value"));
			
			if($dateFilterFlag == true){
				if($createdAtFromDate != null && $createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
				}elseif($createdAtFromDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
				}elseif($createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
				}
			}
			
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

		$this->addColumn('CustomerID', array(
				'header'    =>Mage::helper('adminhtml')->__('CustomerID'),
				'index'     =>'main_table.CustomerID',
		));
		
		$this->addColumn('value', array(
				'header'    =>Mage::helper('adminhtml')->__('First Name'),
				'index'     =>'firstname.value',
		));
		
		
		$this->addColumn('lastname', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'lastname.value',
				'filter'    => false
		));
		
		$this->addColumn('BidName', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Name'),
				'index'     =>'bid.BidName',
		));
		
		$this->addColumn('BidValue', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Value'),
				'index'     =>'main_table.BidValue',
		));
		
		$isWinOptions = array("NO","YES");
		$this->addColumn('IsWin', array(
				'header'    => Mage::helper('adminhtml')->__('Is Win'),
				'type'      => 'options',
				'index'     => 'main_table.IsWin',
				'options'   => $isWinOptions
		));
		
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Type'),
				'type'  => 'options',
				'index' => 'bid.TypeID',
				'options' => Mage::getModel('webportal/Master_Right_BidType')->getResource()->getOptions()
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Status'),
				'type'  => 'options',
				'index' => 'bid.StatusID',
				'options' => Mage::getModel('webportal/Master_Right_BidStatus')->getResource()->getOptions()
		));
		
		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Created D/T'),
				'index'     => 'main_table.CreatedAt',
				'type'      =>'datetime',
				'width'     =>'50px',
		));
 
		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

