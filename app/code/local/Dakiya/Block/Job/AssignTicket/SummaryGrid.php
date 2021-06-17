<?php
class Dakiya_Block_Job_AssignTicket_SummaryGrid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('job/assignticket/summarygrid.phtml');
		$this->setId('SummaryGrid');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		$this->setFilterVisibility(false);
		$this->setPagerVisibility(false);
	}
	
	protected function _prepareCollection(){
		
		$collection = Mage::getModel("dakiya/Job_AssignTicket_AssignTicket")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()),  
			array("RequestID"=>"main_table.RequestID", 
			"main_table.AssignTO"=>"main_table.AssignTO",
			"main_table.TotalTicket"=>new Zend_Db_Expr(" SUM(1)"), 
			"main_table.AssignToday"=>new Zend_Db_Expr(" SUM( case when date(main_table.AssignAt) = date(now()) then 1 else 0 end)"), 
			"main_table.PendingToday"=>new Zend_Db_Expr(" SUM( case when date(main_table.AssignAt) = date(now()) and main_table.StatusID != 2 then 1 else 0 end)"),
			"main_table.ClosedToday"=>new Zend_Db_Expr(" SUM( case when date(main_table.UpdatedAt) = date(now()) and main_table.StatusID = 2 then 1 else 0 end)"),
			"main_table.PreviousPending"=>new Zend_Db_Expr(" SUM( case when date(main_table.AssignAt) < date(now()) and main_table.StatusID != 2 then 1 else 0 end)"),
			"main_table.TotalPending"=>new Zend_Db_Expr(" SUM( case when main_table.StatusID != 2 then 1 else 0 end)"),
			"main_table.TotalClosed"=>new Zend_Db_Expr(" SUM( case when main_table.StatusID = 2 then 1 else 0 end)")
			));
			
		//$collection->getSelect()->joinInner(array("dats"=>"mage_new_dakiya.dakiya_assign_ticket_status") , "main_table.StatusID=dats.StatusID", array("StatusID"=>"dats.StatusID"));
		$collection->getSelect()->joinInner(array("au"=>$collection->getTable("newdakiya/adminuser")), "main_table.AssignTo=au.user_id", array("au.username"=>"au.username") );		
		$collection->getSelect()->group("main_table.AssignTo");
		//$collection->getSelect()->order("main_table.CreatedAt desc");
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	

	protected function _prepareColumns(){
		
		$this->addColumn('username', array(
				'header'    => Mage::helper('adminhtml')->__('AssignTo'),
				'index'     => 'au.username',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'dakiya/Job_AssignTicket_SummaryRenderer',
		));
		
		
		
		$this->addColumn('AssignToday', array(
				'header'    => Mage::helper('adminhtml')->__('Assign Today'),
				'index'     => 'main_table.AssignToday',
				'sortable'  => false,
				'filter'    => false
		));
		
		$this->addColumn('ClosedToday', array(
				'header'    => Mage::helper('adminhtml')->__('Closed Today'),
				'index'     => 'main_table.ClosedToday',
				'sortable'  => false,
				'filter'    => false
		));
		
		$this->addColumn('PendingToday', array(
				'header'    => Mage::helper('adminhtml')->__('Pending Today'),
				'index'     => 'main_table.PendingToday',
				'sortable'  => false,
				'filter'    => false
		));
		
		
		$this->addColumn('TotalTicket', array(
				'header'    => Mage::helper('adminhtml')->__('Total'),
				'index'     => 'main_table.TotalTicket',
				'width'     => '150px',
				'sortable'  => false,
				'filter'    => false
		));
		
		
		$this->addColumn('TotalClosed', array(
				'header'    => Mage::helper('adminhtml')->__('Total Closed'),
				'index'     => 'main_table.TotalClosed',
				'sortable'  => false,
				'filter'    => false
		));

		
		$this->addColumn('PreviousPending', array(
				'header'    => Mage::helper('adminhtml')->__('Previous Pending'),
				'index'     => 'main_table.PreviousPending',
				'sortable'  => false,
				'filter'    => false
		));
		
		
		$this->addColumn('TotalPending', array(
				'header'    => Mage::helper('adminhtml')->__('Total Pending'),
				'index'     => 'main_table.TotalPending',
				'sortable'  => false,
				'filter'    => false
		));
		
		
		
		//$this->addExportType('*/*/export/ExportType/xls', 'xls');
		//$this->addExportType('*/*/export/ExportType/xlsx', 'xlsx');
		
	  return parent::_prepareColumns();
	}

	public function getExportContent(){
		$this->_isExport = true;
		$this->_prepareGrid();
		$this->getCollection()->getSelect()->limit();
		$this->getCollection()->setPageSize(0);
		$this->getCollection()->load();
		$this->_afterLoadCollection();
		return $this;
	}
	 
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}

}
