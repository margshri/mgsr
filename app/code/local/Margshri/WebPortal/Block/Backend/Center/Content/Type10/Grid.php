<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type10_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	protected $currentOfficeVO;
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('managedata');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
		$this->currentOfficeVO = Mage::helper('webportal/Data')->getCurrentOfficeVO();
	}

	protected function _prepareCollection()
	{
		try{
			
			$collection =   Mage::helper('webportal/Data')->getType10Model($this->getTableCode())->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.Value"=>"main_table.Value" , "main_table.DistrictID"=> "main_table.DistrictID", "main_table.edit"=> new Zend_Db_Expr("'Edit'"), "main_table.SubPage"=> new Zend_Db_Expr(" case when main_table.IsPaid = 1 then 'Sub Page' else '' end ") ));
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'main_table.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
			$collection->getSelect()->joinLeft(array("type"=>$collection->getTable('webportal/'.$this->getTableCode().'type')), 'main_table.TypeID = type.ID', array("type.ID"=>"type.ID", "type.Value"=>"type.Value"));
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			
			if($this->currentOfficeVO->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$COUNTRY_TYPE){
				$collection->getSelect()->where('main_table.CountryID =?', $this->currentOfficeVO->getCountryID());
			}
			
			if($this->currentOfficeVO->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$STATE_TYPE){
				$collection->getSelect()->where('main_table.CountryID =?', $this->currentOfficeVO->getCountryID());
				$collection->getSelect()->where('main_table.StateID =?', $this->currentOfficeVO->getStateID());
			}
			
			if($this->currentOfficeVO->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$DISTRICT_TYPE){
				$collection->getSelect()->where('main_table.CountryID =?', $this->currentOfficeVO->getCountryID());
				$collection->getSelect()->where('main_table.StateID =?', $this->currentOfficeVO->getStateID());
				$collection->getSelect()->where('main_table.DistrictID =?', $this->currentOfficeVO->getDistrictID());
			}
			
			if($this->currentOfficeVO->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$CITY_TYPE){
				$collection->getSelect()->where('main_table.CountryID =?', $this->currentOfficeVO->getCountryID());
				$collection->getSelect()->where('main_table.StateID =?', $this->currentOfficeVO->getStateID());
				$collection->getSelect()->where('main_table.DistrictID =?', $this->currentOfficeVO->getDistrictID());
				$collection->getSelect()->where('main_table.CityID =?', $this->currentOfficeVO->getCityID());
				
			}
			
			$collection->getSelect()->Order('main_table.ID Desc');
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

		
		$this->addColumn('Name', array(
				'header'    =>Mage::helper('adminhtml')->__('Name'),
				'index'     =>'main_table.Value',
		));
		
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Type'),
				'type'  => 'options',
				'index' => 'type.ID',
				'options' => Mage::helper('webportal/Data')->getType10TypeModel($this->getTableCode())->getResource()->getOptions($this->getTableCode())
		));
		
		if($this->currentOfficeVO->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$MAIN_OFFICE_TYPE){
			$this->addColumn('DistrictID', array(
					'header'    =>Mage::helper('adminhtml')->__('District'),
					'type'  => 'options',
					'index' => 'main_table.DistrictID',
					'options' => Mage::getModel('webportal/Directory_DistrictList')->getResource()->getGridOptions()
			));
		}
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
                'index' => 'status.ID',
                'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
		));
		
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'tablecode' => $this->getTableCode(),
				'renderer'  => 'webportal/Backend_Center_Content_Type10_Renderer',
				
		));
				

		$this->addColumn('SubPage', array(
				'header'    =>Mage::helper('adminhtml')->__('Sub Page'),
				'index'     =>'main_table.SubPage',
				'align'     => 'left',
				'width'     => '100px',
				'sortable'  => false,
				'filter'    => false,
				'tablecode' => $this->getTableCode(),
				'renderer'  => 'webportal/Backend_Center_Content_Type10_Renderer',
		
		));
		
		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('TableCode'=>$this->getTableCode(),  '_current'=>true));
	}


}

