<?php
class Margshri_WebPortal_Block_Frontend_Center_SubPage_Type2_MemberList extends Mage_Core_Block_Template{
	
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function getSubPageArray(){
		return Mage::registry("CurrentSubPageVOs");
	}
	
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}
	
	
	public function getRecordID(){
		return Mage::registry("RecordID");
	}
	
	
	public function getTableCode(){
		return Mage::registry("TableCode");
	}
	
	
	public function getPersonDetailHTML($attributeTypeID, $attributeCode, $subPageVO=null){
		
		$html = '';
		if($subPageVO == null){
			$subPageVO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
		}
		
		$customerID = 0;
		$profileURL = "#";
		if($subPageVO->getValue() != null){
			$firstArr = explode("/", $subPageVO->getValue());
			$sizeFirstArr = sizeof($firstArr);
			$secondArr = explode(".", $firstArr[$sizeFirstArr-1]);
			$customerID = $secondArr[0];
		
				
			$customerGenderCollection = Mage::getModel('customer/customer')->getCollection();
			$customerGenderCollection->getSelect()->reset()->from(array("main_table"=>$customerGenderCollection->getTable("webportal/customerentityint"), array("entity_id", "value") ));
			$customerGenderCollection->getSelect()->where('main_table.attribute_id =?', 18);
			$customerGenderCollection->getSelect()->where('main_table.entity_id =?', $customerID);
			$this->setCollection($customerGenderCollection);
				
			$customerGenderCollection = $this->getCollection();
			$genderID = 0;
			foreach ($customerGenderCollection as $key=> $_obj){
				$genderID = $_obj->getData('value');
			}
				
			if($genderID == 1){ // 1 for male
				$recordID  = $this->getRequest()->getParam("RecordID");
				$tableCode = $this->getRequest()->getParam("TableCode");
				$recordName = $this->getRequest()->getParam("RecordName");
				$profileURL = $this->getUrl('*/*/showProfile', array("CustomerID"=>$customerID, "ID"=>$recordID,"TableCode"=>$tableCode,"RecordName"=>$recordName));
			}

			$customerModel = Mage::getModel('common/Customer_Customer');
			$customerDataObj = $customerModel->getResource()->getByCustomerID($customerID);
			if($customerDataObj !== false){
			    if($customerDataObj['IsShowProfile'] != 1){
			        $profileURL = '#';
			    }
			}
		}
		
		
		if($profileURL != "#"){
			$html .=  "<div class='customer-image-container' style='width: 116px !important;'>
					   	<a href = '".$profileURL."' >
							<img alt='".$attributeCode."' src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $subPageVO->getValue()."' class='customer-image'>
						</a>		
					   </div>
					   <div class='customer-detail-with-image' style='width: 116px !important;'>";
		}else{
			$html .=  "<div class='customer-image-container' style='width: 116px !important;'>
					   	<img alt='".$attributeCode."' src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $subPageVO->getValue()."' class='customer-image'>
					   </div>
					   <div class='customer-detail-with-image' style='width: 116px !important;'>";
		}
		

    	if($subPageVO->getPersonName() != null){
    		$html .= "<span>". $subPageVO->getPersonName() . "</span><br />";
    	}
        
    	if($subPageVO->getPost1Name() != null){
    		$html .= "<span>". $subPageVO->getPost1Name() . "</span><br />";
    	}
    	
    	if($subPageVO->getPost2Name() != null){
    		$html .= "<span>". $subPageVO->getPost2Name() . "</span><br />";
    	}
        					
    	$html .= "</div>";
    	
    	return $html;
	}
	
}
