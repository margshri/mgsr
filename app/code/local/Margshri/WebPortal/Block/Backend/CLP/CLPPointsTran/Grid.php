<?php
class Margshri_WebPortal_Block_Backend_CLP_CLPPointsTran_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('CLPPointsTran');
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
					
					if(sizeof($filterDataObjs) == 1){
						if($createdAtFromDate == null && $createdAtToDate == null){
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
			
			
			$collection = Mage::getModel("webportal/Right_CLPPointsTran")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
					"main_table.CustomerID"=>"main_table.CustomerID", "main_table.CLPPointID"=>"main_table.CLPPointID",
					"main_table.TypeID"=>"main_table.TypeID", "main_table.ModeID"=>"main_table.ModeID",
					"main_table.EntityID"=>"main_table.EntityID","main_table.EntityTransactionID"=>"main_table.EntityTransactionID",
					"main_table.MinCLPPoints"=>"main_table.MinCLPPoints", "main_table.MaxCLPPoints"=>"main_table.MaxCLPPoints",
					"main_table.RandomPoints"=>"main_table.RandomPoints", "main_table.Points"=>"main_table.Points",
					"main_table.CreatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) "), "main_table.edit"=> new Zend_Db_Expr("'Edit'")
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
		
		
		$this->addColumn('CLPPointID', array(
				'header'    =>Mage::helper('adminhtml')->__('CLPPointID'),
				'index'     =>'main_table.CLPPointID',
		));
		
		
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Type'),
				'type'  => 'options',
				'index' => 'main_table.TypeID',
				'options' => Mage::getModel('webportal/Master_Right_CLPPointsType')->getResource()->getActiveOptions()
		));

		$this->addColumn('ModeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Mode'),
				'type'  => 'options',
				'index' => 'main_table.ModeID',
				'options' => Mage::getModel('webportal/Master_Right_CLPPointsMode')->getResource()->getActiveOptions()
		));
		
		
		$this->addColumn('EntityID', array(
				'header'    =>Mage::helper('adminhtml')->__('Entity'),
				'type'  => 'options',
				'index' => 'main_table.EntityID',
				'options' => Mage::getModel('webportal/Master_Right_Entity')->getResource()->getActiveOptions()
		));
		
		$this->addColumn('EntityTransactionID', array(
				'header'    => Mage::helper('adminhtml')->__('Page <br /> SubPage ID'),
				'index'     => 'main_table.EntityTransactionID',
		));
		
		
		$this->addColumn('Points', array(
				'header'    => Mage::helper('adminhtml')->__('Points'),
				'index'     => 'main_table.Points',
		));

		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Created D/T'),
				'index'     => 'main_table.CreatedAt',
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

