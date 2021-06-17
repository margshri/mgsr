<?php
class Margshri_WebPortal_Block_Backend_FileUpload_ImageUpload_Advertisement_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{
    
	
	public $level0CategoryOptions = array();
	public $level1CategoryOptions = array();
	public $level2CategoryOptions = array();
	
	 
	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('webportal/fileupload/imageupload/advertisement/entropy.phtml');
        $this->getStoreCategories();
    }

    public function getTabLabel()
    {
    	return Mage::helper('adminhtml')->__('Advertisement Info');
    }
    
    public function getTabTitle()
    {
    	return $this->getTabLabel();
    }
    
    public function canShowTab()
    {
    	return true;
    }
    
    public function isHidden()
    {
    	return false;
    }
    
    
    public function getAdvertisementVO(){
        return Mage::registry('CurrentAdvertisementVO');
    }
    
    public function getAdvertisementTypeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/FileUpload_ImageUpload_AdvertisementType');
    	$options = $model->getResource()->getOptions();
    	return $options;
    	
    }
    
    public function getCountryOptions(){
    	return Mage::helper('webportal/Data')->getCountryOptions();
    }
    
    public function getStateOptions(){
    	return Mage::helper('webportal/Data')->getStateOptions();
    }
    
    public function getDistrictOptions(){
    	return Mage::helper('webportal/Data')->getDistrictOptions();
    }
    
    public function getCityOptions(){
    	return Mage::helper('webportal/Data')->getCityOptions();
    }
    
    
    public function getLevel0CategoryOptions(){
    	return $this->level0CategoryOptions;
    }
    
    public function getLevel1CategoryOptions(){
    	return $this->level1CategoryOptions;
    }
    
    public function getLevel2CategoryOptions(){
    	return $this->level2CategoryOptions;
    }
	    
    
    public function getStoreCategories(){
    
    	$helper = Mage::helper('catalog/category');
    
    	$categories = $helper->getStoreCategories();
    	if (count($categories) > 0) {
    		foreach ($categories as $_sub_category){
    			if($_sub_category->getRequest_path()  == 'leftsidebar.html'){
    				$_left_sidebar_Id = $_sub_category->entity_id;
    				$_left_sidebar_model = Mage::getModel('catalog/category')->load($_left_sidebar_Id);
    				$_left_sidebar_Categories = explode(',', $_left_sidebar_model->getChildren());
    
    
    				foreach ($_left_sidebar_Categories as $key=>$_level0_category_Id){
    
    					$_level0_category = Mage::getModel('catalog/category')->load($_level0_category_Id);
    					if ($_level0_category->getIsActive() ){
    						$_level0_category_Id = $_level0_category->entity_id;
    						$_level0_category_model = Mage::getModel('catalog/category')->load($_level0_category_Id);
    						$_level0_subCategories = explode(',', $_level0_category_model->getChildren());
    
    
    						$this->level0CategoryOptions[] = array("ID"=>1, "Value"=> Mage::helper("webportal/data")->camelCase( $this->escapeHtml($_level0_category->getName())) );
    
    
    
    						if ($_level0_subCategories[0] != null){
    							foreach ($_level0_subCategories as $key=>$_level1_categoryId ){
    								$_level1_category = Mage::getModel('catalog/category')->load($_level1_categoryId);
    								if ($_level1_category->getIsActive() ){
    									$_level1_category_Id = $_level1_category->entity_id;
    									$_level1_category_model = Mage::getModel('catalog/category')->load($_level1_category_Id);
    									$_level1_subCategories = explode(',', $_level1_category_model->getChildren());
    
    									$this->level1CategoryOptions[] = Mage::helper("webportal/data")->camelCase($this->escapeHtml($_level1_category->getName()));
    
    
    									if ($_level1_subCategories[0] != null){
    										foreach ($_level1_subCategories as $key=>$_level2_categoryId ){
    											$_level2_category = Mage::getModel('catalog/category')->load($_level2_categoryId);
    											if ($_level2_category->getIsActive() ){
    												$this->level2CategoryOptions[] = Mage::helper("webportal/data")->camelCase($this->escapeHtml($_level2_category->getName()));
    											}
    										}
    
    									}
    									
    								}
    							}
    						}
    						
    					}
    				}
    				
    			}
    		}
    	}
    }	
    
    
    public function getTableCodeOptions(){
    	$options = array();
    	
    	$model = Mage::getModel('webportal/Master_Table_Table');
    	$list = $model->getResource()->getOrderList('FileName', 'Asc');
    	    	 
    	foreach($list as $row){
    		$DTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		/* @var $VO  Margshri_WebPortal_VO_Master_Table_TableVO */
    		$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
    		
    		if($VO->getIsFileName() == 1){
    			$options[$VO->getCode()]= $VO->getFileName();
    		}	
    	}
    	return $options;
    }
    
    
    public function getOrderOptions(){
    	$options = array();
    	$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
    	$MAX_ADVERTISEMENT_ORDER = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$MAX_ADVERTISEMENT_ORDER);
    	 
    	for($count=1; $count <= $MAX_ADVERTISEMENT_ORDER; $count++){
    		$options[$count]= $count;
    	}
    	return $options;
    }
    
    
    
    
    /*
    public function getCountryOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_CountryList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    } 
      
    public function getStateOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_StateList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getDistrictOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_DistrictList');
    	$options = $model->getResource()->getOptions();
    	return $options;
   	}
   	
   	public function getCityOptions(){
   		$options = array();
   		$model = Mage::getModel('webportal/Directory_CityList');
   		$options = $model->getResource()->getOptions();
   		return $options;
   	}
   	*/

    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
       
  	public function getHTMLFormID(){
    	return 'Advertisement';
    }
    
}