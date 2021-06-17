<?php
class Margshri_Common_Block_Backend_Customer_ManageVisitor_ActualVisitor_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('actualvisitor');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection(){

		try{
			/*
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5);
			
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7);
			
			$mobileNumberCollection = Mage::getModel('customer/customer')->getCollection();
			$mobileNumberQuery = $mobileNumberCollection->getSelect()->reset()->from(array("main_table"=>$mobileNumberCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 139);
			
			$customerImageCollection = Mage::getModel('customer/customer')->getCollection();
			$customerImageQuery = $customerImageCollection->getSelect()->reset()->from(array("main_table"=>$customerImageCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 140);
			
			
			$collection = Mage::getModel('customer/customer')->getCollection();
			$collection->getSelect()->reset()->from(array("e"=>$collection->getTable("webportal/customerentity")), array("entity_id", "email", "edit"=> new Zend_Db_Expr("'Edit'")) );
			$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "e.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"));
			$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "e.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"));
			$collection->getSelect()->joinLeft(array("mobilenumber"=>$mobileNumberQuery), "e.entity_id = mobilenumber.entity_id", array("MobileNumber"=>"mobilenumber.value"));
			$collection->getSelect()->joinLeft(array("customerimage"=>$customerImageQuery), "e.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"));
			$collection->getSelect()->order('entity_id DESC');
			$this->setCollection($collection);
			*/
			
			$collection = Mage::getModel('customer/customer')->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable("common/apctlogvisitor")), array("main_table.visitor_id"=>"main_table.visitor_id", "main_table.first_visit_at"=>new Zend_Db_Expr(" DATE_SUB(main_table.first_visit_at, INTERVAL 330 minute) "), "main_table.last_visit_at"=>new Zend_Db_Expr(" DATE_SUB(main_table.first_visit_at, INTERVAL 330 minute) ")));
			//$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "e.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"));
			//$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "e.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"));
			//$collection->getSelect()->joinLeft(array("mobilenumber"=>$mobileNumberQuery), "e.entity_id = mobilenumber.entity_id", array("MobileNumber"=>"mobilenumber.value"));
			//$collection->getSelect()->joinLeft(array("customerimage"=>$customerImageQuery), "e.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"));
			$collection->getSelect()->order('visitor_id DESC');
			$this->setCollection($collection);
			
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns(){

		$this->addColumn('visitor_id', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.visitor_id',
				'align'     => 'right',
				'width'    => '50px'
		));

		
		$this->addColumn('first_visit_at', array(
				'header'    =>Mage::helper('adminhtml')->__('First Visit At'),
				'index'     =>'main_table.first_visit_at',
		));

		
		$this->addColumn('last_visit_at', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Visit At'),
				'index'     =>'main_table.last_visit_at',
		));
		
		 
		return parent::_prepareColumns();
		
	}


	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

