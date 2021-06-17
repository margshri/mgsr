<?php
class Dakiya_Block_Job_AssignTicket_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('job/assignticket/grid.phtml');
		$this->setId('AssignTicketGrid');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}
	
	protected function _prepareCollection(){
		
		$dateFilterFlag = false;
		$filter = $this->getParam($this->getVarNameFilter(), null);
		$todayDate = Dakiya_Helper_Utility::getTodayDate("Y-m-d");
		$createdAtFromDate = null; $createdAtToDate = null;
		$updatedDateFromDate = null; $updatedDateToDate = null;
		$assignDateFromDate = null; $assignDateToDate = null;
		
		if(empty($filter) && is_string($filter)){
			// when reset filter is tigger
		}else if(is_string($filter)){
			$filterDataObjs = $this->helper('adminhtml')->prepareFilterString($filter);
			if(sizeof($filterDataObjs) > 0){
				$dateFilterFlag = true;
				
				if(array_key_exists('CreatedAt', $filterDataObjs)){
					if(array_key_exists('from', $filterDataObjs['CreatedAt'])){
						$createdAtFromDate = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['from']));
					}
					
					if(array_key_exists('to', $filterDataObjs['CreatedAt'])){
						$createdAtToDate   = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['to']));
					}
				}
				
				if(array_key_exists('UpdatedAt', $filterDataObjs)){
					if(array_key_exists('from', $filterDataObjs['UpdatedAt'])){
						$updatedDateFromDate = date('Y-m-d', strtotime($filterDataObjs['UpdatedAt']['from']));
					}
					if(array_key_exists('to', $filterDataObjs['UpdatedAt'])){
						$updatedDateToDate = date('Y-m-d', strtotime($filterDataObjs['UpdatedAt']['to']));
					}
				}
				
				if(array_key_exists('AssignAt', $filterDataObjs)){
					if(array_key_exists('from', $filterDataObjs['AssignAt'])){
						$assignDateFromDate = date('Y-m-d', strtotime($filterDataObjs['AssignAt']['from']));
					}
					if(array_key_exists('to', $filterDataObjs['AssignAt'])){
						$assignDateToDate = date('Y-m-d', strtotime($filterDataObjs['AssignAt']['to']));
					}
				}
				
				if(sizeof($filterDataObjs) == 3){
					if($createdAtFromDate == null && $createdAtToDate == null &&
							$updatedDateFromDate == null && $updatedDateToDate == null &&
							$assignDateFromDate == null && $assignDateToDate == null ){
								$dateFilterFlag = false;
					}
				}
			}
		}
		$assignToUserID = $this->getRequest()->getParam("AssignToUserID");
		
		
		// GET CALL HISTORY
		$userCallHistoryCollection = Mage::getModel("dakiya/User_UserCallHistory_UserCallHistory")->getCollection();
		$userCallHistoryQuery = $userCallHistoryCollection->getSelect()->reset()
		->from(array("duch"=>$userCallHistoryCollection->getMainTable()), array("RequestID"=>"duch.RequestID",  "Remarks"=> new Zend_Db_Expr("group_concat(duch.Remarks, '| ')"), "CollectibleAmount"=>"duch.CollectibleAmount" ,"CreatedAt"=>"duch.CreatedAt"))
		/*
		->joinLeft(array("ducr"=>$userCallHistoryCollection->getTable('newdakiya/dakiyausercallingreason')), 'duch.CallingReasonID = ducr.ReasonID',  array("CallingReasonName"=>"ducr.ReasonName"))
		->joinLeft(array("ducsr"=>$userCallHistoryCollection->getTable('newdakiya/dakiyausercallingsubreason')), 'duch.CallingSubReasonID = ducsr.ReasonID',  array("CallingSubReasonName"=>"ducsr.ReasonName"))
		->joinLeft(array("ducssr"=>$userCallHistoryCollection->getTable('newdakiya/dakiyausercallingsubsubreason')), 'duch.CallingSubSubReasonID = ducssr.ReasonID',  array("CallingSubSubReasonName"=>"ducssr.ReasonName"))
		->joinLeft(array("au"=>$userCallHistoryCollection->getTable('newdakiya/adminuser')), 'duch.CreatedBy = au.user_id',  array("AdminUserName"=>"au.username"))
		->joinLeft(array("duct"=>$userCallHistoryCollection->getTable('newdakiya/dakiyausercallingtype')), 'duch.CallingTypeID = duct.TypeID',  array("CallingTypeName"=>"duct.TypeName"))
		->joinLeft(array("dpct"=>$userCallHistoryCollection->getTable('newdakiya/dakiyapaymentcollectiontype')), 'duch.PaymentCollectionTypeID = dpct.TypeID',  array("PaymentCollectionTypeName"=>"dpct.TypeName"))
		*/
		->group("duch.RequestID");
		//->order("duch.HistoryID desc");
		//return $read->fetchAll($select);
		
		
		
		$collection = Mage::getModel("dakiya/Job_AssignTicket_AssignTicket")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()),array("main_table.RequestID"=>"main_table.RequestID", "main_table.StatusID"=>"main_table.StatusID", "main_table.AssignAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.AssignAt,INTERVAL '05:30' HOUR_MINUTE)"), "main_table.CreatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)"), "main_table.UpdatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.UpdatedAt,INTERVAL '05:30' HOUR_MINUTE)"), "main_table.Remarks"=>"main_table.Remarks" ));
		//$collection->getSelect()->joinInner(array("dats"=>"mage_new_dakiya.dakiya_assign_ticket_status") , "main_table.StatusID=dats.StatusID", array("StatusID"=>"dats.StatusID"));
		$collection->getSelect()->joinInner(array("asgntousr"=>$collection->getTable("newdakiya/adminuser")), "main_table.AssignTo=asgntousr.user_id", array("asgntousr.username"=>"asgntousr.username") );
		$collection->getSelect()->joinInner(array("asgnbyusr"=>$collection->getTable("newdakiya/adminuser")), "main_table.AssignBy=asgnbyusr.user_id", array("asgnbyusr.username"=>"asgnbyusr.username") );
		$collection->getSelect()->joinLeft(array("duch"=>$userCallHistoryQuery), "main_table.RequestID=duch.RequestID", array("duch.Remarks"=>"duch.Remarks") );
		
		$collection->getSelect()->where("main_table.AssignTo =?", $assignToUserID);
		
		if($dateFilterFlag == true){
			
			if($createdAtFromDate != null && $createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
			}elseif($createdAtFromDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
			}elseif($createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
			}
			
			if($updatedDateFromDate!= null && $updatedDateToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.UpdatedAt) between '" . $updatedDateFromDate. "' and '" . $updatedDateToDate. "'") );
			}elseif($updatedDateFromDate!= null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.UpdatedAt) >= '" . $updatedDateFromDate. "'") );
			}elseif($updatedDateToDate!= null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.UpdatedAt) <= '" . $updatedDateToDate. "'") );
			}
			
			if($assignDateFromDate!= null && $assignDateToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.AssignAt) between '" . $assignDateFromDate. "' and '" . $assignDateToDate . "'") );
			}elseif($assignDateFromDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.AssignAt) >= '" . $assignDateFromDate. "'") );
			}elseif($assignDateToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.AssignAt) <= '" . $assignDateToDate . "'") );
			}
		}
		
		$collection->getSelect()->order("main_table.AssignTicketID desc");
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns(){

		
		$this->addColumn('RequestID', array(
				'header'    =>Mage::helper('adminhtml')->__('TxnID'),
				'index'     =>'main_table.RequestID',
				//'width'     => '50px',
				//'renderer'  => 'dakiya/CRM_ComplaintRegistration_ComplaintRegistration_Renderer'
		));

		$this->addColumn('asgntousr.username', array(
				'header'    =>Mage::helper('adminhtml')->__('Assign To'),
				'index'     =>'asgntousr.username',
				//'width'     => '90px',
		));
		
		$this->addColumn('asgnbyusr.username', array(
				'header'    =>Mage::helper('adminhtml')->__('Assign By'),
				'index'     =>'asgnbyusr.username',
				//'width'     => '90px',
		));
		
		$this->addColumn('AssignAt', array(
				'header'    => Mage::helper('adminhtml')->__('Assign <br /> Date'),
				'index'     => 'main_table.AssignAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		
		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Created <br /> Date'),
				'index'     => 'main_table.CreatedAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		
		$this->addColumn('UpdatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Updated <br /> Date'),
				'index'     => 'main_table.UpdatedAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'index'     =>'main_table.StatusID',
				//'width'     => '70px',
				'type'      => 'options',
				'options'   => Mage::getModel('dakiya/Master_Job_AssignTicket_AssignTicketStatus')->getResource()->getOptions()
		));
		
		$this->addColumn('main_table.Remarks', array(
				'header'    =>Mage::helper('adminhtml')->__('Ticket Remarks'),
				'index'     =>'main_table.Remarks',
				//'width'     => '90px',
		));
		
		$this->addColumn('duch.Remarks', array(
				'header'    =>Mage::helper('adminhtml')->__('Communication <br /> Remarks'),
				'index'     =>'duch.Remarks',
				//'width'     => '90px',
		));
		
		
		
		//$this->addExportType('*/*/export/ExportType/xls', 'xls');
		//$this->addExportType('*/*/export/ExportType/xlsx', 'xlsx');
		
	  return parent::_prepareColumns();
	}

	/*
	public function getExportContent(){
		$this->_isExport = true;
		$this->_prepareGrid();
		$this->getCollection()->getSelect()->limit();
		$this->getCollection()->setPageSize(0);
		$this->getCollection()->load();
		$this->_afterLoadCollection();
		return $this;
	}
	*/
	 
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}

}
