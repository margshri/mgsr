<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type5_Viewer_Viewer extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebviewer', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO $viewerVO){
	
		$response = array();
		
		// INSERT OR UPDATE 
		$viewerDTO = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
	
		if($viewerVO->getID() > 0){
			$rowSet = $viewerDTO->find( $viewerVO->getID() );
			$row    = $rowSet['_data'];
		}else{
			$row = $viewerDTO->fetchNew();
		}
	
		foreach($viewerVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	public function updateDB(Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO $viewerVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// UPDATE
		$viewerDTO = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO;
	
		if($viewerVO->getID() > 0){
			$rowSet = $viewerDTO->find( $viewerVO->getID());
			$row    = $rowSet['_data'];
	
			$viewerVO->setUpdatedAt($serverDate);
			$viewerVO->setUpdatedBy($userID);
			
			foreach($viewerVO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
			$row->save();
	
			$response['status']  = 'SUCCESS';
			$response['message'] = 'Successfully Saved';
		}else{
			$response['status']  = 'ERROR';
			$response['message'] = ' Not Saved';
		}
		return $response;
	
	}
	
}