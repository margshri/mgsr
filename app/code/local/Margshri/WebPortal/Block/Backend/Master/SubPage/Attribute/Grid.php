<?php
class Margshri_WebPortal_Block_Backend_Master_SubPage_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('attribute');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			$collection =  Mage::getModel("webportal/Master_SubPage_Attribute")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.Value"=>"main_table.Value", "main_table.Code"=>"main_table.Code", "main_table.TypeID"=>"main_table.TypeID", "main_table.DataTypeID"=>"main_table.DataTypeID", "main_table.StatusID"=> "main_table.StatusID", "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("type"=>$collection->getTable('webportal/apctwebsubpageattributetype')), 'main_table.TypeID = type.ID', array("type.ID"=>"type.ID", "type.Value"=>"type.Value"));
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

		
		$this->addColumn('Value', array(
				'header'    =>Mage::helper('adminhtml')->__('Name'),
				'index'     =>'main_table.Value',
		));
		
		$this->addColumn('Code', array(
				'header'    =>Mage::helper('adminhtml')->__('Code'),
				'index'     =>'main_table.Code',
		));
		
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Type'),
				'type'  => 'options',
				'index' => 'main_table.TypeID',
				'options' => Mage::getModel('webportal/Master_SubPage_AttributeType')->getResource()->getOptions()
		));
		
		
		$this->addColumn('DataTypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Data Type'),
				'type'  => 'options',
				'index' => 'main_table.DataTypeID',
				'options' => Mage::getModel('webportal/Master_SubPage_AttributeDataType')->getResource()->getOptions()
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
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Master_SubPage_Attribute_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

