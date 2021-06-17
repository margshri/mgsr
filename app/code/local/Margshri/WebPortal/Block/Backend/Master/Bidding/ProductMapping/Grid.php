<?php
class Margshri_WebPortal_Block_Backend_Master_Bidding_ProductMapping_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('productmapping');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			
			$productNameCollection = Mage::getModel('catalog/product')->getCollection();
			$productNameQuery = $productNameCollection->getSelect()->reset()->from(array("main_table"=>$productNameCollection->getTable("webportal/catalogproductentityvarchar"), array("entity_id", "value") ))
			->where('main_table.entity_type_id =?', 4)
			->where('main_table.attribute_id =?', 71);
			
			
			$collection =  Mage::getModel("webportal/Master_Right_BidProducts")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.StatusID"=> "main_table.StatusID", "main_table.edit"=> new Zend_Db_Expr(" case when bid.statusid = 1 then 'Edit' else '' end") ));
			$collection->getSelect()->joinLeft(array("bid"=>$collection->getTable('webportal/apctwebbid')), 'main_table.BidID = bid.ID', array("bid.ID"=>"bid.ID", "bid.BidName"=>"bid.BidName"));
			
			$collection->getSelect()->joinLeft(array("product"=>$productNameQuery), 'main_table.ProductID = product.entity_id', array("product.entity_id"=>"product.entity_id", "product.value"=>"product.value"));
			
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'main_table.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
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

		$this->addColumn('BidID', array(
				'header'    =>Mage::helper('adminhtml')->__('Bid Name'),
				'type'  => 'options',
				'index' => 'bid.ID',
				'options' => Mage::getModel('webportal/Master_Right_Bid')->getResource()->getOptions()
		));
		
		
		
		$this->addColumn('value', array(
				'header'    =>Mage::helper('adminhtml')->__('Product Name'),
				'type'  => 'options',
				'index' => 'product.entity_id',
				'options' => Mage::getModel('webportal/Master_Right_BidProducts')->getResource()->getProductOptions()
		));
		
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
				'index' => 'main_table.StatusID',
				'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
		));
		
		$this->addColumn('edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'    => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Master_Bidding_ProductMapping_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

