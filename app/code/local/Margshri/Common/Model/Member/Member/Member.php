<?php

class Margshri_Common_Model_Member_Member_Member extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Member_Member_MemberVO::$modelName);
    }
}


