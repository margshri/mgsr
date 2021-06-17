<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type2_CityDiamonds_CityDiamonds extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebcitydiamonds', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO $cityDiamondsVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		 
		
		// INSERT OR UPDATE 
		$cityDiamondsDTO = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO();
	
		if($cityDiamondsVO->getID() > 0){
			
			$rowSet = $cityDiamondsDTO->find( $cityDiamondsVO->getID() );
			$row    = $rowSet['_data'];
			
			$cityDiamondsVO->setUpdatedAt($serverDate);
			$cityDiamondsVO->setUpdatedBy($userID);
			
		}else{
			
			$row = $cityDiamondsDTO->fetchNew();
			
			$cityDiamondsVO->setCreatedAt($serverDate);
			$cityDiamondsVO->setCreatedBy($userID);
			$cityDiamondsVO->setUpdatedAt($serverDate);
			$cityDiamondsVO->setUpdatedBy($userID);
			
		}
	
		foreach($cityDiamondsVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}