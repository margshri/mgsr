<?php 
class Margshri_Common_Frontend_Programme_ProgrammeController extends Mage_Core_Controller_Front_Action {
	
    public function showProgrammeListAction(){
        
        
        $code = $this->getRequest()->getParam('Code');
        switch ($code){
            case 'donation':
            $model = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
            
            
            $dataObj = $model->getResource()->getGroupProgrammeList();
        }
        
        Mage::register("CurrentProgrammeList", $dataObj);
        
	    $this->loadLayout();
	    $this->renderLayout();
	}
	    
}
