<?php
class Dakiya_Block_SMS_SendSMS_Grid extends Mage_Adminhtml_Block_Widget_Grid{

	public function __construct(){
		parent::__construct();
		$this->setId('SendSMSList');
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
		
		
			$collection =  Mage::getModel("dakiya/SMS_SendSMS_SendSMS")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()),  array("main_table.SentSMSID"=>"main_table.SentSMSID", "main_table.ReceiverMobileNO"=>"main_table.ReceiverMobileNO", "main_table.Remarks"=>"main_table.Remarks", "main_table.SMSContent"=>"main_table.SMSContent", "main_table.SMSTemplateID"=>"main_table.SMSTemplateID", "main_table.SMSConfigID"=>"main_table.SMSConfigID",  "main_table.StatusID"=>"main_table.StatusID", "main_table.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) "),  ));
			$collection->getSelect()->joinLeft(array("dsss"=>$collection->getTable('dakiya/dakiyasentsmsstatus')), 'main_table.StatusID = dsss.StatusID',  array("dsss.StatusName"=>"dsss.StatusName"));
			$collection->getSelect()->joinLeft(array("dst"=>$collection->getTable('dakiya/dakiyasmstemplate')), 'main_table.SMSTemplateID = dst.TemplateID',  array("dst.TemplateName"=>"dst.TemplateName"));
			$collection->getSelect()->joinLeft(array("dsc"=>$collection->getTable('dakiya/dakiyasmsconfig')), 'main_table.SMSConfigID = dsc.ConfigID',  array("dsc.ConfigName"=>"dsc.ConfigName"));
			$collection->getSelect()->joinLeft(array("au"=>$collection->getTable('dakiya/adminuser')), 'main_table.CreatedBy = au.user_id',  array("au.username"=>"au.username"));
			
			if($createdAtFromDate != null && $createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
			}elseif($createdAtFromDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
			}elseif($createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
			}
			
			$collection->getSelect()->order("main_table.SentSMSID desc");
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

		$this->addColumn('SentSMSID', array(
				'header'    => Mage::helper('adminhtml')->__('ID'),
				'index'     => 'main_table.SentSMSID',
				'align'     => 'right',
				'width'     => '50px'
		));
		
		$this->addColumn('ReceiverMobileNO', array(
				'header'    =>Mage::helper('adminhtml')->__('Mobile Number'),
				'index'     =>'main_table.ReceiverMobileNO',
		));
		
		$this->addColumn('SMSTemplateID', array(
				'header'    =>Mage::helper('adminhtml')->__('Template Name'),
				'type'      =>'options',
				'index'     =>'main_table.SMSTemplateID',
				'options'   =>Mage::getModel('dakiya/Master_SMS_SMSTemplate')->getResource()->getOptions()
		));
		
		$this->addColumn('SMSConfigID', array(
				'header'    =>Mage::helper('adminhtml')->__('Sender Name'),
				'type'      =>'options',
				'index'     =>'main_table.SMSConfigID',
				'options'   =>Mage::getModel('dakiya/Master_SMS_SMSConfig')->getResource()->getOptions()
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'      =>'options',
				'index'     =>'main_table.StatusID',
				'options'   =>Mage::getModel('dakiya/Master_SMS_SendSMSStatus')->getResource()->getOptions()
		));
		
		$this->addColumn('CreatedAt', array(
				'header'    =>Mage::helper('adminhtml')->__('SMS SentOn'),
				'index'     =>'main_table.CreatedAt',
				'type'      => 'datetime',
				'width'     => '100px'
		));
		
		$this->addColumn('username', array(
				'header'    =>Mage::helper('adminhtml')->__('SMS SentBy'),
				'index'     =>'au.username',
		));
		
		$this->addColumn('Remarks', array(
				'header'    =>Mage::helper('adminhtml')->__('Remarks'),
				'index'     =>'main_table.Remarks',
		));
		
		$this->addColumn('SMSContent', array(
				'header'    =>Mage::helper('adminhtml')->__('SMS Content'),
				'index'     =>'main_table.SMSContent',
		));
	  return parent::_prepareColumns();
	}
	

	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}