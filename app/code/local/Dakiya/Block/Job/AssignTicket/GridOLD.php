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
		

		// NOTE DATE FILTER DEFAULT KEY SEND BY AJAX SO ADD ALL DATE FILTER
		$dateFilterFlag = false;
		$filter = $this->getParam($this->getVarNameFilter(), null);
		$todayDate = Dakiya_Helper_Utility::getTodayDate("Y-m-d");
		$createdAtFromDate = null; $createdAtToDate = null;
		$journeyDateFromDate = null; $journeyDateToDate = null;
		$assignDateFromDate = null; $assignDateToDate = null;
		$systemConfigModel = Mage::getModel('dakiya/Master_System_SystemConfig_SystemConfig');
		
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
				
				if(array_key_exists('JourneyDate', $filterDataObjs)){
					if(array_key_exists('from', $filterDataObjs['JourneyDate'])){
						$journeyDateFromDate = date('Y-m-d', strtotime($filterDataObjs['JourneyDate']['from']));
					}
					if(array_key_exists('to', $filterDataObjs['JourneyDate'])){
						$journeyDateToDate   = date('Y-m-d', strtotime($filterDataObjs['JourneyDate']['to']));
					}
				}
				
				if(array_key_exists('AssignDate', $filterDataObjs)){
					if(array_key_exists('from', $filterDataObjs['AssignDate'])){
						$assignDateFromDate = date('Y-m-d', strtotime($filterDataObjs['AssignDate']['from']));
					}
					if(array_key_exists('to', $filterDataObjs['AssignDate'])){
						$assignDateToDate = date('Y-m-d', strtotime($filterDataObjs['AssignDate']['to']));
					}
				}
				
				if(sizeof($filterDataObjs) == 3){
					if($createdAtFromDate == null && $createdAtToDate == null &&
							$journeyDateFromDate == null && $journeyDateToDate == null && 
							$assignDateFromDate == null && $assignDateToDate == null ){
								$dateFilterFlag = false;
					}
				}
			}
		}
		
		// GET DEFAULT ALLOWED LOGIN ADMIN USER ID
		//$systemConfigModel = Mage::getModel('dakiya/Master_System_SystemConfig_SystemConfig');
		//$alwdAsgnAdminUserIDsStr  = $systemConfigModel->getResource()->getConfigValueByConfigKey(Dakiya_VO_Master_System_SystemConfig_SystemConfigVO::$ADMIN_USER_IDS_SHOW_ALL_ASSIGN_TICKET);
		//$alwdAsgnAdminUserIDsArray= explode('|', $alwdAsgnAdminUserIDsStr);
		
		// GET CURRENT LOGIN ADMIN USER ID
		//$currAdminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
		//$alwdAsgnAdminUserIDsArray[] = $currAdminUserID;
		
		$assignTicketModel   = Mage::getModel("dakiya/Job_AssignTicket_AssignTicket");
		$assignTicketDataObjs=$assignTicketModel->getResource()->getList();
		$assignRequestIDs = array();
		foreach ($assignTicketDataObjs as $assignTicketDataObj){
			$assignRequestIDs[] = $assignTicketDataObj['RequestID'];
		}
		
		// GET ASSIGN TICKET TMP TABLE
		/*
		$collection = Mage::getModel("dakiya/Job_AssignTicket_AssignTicket")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>"mage_new_dakiya.dakiya_assign_ticket"),  array("RequestID"=>"main_table.RequestID", "AssignDate"=>"main_table.CreatedAt"));
		$collection->getSelect()->joinInner(array("dats"=>"mage_new_dakiya.dakiya_assign_ticket_status") , "main_table.StatusID=dats.StatusID", array("StatusID"=>"dats.StatusID"));
		$collection->getSelect()->joinInner(array("au"=>"mage_new_dakiya.admin_user"), "main_table.AssignTo=au.user_id", array("username"=>"au.username") );		
		if($dateFilterFlag == true){
			if($assignDateFromDate!= null && $assignDateToDate!= null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $assignDateFromDate. "' and '" . $assignDateToDate. "'") );
			}elseif($assignDateFromDate!= null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $assignDateFromDate. "'") );
			}elseif($assignDateToDate!= null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $assignDateToDate. "'") );
			}
		}	
		$asgnTktTmpTbl = $collection->getSelect();
		*/
		
		$collection =  Mage::getModel("dakiya/Booking_Request_UserBookingRequest")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()),  array("main_table.RequestID"=>"main_table.RequestID", "main_table.CurrStatusID"=>"main_table.CurrStatusID", "main_table.PaymentMethodID"=>"main_table.PaymentMethodID", "main_table.PaymentGatewayID"=>new Zend_Db_Expr(" case when main_table.PaymentGatewayID is null and main_table.PaymentMethodID = 1 then 1 else main_table.PaymentGatewayID end"), "main_table.NetTicketAmount"=> new Zend_Db_Expr("case when main_table.NetTicketAmount = 0 then '' else main_table.NetTicketAmount end"), "main_table.CreatedAt"=> new Zend_Db_Expr("  case when lt.PNRNumber is null then DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) else  DATE_SUB(lt.BookedOn,INTERVAL '05:30' HOUR_MINUTE) end ")  ,  "main_table.JourneyDate" => new Zend_Db_Expr(" case when lt.PNRNumber is null then DATE_SUB(main_table.JourneyDate,INTERVAL '05:30' HOUR_MINUTE) else  date(lt.JourneyDate) end "), "main_table.MobileNo"=>"main_table.MobileNo", "main_table.TrainNo"=>"main_table.TrainNo", "main_table.BookMode"=>"main_table.BookMode", "main_table.CODPincode"=>"main_table.CODPincode", "main_table.SourceStationCode"=>new Zend_Db_Expr(" case when lt.PNRNumber is null then main_table.SourceStationCode else  lt.Source end "), "main_table.DestinationStationCode"=>new Zend_Db_Expr(" case when lt.PNRNumber is null then main_table.DestinationStationCode else  lt.Destination end "), "main_table.TransactionNo"=>"main_table.TransactionNo", "main_table.Detail"=>new Zend_Db_Expr("'Detail'" ), "main_table.CODAddress1"=>"main_table.CODAddress1", "main_table.CODAddress2"=>"main_table.CODAddress2" ));
		$collection->getSelect()->joinInner(array("lt"=>$collection->getTable('dakiya/localticket')), 'main_table.RequestID = lt.RequestID',  array("lt.TicketID"=>"lt.TicketID", "lt.PNRNumber"=>"lt.PNRNumber", "lt.TrainName"=>"lt.TrainName", "lt.BookedOn"=> new Zend_Db_Expr("date(lt.BookedOn)"), "lt.BoardingDate"=>"lt.BoardingDate" ));
		$collection->getSelect()->joinLeft(array("lbrs"=>$collection->getTable('dakiya/localbookingrequeststatus')), 'main_table.CurrStatusID = lbrs.RequestStatusID', array("lbrs.StatusName"=>"lbrs.StatusName" ));
		$collection->getSelect()->joinLeft(array("lu"=>$collection->getTable('dakiya/localuser')), 'main_table.UserID = lu.UserID', array("lu.UserID"=>"lu.UserID", "lu.IRCTCUserName"=>"lu.IRCTCUserName", "lu.MobileNO"=>new Zend_Db_Expr("case when lu.MobileNO = '9810198101' then '' else lu.MobileNO end ")  , "lu.EmailID"=>new Zend_Db_Expr("case when lu.EmailID = 'defaultuser@cashondelviery.co.in' then '' else lu.EmailID end "), "lu.CreatedAt"=>new Zend_Db_Expr("date(lu.CreatedAt)")  ));
		//$collection->getSelect()->joinLeft(array("lpg"=>$collection->getTable('dakiya/localpaymentgateway')), 'main_table.PaymentGatewayID = lpg.GatewayID', array("lpg.GatewayName"=>"lpg.GatewayName"));
		//$collection->getSelect()->joinLeft(array("lpm"=>$collection->getTable('dakiya/localpaymentmethod')), 'main_table.PaymentMethodID = lpm.PaymentMethodID', array("lpm.PayementMethodName"=>"lpm.PayementMethodName" ));
		//$collection->getSelect()->joinLeft(array("lmdshipment"=>$collection->getTable('dakiya/locallmdshipment')), 'main_table.RequestID = lmdshipment.RequestID', array("lmdshipment.WaybillNo"=>"lmdshipment.WaybillNo" ));
		//$collection->getSelect()->joinLeft(array("lnpc"=>$collection->getTable('dakiya/localnotifypincode')), 'main_table.UserID = lnpc.UserID', array("lnpc.Pincode"=>"lnpc.Pincode"));
		//$collection->getSelect()->joinLeft(array("lpc"=>$collection->getTable('dakiya/localpincode')), 'main_table.CODPincode = lpc.Pincode', array("lpc.Pincode"=>new Zend_Db_Expr(" case when lpc.Pincode is null then 0 else 1 end ")));
		//$collection->getSelect()->joinLeft(array("codcity"=>$collection->getTable('dakiya/city')), 'main_table.CODCity = codcity.CityID', array("codcity.CityName"=>"codcity.CityName"));
		//$collection->getSelect()->joinLeft(array("codstate"=>$collection->getTable('dakiya/stateregion')), 'main_table.CODState = codstate.StateRegionID', array("codstate.StateRegionName"=>"codstate.StateRegionName"));
		//$collection->getSelect()->joinInner(array("dat"=>$asgnTktTmpTbl), 'main_table.RequestID = dat.RequestID', array("dat.StatusID"=>"dat.StatusID", "dat.username"=>"dat.username", "dat.AssignDate"=>"dat.AssignDate"));
		
		if($dateFilterFlag == true){
			/* below where condition is run when booked date filter is used */
			if($createdAtFromDate != null && $createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
			}elseif($createdAtFromDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
			}elseif($createdAtToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
			}
				
			/* below where condition is run when journey date filter is used */
			if($journeyDateFromDate != null && $journeyDateToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" case when lt.PNRNumber is null then date(main_table.JourneyDate) else date(lt.JourneyDate) end between '" . $journeyDateFromDate . "' and '" . $journeyDateToDate . "'") );
			}elseif($journeyDateFromDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" case when lt.PNRNumber is null then date(main_table.JourneyDate) else date(lt.JourneyDate) end >= '" . $journeyDateFromDate . "'") );
			}elseif($journeyDateToDate != null){
				$collection->getSelect()->where( new Zend_Db_Expr(" case when lt.PNRNumber is null then date(main_table.JourneyDate) else date(lt.JourneyDate) end <= '" . $journeyDateToDate . "'") );
			}
		}
		$collection->getSelect()->where("main_table.RequestID IN(?)", $assignRequestIDs);
		$collection->getSelect()->order("main_table.CreatedAt desc");
		 
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
				
				if($this->_isExport == true){
					if($field == 'main_table.CurrStatusID' || $field == 'main_table.PaymentMethodID' || $field == 'main_table.PaymentGatewayID' || $field == 'dat.StatusID'){
						$cond = array('in'=> explode(',', $column->getFilter()->getValue()));
					}
				}	
				
				if ($field && isset($cond)) {
					$this->getCollection()->addFieldToFilter($field , $cond);
				}
			}
		}
		return $this;
	}
	

	protected function _prepareColumns(){

		
		$this->addColumn('RequestID', array(
				'header'    =>Mage::helper('adminhtml')->__('TxnID'),
				'index'     =>'main_table.RequestID',
				//'width'     => '50px',
				//'renderer'  => 'dakiya/CRM_ComplaintRegistration_ComplaintRegistration_Renderer'
		));

		$this->addColumn('PNRNumber', array(
				'header'    =>Mage::helper('adminhtml')->__('PNRNo'),
				'index'     =>'lt.PNRNumber',
				//'width'     => '90px',
		));

		$this->addColumn('IRCTCUserName', array(
				'header'    =>Mage::helper('adminhtml')->__('User <br /> Name'),
				'index'     =>'lu.IRCTCUserName',
				//'width'     => '80px',
				//'renderer'  => 'dakiya/CRM_ComplaintRegistration_ComplaintRegistration_Renderer'
		));
		
		$this->addColumn('MobileNO', array(
				'header'    =>Mage::helper('adminhtml')->__('MobileNo'),
				'index'     =>'lu.MobileNO',
				//'width'     => '90px',
		));
		
		
		$this->addColumn('NetTicketAmount', array(
				'header'    =>Mage::helper('adminhtml')->__('Amt'),
				'index'     =>'main_table.NetTicketAmount',
				'width'     => '50px',
		));
		
		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Booking <br /> Date'),
				'index'     => 'main_table.CreatedAt',
				'type'      => 'datetime',
				//'width'     => '50px',
		));
		
		$this->addColumn('JourneyDate', array(
				'header'    =>Mage::helper('adminhtml')->__('Journey <br /> Date'),
				'index'     =>'main_table.JourneyDate',
				'type'      =>'date',
				//'width'     =>'50px',
		));
		
		$this->addColumn('PaymentGatewayID', array(
				'header'    =>Mage::helper('adminhtml')->__('Payment <br /> Gateway'),
				//'width'     => '70px',
				'type'      => 'options',
				'index'     =>'main_table.PaymentGatewayID',
				'options'   => Mage::getModel('dakiya/Master_Payment_PaymentGateway')->getResource()->getOptions()
		));
		
		
		$this->addColumn('CurrStatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				//'width'     => '70px',
				'type'      => 'options',
				'index'     =>'main_table.CurrStatusID',
				'options'   => Mage::getModel('dakiya/Master_Booking_UserBookingRequestStatus')->getResource()->getOptions()
		));
		
		/*
		$this->addColumn('username', array(
				'header'    =>Mage::helper('adminhtml')->__('Assign To'),
				'index'     =>'dat.username',
		));
		
		
		$this->addColumn('StatusID', array(
				'header'    => Mage::helper('adminhtml')->__('Ticket <br /> Status'),
				'type'      => 'options',
				'index'     => 'dat.StatusID',
				'options'   => Mage::getModel('dakiya/Master_Job_AssignTicket_AssignTicketStatus')->getResource()->getOptions()
		));
		
		$this->addColumn('AssignDate', array(
				'header'    =>Mage::helper('adminhtml')->__('Assign <br /> Date'),
				'index'     =>'dat.AssignDate',
				'type'      =>'date'
		));
		*/
		
		$this->addColumn('Detail', array(
				'header'    =>Mage::helper('adminhtml')->__('Detail'),
				'index'     =>'main_table.Detail',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'dakiya/CRM_ComplaintRegistration_ComplaintRegistration_Renderer',
		));
		
		
		/*
		$this->addColumn('EmailID', array(
				'header'    =>Mage::helper('adminhtml')->__('Email'),
				'index'     =>'lu.EmailID',
				'width'     => '100px',
				'renderer'  => 'dakiya/CRM_ComplaintRegistration_ComplaintRegistration_Renderer',
		));
		
		
		$this->addColumn('WaybillNo', array(
				'header'    =>Mage::helper('adminhtml')->__('Waybill <br /> Num'),
				'index'     =>'lmdshipment.WaybillNo',
				'width'     => '50px'
		));
		
		$this->addColumn('TrainNo', array(
				'header'    =>Mage::helper('adminhtml')->__('Train <br /> Num'),
				'index'     =>'main_table.TrainNo',
				'width'     => '50px',
		));
		
		
		$this->addColumn('Source', array(
				'header'    =>Mage::helper('adminhtml')->__('From'),
				'index'     =>'main_table.SourceStationCode',
				'width'     => '50px',
		));
		
		 
		
		$this->addColumn('Destination', array(
				'header'    =>Mage::helper('adminhtml')->__('To'),
				'index'     =>'main_table.DestinationStationCode',
				'width'     => '50px',
		));
		
		$this->addColumn('PaymentMethodID', array(
				'header'    =>Mage::helper('adminhtml')->__('Payment <br /> Type'),
				'width'     => '70px',
				'type'      => 'options',
				'index'     =>'main_table.PaymentMethodID',
				'options'   => Mage::getModel('dakiya/Master_Payment_PaymentMethod')->getResource()->getOptions()
		));

		
		
		*/
		
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
