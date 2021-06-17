<?php

class Yes_Master_Model_Mysql4_UserOffice_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
    //public $size=0;
    protected function _construct()
    {
        // call SpringOM_Masters_Model_SalesScheme.php
        $this->_init('yesmaster/userOffice');
        
       // $obj = new Yes_Master_Block_UserOffice_Grid_UserOffice;
       // $this->size = $obj->getCount();
        
    }


   // public function getData()
   // {
   //      $obj = new Yes_Master_Block_UserOffice_Grid_UserOffice;
  //       return $obj->getUserOffice($this->getCurPage(), $this->getPageSize());
  //  }    

    
   
 //  public function getSize()
  //  {
  //      return $this->size;
  //  }
    
 
}

