<?php

class Yes_Master_Block_Office_UserOffice_Tab_UserOfficeInfo extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('User Office Info');
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
        $this->setTemplate('YesMaster/userOfficeEntropy.phtml');
    }    

        
    public function getOffices()
    {
    	/* by vipin
        $officesModel = Mage::getModel('yesmaster/offices');
        $officesModel ->setData(array());
        $columns = array("OfficeID","OfficeName");
        $whereClause='0=0';
        $orderby ='OfficeName asc';
        $officesModel->getResource()->getOffices($officesModel , $columns , $whereClause , $orderby );
        $offices = $officesModel ->_data;
        return $offices ;
        */
        
    	$model = Mage::getModel('yesmaster/offices');
        $data = $model->getCollection()->getData();
        return $data;
        
        
    }    

    public function getReportingOffices()
    {
    	/* by vipin
    	$officesModel = Mage::getModel('yesmaster/offices');
        $officesModel ->setData(array());
        $columns = array("OfficeID","OfficeName" , " '' `checked`");
        $whereClause='0=0';
        $orderby ='OfficeName asc';
        $officesModel->getResource()->getOffices($officesModel , $columns  ,$whereClause,$orderby );
        $offices = $officesModel ->_data;
      
        $model = Mage::getModel('yesmaster/userOffice')->getResource();
        $reportingOffices =unserialize($model->getReportingOfficesForUser($this->getUserOfficeInfoData('ReportingOffices')));
        if (!is_array($reportingOffices )){
        	$reportingOffices  = array();
        }
        foreach($offices as $key => $row){
        	if( in_array($row['OfficeID'], $reportingOffices)){
        		$offices[$key]['checked'] ='checked';
        	}
        }
        return $offices ;
       */
       
    	$officesModel = Mage::getModel('yesmaster/offices');
    	$offices = $officesModel->getCollection()->getData();
    	

    	
    	$model = Mage::getModel('yesmaster/offices')->getResource();
    	$reportingOffices =unserialize($model->getReportingOfficesForUser($this->getUserOfficeInfoData('user_id')));
    	
    	if (!is_array($reportingOffices )){
    		$reportingOffices  = array();
    	}
    	foreach($offices as $key => $row){
    		if( in_array($row['OfficeID'], $reportingOffices)){
    			$offices[$key]['checked'] ='checked';
    		}
    	}
    	 
    	
    	/*
    	$userOfficeModel = Mage::getModel('yesmaster/userOffice');
    	$userOffices = $userOfficeModel->getCollection()->getData();
    	
        $u = $this->getRequest()->getParam('user_id', false);
    	$u = $u - 1;
    	
    	//foreach($userOffices as $rowUserOffice)
    	//{
    		$reportingOffices = unserialize($userOffices[$u]['ReportingOffices']);
			
    		if (!is_array($reportingOffices )){
    			$reportingOffices  = array();
    		}
    		
    		foreach($offices as $key => $row){
    			
    			if(in_array($row['OfficeID'], $reportingOffices)){
    				$offices[$key]['checked'] ='checked';
    			}
    		}
    		
    	//}
    	*/
    	return $offices ;
        
         
    }    
    
    public function getUserOfficeInfoData($var)
   {
            $userOffice = Mage::registry('current_userOffice');
            return $userOffice->getData($var) ;
   }
   
   public function getHtmlId(){
   	return 'userOfficeEntropy';
   }    
    
   

}