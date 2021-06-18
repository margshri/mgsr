<?php
class Margshri_Transport_Block_Backend_Consignment_Consignment_ConsignmentNote_Print extends Mage_Adminhtml_Block_Template{
	
    public $commonList = array(); 
    
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("transport/consignment/consignment/consignmentnote/print.phtml");
    }

    protected function _prepareLayout(){
    	 
    	$this->setChild('backButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Back'),
                    'onclick'   => 'window.location.href=\''.$this->getUrl('*/*/').'\'',
                    'class' => 'back'
                ))
        );

        $this->setChild('resetButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Reset'),
                    'onclick'   => 'window.location.reload()'
                ))
        );

        $this->setChild('printButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Print'),
                    'onclick'   => 'consignmentNoteFormJS.print(); ',
                ))
        );
		
        return parent::_prepareLayout();
    }

    public function getBackButtonHtml(){
        return $this->getChildHtml('backButton');
    }

    public function getResetButtonHtml(){
        return $this->getChildHtml('resetButton');
    }

    public function getPrintButtonHtml(){
        return $this->getChildHtml('printButton');
    }

    public function getHTMLFormID(){
    	   return 'ConsignmentNoteForm';
    }
    
    public function getConsignmentNoteVO(){
        return Mage::registry('CurrentConsignmentNoteVO');
    }
    
    public function getCityOptions(){
        $options = array();
        $statusModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
        $options = $statusModel->getResource()->getActiveOptions();
        return $options;
    }
    
    
    public function getCommonOptions(){
        $options = array();
        $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
        $vahicaleVO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
        
        $ownerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
        $ownerVO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
        
        $driverModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName);
        $driverVO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
        
        $commonModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName);
        $commonVO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
        
        $commonDataObjs = $commonModel->getResource()->getActiveList();
        if(sizeof($commonDataObjs) > 0){
            foreach ($commonDataObjs as $commonDataObj){
                $commonDTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
                $commonVO = Margshri_Common_Helper_Utility::callInstanceFunction($commonDTO, $commonDataObj);
                
                if($commonVO->getVahicaleID() != null){
                    $vahicaleDataObj = $vahicaleModel->getResource()->getByID($commonVO->getVahicaleID());
                    if($vahicaleDataObj !== false){
                        $vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
                        $vahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
                    }
                }
                
                if($commonVO->getOwnerID() != null){
                    $ownerDataObj = $ownerModel->getResource()->getByID($commonVO->getOwnerID());
                    if($ownerDataObj !== false){
                        $ownerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
                        $ownerVO = Margshri_Common_Helper_Utility::callInstanceFunction($ownerDTO, $ownerDataObj);
                    }
                }
                
                if($commonVO->getDriverID() != null){
                    $driverDataObj = $driverModel->getResource()->getByID($commonVO->getDriverID());
                    if($driverDataObj !== false){
                        $driverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
                        $driverVO = Margshri_Common_Helper_Utility::callInstanceFunction($driverDTO, $driverDataObj);
                    }
                    
                }
                
                $options[$commonVO->getID()] = $vahicaleVO->getVahicaleNumber() . " - " . $ownerVO->getName() . "(" . $ownerVO->getMobileNo() . ")" . " - " . $driverVO->getName() . "(" . $driverVO->getMobileNo() . ")";
                
                $vahicale = array("ID"=>$vahicaleVO->getID(), "VahicaleNumber"=>$vahicaleVO->getVahicaleNumber());
                $owner = array("ID"=>$ownerVO->getID(), "Name"=>$ownerVO->getName(), "MobileNo"=>$ownerVO->getMobileNo());
                $driver = array("ID"=>$driverVO->getID(), "Name"=>$driverVO->getName(), "MobileNo"=>$driverVO->getMobileNo());
                $this->commonList[$commonVO->getID()] = array("Vahicale"=>$vahicale, "Owner"=>$owner, "Driver"=>$driver);
            }
        }
        return $options;
    }
    
    public function getCommonList(){
        return $this->commonList;
    }
    
    public function getVahicaleOptions(){
        $options = array();
        $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
        $vahicaleDataObjs = $vahicaleModel->getResource()->getActiveList();
        
        if(sizeof($vahicaleDataObjs) > 0){
            $ownerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
            $ownerDataObjs = $ownerModel->getResource()->getActiveList();
            $newOwnerDataObjs = array();
            foreach ($ownerDataObjs as $ownerDataObj){
                $ownerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
                /* @var $ownerVO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
                $ownerVO = Margshri_Common_Helper_Utility::callInstanceFunction($ownerDTO, $ownerDataObj);
                $newOwnerDataObjs[$ownerVO->getID()] = $ownerVO->getName();
            }
            
            $counter = 1;
            foreach ($vahicaleDataObjs as $vahicaleDataObj){
                $vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
                /* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
                $vahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
                
                $ownerIDs = array();
                $ownerIDs[] = $vahicaleVO->getOwnerID();
                foreach ($ownerIDs as $ownerID){
                    if(array_key_exists($ownerID, $newOwnerDataObjs)){
                        $options[$counter] = array("VahicaleID"=>$vahicaleVO->getID(), "VahicaleOwnerID"=>$ownerID , "DriverID"=>"", "Value"=>$vahicaleVO->getVahicaleNumber()." - ". $newOwnerDataObjs[$ownerID]);
                        // $options[$counter] = $vahicaleVO->getVahicaleNumber() . " - " . $newOwnerDataObjs[$ownerID];
                    }else{
                        $options[$counter] = array("VahicaleID"=>$vahicaleVO->getID(), "VahicaleOwnerID"=>"", "DriverID"=>"", "Value"=>$vahicaleVO->getVahicaleNumber());
                        // $options[$counter] = $vahicaleVO->getVahicaleNumber();
                    }
                }
                $counter++;
            }
        }
        return $options;
    }
    
    
    public function getVahicaleOwnerOptions(){
        $options = array();
        $ownerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
        $options = $ownerModel->getResource()->getActiveOptions();
        return $options;
    }
    
    public function getDriverOptions(){
        $options = array();
        $driverModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName);
        $options = $driverModel->getResource()->getActiveOptions();
        return $options;
    }
    
    
    public function getStatusOptions(){
        $options = array();
        $statusModel = Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName);
        $options = $statusModel->getResource()->getOptions();
        return $options;
    }
    
    public function getUnitTypeOptions(){
        $options = array(1=>"KG", 2=>"Quintal", 3=>"Ton");
        return $options;
    }
}
