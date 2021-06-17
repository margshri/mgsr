<?php
class Dakiya_Block_Master_SMS_SMSTemplate_SMSTemplate_Grid extends Mage_Adminhtml_Block_Widget_Grid{

	public function __construct(){
		parent::__construct();
		$this->setId('SMSTemplate');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection(){
		$collection =  Mage::getModel("dakiya/Master_SMS_SMSTemplate")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()),  array("main_table.TemplateID"=>"main_table.TemplateID", "main_table.TemplateName"=>"main_table.TemplateName", "main_table.TemplateCode"=>"main_table.TemplateCode", "main_table.StatusID"=>"main_table.StatusID",  "main_table.Edit"=> new Zend_Db_Expr("'Edit'" ) ));
		$collection->getSelect()->joinLeft(array("ds"=>$collection->getTable('dakiya/dakiyastatus')), 'main_table.StatusID = ds.StatusID',  array("ds.StatusName"=>"ds.StatusName"));
		$collection->getSelect()->order("main_table.TemplateID desc");
		$this->setCollection($collection);
	    return parent::_prepareCollection();
	}

	protected function _prepareColumns(){

		$this->addColumn('TemplateID', array(
				'header'    => Mage::helper('adminhtml')->__('ID'),
				'index'     => 'main_table.TemplateID',
				'align'     => 'right',
				'width'     => '50px'
		));

		$this->addColumn('TemplateName', array(
				'header'    =>Mage::helper('adminhtml')->__('Template Name'),
				'index'     =>'main_table.TemplateName',
		));
		
		$this->addColumn('TemplateCode', array(
				'header'    =>Mage::helper('adminhtml')->__('Template Code'),
				'index'     =>'main_table.TemplateCode',
		));
		
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'width'     =>'100px',
				'type'      =>'options',
				'index'     =>'main_table.StatusID',
				'options'   =>Mage::getModel('dakiya/Master_Status_Status')->getResource()->getOptions()
		));
		
		
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.Edit',
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'dakiya/Master_SMS_SMSTemplate_SMSTemplate_Renderer',
		));

	  return parent::_prepareColumns();
	}

	
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}