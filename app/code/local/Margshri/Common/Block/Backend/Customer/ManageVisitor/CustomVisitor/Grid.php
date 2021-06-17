<?php
class Margshri_Common_Block_Backend_Customer_ManageVisitor_CustomVisitor_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('customvisitor');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection(){

		try{
			$collection = Mage::getModel('customer/customer')->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable("common/apctwebvisitorcounter")), array("main_table.ID"=>"main_table.ID", "main_table.VisitorIP"=>"main_table.VisitorIP", "main_table.CreatedAt"=>new Zend_Db_Expr(" DATE_SUB(main_table.CreatedAt, INTERVAL 330 minute) ")));
			$collection->getSelect()->order('ID DESC');
			$this->setCollection($collection);
			
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns(){

		$this->addColumn('ID', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.ID',
				'align'     => 'right',
				'width'    => '50px'
		));

		
		$this->addColumn('VisitorIP', array(
				'header'    =>Mage::helper('adminhtml')->__('VisitorIP'),
				'index'     =>'main_table.VisitorIP',
		));

		
		$this->addColumn('CreatedAt', array(
				'header'    =>Mage::helper('adminhtml')->__('CreatedAt'),
				'index'     =>'main_table.CreatedAt',
		));
		
		 
		return parent::_prepareColumns();
		
	}


	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

