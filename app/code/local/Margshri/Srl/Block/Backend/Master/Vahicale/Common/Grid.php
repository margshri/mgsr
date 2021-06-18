<?php
class Margshri_Transport_Block_Backend_Master_Vahicale_Common_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	
	
	public function __construct(){
		parent::__construct();
		$this->setId('common');
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
			

			$collection = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName)->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
			    "main_table.VahicaleID"=>"main_table.VahicaleID", "main_table.OwnerID"=>"main_table.OwnerID",
			    "main_table.DriverID"=>"main_table.DriverID", "main_table.StatusID"=>"main_table.StatusID",
			"main_table.Edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("vahicale"=>$collection->getTable('transport/mgsrvahicale')), 'main_table.VahicaleID = vahicale.ID', array("vahicale.ID"=>"vahicale.ID", "vahicale.VahicaleNumber"=>"vahicale.VahicaleNumber"));
			$collection->getSelect()->joinLeft(array("owner"=>$collection->getTable('transport/mgsrvahicaleowner')), 'main_table.OwnerID = owner.ID', array("owner.ID"=>"owner.ID", "owner.Name"=>"owner.Name", "owner.MobileNo"=>"owner.MobileNo"));
			$collection->getSelect()->joinLeft(array("driver"=>$collection->getTable('transport/mgsrvahicaledriver')), 'main_table.DriverID = driver.ID', array("driver.ID"=>"driver.ID", "driver.Name"=>"driver.Name", "driver.MobileNo"=>"driver.MobileNo"));
			
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

	
	 
	

	protected function _prepareColumns(){

		$this->addColumn('ID', array(
				'header'    => Mage::helper('adminhtml')->__('ID'),
				'index'     => 'main_table.ID',
				'align'     => 'right',
				'width'     => '50px'
		));
		
		
		$this->addColumn('VahicaleNumber', array(
		    'header'    => Mage::helper('adminhtml')->__('Truck'),
		    'index'     => 'vahicale.VahicaleNumber'
		));
		
		$this->addColumn('OwnerName', array(
		    'header'    => Mage::helper('adminhtml')->__('Owner'),
		    'index'     => 'owner.Name'
		));
		
		$this->addColumn('OwnerMobileNo', array(
		    'header'    => Mage::helper('adminhtml')->__('Owner MobileNo'),
		    'index'     => 'owner.MobileNo'
		));
		
		$this->addColumn('DriverName', array(
		    'header'    => Mage::helper('adminhtml')->__('Driver'),
		    'index'     => 'driver.Name'
		));
		
		$this->addColumn('DriverMobileNo', array(
		    'header'    => Mage::helper('adminhtml')->__('Driver MobileNo'),
		    'index'     => 'driver.MobileNo'
		));
		
		/*
		$this->addColumn('VahicaleID', array(
		    'header'    => Mage::helper('adminhtml')->__('Truck'),
		    'type'      => 'options',
		    'index'     => 'main_table.VahicaleID',
		    'options'   => Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName)->getResource()->getOptions()
		));
		
		
		$this->addColumn('OwnerID', array(
		    'header'    => Mage::helper('adminhtml')->__('Owner'),
		    'type'      => 'options',
		    'index'     => 'main_table.OwnerID',
		    'options'   => Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName)->getResource()->getOptions()
		));
		
		$this->addColumn('DriverID', array(
		    'header'    => Mage::helper('adminhtml')->__('Driver'),
		    'type'      => 'options',
		    'index'     => 'main_table.DriverID',
		    'options'   => Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName)->getResource()->getOptions()
		));
		*/
		
		$this->addColumn('StatusID', array(
		    'header'    => Mage::helper('adminhtml')->__('Status'),
		    'type'      => 'options',
		    'index'     => 'main_table.StatusID',
		    'options'   => Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName)->getResource()->getOptions()
		));
		
		
		$this->addColumn('Edit', array(
		    'header'    =>Mage::helper('adminhtml')->__('Edit'),
		    'index'     =>'main_table.Edit',
		    'align'     => 'left',
		    'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		    'renderer'  => 'transport/Backend_Master_Vahicale_Common_Renderer',
		    
		));

		return parent::_prepareColumns();
		
	}

	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

