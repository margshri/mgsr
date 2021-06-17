<?php
class Margshri_WebPortal_Block_Backend_CLP_CLPPoints_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('CLPPoints');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection(){
		try{
			$dateFilterFlag = false;
			$filter   = $this->getParam($this->getVarNameFilter(), null);
			$todayDate= date($format, Mage::getModel('core/date')->timestamp(time()));
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
							$updatedAtFromDate = date('Y-m-d', strtotime($filterDataObjs['UpdatedAt']['from']));
						}
					
						if(array_key_exists('to', $filterDataObjs['UpdatedAt'])){
							$updatedAtToDate   = date('Y-m-d', strtotime($filterDataObjs['UpdatedAt']['to']));
						}
					}
					
					
					
					if(sizeof($filterDataObjs) == 2){
						if($createdAtFromDate == null && $createdAtToDate == null &&
								$updatedAtFromDate == null && $updatedAtToDate == null){
									$dateFilterFlag = false;
						}
					}
				}
			}
			
			
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5);
				
				
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7);
			
			
			$collection =   Mage::getModel("webportal/Right_CLPPoints")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
					"main_table.CustomerID"=>"main_table.CustomerID", "main_table.DailyPoints"=>"main_table.DailyPoints",
					"main_table.WeeklyPoints"=>"main_table.WeeklyPoints", "main_table.EarnedPoints"=>"main_table.EarnedPoints",
					"main_table.MonthlyPoints"=>"main_table.MonthlyPoints","main_table.SpecialPoints"=>"main_table.SpecialPoints",
					"main_table.RedeemedPoints"=>"main_table.RedeemedPoints", "main_table.CreatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) "),
					"main_table.UpdatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.UpdatedAt,INTERVAL '05:30' HOUR_MINUTE) "), "main_table.edit"=> new Zend_Db_Expr("'Edit'")
			));
			
			$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "main_table.CustomerID = firstname.entity_id", array("firstname.value"=>"firstname.value"));
			$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "main_table.CustomerID = lastname.entity_id", array("lastname.value"=>"lastname.value"));
				
			
			if($dateFilterFlag == true){
				if($createdAtFromDate != null && $createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
				}elseif($createdAtFromDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
				}elseif($createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
				}
				
				if($updatedAtFromDate != null && $createdAtToDate != null){
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
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.ID',
				'align'     => 'right',
				'width'    => '50px'
		));
		
		$this->addColumn('CustomerID', array(
				'header'    =>Mage::helper('adminhtml')->__('CustomerID'),
				'index'     =>'main_table.CustomerID',
		));

		$this->addColumn('value', array(
				'header'    =>Mage::helper('adminhtml')->__('First Name'),
				'index'     =>'firstname.value',
		));
		
		
		$this->addColumn('lastname', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'lastname.value',
				'filter'    => false
		));
		
		$this->addColumn('DailyPoints', array(
				'header'    =>Mage::helper('adminhtml')->__('Daily Points'),
				'index'     =>'main_table.DailyPoints',
		));
		
		$this->addColumn('WeeklyPoints', array(
				'header'    =>Mage::helper('adminhtml')->__('Weekly Points'),
				'index'     =>'main_table.WeeklyPoints',
		));
		
		
		$this->addColumn('MonthlyPoints', array(
				'header'    =>Mage::helper('adminhtml')->__('Monthly Points'),
				'index'     =>'main_table.MonthlyPoints',
		));

		$this->addColumn('SpecialPoints', array(
				'header'    =>Mage::helper('adminhtml')->__('Special Points'),
				'index'     =>'main_table.SpecialPoints',
		));
		
		
		$this->addColumn('EarnedPoints', array(
				'header'    =>Mage::helper('adminhtml')->__('Earned Points'),
				'index'     =>'main_table.EarnedPoints',
		));
		
		$this->addColumn('RedeemedPoints', array(
				'header'    => Mage::helper('adminhtml')->__('Redeemed Points'),
				'index'     => 'main_table.RedeemedPoints',
		));
		

		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Created D/T'),
				'index'     => 'main_table.CreatedAt',
				'type'      =>'datetime',
				'width'     =>'50px',
		));
		
		
		$this->addColumn('UpdatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Updated D/T'),
				'index'     => 'main_table.UpdatedAt',
				'type'      =>'datetime',
				'width'     =>'50px',
		));
		
		/*
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit',
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Registration_Registration_Renderer',
		));
		*/
		return parent::_prepareColumns();
		
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

	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}

}

