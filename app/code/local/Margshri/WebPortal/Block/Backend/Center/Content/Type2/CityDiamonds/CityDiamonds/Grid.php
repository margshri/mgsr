<?php 
class Margshri_WebPortal_Block_Backend_Center_Content_Type2_CityDiamonds_CityDiamonds_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('citydiamonds');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
	}

	protected function _prepareCollection()
	{
		try{
			
			$collection = Mage::getResourceModel('customer/customer_collection')
			->addNameToSelect()
			->addAttributeToSelect('email')
			->addAttributeToSelect('mobilenumber')
			->addAttributeToSelect('created_at')
			->addAttributeToSelect('group_id')
			->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
			->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
			->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
			->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
			->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left');
				
			$customerAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
			$customerAddressQuery = $customerAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
			->joinLeft(array("country"=>$customerAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
			->joinLeft(array("state"=>$customerAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
			->joinLeft(array("district"=>$customerAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
			->joinLeft(array("city"=>$customerAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
			->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$RESIDENCE_ADDRESS);
			
			$collection->getSelect()->joinLeft(array("citydiamonds"=>$collection->getTable("webportal/apctwebcitydiamonds")), "e.entity_id = citydiamonds.CustomerID", array("citydiamonds.ID" =>"citydiamonds.ID", "citydiamonds.edit"=> new Zend_Db_Expr("'Edit'")) );
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable("webportal/apctstatus")), "citydiamonds.StatusID = status.ID", array("status.ID" =>"status.ID", "status.Value" =>"status.Value") );
			$collection->getSelect()->joinLeft(array("address"=>$customerAddressQuery), "e.entity_id = address.CustomerID", array("Address"=>"address.Address", "CityName"=>"address.CityName", "CityCode"=>"address.CityCode", "DistrictName" => "address.DistrictName", "DistrictCode" => "address.DistrictCode", "StateName"=>"address.StateName", "CountryName"=>"address.CountryName"  ));
			$collection->getSelect()->order("e.entity_id desc");
			$this->setCollection($collection);
			
			/*
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5);
			
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7);
			
			$customerImageCollection = Mage::getModel('customer/customer')->getCollection();
			$customerImageQuery = $customerImageCollection->getSelect()->reset()->from(array("main_table"=>$customerImageCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 140);
				
			$collection = Mage::getModel('customer/customer')->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable("webportal/customerentity")), array("main_table.entity_id"=>"main_table.entity_id", "main_table.email"=>"main_table.email", "main_table.edit"=> new Zend_Db_Expr("'Edit'") ) );
			$collection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("firstname.value"=>"firstname.value"));
			$collection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("lastname.value"=>"lastname.value"));
			$collection->getSelect()->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("customerimage.value"=>"customerimage.value"));
			$collection->getSelect()->joinLeft(array("citydiamonds"=>$collection->getTable("webportal/apctwebcitydiamonds")), "main_table.entity_id = citydiamonds.CustomerID", array("citydiamonds.ID" =>"citydiamonds.ID") );
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable("webportal/apctstatus")), "citydiamonds.StatusID = status.ID", array("status.ID" =>"status.ID", "status.Value" =>"status.Value") );
			$collection->getSelect()->order("main_table.entity_id desc");
			$this->setCollection($collection);
			*/
			
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns()
	{
		$this->addColumn('entity_id', array(
				'header'    => Mage::helper('customer')->__('ID'),
				'width'     => '50px',
				'index'     => 'entity_id',
				//'type'  => 'number',
		));
		
		$this->addColumn('firstname', array(
				'header'    => Mage::helper('customer')->__('First Name'),
				'index'     => 'firstname'
		));
		
		$this->addColumn('lastname', array(
				'header'    => Mage::helper('customer')->__('Last Name'),
				'index'     => 'lastname'
		));
		
		/*
		 $this->addColumn('name', array(
		 'header'    => Mage::helper('customer')->__('Name'),
		 'index'     => 'name'
		 ));
		 */
		
		$this->addColumn('mobilenumber', array(
				'header'    => Mage::helper('customer')->__('Mobile No'),
				'width'     => '150',
				'index'     => 'mobilenumber'
		));
		
		$this->addColumn('email', array(
				'header'    => Mage::helper('customer')->__('Email'),
				'width'     => '150',
				'index'     => 'email'
		));
		
		
		$this->addColumn('CityName', array(
				'header'    => Mage::helper('customer')->__('City'),
				'width'     => '150',
				'filter'    => false,
				'index'     => 'CityName'
		));
		
		
		$this->addColumn('DistrictName', array(
				'header'    => Mage::helper('customer')->__('District'),
				'width'     => '150',
				'filter'    => false,
				'index'     => 'DistrictName'
		));
		
		
		$this->addColumn('StateName', array(
				'header'    => Mage::helper('customer')->__('State'),
				'width'     => '150',
				'filter'    => false,
				'index'     => 'StateName'
		));
		
		
		
		$this->addColumn('created_at', array(
				'header'    => Mage::helper('customer')->__('Created Date'),
				'width'     => '150',
				'index'     => 'created_at'
		));
		
			
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
				'index' => 'status.ID',
				'filter'    => false,
				'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
		));
		
		
		
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'citydiamonds.edit',
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Center_Content_Type2_CityDiamonds_CityDiamonds_Renderer',
		
		));
		
		
		/*
		$this->addColumn('entity_id', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.entity_id',
				'align'     => 'right',
				'width'    => '50px',
				'filter'    => false,
		));

		
		$this->addColumn('firstname', array(
				'header'    =>Mage::helper('adminhtml')->__('First Name'),
				'index'     =>'firstname.value',
				'filter'    => false,
		));
		
		
		$this->addColumn('lastname', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'lastname.value',
				'filter'    => false,
		));
		
		 
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
                'index' => 'status.ID',
				'filter'    => false,
                'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
		));
		
		
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Center_Content_Type2_CityDiamonds_CityDiamonds_Renderer',
				
		));
		*/

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

