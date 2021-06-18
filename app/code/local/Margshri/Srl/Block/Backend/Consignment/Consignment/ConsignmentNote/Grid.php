<?php
class Margshri_Transport_Block_Backend_Consignment_Consignment_ConsignmentNote_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	
	public function __construct(){
		parent::__construct();
		$this->setId('ConsignmentNote');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection(){

		try{
			
			$filter = $this->getParam($this->getVarNameFilter(), null);
			$createdAtFromDate = null; $createdAtToDate = null;
			$updatedAtFromDate = null; $updatedAtToDate = null;
			
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
							$createdAtFromDate = date('Y-m-d', strtotime($filterDataObjs['UpdatedAt']['from']));
						}
							
						if(array_key_exists('to', $filterDataObjs['UpdatedAt'])){
							$createdAtToDate   = date('Y-m-d', strtotime($filterDataObjs['UpdatedAt']['to']));
						}
					}
			
					if(sizeof($filterDataObjs) == 2){
					    if( $createdAtFromDate == null && $createdAtToDate == null &&
						    $updatedAtFromDate == null && $updatedAtToDate == null){
							$dateFilterFlag = false;
						}
					}
				}
			}
			

			$collection = Mage::getModel(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$modelName)->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
			    "main_table.ConsignmentNo"=>"main_table.ConsignmentNo", "main_table.ConsignorName"=>"main_table.ConsignorName",
			    "main_table.ConsignorAddress"=>"main_table.ConsignorAddress", "main_table.ConsignorGstinNo"=>"main_table.ConsignorGstinNo",
			    "main_table.ConsignorMobileNo"=>"main_table.ConsignorMobileNo", "main_table.ConsignorCityID"=>"main_table.ConsignorCityID",
			    "main_table.ConsigneeName"=>"main_table.ConsigneeName", "main_table.ConsigneeAddress"=>"main_table.ConsigneeAddress",
			    "main_table.ConsigneeGstinNo"=>"main_table.ConsigneeGstinNo", "main_table.ConsigneeMobileNo"=>"main_table.ConsigneeMobileNo",
			    "main_table.ConsigneeCityID"=>"main_table.ConsigneeCityID", "main_table.VahicaleID"=>"main_table.VahicaleID",
			    "main_table.SourceCityID"=>"main_table.SourceCityID", "main_table.DestinationCityID"=>"main_table.DestinationCityID",
			    "main_table.DriverID"=>"main_table.DriverID", "main_table.VahicaleOwnerID"=>"main_table.VahicaleOwnerID",
			    "main_table.StatusID"=>"main_table.StatusID", "main_table.Print"=> new Zend_Db_Expr("'Print'"),
			    "main_table.Edit"=> new Zend_Db_Expr("'Edit'") ));
			
			    /*
			    "main_table.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)"), 
			    "main_table.UpdatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.UpdatedAt,INTERVAL '05:30' HOUR_MINUTE)"), 
			    */
			// $collection->getSelect()->joinLeft(array("user"=>$collection->getTable(Margshri_Common_VO_User_User_UserVO::$tableAlias)), 'main_table.UserID = user.ID', array("user.ID"=>"user.ID", "user.Name"=>new Zend_Db_Expr(" case when user.ID is null then main_table.DonorName else user.Name end") ));
			$collection->getSelect()->joinLeft(array("createdby"=>$collection->getTable('common/adminuser')), 'main_table.CreatedBy = createdby.user_id', array("createdby.firstname"=>"createdby.firstname"));
			$collection->getSelect()->joinLeft(array("updatedby"=>$collection->getTable('common/adminuser')), 'main_table.UpdatedBy = updatedby.user_id', array("updatedby.firstname"=>"updatedby.firstname"));
			
			 
			
			if($dateFilterFlag == true){
				/* below where condition is run when booked date filter is used */
			    
				if($createdAtFromDate != null && $createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
				}elseif($createdAtFromDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
				}elseif($createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
				}
				
				if($updatedAtFromDate != null && $updatedAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.UpdatedAt) between '" . $updatedAtFromDate . "' and '" . $updatedAtToDate . "'") );
				}elseif($updatedAtFromDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.UpdatedAt) >= '" . $updatedAtFromDate . "'") );
				}elseif($updatedAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.UpdatedAt) <= '" . $updatedAtToDate . "'") );
				}
			}	

			$collection->getSelect()->Order('main_table.ID Desc');
			$this->setCollection($collection);
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}

	
	protected function _addColumnFilterToCollection($column){
		if ($this->getCollection()) {
				
			if($column->getType() == 'date' || $column->getType() == 'datetime'){
				return $this;
			}
				
			$field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();

			/*
			if($field == 'lu.IRCTCUserName' || $field == 'main_table.ShipmentStatus'){
				return $this;
			}
			*/	
				
				
			if ($column->getFilterConditionCallback()) {
				call_user_func($column->getFilterConditionCallback(), $this->getCollection(), $column);
			} else {
	
				$cond = $column->getFilter()->getCondition();
				/*
				if($this->_isExport == true){
					if($field == 'main_table.CurrStatusID' || $field == 'main_table.PaymentMethodID' || $field == 'main_table.PaymentGatewayID' || $field == 'enuesr.DebitStatusID'){
						$cond = array('in'=> explode(',', $column->getFilter()->getValue()));
					}
				}
				*/
				if ($field && isset($cond)) {
					$this->getCollection()->addFieldToFilter($field , $cond);
				}
			}
		}
		return $this;
	}
	

	protected function _prepareColumns(){

		$this->addColumn('ID', array(
				'header'    => Mage::helper('adminhtml')->__('ID'),
				'index'     => 'main_table.ID',
				'align'     => 'right',
				'width'     => '50px'
		));
		
		
		$this->addColumn('ConsignmentNo', array(
		    'header'    => Mage::helper('adminhtml')->__('ConsignmentNo'),
		    'index'     => 'main_table.ConsignmentNo',
		));
		
		
		$this->addColumn('ConsignorName', array(
		    'header'    => Mage::helper('adminhtml')->__('ConsignorName'),
		    'index'     => 'main_table.ConsignorName',
		));
		
		$this->addColumn('ConsignorMobileNo', array(
		    'header'    => Mage::helper('adminhtml')->__('ConsignorMobileNo'),
		    'index'     => 'main_table.ConsignorMobileNo',
		));
		
		$this->addColumn('ConsigneeName', array(
		    'header'    => Mage::helper('adminhtml')->__('ConsigneeName'),
		    'index'     => 'main_table.ConsigneeName',
		));
		
		$this->addColumn('ConsigneeMobileNo', array(
		    'header'    => Mage::helper('adminhtml')->__('ConsigneeMobileNo'),
		    'index'     => 'main_table.ConsigneeMobileNo',
		));
		
		$this->addColumn('SourceCityID', array(
		    'header'    => Mage::helper('adminhtml')->__('SourceCity'),
		    'type'      => 'options',
		    'index'     => 'main_table.SourceCityID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName)->getResource()->getGridOptions()
		));
		
		$this->addColumn('DestinationCityID', array(
		    'header'    => Mage::helper('adminhtml')->__('DestinationCity'),
		    'type'      => 'options',
		    'index'     => 'main_table.DestinationCityID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName)->getResource()->getGridOptions()
		));
		
		$this->addColumn('VahicaleID', array(
		    'header'    => Mage::helper('adminhtml')->__('TruckNo'),
		    'type'      => 'options',
		    'index'     => 'main_table.VahicaleID',
		    'options'   => Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName)->getResource()->getActiveOptions()
		));
		
		$this->addColumn('DriverID', array(
		    'header'    => Mage::helper('adminhtml')->__('Driver'),
		    'type'      => 'options',
		    'index'     => 'main_table.DriverID',
		    'options'   => Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName)->getResource()->getActiveOptions()
		));
		
		$this->addColumn('StatusID', array(
		    'header'    => Mage::helper('adminhtml')->__('Status'),
		    'type'      => 'options',
		    'index'     => 'main_table.StatusID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName)->getResource()->getOptions()
		));
		
		$this->addColumn('Print', array(
		    'header'    =>Mage::helper('adminhtml')->__('Print'),
		    'index'     =>'main_table.Print',
		    'align'     => 'left',
		    'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		    'renderer'  => 'transport/Backend_Consignment_Consignment_ConsignmentNote_Renderer',
		    
		));
		
		$this->addColumn('Edit', array(
		    'header'    =>Mage::helper('adminhtml')->__('Edit'),
		    'index'     =>'main_table.Edit',
		    'align'     => 'left',
		    'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		    'renderer'  => 'transport/Backend_Consignment_Consignment_ConsignmentNote_Renderer',
		    
		));
		
        /*		
	  
		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Created <br /> <br /> Date'),
				'index'     => 'main_table.CreatedAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		$this->addColumn('CreatedBy', array(
				'header'    => Mage::helper('adminhtml')->__('Created By'),
				'index'     => 'createdby.firstname',
		        'width'     => '50px'
		));
		
		
		$this->addColumn('UpdatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Updated <br /> <br /> Date'),
				'index'     => 'main_table.UpdatedAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		
		$this->addColumn('UpdatedBy', array(
				'header'    => Mage::helper('adminhtml')->__('Updated By'),
				'index'     => 'updatedby.firstname',
		        'width'     => '50px'
		));
		
		
		
		
		*/
		
		// $this->addExportType('*/*/export/ExportType/xls', 'xls');
		// $this->addExportType('*/*/export/ExportType/xlsx', 'xlsx');

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

