<?php
class Yes_Master_Model_Mysql4_State extends Mage_Core_Model_Mysql4_Abstract
{

	protected function _construct()
	{
		$this->_init('yesmaster/state', 'stateId');
	}
	
	public function getOptionArray(){
	    $options = array();
    	$read = $this->_getReadAdapter();
		$select = $read->select()
		    				   ->from(array("state" => $this->getTable("yesmaster/state")) , array("StateId"=>"stateId", "StateName"=>"stateName") );
	//	    				   ->where("stor.status=1"); 
 		    				   
		$recordSet= $read->fetchAll($select);    				   
	    
        foreach($recordSet as $row) {
            $options[$row["StateId"]] = Mage::helper('catalog')->__($row["StateName"]);
        }

        return $options;
        
	}	

}	