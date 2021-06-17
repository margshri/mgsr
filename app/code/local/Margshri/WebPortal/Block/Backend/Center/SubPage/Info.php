<?php
class Margshri_WebPortal_Block_Backend_Center_SubPage_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	protected $recordID;
	protected $tableCode;
	protected $previousActionName;
	protected $previousControllerName;
	
	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Info');
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
    
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('webportal/center/subpage/entropy.phtml');
        
        $this->recordID  = $this->getRequest()->getParam("RecordID");
        $this->tableCode = $this->getRequest()->getParam("TableCode");
        $this->previousControllerName = $this->getRequest()->getParam("PreviousControllerName");
    }

    public function getSubPageVOs(){
        return Mage::registry('CurrentSubPageVOs');
    }
    
	public function getRecordID(){
    	return $this->recordID;
    }
    
    public function getTableCode(){
    	return  $this->tableCode;
    }
    
    public function getPreviousControllerName(){
    	return  $this->previousControllerName;
    }
    
    public function getServiceOptions(){
    	/*
    	$entityModel   = Mage::getModel('webportal/Master_SubPage_Entity');
    	$entityDataObj = $entityModel->getResource()->getByTableCode($this->getTableCode());
    	
    	$entityID = 0;
    	if($entityDataObj !== false){
    		$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
    		$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $entityDataObj);
    		$entityID = $entityVO->getID();
    	}
    	*/
    	
    	$options = array();
    	$model = Mage::getModel('webportal/Master_SubPage_Service');
    	//$options = $model->getResource()->getOptionsByEntityID($entityID);
    	$options = $model->getResource()->getActiveOptions($entityID);
    	return $options;
    }
    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    
    public function getPost1Options(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_SubPage_Post1');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getPost2Options(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_SubPage_Post2');
    	$dataObjs = $model->getResource()->getActiveList();
    	
    	foreach($dataObjs as $dataObj){
    		/* @var $VO Margshri_WebPortal_VO_Master_SubPage_Post2VO */
    		$DTO = new Margshri_WebPortal_VO_Master_SubPage_Post2VO();
    		$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		$options[$VO->getID()]= $VO->getValue() . ' ' . $VO->getCode();
    	}
    	return $options;
    }
    
    public function getPageTitle(){
    	return $this->getRequest()->getParam("PageTitle");
    }
    
    public function getHTMLFormID(){
    	return 'SubPage';
    }
    
}