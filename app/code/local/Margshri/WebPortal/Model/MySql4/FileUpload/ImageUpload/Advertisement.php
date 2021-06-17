<?php
class Margshri_WebPortal_Model_Mysql4_FileUpload_ImageUpload_Advertisement extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebadvertisement', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByCode($code){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('Code =?', $code);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	
	public function getByVO(Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO $advertisementVO){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		if($advertisementVO->getCountryID() != null){
			$select->where('CountryID =?', $advertisementVO->getCountryID());
		}
		if($advertisementVO->getStateID() != null){
			$select->where('StateID =?', $advertisementVO->getStateID());
		}
		if($advertisementVO->getDistrictID() != null){
			$select->where('DistrictID =?', $advertisementVO->getDistrictID());
		}
		if($advertisementVO->getCityID() != null){
			$select->where('CityID =?', $advertisementVO->getCityID());
		}
		$select->where('TypeID =?', $advertisementVO->getTypeID());
		$select->where('TableCode =?', $advertisementVO->getTableCode());
		$select->where('StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	

	public function getByMobileNumber1($mobileNumber1){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('MobileNumber1 =?', $mobileNumber1);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	 
	public function saveDB(Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO $advertisementVO, $imageFileObj=null){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		$queryAdvertisementVO =  new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
		$queryAdvertisementVO->setCountryID($advertisementVO->getCountryID());
		$queryAdvertisementVO->setStateID($advertisementVO->getStateID());
		$queryAdvertisementVO->setDistrictID($advertisementVO->getDistrictID());
		$queryAdvertisementVO->setCityID($advertisementVO->getCityID());
		$queryAdvertisementVO->setTypeID($advertisementVO->getTypeID());
		$queryAdvertisementVO->setTableCode($advertisementVO->getTableCode());
		
		// VALIDATION
		if($advertisementVO->getStateID() != null && $advertisementVO->getDistrictID() == null){
			$stateSliderDataObjs = $this->getByVO($queryAdvertisementVO);
			$stateSliderCount    = sizeof($stateSliderDataObjs);
				
			$districtModel    = Mage::getModel("webportal/Directory_DistrictList");
			$districtDataObjs = $districtModel->getResource()->getByStateID($advertisementVO->getStateID());
				
			foreach ($districtDataObjs as $districtDataObj){
				$queryAdvertisementVO->setDistrictID($districtDataObj["ID"]);
				$districtSliderDataObjs = $this->getByVO($queryAdvertisementVO);
				$districtSliderCount    = sizeof($districtSliderDataObjs);
		
				if( ($stateSliderCount+$districtSliderCount) > Margshri_WebPortal_VO_SystemConfigVO::$MAX_ADVERTISEMENT_ORDER ){
					$response['status']  = 'ERROR';
					$response['message'] = 'Exeed Limit For Advertisement';
					return $response;
				}
			}
		}
		
		
		
		if($advertisementVO->getDistrictID() != null && $advertisementVO->getCityID() == null){
			$districtSliderDataObjs = $this->getByVO($queryAdvertisementVO);
			$districtSliderCount    = sizeof($districtSliderDataObjs);
			
			$cityModel    = Mage::getModel("webportal/Directory_CityList");
			$cityDataObjs = $cityModel->getResource()->getByDistrictID($advertisementVO->getDistrictID()); 
			
			foreach ($cityDataObjs as $cityDataObj){
				$queryAdvertisementVO->setCityID($cityDataObj["ID"]);
				$citySliderDataObjs = $this->getByVO($queryAdvertisementVO);
				$citySliderCount    = sizeof($citySliderDataObjs);
				
				if( ($districtSliderCount+$citySliderCount) > Margshri_WebPortal_VO_SystemConfigVO::$MAX_ADVERTISEMENT_ORDER ){
					$response['status']  = 'ERROR';
					$response['message'] = 'Exeed Limit For Advertisement';
					return $response;
				}
			}
		}	

		
		if($advertisementVO->getCityID() != null){
			$citySliderDataObjs = $this->getByVO($queryAdvertisementVO);
			$citySliderCount    = sizeof($citySliderDataObjs);
			if($citySliderCount > Margshri_WebPortal_VO_SystemConfigVO::$MAX_ADVERTISEMENT_ORDER ){
				$response['status']  = 'ERROR';
				$response['message'] = 'Exeed Limit For Advertisement';
				return $response;
			}
		}
		
		
		// SET ADVERTISEMENT CODE
		$code = '';
		if($advertisementVO->getCountryID() != null){
			$code .=  $advertisementVO->getCountryID();
		}
		if($advertisementVO->getStateID() != null){
			$code .=  $advertisementVO->getStateID();
		}
		if($advertisementVO->getDistrictID() != null){
			$code .=  $advertisementVO->getDistrictID();
		}
		if($advertisementVO->getCityID() != null){
			$code .=  $advertisementVO->getCityID();
		}
		$code .=  $advertisementVO->getTypeID();
		$code .=  $advertisementVO->getTableCode();
		$code .=  $advertisementVO->getOrder();
		$advertisementVO->setCode($code);
		
		
		// CREATE IMAGE PATH AND SET IMAGE PATH
		if($imageFileObj != null){
			$imagePath = '';
			switch ($advertisementVO->getTypeID()){
				case Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$TOP_HEADER:
					$imagePath = 'web_portal/frontend/advertisement/header/';  
					break;
				case Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$LEFT_SIDE_BAR:
					$imagePath = 'web_portal/frontend/advertisement/left/';
					break;
				case Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$MIDDLE_BAR:
					$imagePath = 'web_portal/frontend/advertisement/middle/';
					break;
				case Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$RIGHT_SIDE_BAR:
					$imagePath = 'web_portal/frontend/advertisement/right/';
					break;
				case Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$FOOTER_BAR:
					$imagePath = 'web_portal/frontend/advertisement/footer/';
					break;
				case Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$CONTENT_BAR:
					$imagePath = 'web_portal/frontend/advertisement/content/';
					break;
					
			}
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$imagePath = $imagePath.$advertisementVO->getCode().'.'.$ext;
			$advertisementVO->setImagePath($imagePath);
		}
		 
		
		// INSERT OR UPDATE 
		$advertisementDTO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
		if($advertisementVO->getID() > 0){
			$dataObj = $this->getByCode($advertisementVO->getCode());
			if($dataObj !== false){
				$newAdvertisementDTO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
				/*  @var $newAdvertisementVO  Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO */
				$newAdvertisementVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newAdvertisementDTO, $dataObj);
				if($newAdvertisementVO->getID() != $advertisementVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			$rowSet = $advertisementDTO->find( $advertisementVO->getID() );
			$row    = $rowSet['_data'];
			$advertisementVO->setUpdatedAt($serverDate);
			$advertisementVO->setUpdatedBy($userID);
		}else{
			$dataObj = $this->getByCode($advertisementVO->getCode());
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			$row = $advertisementDTO->fetchNew();
			$advertisementVO->setCreatedAt($serverDate);
			$advertisementVO->setCreatedBy($userID);
			$advertisementVO->setUpdatedAt($serverDate);
			$advertisementVO->setUpdatedBy($userID);
		}
	
		foreach($advertisementVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		// SAVE IMAGE FILE
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
			$res = move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $advertisementVO->getImagePath());
		}
		
		//echo $helper->getServerPath() . $advertisementVO->getImagePath();
		//exit;
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}