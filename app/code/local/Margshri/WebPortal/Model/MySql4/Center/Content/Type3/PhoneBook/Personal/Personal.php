<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type3_PhoneBook_Personal_Personal extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebpersonalphonebook', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO $personalVO){
	
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		
		// INSERT OR UPDATE 
		$personalDTO = new Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO();
	
		if($personalVO->getID() > 0){
			$rowSet = $personalDTO->find( $personalVO->getID() );
			$row    = $rowSet['_data'];
			
			$personalVO->setUpdatedAt($serverDate);
			$personalVO->setUpdatedBy(1);
		}else{
			$row = $personalDTO->fetchNew();
			$personalVO->setCreatedAt($serverDate);
			$personalVO->setCreatedBy(1);
			$personalVO->setUpdatedAt($serverDate);
			$personalVO->setUpdatedBy(1);
		}
	
		foreach($personalVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}