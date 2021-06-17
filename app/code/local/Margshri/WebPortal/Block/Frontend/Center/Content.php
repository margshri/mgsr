<?php
class Margshri_WebPortal_Block_Frontend_Center_Content extends Mage_Core_Block_Template{
	
	protected $tableCode;
	protected $title;
	//protected $redirectURL;
	
	public function __construct(){
		$currentCategoryObj = Mage::registry('current_category');
		$this->tableCode = $currentCategoryObj->getUrl_key();
		
		
		$this->title = Mage::helper('webportal/Data')->getPageTitleByTableCode($this->tableCode);
		//$this->title = $currentCategoryObj->getName(); 
				
		Mage::register("CurrentTableCode", $this->tableCode);
		
		Mage::register("CurrentPageTitle", $this->title);
		
		parent::__construct();
	}
	
	protected function _prepareLayout()
	{
		 
		/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
		$tableVO = Mage::helper('webportal/Data')->getTableVOByTableCode($this->tableCode);
		
		/* @var $tableTypeVO Margshri_WebPortal_VO_Master_Table_TableTypeVO */
		$tableTypeVO = Mage::helper('webportal/Data')->getTableTypeVOByTableCode($this->tableCode);
		
		if($tableTypeVO != null){
			switch ($tableTypeVO->getCode()){
				case 'type1':
					$this->setChild('entropy',
							$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type1_Bank_Bank_Info') );
					break;
					
				case 'type2':
					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE2_CITY_DIAMONDS){
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type2_CityDiamonds_CityDiamonds_Info'));
						break;
					}elseif($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE2_BLOOD_DONOR ){
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type2_BloodDonor_BloodDonor_Info'));
						break;
					}else{
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type2_Professional_Professional_Info'));
						break;
					}
					
				case 'type3':
					
					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE3_PERSONAL_PHONEBOOK){
						$this->setChild('entropy',
						$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type3_PhoneBook_Personal_Info'));
						break;
					}

					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE3_GENERAL_PHONEBOOK){
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type3_PhoneBook_General_Info'));
						break;
					}
							
				
				case 'type5':
					$this->setChild('entropy',
							$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type5_Viewer_Viewer_Info'));
					break;
					
				case 'type7':
					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE7_EVENT){
						$this->setChild('entropy',
						$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Event_Event_Info') );
						break;
					}

					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE7_ACHIVEMENT){
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Achivement_Achivement_Info') );
						break;
					}
					
					
					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE7_NEWS){
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_News_News_Info') );
						break;
					}
					
				case 'type6':
					//$this->setChild('entropy',
					//$this->getLayout()->createBlock('core/template')->setTemplate("contacts/form.phtml") );
					$this->setChild('entropy',
							$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type6_ContactUs_ContactUs_Info') );
					break;
					
				case 'type8':
					$this->setChild('entropy',
							$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Info') );
					break;
					
				case 'type10':
					
					if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE10_RECRUITMENT){
						$this->setChild('entropy',
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type10_Recruitment_Recruitment_Info') );
						break;
					}else if($tableVO->getValue() == Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE10_HOSPITAL){
						$this->setChild('entropy',
								//$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type10_Hospital_Hospital_Info') );
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Info') );
						break;
					}else{
					
						$this->setChild('entropy',
								//$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type10_Info') );
								$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Info') );
						break;
					}
					
					
				case 'type11':
					$this->setChild('entropy',
					$this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type11_Info') );
					break;
							
					
			}
		}
	
		return parent::_prepareLayout();
	}
	
	public function getEntropy()
	{
		return $this->getChildHtml('entropy');
	}
    
}

