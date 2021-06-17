<?php
class Margshri_Common_Block_Frontend_Programme_Programme_ProgrammeList extends Mage_Core_Block_Template{
	
    
    public function __construct(){
        parent::__construct();
    }
    
    
    public function getProgrammeList(){
        return Mage::registry("CurrentProgrammeList");
    }
    
}
