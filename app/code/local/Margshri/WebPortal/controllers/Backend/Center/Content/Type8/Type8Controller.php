<?php 
class Margshri_WebPortal_Backend_Center_Content_Type8_Type8Controller extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	protected $tableCode;
	protected $title;
	
	protected function _initAction(){
		$this->loadLayout();
		$this->setTableName();
		$this->setTitle();
		$this->setBlock();
		return $this;
	}
	
	protected function setTableName(){
		$this->tableCode = $this->getRequest()->getActionName();
	}
	
	protected function setTitle(){
		$this->title = Mage::helper('webportal/Data')->getPageTitleByTableCode($this->getRequest()->getActionName());
		//$this->title = $this->__(ucwords( str_replace('apctweb', '', $this->getRequest()->getActionName())) ) ;
		$this->getLayout()->getBlock('head')->setTitle($this->title);
	}
	
	protected function setBlock(){
    	$headerBlock = $this->getLayout()->createBlock("webportal/Backend_Center_Content_Type8_Header");
    	$headerBlock->setTemplate('webportal/center/content/type8/header.phtml')->setTableCode($this->tableCode);
    	
    	$gridBlock =$this->getLayout()->createBlock("webportal/Backend_Center_Content_Type8_Grid")->setTableCode($this->tableCode);
    	$headerBlock->setChild("grid", $gridBlock);
    	
    	$this->getLayout()->getBlock('content')->append($headerBlock);
	}
    
	/*
    public function apctwebassociationAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    
    public function apctwebautomobileAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    */
	
	
	
	
	
	
    
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::helper('webportal/Data')->getType8Model($this->tableCode);
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$type8DTO = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($this->tableCode); 
    			$type8VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($type8DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentType8VO', $type8VO);
    	return Mage::registry('CurrentType8VO');
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$this->tableCode = $this->getRequest()->getParam("TableCode");
    	Mage::register('CurrentTableCode', $this->tableCode);
    	$type8VO = $this->_init();
    	
    	if($type8VO == null){
    		$type8VO = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($this->tableCode);  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type8_Buttons')
    			->setTemplate('webportal/center/content/type8/info.phtml')
    			->setID($type8VO->getID())
    	);
    	
    	
    	
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$this->tableCode = $this->getRequest()->getParam("TableCode");
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type8_Grid')->setTableCode($this->tableCode);
    	$this->getResponse()->setBody($gridBlock->toHtml());
    }
    
    public function saveAction(){
    	try {
    		
    		$post = $this->getRequest()->getPost();
    		
    		$errorMsg = array();
    		$response = array();
    		
    		if (empty($post)) {
    			Mage::throwException($this->__('Invalid form data.'));
    		}
    		
    		/*
    		$fromKey = Mage::getSingleton('adminhtml/session')->getData('FormKey');
    		if($fromKey == $post['form_key']){
    			return;
    		}else{
    			Mage::getSingleton('adminhtml/session')->setData('FormKey', $post['form_key']);
    		}
    		*/
    		
    		$type8DataObj = json_decode($post["Type8DataObj"],true);
    		
    		$this->tableCode = $type8DataObj['TableName'];
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($this->tableCode);
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($this->tableCode);
    		
    		$type8DTO = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($this->tableCode);
    		/* @var $type8VO Margshri_WebPortal_VO_Center_Content_Type8_Type8VO */
    		$type8VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($type8DTO, $type8DataObj);
    		
    		
    		// FOR MUTIPAL TABLE ENTRY
    		$tableDataObjs = $type8VO->getTableVOs();
    		$tableVOs = array();
    		foreach ($tableDataObjs as $tableDataObj){
    			$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    			$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
    			$tableVOs[] = $tableVO;
    		}
    		$type8VO->setTableVOs($tableVOs);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::helper('webportal/Data')->getType8Model($this->tableCode);
    		$response = $model->getResource()->saveDB($type8VO);
    
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			$responseVO->setSuccessMessage($response['message']);
    		}else{
    			$adapter->getAdapter()->rollBack();
    			$responseVO->setErrorMessage($response['message']);
    		}
    
    	} catch (Exception $e) {
    		$adapter->getAdapter()->rollBack();
    		$responseVO->setErrorMessage(array($e->getMessage()));
    	}
    	$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
    	return;
    
    }
    
    
    public function apctwebcollegeAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    
    public function apctwebhostelAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebhotelAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebrestaurantsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebdhabaAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebbambooproductsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebbarAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebprovisionstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpansariAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebicecreambakeryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebsweetshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpannierhouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebmilkmanAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcrockeryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebbartonbandarAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebhealthcaregoodsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebhandloomAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpurifierAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebpetrolpumpAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebdishtvAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebgarmentAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebguesthouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebsareeAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebalstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebjewelleryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebfootwearAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebwatchAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebopticalAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebhosieryshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpicturehouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebkanganstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebelectronicAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebelectronicmediaAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpainthouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebfurnitureAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebironstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebsanitaryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebbuildingmaterialAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebbricksAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebmarbleAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebsteelworkAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebsandAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtrunkshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtimbermartAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebplywoodshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebglassstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebshoppingmollsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcomputerworldAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebcontactusAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebgiftshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebmedicalstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebcyclestoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebstationaryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtelecomshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebsportsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
	public function apctwebartandcraftsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }    


    public function apctwebautomobileAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebhospitalAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebaccountantAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebadvocateAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebarchitectAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcharteraccountantAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebdoctorAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebinteriordecoratorAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
   
    
    
    
    public function apctwebmarriageplaceAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebdharmshalaAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    
    
    
    public function apctwebgeneralphonebookAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebrecruitmentAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcinemaAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebadventureAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebplayzoneAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpicnicspotsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebparksAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebswimmingpoolsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtravelAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtaxiAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebteaAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebindustriesAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebfactoryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebgeneralstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebcompanyAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebgameAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebfoundationsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctweborganizationAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtrustsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebassociationAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebnewspaperagencyAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebngoAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebunionAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebsocietyAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebclubAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebkreshimandiAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebbeautyparloursAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebbloodbankAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebboutiqueAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcarpenterAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebdrivingschoolAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebcementmasonAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcomputerhardwarenetworkingAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebcouriersAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebdharamkantaAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebemitraAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebelectricianAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebfloristAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebmotormechanicAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpainterAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebplumberAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebpropertyadviserAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebscrapstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebsilaicenterAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebstudioAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebsurgicalAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebtailorAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtenthousecaterersAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtiffincenterAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtransportsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebtypecollegesAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebwatercamperAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    public function apctwebprintinghouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    public function apctwebcarpaintorAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebdjAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebdrycleanerAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebmusicalinstrumentsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    	
    public function apctwebclothingAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    	
    public function apctweblacegotastoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    	
    public function apctwebphotostatlaminationAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    
    
    
    public function acptwebmarriagebeuroAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebmattressfoamhouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebnamkeenbhandarAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebattachakkiAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebhaircutAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebemergencyAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }


	public function apctwebtattoosworldAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebbaheestoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
 
	public function apctwebluggageAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebhandicraftsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebfancydressesstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebgaslighthouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
												 
	public function apctwebfruithouseAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebmusiccenterAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
												 


	public function apctwebarmystoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebgemsstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebmatchingstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
												 
	public function apctwebdanceacademyAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebdisposalAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }


	public function apctwebteastallAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebshutteringstoreAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebfourwheelerworkshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebtwowheelerworkshopAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

	public function apctwebrajaigaddabharaicenterAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
 
}
