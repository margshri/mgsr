<?php
class Margshri_WebPortal_Block_Backend_Registration_Registration_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	public function __construct(){
		parent::__construct();
		$this->setId('Registration');
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
			$dobDateFromDate = null; $dobDateToDate = null;
			$irctcUserNames = array();
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
					
					if(array_key_exists('DOB', $filterDataObjs)){
						if(array_key_exists('from', $filterDataObjs['DOB'])){
							$dobDateFromDate= date('Y-m-d', strtotime($filterDataObjs['DOB']['from']));
						}
						if(array_key_exists('to', $filterDataObjs['DOB'])){
							$dobDateToDate= date('Y-m-d', strtotime($filterDataObjs['DOB']['to']));
						}
					}
					
					if(sizeof($filterDataObjs) == 2){
						if($createdAtFromDate == null && $createdAtToDate == null &&
								$dobDateFromDate== null && $dobDateToDate== null){
									$dateFilterFlag = false;
						}
					}
				}
			}
			
			
			$collection =   Mage::getModel("webportal/Registration_Registration_Registration")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("main_table.ID"=>"main_table.ID",
			        "main_table.Name"=>"main_table.Name", "main_table.Qualification"=>"main_table.Qualification",
					"main_table.FirstName"=>"main_table.FirstName", "main_table.LastName"=>"main_table.LastName", 
					"main_table.FatherName"=>"main_table.FatherName", "main_table.DOB"=>new Zend_Db_Expr(" date(main_table.DOB) " ),
					"main_table.Gender"=>"main_table.Gender","main_table.DistrictID"=>"main_table.DistrictID",
					"main_table.MobileNumber"=>"main_table.MobileNumber","main_table.Email"=>"main_table.Email",
					"main_table.CurrentSchool"=>"main_table.CurrentSchool", "main_table.ClassID"=>"main_table.ClassID",
					"main_table.SubjectID"=>"main_table.SubjectID", "main_table.BoardID"=>"main_table.BoardID",
					"main_table.Address"=>"main_table.Address", "main_table.AddharCardNumber"=>"main_table.AddharCardNumber",
					"main_table.TransactionID"=>"main_table.TransactionID","main_table.CityID"=>"main_table.CityID",
					"main_table.IsPaid"=>"main_table.IsPaid","main_table.CreatedAt"=> new Zend_Db_Expr(" DATE_SUB(main_table.CreatedAt,INTERVAL '05:30' HOUR_MINUTE) "),
			        "main_table.RollNo"=> "main_table.RollNo", "main_table.Percentage"=> "main_table.Percentage",  
			        "main_table.ProgrammeID"=> "main_table.ProgrammeID", "main_table.UserID"=> "main_table.UserID",  
			        "main_table.edit"=> new Zend_Db_Expr("'Edit'"), "main_table.print"=> new Zend_Db_Expr("'Print'")
			    
			));
			
			if($dateFilterFlag == true){
				if($createdAtFromDate != null && $createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'") );
				}elseif($createdAtFromDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) >= '" . $createdAtFromDate . "'") );
				}elseif($createdAtToDate != null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.CreatedAt) <= '" . $createdAtToDate . "'") );
				}
				
				if($dobDateFromDate!= null && $dobDateToDate!= null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.DOB) between '" . $dobDateFromDate. "' and '" . $dobDateToDate. "'") );
				}elseif($dobDateFromDate!= null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.DOB) >= '" . $dobDateFromDate. "'") );
				}elseif($dobDateToDate!= null){
					$collection->getSelect()->where( new Zend_Db_Expr(" date(main_table.DOB) <= '" . $dobDateToDate. "'") );
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

	protected function _prepareColumns(){

		$this->addColumn('ID', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.ID',
				'align'     => 'right',
				'width'    => '50px'
		));

		$this->addColumn('CreatedAt', array(
				'header'    => Mage::helper('adminhtml')->__('Date/Time'),
				'index'     => 'main_table.CreatedAt',
				'type'      =>'datetime',
				'width'     =>'50px',
		));
		
		$this->addColumn('Name', array(
		    'header'    =>Mage::helper('adminhtml')->__('Student Name'),
		    'index'     =>'main_table.Name',
		));
		
		/*
		$this->addColumn('FirstName', array(
				'header'    =>Mage::helper('adminhtml')->__('First Name'),
				'index'     =>'main_table.FirstName',
		));

		$this->addColumn('LastName', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'main_table.LastName',
		));
		*/
		
		$this->addColumn('FatherName', array(
				'header'    =>Mage::helper('adminhtml')->__('Father Name'),
				'index'     =>'main_table.FatherName',
		));
		
		/*
		$this->addColumn('DOB', array(
				'header'    => Mage::helper('adminhtml')->__('DOB'),
				'index'     => 'main_table.DOB',
				'type'      =>'date',
				'width'     =>'50px',
		));
		
		$genderOption = array("1"=>"Male", "2"=>"Female");
		$this->addColumn('Gender', array(
				'header'    =>Mage::helper('adminhtml')->__('Gender'),
				'type'  => 'options',
				'index' => 'main_table.Gender',
				'options' =>$genderOption
		));
		*/
		
		
		$this->addColumn('MobileNumber', array(
				'header'    =>Mage::helper('adminhtml')->__('Mobile Number'),
				'index'     =>'main_table.MobileNumber',
		));
		
		/*
		$this->addColumn('Email', array(
				'header'    =>Mage::helper('adminhtml')->__('Email'),
				'index'     =>'main_table.Email',
		));
		
		
		$this->addColumn('RollNo', array(
				'header'    =>Mage::helper('adminhtml')->__('RollNo'),
				'index'     =>'main_table.RollNo',
		));
		
		
		$isPaid = array("0"=>"No", "1"=>"Yes");
		$this->addColumn('IsPaid', array(
				'header'    =>Mage::helper('adminhtml')->__('IsPaid'),
				'type'  => 'options',
				'index' => 'main_table.IsPaid',
				'options' =>$isPaid
		));
		
		$this->addColumn('CurrentSchool', array(
				'header'    =>Mage::helper('adminhtml')->__('Current School'),
				'index'     =>'main_table.CurrentSchool',
		));
		*/
		
		
		
		$genderOption = array("1"=>"Male", "2"=>"Female");
		$this->addColumn('Gender', array(
		    'header'    =>Mage::helper('adminhtml')->__('Gender'),
		    'type'  => 'options',
		    'index' => 'main_table.Gender',
		    'options' =>$genderOption
		));
		
		
		$classOption = array("1"=>"5th", "2"=>"8th", "3"=>"10th", "4"=>"12th", "5"=>"Graduation", "6"=>"Post Graduation", "7"=>"Other");
		$this->addColumn('ClassID', array(
				'header'    =>Mage::helper('adminhtml')->__('Passad <br /> Class'),
				'type'  => 'options',
				'index' => 'main_table.ClassID',
				'options' =>$classOption
		));
		
		$this->addColumn('Qualification', array(
		    'header'    =>Mage::helper('adminhtml')->__('Detail'),
		    'index'     =>'main_table.Qualification',
		));
		
		
		$this->addColumn('Percentage', array(
		    'header'    =>Mage::helper('adminhtml')->__('Percentage'),
		    'index'     =>'main_table.Percentage',
		));
		
		
		/* 
		$subjectOption = array("1"=>"General", "2"=>"Commerce", "3"=>"Science", "4"=>"CA-CPT-PCC");
		$this->addColumn('SubjectID', array(
				'header'    =>Mage::helper('adminhtml')->__('Subject'),
				'type'  => 'options',
				'index' => 'main_table.SubjectID',
				'options' =>$subjectOption
		));
		
		 
		
		$boardOption = array("1"=>"CBSE", "2"=>"ICSE", "3"=>"Other");
		$this->addColumn('BoardID', array(
				'header'    =>Mage::helper('adminhtml')->__('Board'),
				'type'  => 'options',
				'index' => 'main_table.BoardID',
				'options' =>$boardOption
		));
		
		
		
		$this->addColumn('AddharCardNumber', array(
				'header'    =>Mage::helper('adminhtml')->__('AddharCardNumber'),
				'index'     =>'main_table.AddharCardNumber',
		));
		*/
		
		$this->addColumn('TransactionID', array(
				'header'    =>Mage::helper('adminhtml')->__('Registration <br /> Number'),
				'index'     =>'main_table.TransactionID',
		));
		
		
		$this->addColumn('ProgrammeID', array(
		    'header'    =>Mage::helper('adminhtml')->__('Programme'),
		    'type'  => 'options',
		    'index' => 'main_table.ProgrammeID',
		    'options' => Mage::getModel(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName)->getResource()->getOptions()
		));
		
		
		$this->addColumn('UserID', array(
		    'header'    =>Mage::helper('adminhtml')->__('User'),
		    'type'  => 'options',
		    'index' => 'main_table.UserID',
		    'options' => Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName)->getResource()->getGridOptions()
		));
		
		
		$this->addColumn('Address', array(
				'header'    =>Mage::helper('adminhtml')->__('Address'),
				'index'     =>'main_table.Address',
		));
		
		$this->addColumn('CityID', array(
				'header'    =>Mage::helper('adminhtml')->__('City'),
				'type'  => 'options',
				'index' => 'main_table.CityID',
				'options' => Mage::getModel('webportal/Directory_CityList')->getResource()->getGridOptions()
		));
		
		$isRejectedOptions = array(1=>"NO", 2=>"YES");
		$this->addColumn('IsPaid', array(
		    'header'    =>Mage::helper('adminhtml')->__('Is Rejected'),
		    'type'  => 'options',
		    'index' => 'main_table.IsPaid',
		    'options' => $isRejectedOptions
		));
		
		
		/*
		$this->addColumn('DistrictID', array(
				'header'    =>Mage::helper('adminhtml')->__('District'),
				'type'  => 'options',
				'index' => 'main_table.DistrictID',
				'options' => Mage::getModel('webportal/Directory_DistrictList')->getResource()->getGridOptions()
		));
		*/
		
		$this->addColumn('Edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit',
				'align'     => 'left',
				'width'     => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Registration_Registration_Renderer',
		));
		
		
		$this->addColumn('Print', array(
		    'header'    =>Mage::helper('adminhtml')->__('Print'),
		    'index'     =>'main_table.print',
		    'align'     => 'left',
		    'width'     => '50px',
		    'sortable'  => false,
		    'filter'    => false,
		    'renderer'  => 'webportal/Backend_Registration_Registration_Renderer',
		));
		
		
// 		$this->addColumn('StatusID', array(
// 				'header'    =>Mage::helper('adminhtml')->__('Status'),
// 				'type'  => 'options',
//                 'index' => 'status.ID',
//                 'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
// 		));

		
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

