<?php
class Yes_Master_Office_OfficeTypeController extends Mage_Adminhtml_Controller_Action
{
	
 /**
     * Preparing layout for output
     *
     * @return Mage_Adminhtml_Permissions_RoleController
     */
    protected function _initAction()
    {
    	
    	$this->loadLayout();
/*        $this->_setActiveMenu('springomwms/acl');
        $this->_addBreadcrumb($this->__('Masters'), $this->__('Masters'));
        $this->_addBreadcrumb($this->__('Office Type'), $this->__('Office Type'));
*/        
        return $this;
    }

    protected function _init($entityId = 'officeTypeId')
    {
            
    		  $officeTypeId=$this->getRequest()->getParam($entityId);
              $officeTypeId= $officeTypeId>0 ? $officeTypeId : 0;

              $officeTypeVO= Mage::getModel('yesmaster/officeType');
         	  $officeTypeVO->getResource()->getOfficeTypeById($officeTypeVO, $officeTypeId);
         		
         	  Mage::register('current_officeTypeVO', $officeTypeVO  );
         	  return Mage::registry('current_officeTypeVO');
    }

    
    public function indexAction()
    {
    	$this->_title($this->__('Masters'))
             ->_title($this->__('Office Type'));
		
        $this->_initAction();

        $this->renderLayout();
    } 

       
    /**
     * Action for ajax request from grid
     *
     */
    public function officeTypeListAction()
    {
    	$this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->getBlock('wmsmasters.officetype.grid.officetypelist')->toHtml());
    }
    
    
    /**
     * Edit  action
     *
     */
    public function editAction()
    {
        $officeTypeVO= $this->_init();
        $this->_initAction();
         
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->_title($this->__('Masters'))->_title($this->__('Office Type'));
        
        $this->_addContent(
            $this->getLayout()->createBlock('yesmaster/office_officeType_buttons')
                ->setId($officeTypeVO->getData('OfficeTypeId') )
                ->setInfo($officeTypeVO)
                ->setTemplate('YesMaster/OfficeType/info.phtml')
        );
       
        $this->renderLayout();
    }
    
    
     public function saveAction()
    {
    	    
    	$post = $this->getRequest()->getPost();
    	        
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            /* here's your form processing */
            //Mage::getModel('core/date')->gmtDate(date());
           
            	$officeTypeVO= $this->_init();
                $model = Mage::getModel('yesmaster/officeType');
                $response= $model->getResource()->saveDB( $post);
                 
                //$productID =$response['productID'];
                 
                 
                if($response['status']=="SUCCESS")
                	Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
        } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $response['status'] ='ERROR';
        }
        $this->getResponse()->setBody( Mage::helper('yesmaster/Data')->jsonEncode($response )   );
        
        return;
    	
    }
    

  
     
}