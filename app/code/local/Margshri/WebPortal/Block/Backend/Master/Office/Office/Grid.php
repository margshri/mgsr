<?php
class Margshri_WebPortal_Block_Backend_Master_Office_Office_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('Office');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			$collection =  Mage::getModel("webportal/Master_Office_Office_Office")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.value"=>"main_table.value", "main_table.Code"=>"main_table.Code", "main_table.StatusID"=> "main_table.StatusID", "main_table.TypeID"=> "main_table.TypeID",   "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'main_table.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
			$collection->getSelect()->joinLeft(array("officetype"=>$collection->getTable('webportal/apctwebofficetype')), 'main_table.TypeID = officetype.ID', array("officetype.ID"=>"officetype.ID", "officetype.Value"=>"officetype.Value"));
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

		
		$this->addColumn('value', array(
				'header'    =>Mage::helper('adminhtml')->__('Name'),
				'index'     =>'main_table.value',
		));
		
		$this->addColumn('Code', array(
				'header'    =>Mage::helper('adminhtml')->__('Code'),
				'index'     =>'main_table.Code',
		));
		
		
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Office Type'),
				'type'  => 'options',
				'index' => 'main_table.TypeID',
				'options' => Mage::getModel('webportal/Master_Office_OfficeType_OfficeType')->getResource()->getOptions()
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
				'renderer'  => 'webportal/Backend_Master_Office_Office_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

