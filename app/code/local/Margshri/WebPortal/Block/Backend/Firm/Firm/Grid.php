<?php
class Margshri_WebPortal_Block_Backend_Firm_Firm_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	protected $currentOfficeVO;
	
	public function __construct(){
		parent::__construct();
		$this->setId('firm');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
		$this->currentOfficeVO = Mage::helper('webportal/Data')->getCurrentOfficeVO();
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
						if($createdAtFromDate == null && $createdAtToDate == null &&
								$updatedDateFromDate == null && $updatedDateToDate == null){
							$dateFilterFlag = false;
						}
					}
				}
			}
			

			$collection =   Mage::getModel("webportal/Firm_Firm_Firm")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID", "main_table.Value"=>"main_table.Value" , "main_table.TableCodes"=> "main_table.TableCodes", 
					"main_table.Address"=> "main_table.Address", "main_table.LandLineNumber"=> "main_table.LandLineNumber",
					"main_table.SortName"=> "main_table.SortName", "main_table.ContactPersonName"=> "main_table.ContactPersonName",
					"main_table.Area"=> "main_table.Area", "main_table.CustomerCareNumber"=> "main_table.CustomerCareNumber",
					"main_table.EmergencyNumber"=> "main_table.EmergencyNumber", "main_table.TollFree"=> "main_table.TollFree",
					"main_table.WebsiteLink"=> "main_table.WebsiteLink", "main_table.Email"=> "main_table.Email",
					"main_table.MobileNumber1"=> "main_table.MobileNumber1", "main_table.MobileNumber2"=> "main_table.MobileNumber2",
					"main_table.PinCode"=> "main_table.PinCode", "main_table.StateID"=>"main_table.StateID", "main_table.CityID"=>"main_table.CityID",
					"main_table.DistrictID"=> "main_table.DistrictID", "main_table.SubPageTableCode"=>"main_table.SubPageTableCode", 
					"main_table.IsPaid"=>new Zend_Db_Expr(" ifnull(main_table.IsPaid,0) "), "main_table.edit"=> new Zend_Db_Expr("'Edit'") , 
					"main_table.SubPage"=> new Zend_Db_Expr(" case when main_table.IsPaid = 1 then 'Sub Page' else '' end "),
					"main_table.CreatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE)"),
					"main_table.UpdatedAt"=> new Zend_Db_Expr("  DATE_SUB(main_table.UpdatedAt,INTERVAL '05:30' HOUR_MINUTE)") ));
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'main_table.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
			
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			$collection->getSelect()->joinLeft(array("createdby"=>$collection->getTable('webportal/adminuser')), 'main_table.CreatedBy = createdby.user_id', array("createdby.firstname"=>"createdby.firstname"));
			$collection->getSelect()->joinLeft(array("updatedby"=>$collection->getTable('webportal/adminuser')), 'main_table.UpdatedBy = updatedby.user_id', array("updatedby.firstname"=>"updatedby.firstname"));
			
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

		$this->addColumn('SortName', array(
				'header'    =>Mage::helper('adminhtml')->__('Sort Name'),
				'index'     =>'main_table.SortName',
		));
		
		$this->addColumn('ContactPersonName', array(
				'header'    =>Mage::helper('adminhtml')->__('Contact <br /><br /> PersonName'),
				'index'     =>'main_table.ContactPersonName',
		));
		
		
		
		
		
		$this->addColumn('Email', array(
				'header'    =>Mage::helper('adminhtml')->__('Email'),
				'index'     =>'main_table.Email',
				'width'    => '200px',
				'renderer'  => 'webportal/Backend_Firm_Firm_Renderer',
		));
		
		
		$this->addColumn('MobileNumber1', array(
				'header'    =>Mage::helper('adminhtml')->__('Mobile <br />Number1'),
				'index'     =>'main_table.MobileNumber1',
		));
		
		
		$this->addColumn('MobileNumber2', array(
				'header'    =>Mage::helper('adminhtml')->__('Mobile <br />Number2'),
				'index'     =>'main_table.MobileNumber2',
		));
		
		
		$this->addColumn('Area', array(
				'header'    =>Mage::helper('adminhtml')->__('Area'),
				'index'     =>'main_table.Area',
		));
		
		$this->addColumn('PinCode', array(
				'header'    =>Mage::helper('adminhtml')->__('Pin<br/>Code'),
				'index'     =>'main_table.PinCode',
		));
		
		
		$this->addColumn('StateID', array(
				'header'    =>Mage::helper('adminhtml')->__('State'),
				'type'  => 'options',
				'index' => 'main_table.StateID',
				'options' => Mage::getModel('webportal/Directory_StateList')->getResource()->getGridOptions()
		));
		
		
		$this->addColumn('DistrictID', array(
				'header'    =>Mage::helper('adminhtml')->__('District'),
				'type'  => 'options',
				'index' => 'main_table.DistrictID',
				'options' => Mage::getModel('webportal/Directory_DistrictList')->getResource()->getGridOptions()
		));
		
		
		$this->addColumn('CityID', array(
				'header'    =>Mage::helper('adminhtml')->__('City'),
				'type'  => 'options',
				'index' => 'main_table.CityID',
				'options' => Mage::getModel('webportal/Directory_CityList')->getResource()->getGridOptions()
		));
		
		
		$this->addColumn('TableCodes', array(
				'header'    =>Mage::helper('adminhtml')->__('Table Codes'),
				'index'     =>'main_table.TableCodes',
				'width'    => '100px',
				'renderer'  => 'webportal/Backend_Firm_Firm_Renderer',
		));
				
		
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
				'renderer'  => 'webportal/Backend_Firm_Firm_Renderer',
				
		));
	
		
		$this->addColumn('SubPage', array(
				'header'    =>Mage::helper('adminhtml')->__('Sub Page'),
				'index'     =>'main_table.SubPage',
				'align'     => 'left',
				'width'     => '100px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Firm_Firm_Renderer',
		
		));
		
		$isHaveSubPageOptions = array("NO","YES"); 
		$this->addColumn('IsPaid', array(
				'header'    =>Mage::helper('adminhtml')->__('IsPaid'),
				'type'  => 'options',
                'index' => 'main_table.IsPaid',
                'options' => $isHaveSubPageOptions
		
		));
		
		
		$this->addColumn('CustomerCareNumber', array(
				'header'    =>Mage::helper('adminhtml')->__('Customer <br /><br /> CareNumber'),
				'index'     =>'main_table.CustomerCareNumber',
		));
		
		$this->addColumn('EmergencyNumber', array(
				'header'    =>Mage::helper('adminhtml')->__('Emergency <br /><br /> Number'),
				'index'     =>'main_table.EmergencyNumber',
		));
		
		$this->addColumn('TollFree', array(
				'header'    =>Mage::helper('adminhtml')->__('Toll Free'),
				'index'     =>'main_table.TollFree',
		));
		
		$this->addColumn('WebsiteLink', array(
				'header'    =>Mage::helper('adminhtml')->__('Website <br /><br /> Link'),
				'index'     =>'main_table.WebsiteLink',
		));
		
		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Created <br /> Date'),
				'index'     => 'main_table.CreatedAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		$this->addColumn('CreatedBy', array(
				'header'    => Mage::helper('adminhtml')->__('Created By'),
				'index'     => 'createdby.firstname',
		));
		
		
		$this->addColumn('UpdatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Updated <br /> Date'),
				'index'     => 'main_table.UpdatedAt',
				'type'      => 'datetime',
				'width'     => '50px',
		));
		
		
		$this->addColumn('UpdatedBy', array(
				'header'    => Mage::helper('adminhtml')->__('Updated By'),
				'index'     => 'updatedby.firstname',
		));
		
		$this->addExportType('*/*/export/ExportType/xls', 'xls');
		$this->addExportType('*/*/export/ExportType/xlsx', 'xlsx');

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

