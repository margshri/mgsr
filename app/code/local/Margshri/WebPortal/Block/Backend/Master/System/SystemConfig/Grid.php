<?php
class Margshri_WebPortal_Block_Backend_Master_System_SystemConfig_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('SystemConfig');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			$collection =  Mage::getModel("webportal/Master_System_SystemConfig")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.ConfigName"=>"main_table.ConfigName", "main_table.ConfigCode"=>"main_table.ConfigCode", "main_table.ConfigValue"=>"main_table.ConfigValue", "main_table.StatusID"=> "main_table.StatusID", "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
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

		
		$this->addColumn('ConfigName', array(
				'header'    =>Mage::helper('adminhtml')->__('Config Name'),
				'index'     =>'main_table.ConfigName',
		));
		
		$this->addColumn('ConfigCode', array(
				'header'    =>Mage::helper('adminhtml')->__('Config Code'),
				'index'     =>'main_table.ConfigCode',
		));
		
		$this->addColumn('ConfigValue', array(
				'header'    =>Mage::helper('adminhtml')->__('Config Value'),
				'index'     =>'main_table.ConfigValue',
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
				'renderer'  => 'webportal/Backend_Master_System_SystemConfig_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

