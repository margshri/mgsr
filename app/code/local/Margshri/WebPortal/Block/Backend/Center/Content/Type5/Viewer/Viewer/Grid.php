<?php 
class Margshri_WebPortal_Block_Backend_Center_Content_Type5_Viewer_Viewer_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	protected $currentOfficeVO;
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('viewer');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
		$this->currentOfficeVO = Mage::helper('webportal/Data')->getCurrentOfficeVO();
	}

	protected function _prepareCollection()
	{
		try{
			
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5);
			
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7);
			
			$customerImageCollection = Mage::getModel('customer/customer')->getCollection();
			$customerImageQuery = $customerImageCollection->getSelect()->reset()->from(array("main_table"=>$customerImageCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 140);
			
			
			$customerPermanentAddressCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPermanentAddressQuery = $customerPermanentAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressCollection->getTable("webportal/customeraddressentity"), array("entity_id", "parent_id") ))
			->joinLeft(array("cei"=>$customerPermanentAddressCollection->getTable("webportal/customerentityint")), "main_table.entity_id=cei.value" ,array("value_id"))
			->where('cei.attribute_id =?', 160);
			
	
			$customerPAStreetCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPAStreetQuery = $customerPAStreetCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
			->joinLeft(array("caet"=>$customerPAStreetCollection->getTable("webportal/customeraddressentitytext") ), "main_table.entity_id=caet.entity_id", array("value") )
			->where('caet.attribute_id =?', 25);
			
			
			$customerPACityCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPACityQuery = $customerPACityCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
			->joinLeft(array("caev"=>$customerPACityCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
			->where('caev.attribute_id =?', 158);
			
			$customerPADistrictCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPADistrictQuery = $customerPADistrictCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
			->joinLeft(array("caev"=>$customerPADistrictCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
			->where('caev.attribute_id =?', 157);
			
			$customerPAStateCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPAStateQuery = $customerPAStateCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
			->joinLeft(array("caev"=>$customerPAStateCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
			->where('caev.attribute_id =?', 156);
			
			$customerPACountryCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPACountryQuery = $customerPACountryCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
			->joinLeft(array("caev"=>$customerPACountryCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
			->where('caev.attribute_id =?', 155);
			
			$customerPAPinCodeCollection = Mage::getModel('customer/customer')->getCollection();
			$customerPAPinCodeQuery = $customerPAPinCodeCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
			->joinLeft(array("caev"=>$customerPAPinCodeCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
			->where('caev.attribute_id =?', 30);
			
			$customerCollection = Mage::getModel('customer/customer')->getCollection();
			$customerQuery = $customerCollection->getSelect()->reset()->from(array("main_table"=>$customerCollection->getTable("webportal/customerentity")), array("entity_id","email") )
			->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"))
			->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"))
			->joinLeft(array("address"=>$customerPAStreetQuery), "main_table.entity_id = address.parent_id", array("Address"=>"address.value"))
			->joinLeft(array("city"=>$customerPACityQuery), "main_table.entity_id = city.parent_id", array("CityName"=>"city.value"))
			->joinLeft(array("district"=>$customerPADistrictQuery), "main_table.entity_id = district.parent_id", array("DistrictName"=>"district.value"))
			->joinLeft(array("state"=>$customerPAStateQuery), "main_table.entity_id = state.parent_id", array("StateName"=>"state.value"))
			->joinLeft(array("country"=>$customerPACountryQuery), "main_table.entity_id = country.parent_id", array("CountryName"=>"country.value"))
			->joinLeft(array("pincode"=>$customerPAPinCodeQuery), "main_table.entity_id = pincode.parent_id", array("PinCode"=>"pincode.value"))
			->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"));
			
	
			$viewCollection = Mage::getModel('webportal/Center_Content_Type5_Viewer_Viewer')->getCollection();
			$viewQuery =  $viewCollection->getSelect()->reset()->from(array("main_table"=>$viewCollection->getMainTable()), array("CustomerID"=>"main_table.CreatedBy", "LastViewDate" => new Zend_Db_Expr(" MAX(main_table.CreatedAt) ")) )
			->group("main_table.CreatedBy");
			
			
			$collection = Mage::getModel('webportal/Center_Content_Type5_Viewer_Viewer')->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.Value"=>"main_table.Value", "StatusID"=>"main_table.ID", "CurrentCustomerID" => "main_table.CreatedBy" , "main_table.edit"=> new Zend_Db_Expr("'Edit'") ) );
			$collection->getSelect()->joinLeft(array("customer"=>$customerQuery), "main_table.CreatedBy = customer.entity_id");
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctwebviewerstatus')), "main_table.StatusID = status.ID", array("status.ID"=>"status.ID"));
			
			//$collection->getSelect()->joinInner(array("view"=>$viewQuery), "main_table.CreatedBy = view.CustomerID and main_table.CreatedAt = view.LastViewDate");
			$collection->getSelect()->order("main_table.ID desc");
			$this->setCollection($collection);
			
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns()
	{

		$this->addColumn('ID', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.ID',
				'align'     => 'right',
				'width'    => '50px'
		));

		$this->addColumn('FirstName', array(
				'header'    =>Mage::helper('adminhtml')->__('First Name'),
				'index'     =>'FirstName',
				'filter'    => false
		));
		
		$this->addColumn('LastName', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'LastName',
				'filter'    => false
		));
		
		
		$this->addColumn('Address', array(
				'header'    =>Mage::helper('adminhtml')->__('Address'),
				'index'     =>'Address',
				'filter'    => false
		));
		
		
		$this->addColumn('View', array(
				'header'    =>Mage::helper('adminhtml')->__('View'),
				'index'     =>'main_table.Value',
		));
		
		/*
		
		
		$this->addColumn('Code', array(
				'header'    =>Mage::helper('adminhtml')->__('Code'),
				'index'     =>'main_table.Code',
		));
		
		$this->addColumn('EventDate', array(
				'header'    =>Mage::helper('adminhtml')->__('Event Date'),
				'index'     =>'main_table.EventDate',
		));

		$this->addColumn('LaunchDate', array(
				'header'    =>Mage::helper('adminhtml')->__('Launch Date'),
				'index'     =>'main_table.LaunchDate',
		));
		
		$this->addColumn('EndDate', array(
				'header'    =>Mage::helper('adminhtml')->__('End Date'),
				'index'     =>'main_table.EndDate',
		));
		*/
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
                'index' => 'status.ID',
                'options' => Mage::getModel('webportal/Center_Content_Type5_Viewer_ViewerStatus')->getResource()->getOptions()
		));
		
		
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Center_Content_Type5_Viewer_Viewer_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

