<?php
class Margshri_Common_Block_Backend_Programme_Programme_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	
	
	public function __construct(){
		parent::__construct();
		$this->setId('programme');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection(){

		try{
		    $adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
		    
			$filter = $this->getParam($this->getVarNameFilter(), null);
			$donationFromDate = null; $donationToDate = null;
			$createdAtFromDate = null; $createdAtToDate = null;
			$updatedAtFromDate = null; $updatedAtToDate = null;
			
			if(empty($filter) && is_string($filter)){
				// when reset filter is tigger
			}else if(is_string($filter)){
				$filterDataObjs = $this->helper('adminhtml')->prepareFilterString($filter);
				if(sizeof($filterDataObjs) > 0){
					$dateFilterFlag = true;
			
					
					if(array_key_exists('DonationDate', $filterDataObjs)){
					    if(array_key_exists('from', $filterDataObjs['DonationDate'])){
					        $donationFromDate = date('Y-m-d', strtotime($filterDataObjs['DonationDate']['from']));
					    }
					    
					    if(array_key_exists('to', $filterDataObjs['CreatedAt'])){
					        $donationToDate   = date('Y-m-d', strtotime($filterDataObjs['DonationDate']['to']));
					    }
					}
					
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
			
					if(sizeof($filterDataObjs) == 3){
					    if($donationFromDate == null && $donationToDate == null &&
						    $createdAtFromDate == null && $createdAtToDate == null &&
						    $updatedAtFromDate == null && $updatedAtToDate == null){
							$dateFilterFlag = false;
						}
					}
				}
			}
			

			$collection = Mage::getModel(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName)->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
			    "main_table.ProgrammeName"=>"main_table.ProgrammeName", "main_table.ProgrammeYear"=>"main_table.ProgrammeYear",
			    "main_table.ProgrammeDate"=>new Zend_Db_Expr("  DATE_SUB(main_table.ProgrammeDate,INTERVAL '05:30' HOUR_MINUTE)"),
			    "main_table.TypeID"=>"main_table.TypeID", "main_table.StatusID"=>"main_table.StatusID",
			    "main_table.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)"), 
			    "main_table.UpdatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.UpdatedAt,INTERVAL '05:30' HOUR_MINUTE)"), 
			    "main_table.Edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("createdby"=>$collection->getTable('common/adminuser')), 'main_table.CreatedBy = createdby.user_id', array("createdby.firstname"=>"createdby.firstname"));
			$collection->getSelect()->joinLeft(array("updatedby"=>$collection->getTable('common/adminuser')), 'main_table.UpdatedBy = updatedby.user_id', array("updatedby.firstname"=>"updatedby.firstname"));
			
			if($dateFilterFlag == true){
				/* below where condition is run when booked date filter is used */
			    
			    /*
			    if($donationFromDate != null && $donationToDate != null){
			        $collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $donationFromDate . "' and '" . $donationToDate . "'") );
			    }elseif($donationFromDate != null){
			        $collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
			    }elseif($donationToDate != null){
			        $collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $donationToDate . "'") );
			    }
			    */
			    
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
			
			if($adminUserID != 1){ // 1 for admin 
			    $collection->getSelect()->where("main_table.CreatedBy =?", $adminUserID);
			}
			
			// $collection->getSelect()->where("main_table.DonationTypeID =?", Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$MEMBERSHIP_RECEIPT);
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
		
		
		$this->addColumn('ProgrammeDate', array(
		    'header'    => Mage::helper('adminhtml')->__('Programme Date'),
		    'index'     => 'main_table.ProgrammeDate',
		    'type'      => 'datetime',
		    'width'     => '50px',
		));
		
		
		$this->addColumn('ProgrammeName', array(
		    'header'    => Mage::helper('adminhtml')->__('Programme Name'),
		    'index'     => 'main_table.ProgrammeName',
		));
		
		
		$this->addColumn('ProgrammeYear', array(
				'header'    => Mage::helper('adminhtml')->__('Programme Year'),
				'index'     => 'main_table.ProgrammeYear',
		));
 		
		
		$this->addColumn('TypeID', array(
		    'header'    => Mage::helper('adminhtml')->__('Type'),
		    'type'      => 'options',
		    'index'     => 'main_table.TypeID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Master_Programme_ProgrammeTypeVO::$modelName)->getResource()->getOptions()
		));
		 
        		
		$this->addColumn('StatusID', array(
		    'header'    => Mage::helper('adminhtml')->__('Status'),
		    'type'      => 'options',
		    'index'     => 'main_table.StatusID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Master_Programme_ProgrammeStatusVO::$modelName)->getResource()->getOptions()
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
		
		/*
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
		
		$this->addColumn('Edit', array(
		    'header'    =>Mage::helper('adminhtml')->__('Edit'),
		    'index'     =>'main_table.Edit',
		    'align'     => 'left',
		    'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		    'renderer'  => 'common/Backend_Programme_Programme_Renderer',
		    
		));
		
		
		// $this->addExportType('*/*/export/ExportType/xls', 'xls');
		// $this->addExportType('*/*/export/ExportType/xlsx', 'xlsx');

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

