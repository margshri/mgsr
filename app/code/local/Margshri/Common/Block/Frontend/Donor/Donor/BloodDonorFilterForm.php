<?php
class Margshri_Common_Block_Frontend_Donor_Donor_BloodDonorFilterForm extends Mage_Core_Block_Template{
	
    
    public function __construct(){
        parent::__construct();
    }

    
    public function getHeaderHtml(){
        // return $this->getChild('Registration_Header')->toHtml();
    }
    
    
    public function getFooterHtml(){
        // return $this->getChild('Registration_Footer')->toHtml();
    }
    
    /*
    public function getDonationVOs(){
        return Mage::registry("CurrentDonationVOs");
    }
    */
    
    public function getHTMLFormID(){
        return 'BloodDonorFilterForm';
    }
    
    
    public function getBloodGroupOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Master_BloodDonation_BloodGroupVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getCityOptions(){
        $options = array();
        $newOptions = array();
        
        $model = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
        $options = $model->getResource()->getOptions();
        
        foreach($options as $key=>$row){
            if($row["DistrictID"] == 31){
                $newOptions[$key] = $row["Name"];
            }
        }
        
        return $newOptions;
    }
    
    
    public function getYesNoOptions(){
        $options = array('0'=>'No', '1'=>'Yes');
        return $options;
    }
    
}
