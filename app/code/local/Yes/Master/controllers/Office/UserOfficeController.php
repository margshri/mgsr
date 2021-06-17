<?php
class Yes_Master_Office_UserOfficeController extends Mage_Adminhtml_Controller_Action
{
 /**
     * Preparing layout for output
     *
     * @return Mage_Adminhtml_Permissions_RoleController
     */
    protected function _initAction()
    {
        $this->loadLayout();
        //$this->_setActiveMenu('springompos/acl');
        //$this->_addBreadcrumb($this->__('POS'), $this->__('POS'));
        //$this->_addBreadcrumb($this->__('Masters'), $this->__('Masters'));
        //$this->_addBreadcrumb($this->__('UserOffice'), $this->__('User Office'));
        return $this;
    }
    protected function _initUserOffice($requestVariable = 'user_id')
    {
        //$this->_title($this->__('POS'))
        //     ->_title($this->__('Masters'))
        //     ->_title($this->__('UserOffice'));
		
		
          $userOffice = Mage::getModel('yesmaster/userOffice')->load($this->getRequest()->getParam($requestVariable));
          $model= Mage::getModel('yesmaster/userOffice');
          $model->setData(array());
          $model->getResource()->loadData($model, $this->getRequest()->getParam($requestVariable));
          $userOffice = $model; 
          Mage::register('current_userOffice', $userOffice);
         
         return Mage::registry('current_userOffice');
        
         
         
         
    }
     public function indexAction()
    {
        //$this->_title($this->__('POS'))
        //     ->_title($this->__('Masters'))
        //     ->_title($this->__('User Office'));

        $this->_initAction();
		$this->renderLayout();
    }    
/**
     * Action for ajax request from grid
     *
     */
    public function userOfficeGridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->getBlock('yesmaster.useroffice.userofficegrid')->toHtml());
    }

    
    /**
     * Edit sales Scheme action
     *
     */
    public function editUserOfficeAction()
    {
        
    	$userOffice = $this->_initUserOffice();
        $this->_initAction();

        if ($userOffice->getData('user_id')) {
            $breadCrumb      = $this->__('Edit User Office');
            $breadCrumbTitle = $this->__('Edit User Office');
        } else {
            $breadCrumb = $this->__('Add new User Office');
            $breadCrumbTitle = $this->__('Add new User Office');
        }

        $this->_title($userOffice->getData('$userOffice') ? $userOffice->getData('username') : $this->__('New User Office'));

        $this->_addBreadcrumb($breadCrumb, $breadCrumbTitle);

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        
        $this->_addContent(
            $this->getLayout()->createBlock('yesmaster/office_userOffice_buttons')
                ->setuser_id($userOffice->getData('user_id') )
                ->setUserOfficeInfo($userOffice)
                ->setTemplate('YesMaster/userOfficeInfo.phtml')
        );
        /* ATL
        $this->_addJs($this->getLayout()->createBlock('adminhtml/template')->setTemplate('permissions/role_users_grid_js.phtml'));
        */
        $this->renderLayout();
    }
    
    
    
    public function saveUserOfficeAction()
    {
    
    	
    	$post = $this->getRequest()->getPost();
                
        try {
            if (empty($post)) {
            	Mage::throwException($this->__('Invalid form data.'));
            }
            	
            /* here's your form processing */
            //Mage::getModel('core/date')->gmtDate(date());
                
            	$officeID        = $this->getRequest()->getParam('officeName', false);
            	
            	$user_id        = $this->getRequest()->getParam('user_id', false);
            	
            	
            	$reportingOffices= serialize(explode(","  , $this->getRequest()->getParam('reportingOffices', false) ) );
                
            	
                
                $request   =array( 'OfficeID'=>$officeID , 'user_id'=>$user_id , 'reportingOffices'=>$reportingOffices );
                $userOfficeModel = Mage::getModel('yesmaster/userOffice');
                $response= $userOfficeModel->getResource()->insertUpdateUserOffice($request);

              
                $message = $response['message'];
                
                Mage::getSingleton('adminhtml/session')->addSuccess($message);
                $path = "*/*/editUserOffice";
                
        } catch (Exception $e) {
        	
        		
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $path = "'*/*/editUserOffice";
                $arg = null;
                
        }
        //$this->getResponse()->setRedirect($this->getUrl("*/*/editrole/rid/$rid"));
     if($user_id !=''){
                $arg = array('user_id' => $response['user_id']) ;
                $this->_redirect($path, $arg  );    
        } else {
               $this->_redirect("*/*/");
        }
        
        
        return;
        
    }

    
}