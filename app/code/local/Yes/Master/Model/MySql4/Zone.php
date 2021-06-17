<?php
class Yes_Master_Model_Mysql4_Zone extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('yesmaster/zone', 'ZoneId');
    }
   
   /*  
    public function getOptionArray(){
        //$model = Mage::getModel('yesmaster/systemConfig');
        //$baseOfficeTypeId = $model->getResource()->getConfigValue($model, "entityId=".SystemConfigVO::$Office_TYPE_ID_OF_BASE);
        
        $options = array();
        $read = $this->_getReadAdapter();
        $select = $read->select()
                               ->from(array("zone" => $this->getTable("yesmaster/zone")) , array("ZoneId"=>"zoneId", "ZoneName"=>"zoneName"));
                               //->order("ZoneName");

        $recordSet= $read->fetchAll($select);                      

       // if($allOption==1){
       //     	$options[0] = Mage::helper('catalog')->__("--ALL--");
       // }
     
        foreach($recordSet   as $row) {
            $options[$row["ZoneId"]] = Mage::helper('catalog')->__($row["ZoneName"]);
        }

        return $options;
            
    }
      

    public function getById(Yes_Masters_Model_Zone $zoneVO, $zoneId  ){
    	$read = $this->_getReadAdapter();
    
    
    	$select = $read->select()
    	->from($this->getMainTable())
    	->where('ZoneId=?',$zoneId );
    	$row=  $read->fetchRow($select);
    	 
    
    	if ($row) {
    		$zoneVO->setData($row);
    	}
    
    	$this->_afterLoad($zoneVO);
    
    	return $this;
    }
    
    public function getZoneList(Yes_Masters_Model_Zone $zoneVO , $orderBy=null){
    	$read = $this->_getReadAdapter();
    
    
    	$select = $read->select()
    	->from($this->getMainTable());
    	if($orderBy!=null){
    		$select->order($orderBy);
    	}
    	 
    	$row=  $read->fetchAll($select);
    	 
    
    	if ($row) {
    		$zoneVO->setData($row);
    	}
    
    	$this->_afterLoad($zoneVO);
    
    	return $this;
    }
    */ 
    
}