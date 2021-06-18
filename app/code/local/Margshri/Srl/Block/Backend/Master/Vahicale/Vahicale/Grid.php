<?php
class Margshri_Transport_Block_Backend_Master_Vahicale_Vahicale_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	
	
	public function __construct(){
		parent::__construct();
		$this->setId('vahicale');
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
			

			$collection = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName)->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
			    "main_table.VahicaleNumber"=>"main_table.VahicaleNumber", "main_table.ChasisNumber"=>"main_table.ChasisNumber",
			"main_table.EngineNumber"=>"main_table.EngineNumber", "main_table.WeightCapacity"=>"main_table.WeightCapacity",
			    "main_table.OwnerID"=>"main_table.OwnerID", "main_table.StatusID"=>"main_table.StatusID",
			"main_table.Edit"=> new Zend_Db_Expr("'Edit'") ));
			    
			    /*
			    
			    "main_table.ReceiptNumber"=>"main_table.ReceiptNumber", "main_table.StatusID"=>"main_table.StatusID",
			    "main_table.DonatedAmount"=>"main_table.DonatedAmount", "main_table.Description"=>"main_table.Description",
			    "main_table.DonationDate"=> new Zend_Db_Expr("  DATE_SUB(main_table.DonationDate,INTERVAL '05:30' HOUR_MINUTE)"),
			    "main_table.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)"), 
			    "main_table.UpdatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.UpdatedAt,INTERVAL '05:30' HOUR_MINUTE)"), 
			    
			    */
			// $collection->getSelect()->joinLeft(array("user"=>$collection->getTable(Margshri_Common_VO_User_User_UserVO::$tableAlias)), 'main_table.UserID = user.ID', array("user.ID"=>"user.ID", "user.Name"=>new Zend_Db_Expr(" case when user.ID is null then main_table.DonorName else user.Name end") ));
			$collection->getSelect()->joinLeft(array("createdby"=>$collection->getTable('webportal/adminuser')), 'main_table.CreatedBy = createdby.user_id', array("createdby.firstname"=>"createdby.firstname"));
			$collection->getSelect()->joinLeft(array("updatedby"=>$collection->getTable('webportal/adminuser')), 'main_table.UpdatedBy = updatedby.user_id', array("updatedby.firstname"=>"updatedby.firstname"));
			
			 
			
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
		
		
		$this->addColumn('VahicaleNumber', array(
		    'header'    => Mage::helper('adminhtml')->__('Vahicale Number'),
		    'index'     => 'main_table.VahicaleNumber',
		));
		
		
		$this->addColumn('ChasisNumber', array(
		    'header'    => Mage::helper('adminhtml')->__('Chasis Number'),
		    'index'     => 'main_table.ChasisNumber',
		));
		
		$this->addColumn('EngineNumber', array(
		    'header'    => Mage::helper('adminhtml')->__('Engine Number'),
		    'index'     => 'main_table.EngineNumber',
		));
		
		$this->addColumn('WeightCapacity', array(
		    'header'    => Mage::helper('adminhtml')->__('Weight Capacity'),
		    'index'     => 'main_table.WeightCapacity',
		));
		
		
		$this->addColumn('OwnerID', array(
		    'header'    => Mage::helper('adminhtml')->__('Owner'),
		    'type'      => 'options',
		    'index'     => 'main_table.OwnerID',
		    'options'   => Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName)->getResource()->getOptions()
		));
		
		
		$this->addColumn('StatusID', array(
		    'header'    => Mage::helper('adminhtml')->__('Status'),
		    'type'      => 'options',
		    'index'     => 'main_table.OwnerID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName)->getResource()->getOptions()
		));
		
		
		$this->addColumn('Edit', array(
		    'header'    =>Mage::helper('adminhtml')->__('Edit'),
		    'index'     =>'main_table.Edit',
		    'align'     => 'left',
		    'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		    'renderer'  => 'transport/Backend_Master_Vahicale_Vahicale_Renderer',
		    
		));
		
        /*		
		$this->addColumn('DonationDate', array(
		    'header'    => Mage::helper('adminhtml')->__('Donation <br /> <br /> Date'),
		    'index'     => 'main_table.DonationDate',
		    'type'      => 'datetime',
		    'width'     => '50px',
		));
		
		
		
		
		
		
		
		$this->addColumn('ContactNumber', array(
		    'header'    => Mage::helper('adminhtml')->__('Contact <br /> <br /> Number'),
		    'index'     => 'main_table.ContactNumber',
		));
 		
		
		$this->addColumn('Address', array(
		    'header'    => Mage::helper('adminhtml')->__('Address'),
		    'index'     => 'main_table.Address',
		));
		
		$this->addColumn('DonationTypeID', array(
		    'header'    => Mage::helper('adminhtml')->__('Donation <br /> <br /> Type'),
		    'type'      => 'options',
		    'index'     => 'main_table.DonationTypeID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName)->getResource()->getOptions()
		));
		
		$this->addColumn('ReceiptBookID', array(
		    'header'    => Mage::helper('adminhtml')->__('Receipt <br /> <br /> Book'),
		    'type'      => 'options',
		    'index'     => 'main_table.ReceiptBookID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$modelName)->getResource()->getOptions()
		));
		
		
		$this->addColumn('ReceiptNumber', array(
		    'header'    => Mage::helper('adminhtml')->__('Receipt <br /> <br /> Number'),
		    'index'     => 'main_table.ReceiptNumber',
		    'width'     => '100px'
		));
		
		
		$this->addColumn('DonatedAmount', array(
		    'header'    => Mage::helper('adminhtml')->__('Donated <br /> <br /> Amount'),
		    'index'     => 'main_table.DonatedAmount',
		));
		
		$this->addColumn('Description', array(
		    'header'    => Mage::helper('adminhtml')->__('Description'),
		    'index'     => 'main_table.Description',
		    'width'     => '100px'
		));
		
		$this->addColumn('StatusID', array(
		    'header'    => Mage::helper('adminhtml')->__('Status'),
		    'type'      => 'options',
		    'index'     => 'main_table.StatusID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$modelName)->getResource()->getOptions()
		));
	  
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

