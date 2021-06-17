<?php
class Margshri_Common_Block_Backend_Customer_ManageCustomer_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('managecustomer');
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
			$collection->getSelect()->joinLeft(array("apctcustomer"=>$collection->getTable("common/apctcustomer")), "e.entity_id = apctcustomer.CustomerID", array("apctcustomer.IsShowProfile"=>new Zend_Db_Expr(" case when apctcustomer.IsShowProfile = 1 then 'Yes' else case when apctcustomer.IsShowProfile = 0 then 'No' else 'OLD Yes' end end "), "apctcustomer.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(apctcustomer.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)")));
			$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "e.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"));
			$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "e.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"));
			$collection->getSelect()->joinLeft(array("mobilenumber"=>$mobileNumberQuery), "e.entity_id = mobilenumber.entity_id", array("MobileNumber"=>"mobilenumber.value"));
			$collection->getSelect()->joinLeft(array("customerimage"=>$customerImageQuery), "e.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"));
			$collection->getSelect()->order('entity_id DESC');
			$this->setCollection($collection);
			return parent::_prepareCollection();
			*/
		    
		    $collection = Mage::getModel('common/Customer_Customer')->getCollection();
		    $collection->getSelect()->reset()->from(array("apctcustomer"=>$collection->getTable("common/apctcustomer")), array("apctcustomer.ID"=>"apctcustomer.ID", "apctcustomer.CustomerID"=>"apctcustomer.CustomerID", "apctcustomer.FirstName"=>"apctcustomer.FirstName", "apctcustomer.LastName"=>"apctcustomer.LastName", "apctcustomer.EmailID"=>"apctcustomer.EmailID", "apctcustomer.MobileNumber"=>"apctcustomer.MobileNumber", "apctcustomer.StatusID"=>"apctcustomer.StatusID", "apctcustomer.IsShowProfile"=>new Zend_Db_Expr(" case when apctcustomer.IsShowProfile = 1 then 'Yes' else case when apctcustomer.IsShowProfile = 0 then 'No' else 'OLD Yes' end end "), "apctcustomer.IsMobileRequest"=>new Zend_Db_Expr(" case when apctcustomer.IsMobileRequest = 1 then 'Mobile' else 'Portal' end"), "apctcustomer.IsMobileOTPVerified"=>new Zend_Db_Expr(" case when apctcustomer.IsMobileOTPVerified = 1 then 'Yes' else 'No' end"), "apctcustomer.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(apctcustomer.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)") , "edit"=> new Zend_Db_Expr("'Edit'") ));
		    $collection->getSelect()->order('apctcustomer.ID DESC');
		    $this->setCollection($collection);
		    return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns(){

		$this->addColumn('ID', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'apctcustomer.ID',
				'align'     => 'right',
				'width'    => '50px'
		));
		
		
		$this->addColumn('CustomerID', array(
		    'header'    =>Mage::helper('adminhtml')->__('CustomerID'),
		    'index'     =>'apctcustomer.CustomerID',
		    'align'     => 'right',
		    'width'    => '50px'
		));
		
		
		$this->addColumn('FirstName', array(
				'header'    =>Mage::helper('adminhtml')->__('First Name'),
				'index'     =>'apctcustomer.FirstName',
		));

		
		$this->addColumn('LastName', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'apctcustomer.LastName',
		));
		
		
		$this->addColumn('Email', array(
				'header'    =>Mage::helper('adminhtml')->__('Email'),
				'index'     =>'apctcustomer.EmailID',
		));
		
		
		$this->addColumn('MobileNumber', array(
				'header'    =>Mage::helper('adminhtml')->__('Mobile Number'),
				'index'     =>'apctcustomer.MobileNumber',
		));
		
		
		$this->addColumn('IsShowProfile', array(
		    'header'    =>Mage::helper('adminhtml')->__('Is Show Profile'),
		    'index'     =>'apctcustomer.IsShowProfile',
		    'sortable'  => false,
		    'filter'    => false,
		));
		
		
		$this->addColumn('IsMobileRequest', array(
		    'header'    =>Mage::helper('adminhtml')->__('Request From'),
		    'index'     =>'apctcustomer.IsMobileRequest',
		    'sortable'  => false,
		    'filter'    => false,
		));
		
		
		$this->addColumn('IsMobileOTPVerified', array(
		    'header'    =>Mage::helper('adminhtml')->__('Mobile OTP Verified'),
		    'index'     =>'apctcustomer.IsMobileOTPVerified',
		    'sortable'  => false,
		    'filter'    => false,
		));
		
		
		$this->addColumn('StatusID', array(
		    'header'    =>Mage::helper('adminhtml')->__('Status'),
		    'index'     =>'apctcustomer.StatusID',
		    // 'sortable'  => false,
		    // 'filter'    => false,
		    'type'  => 'options',
		    'options' => Mage::getModel(Margshri_Common_VO_Customer_CustomerStatusVO::$MODELPATH)->getResource()->getOptions()
		));
		
		$this->addColumn('CreatedAt', array(
		    'header'    => Mage::helper('adminhtml')->__('Cust CreatedAt'),
		    'index'     => 'apctcustomer.CreatedAt',
		    'type'      => 'datetime',
		    //'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		));
		
		 
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'edit',
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'common/Backend_Customer_ManageCustomer_Renderer',
		));
		return parent::_prepareColumns();
		
	}


	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

