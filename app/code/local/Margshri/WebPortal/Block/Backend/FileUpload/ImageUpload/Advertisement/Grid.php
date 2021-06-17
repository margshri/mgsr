<?php
class Margshri_WebPortal_Block_Backend_FileUpload_ImageUpload_Advertisement_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	protected $currentOfficeVO;
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('fileupload');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
		$this->currentOfficeVO = Mage::helper('webportal/Data')->getCurrentOfficeVO();
	}

	protected function _prepareCollection()
	{
		try{
			$collection =  Mage::getModel("webportal/FileUpload_ImageUpload_Advertisement")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.Value"=>"main_table.Value", "main_table.Order"=>"main_table.Order", "main_table.IsTemp"=>"main_table.IsTemp", "main_table.EndDate"=>"main_table.EndDate",  "main_table.DistrictID"=> "main_table.DistrictID", "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("type"=>$collection->getTable('webportal/apctwebadvertisementtype')), 'main_table.TypeID = type.ID', array("type.ID"=>"type.ID", "type.Value"=>"type.Value"));
			$collection->getSelect()->joinLeft(array("table"=>$collection->getTable('webportal/apctwebtable')), 'main_table.TableCode = table.Code', array("table.ID"=>"table.ID", "table.FileName"=>"table.FileName"));
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'main_table.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
			
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

		$this->addColumn('EndDate', array(
				'header' => Mage::helper('adminhtml')->__('End Date'),
				'index' => 'main_table.EndDate',
				'type' => 'datetime',
				'width' => '100px',
		));
		
		
		$this->addColumn('Value', array(
				'header'    =>Mage::helper('adminhtml')->__('Name'),
				'index'     =>'main_table.Value',
		));
		
		 
		
		
		$this->addColumn('Order', array(
				'header'    =>Mage::helper('adminhtml')->__('Order'),
				'index'     =>'main_table.Order',
		));
		
		
		if($this->currentOfficeVO->getTypeID() == Margshri_WebPortal_VO_Master_Office_OfficeTypeVO::$MAIN_OFFICE_TYPE){
			$this->addColumn('DistrictID', array(
					'header'    =>Mage::helper('adminhtml')->__('District'),
					'type'  => 'options',
					'index' => 'main_table.DistrictID',
					'options' => Mage::getModel('webportal/Directory_DistrictList')->getResource()->getGridOptions()
			));
		}
		
		
		$this->addColumn('PageName', array(
				'header'    =>Mage::helper('adminhtml')->__('Page Name'),
				'type'  => 'options',
				'index' => 'table.ID',
				'options' => Mage::getModel('webportal/Master_Table_Table')->getResource()->getOptionsForGrid()
		));
		
		$this->addColumn('TypeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Type'),
				'type'  => 'options',
                'index' => 'type.ID',
                'options' => Mage::getModel('webportal/FileUpload_ImageUpload_AdvertisementType')->getResource()->getOptions()
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
                'index' => 'status.ID',
                'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
		));
		
		$isTempOptions = array(0=>"NO", 1=>"YES");
		$this->addColumn('IsTemp', array(
				'header'    =>Mage::helper('adminhtml')->__('Is Temp'),
				'type'  => 'options',
				'index' => 'main_table.IsTemp',
				'options' => $isTempOptions
		));
		
		$this->addColumn('edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'    => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_FileUpload_ImageUpload_Advertisement_Renderer',
				
		));
					

		return parent::_prepareColumns();
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}

}