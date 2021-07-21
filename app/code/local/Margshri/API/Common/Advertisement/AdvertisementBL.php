<?php

class Margshri_API_Common_Advertisement_AdvertisementBL{
    
    public static function getAdvertisement(){
		header('Content-Type: application/json');
		$message = "";
      try{    
          
            $request_body = file_get_contents('php://input');
            $jsonObj = json_decode($request_body);
            
            if(!isset($jsonObj->DataList)){
                // $result =array("status"=>"fail",'error'=>'DataList parameter not found');
                $result =array("status"=>"fail",'error'=>$request_body);
                echo json_encode($result);
                return;
            }
            $reqDataObj = $jsonObj->DataList;
            
            if($reqDataObj == null){
                $result =array("status"=>"fail",'error'=>'DataList parameter not found');
                echo json_encode($result);
                return;
            }
            
            if($reqDataObj->StoreId == null){
                $result =array("status"=>"fail",'error'=>'StoreId parameter not found');
                echo json_encode($result);
                return;
            }
            
            
            if($reqDataObj->TypeId == null){
                $result =array("status"=>"fail",'error'=>'Type parameter not found');
                echo json_encode($result);
                return;
            }
            
            if($reqDataObj->TableCode == null){
                $result =array("status"=>"fail",'error'=>'Code parameter not found');
                echo json_encode($result);
                return;
            }
            
            $advertisementDTO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
            
            $advertisementDTO->setTypeID($reqDataObj->TypeId);
            $advertisementDTO->setTableCode($reqDataObj->TableCode);
            $model = Mage::getModel("webportal/FileUpload_ImageUpload_Advertisement");
            $dataObjs = $model->getResource()->getByVO($advertisementDTO);
            
            
            $dataList = array();
            if(sizeof($dataObjs)){
                foreach ($dataObjs as $dataObj){
                    $data = array();
                    $newAdvertisementDTO = new Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO();
                    /* @var $newAdvertisementVO Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementVO */
                    $newAdvertisementVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newAdvertisementDTO, $dataObj);
                
                    $data['imagePath'] = $newAdvertisementVO->getImagePath();
                    $data['websiteLink'] = $newAdvertisementVO->getWebsiteLink();
                    $data['order'] = $newAdvertisementVO->getOrder();
                    $data['tableCode'] = $newAdvertisementVO->getTableCode();
                    
                    $dataList[] = $data;
                }
            }
	 	    
            $result=array("status"=>"success", 'message'=>array("successfully fetched"), 'dataList'=> $dataList );
			
			 
			echo json_encode($result);
		}catch(Exception $e){
			$message="Please contact to administrator";
			$result=array("status"=>"fail", 'message'=>array($message), 'dataList'=>array());
			echo json_encode($result);
		}
		exit(0);

	}
}

?>
