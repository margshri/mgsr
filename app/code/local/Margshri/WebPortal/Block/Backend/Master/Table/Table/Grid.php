<?php
class Margshri_WebPortal_Block_Backend_Master_Table_Table_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('table');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			$collection =  Mage::getModel("webportal/Master_Table_Table")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.value"=>"main_table.value", "main_table.Code"=>"main_table.Code", "main_table.Discription"=>"main_table.Discription", "main_table.StatusID"=> "main_table.StatusID", "main_table.TableTypeID"=> "main_table.TableTypeID", "main_table.FileName"=> "main_table.FileName", "main_table.IsFileName"=> "main_table.IsFileName", "main_table.UseInSearch"=>"main_table.UseInSearch" , "main_table.UseInCLP"=>"main_table.UseInCLP", "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'main_table.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
			$collection->getSelect()->joinLeft(array("tabletype"=>$collection->getTable('webportal/apctwebtabletype')), 'main_table.TableTypeID = tabletype.ID', array("tabletype.ID"=>"tabletype.ID", "tabletype.Value"=>"tabletype.Value"));
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
		
		$this->addColumn('Code', array(
				'header'    =>Mage::helper('adminhtml')->__('Code'),
				'index'     =>'main_table.Code',
		));
		
		$this->addColumn('Discription', array(
				'header'    =>Mage::helper('adminhtml')->__('Discription'),
				'index'     =>'main_table.Discription',
		));
		
		$this->addColumn('TableTypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Table Type'),
				'type'  => 'options',
				'index' => 'main_table.TableTypeID',
				'options' => Mage::getModel('webportal/Master_Table_TableType')->getResource()->getOptions()
		));

		$this->addColumn('FileName', array(
				'header'    =>Mage::helper('adminhtml')->__('File Name'),
				'index' => 'main_table.FileName'
		));
		
		$yesNoOption = array("0"=>"No", "1"=>"Yes");
		
		$this->addColumn('IsFileName', array(
				'header'    =>Mage::helper('adminhtml')->__('Is File Name'),
				'type'  => 'options',
				'index' => 'main_table.IsFileName',
				'options' => $yesNoOption
		));
		
		$this->addColumn('UseInSearch', array(
				'header'    =>Mage::helper('adminhtml')->__('Use In Search'),
				'type'  => 'options',
				'index' => 'main_table.UseInSearch',
				'options' => $yesNoOption
		));
		
		$this->addColumn('UseInCLP', array(
				'header'    =>Mage::helper('adminhtml')->__('Use In CLP'),
				'type'  => 'options',
				'index' => 'main_table.UseInCLP',
				'options' => $yesNoOption
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
				'renderer'  => 'webportal/Backend_Master_Table_Table_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

