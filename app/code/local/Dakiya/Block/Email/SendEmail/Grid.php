<?php
class Dakiya_Block_Email_SendEmail_Grid extends Mage_Adminhtml_Block_Widget_Grid{

	public function __construct(){
		parent::__construct();
		$this->setId('SendEmailList');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		
// 		$this->setDefaultSort('TicketID');
// 		$this->setDefaultDir('desc');
// 		$this->setDefaultLimit(20);
		
		
		
	}

	protected function _prepareCollection(){
		//$collection   =  new Varien_Data_Collection();
		//$filter = $this->getParam($this->getVarNameFilter(), null);
		//if($filter){
		
			// NOTE DATE FILTER DEFAULT KEY SEND BY AJAX SO ADD ALL DATE FILTER
			$filter   = $this->getParam($this->getVarNameFilter(), null);
			$createdAtFromDate = null; $createdAtToDate = null;
			if (is_string($filter)) {
				$filterDataObjs = $this->helper('adminhtml')->prepareFilterString($filter);
			
				if(array_key_exists('CreatedAt', $filterDataObjs)){
					if(array_key_exists('from', $filterDataObjs['CreatedAt'])){
						$createdAtFromDate = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['from']));
					}
						
					if(array_key_exists('to', $filterDataObjs['CreatedAt'])){
						$createdAtToDate   = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['to']));
					}
				}
			
			}
		
		
			$collection =  Mage::getModel("dakiya/Email_SendEmail_SendEmail")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()),  array("main_table.SentEmailID"=>"main_table.SentEmailID", "main_table.ReceiverEmail"=>"main_table.ReceiverEmail", "main_table.Remarks"=>"main_table.Remarks", "main_table.EmailTemplateID"=>"main_table.EmailTemplateID", "main_table.EmailConfigID"=>"main_table.EmailConfigID",  "main_table.StatusID"=>"main_table.StatusID", "main_table.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) "),  ));
			$collection->getSelect()->joinLeft(array("dsss"=>$collection->getTable('dakiya/dakiyasentemailstatus')), 'main_table.StatusID = dsss.StatusID',  array("dsss.StatusName"=>"dsss.StatusName"));
			$collection->getSelect()->joinLeft(array("dst"=>$collection->getTable('dakiya/dakiyaemailtemplate')), 'main_table.EmailTemplateID = dst.TemplateID',  array("dst.TemplateName"=>"dst.TemplateName"));
			$collection->getSelect()->joinLeft(array("dsc"=>$collection->getTable('dakiya/dakiyaemailconfig')), 'main_table.EmailConfigID = dsc.ConfigID',  array("dsc.ConfigName"=>"dsc.ConfigName"));
			$collection->getSelect()->joinLeft(array("au"=>$collection->getTable('dakiya/adminuser')), 'main_table.CreatedBy = au.user_id',  array("au.username"=>"au.username"));
			
			if($createdAtFromDate != null && $createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
			}elseif($createdAtFromDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
			}elseif($createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
			}
			
			$collection->getSelect()->order("main_table.SentEmailID desc");
		//}
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	
	protected function _addColumnFilterToCollection($column){
		if ($this->getCollection()) {
	
			if($column->getType() == 'date' || $column->getType() == 'datetime'){
				return $this;
			}
	
			$field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
			if ($column->getFilterConditionCallback()) {
				call_user_func($column->getFilterConditionCallback(), $this->getCollection(), $column);
			} else {
				$cond = $column->getFilter()->getCondition();
				if ($field && isset($cond)) {
					$this->getCollection()->addFieldToFilter($field , $cond);
				}
			}
		}
		return $this;
	}
	
	
	protected function _prepareColumns(){

		$this->addColumn('SentEmailID', array(
				'header'    => Mage::helper('adminhtml')->__('ID'),
				'index'     => 'main_table.SentEmailID',
				'align'     => 'right',
				'width'     => '50px'
		));
		
		$this->addColumn('ReceiverEmail', array(
				'header'    =>Mage::helper('adminhtml')->__('Email'),
				'index'     =>'main_table.ReceiverEmail',
		));
		
		$this->addColumn('EmailTemplateID', array(
				'header'    =>Mage::helper('adminhtml')->__('Template Name'),
				'type'      =>'options',
				'index'     =>'main_table.EmailTemplateID',
				'options'   =>Mage::getModel('dakiya/Master_Email_EmailTemplate')->getResource()->getOptions()
		));
		
		$this->addColumn('EmailConfigID', array(
				'header'    =>Mage::helper('adminhtml')->__('Sender Name'),
				'type'      =>'options',
				'index'     =>'main_table.EmailConfigID',
				'options'   =>Mage::getModel('dakiya/Master_Email_EmailConfig')->getResource()->getOptions()
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'      =>'options',
				'index'     =>'main_table.StatusID',
				'options'   =>Mage::getModel('dakiya/Master_Email_SendEmailStatus')->getResource()->getOptions()
		));
		
		$this->addColumn('CreatedAt', array(
				'header'    =>Mage::helper('adminhtml')->__('Email SentOn'),
				'index'     =>'main_table.CreatedAt',
				'type'      => 'datetime',
				'width'     => '100px'
		));
		
		$this->addColumn('username', array(
				'header'    =>Mage::helper('adminhtml')->__('Email SentBy'),
				'index'     =>'au.username',
		));
		
		$this->addColumn('Remarks', array(
				'header'    =>Mage::helper('adminhtml')->__('Remarks'),
				'index'     =>'main_table.Remarks',
		));
	  return parent::_prepareColumns();
	}
	

	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}