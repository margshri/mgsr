<?php

class Yes_Master_Block_Office_Offices_Tab_OfficeInfo extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Office Info');
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
        $this->setTemplate('YesMaster/officeEntropy.phtml');
    }    

   
   
    public function getOfficeInfoData($var)
    {
    	
    	
    	$office = Mage::registry('current_office');
    
    	return $office->getData($var) ;
    	
    }
    
    
    public function getOfficeType()
    {
    	$officeTypeModel = Mage::getModel('yesmaster/officeType');
    	$orderby ='TypeName asc';
    	$officeTypeModel->getResource()->getOfficeTypeList($officeTypeModel, $orderby );
    	$officeTypeVOs = $officeTypeModel->_data;
    	return $officeTypeVOs ;
    }
  
    public function getZone()
    {
    	
    	$model = Mage::getModel('yesmaster/zone');
    	$data = $model->getCollection()->getData();
    	return $data;
    	
    	/*	
    	$zoneModel = Mage::getModel('yesmaster/zone');
        $orderby ='ZoneName asc';
        $zoneModel->getResource()->getZoneList($zoneModel, $orderby );
        $zoneVOs = $zoneModel->_data;
        return $zoneVOs ;
        */
    
    }
    
    public function getState()
    {
    	$model = Mage::getModel('yesmaster/state');
    	$data = $model->getCollection()->getData();
    	return $data;
    
    
    	/*
    	 $stateModel = Mage::getModel('yesmaster/state');
    	$stateModel->setData(array());
    	$orderby ='stateName asc';
    	$stateModel->getResource()->getStates($stateModel, $orderby );
    	$state = $stateModel->_data;
    	return $state;
    	*/
    	 
    	   
    	/*
    	 $stateModel = Mage::getModel('yesmaster/state');
    	$stateModel->setData(array());
    	$columns = array("stateId","stateName");
    	$whereClause='0=0';
    	$orderby ='stateName asc';
    	$stateModel->getResource()->getStates($stateModel, $columns  ,$whereClause,$orderby );
    	$state = $stateModel->_data;
    	 
    	return $state ;
    	*/
    }
  
 
  
/*
   public function getActivityByType()
    {
    	$model = Mage::getModel('yesmaster/systemConfig');
    	$_id = SystemConfigVO::$OFFICE_LEVEL_ACTIVITY_TYPE_ID ; 
    	$activityTypeId= $model->getResource()->getConfigValue($model , " entityId = {$_id}" );	
    		
    	
        $model = Mage::getModel('yesmaster/activity');
		$orderby ='ActivityName asc';
        $model->getResource()->getActivityList($model, $activityTypeId, $orderby );
        $activityVOs = $model->_data;
        
        $currOfficeId =$this->getOfficeInfoData('officeID'); 
        if($currOfficeId =="") 
            return $activityVOs;

            
        $model = Mage::getModel('yesmaster/offices');
        $model->getResource()->getOfficeActivity($model, $currOfficeId ,  StatusVO::$ACTIVE);
        $officeActivityVOs = $model->_data;    

        if(!is_array($officeActivityVOs))
        		return $activityVOs;


        foreach($activityVOs as $key => $row){getData
        	foreach($officeActivityVOs as $officeActivityVO){
            		if( $row['ActivityId']== $officeActivityVO['ActivityId']){
                		$activityVOs[$key]['checked'] ='checked';
            		}
        	}		
        }
        		
        return $activityVOs;
     } 
    */
     
    
     public function getHtmlId(){
     	return 'officeEntropy';
     }   
   

}