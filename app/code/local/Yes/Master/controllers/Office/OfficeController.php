<?php
class Yes_Master_Office_OfficeController extends Mage_Adminhtml_Controller_Action
{
 /**
     * Preparing layout for output
     *
     * @return Mage_Adminhtml_Permissions_RoleController
     */
    protected function _initAction()
    {
       $this->loadLayout();
        //$this->_setActiveMenu('yesmaster/acl');
        //$this->_addBreadcrumb($this->__('POS'), $this->__('POS'));
        //$this->_addBreadcrumb($this->__('Masters'), $this->__('Masters'));
        //$this->_addBreadcrumb($this->__('Office'), $this->__('Office'));
        return $this;
    }

    protected function _initOffice($requestVariable = 'OfficeID')
    {
       
    	$this->_title($this->__('Master'))
             ->_title($this->__('Office'));
    	
         $office = Mage::getModel('yesmaster/offices')->load($this->getRequest()->getParam($requestVariable));
         Mage::register('current_office', $office);
         return Mage::registry('current_office');
      
         /* 
         
         $officeId=$this->getRequest()->getParam($entityId);
         $officeId= $officeId>0 ? $officeId : 0;
         
         $officeVO= Mage::getModel('yesmaster/offices');
         $officeVO->getResource()->getOfficeById($officeVO, $officeId);
          
         Mage::register('current_officeVO', $officeVO  );
         return Mage::registry('current_officeVO');
         */     
    }

    
    public function indexAction()
    {
    	$this->_title($this->__('POS'))
             ->_title($this->__('Masters'))
             ->_title($this->__('Office'));

        $this->_initAction();

        $this->renderLayout();
    }    
    
    /**
     * Action for ajax request from grid
     *
     */
    public function officesAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->getBlock('yesmaster.office.offices')->toHtml());
    }
    
  
    /**
     * Edit sales Scheme action
     *
     */
    public function editOfficeAction()
    {
        
    	$office = $this->_initOffice();
        
    	$this->_initAction();

        if ($office->getData('OfficeID')) {
        	$breadCrumb      = $this->__('Edit Office');
            $breadCrumbTitle = $this->__('Edit Office');
        } else {
            $breadCrumb = $this->__('Add new Office');
            $breadCrumbTitle = $this->__('Add new Office');
        }

        //$this->_title($office->getData('OfficeID') ? $office->getData('OfficeName') : $this->__('New Office'));

        $this->_addBreadcrumb($breadCrumb, $breadCrumbTitle);

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        
        $this->_addContent(
            $this->getLayout()->createBlock('yesmaster/office_offices_buttons')
                ->setOfficeID($office->getData('OfficeID') )
                ->setOfficeInfo($office)
                ->setTemplate('YesMaster/officeInfo.phtml')
        );
        /* ATL
        $this->_addJs($this->getLayout()->createBlock('adminhtml/template')->setTemplate('permissions/role_users_grid_js.phtml'));
        */
        $this->renderLayout();
    }
    
    
    
    public function saveOfficeAction()
    {
                
    			$post = $this->getRequest()->getPost();
               // $terminal = array();
               // if( array_key_exists('bank' ,$post  ) ){
               // 	$terminal  = $post['bank']['terminal_new'];
               // }
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            /* here's your form processing */
            //Mage::getModel('core/date')->gmtDate(date());
           
                $officeID        = $this->getRequest()->getParam('officeID', false);
                $officeName        = $this->getRequest()->getParam('officeName', false);
                $officeCode        = $this->getRequest()->getParam('officeCode', false);
                $oadd1        = $this->getRequest()->getParam('oadd1', false);
                $oadd2        = $this->getRequest()->getParam('oadd2', false);
                $oadd3		= $this->getRequest()->getParam('oadd3',false);
                $oadd4 		=$this->getRequest()->getParam('oadd4',false);
                $ophone     =$this->getRequest()->getParam('ophone',false);
                $tinno     =$this->getRequest()->getParam('tinno',false);
                $stateName   =$this->getRequest()->getParam('stateName',false);
                $binAddressAbbreviation = $this->getRequest()->getParam('binAddressAbbreviation', false);
                $request   =array('officeID'=>$officeID , 'officeName'=>$officeName , 'officeCode'=>$officeCode ,'oadd1' => $oadd1 ,  'oadd2' => $oadd2 , 'oadd3' => $oadd3 , 'oadd4' => $oadd4 , 'ophone' => $ophone , 'stateName'=>$stateName , 'tinno'=>$tinno , "binAddressAbbreviation"=>$binAddressAbbreviation );
                
                $officeModel = Mage::getModel('yesmaster/offices');
                $response= $officeModel->getResource()->insertUpdateOffice($post, $request /*,$terminal*/);

                if($response['status']=='Duplicate'){
			            Mage::getSingleton('adminhtml/session')->addError($this->__('You can not add, code already exist'));
                    if($officeID !=''){
                            $path = "*/*/editOffice";
                    	    $arg = array('officeID' => $request['officeID']) ;
                            $this->_redirect($path, $arg  );    
                    } else {
                            $this->_redirect("*/*/editOffice");
                    }
			            return;
                }
              
                $message = $response['message'];
                
                Mage::getSingleton('adminhtml/session')->addSuccess($message);
                $path = "*/*/";
                
        } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $path = "'*/*/editOffice";
                $arg = null;
                
        }
        
        //$this->getResponse()->setRedirect($this->getUrl("*/*/editrole/rid/$rid"));
        //if($officeID !=''){
        if($response['status']=="Saved"){
                $arg = array('officeID' => $response['officeID']) ;
                $this->_redirect($path, $arg  );    
        } 
        if($response['status']=="Error"){
        	  if($officeID !=''){
        	       $arg = array('officeID' => $officeID ) ;
        	       $this->_redirect($path, $arg  );    
        	  } else {
                $this->_redirect("*/*/");
        	  } 
        }
        
        
        return;
        
    }
    
    public function deleteAction()
    {
         
    	 $officeID = $this->getRequest()->getParam('OfficeID', false);

    	 $officeModel = Mage::getModel('yesmaster/offices');

    	 // by vipin
    	 //$response= $officeModel->getResource()->isOfficeSale( $officeID);
        
        
        //if($response['status']=='FAIL'){
        //    Mage::getSingleton('adminhtml/session')->addError($this->__($response['message']));
        //    $this->_redirect('*/*/editOffice', array('OfficeID' => $officeID));
       //     return;
       // }
       // if($response['status']=='FOUND'){
       //     Mage::getSingleton('adminhtml/session')->addError($this->__('You can not delete Office, Office has already sale'));
       //     $this->_redirect('*/*/editOffice',array('OfficeID' => $officeID));
       //     return;
       // }

        try {
                $officeModel = Mage::getModel('yesmaster/offices');
                $response= $officeModel->getResource()->deleteOffice($officeID);
                 if($response['status']='DELETED'){
                        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Office successfully deleted.'));    
                 }  else {
                        Mage::getSingleton('adminhtml/session')->addSuccess($this->__($response['status']));
                 }          
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Error while deleting this Office. Please try again later.'));
        }

        $this->_redirect("*/*/");
    }

    
}