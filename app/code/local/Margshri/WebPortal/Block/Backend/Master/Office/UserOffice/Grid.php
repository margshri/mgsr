<?php
class Margshri_WebPortal_Block_Backend_Master_Office_UserOffice_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	
	protected $currentUserID;
	protected $currentRoleID;
	
	public function __construct()
	{
		parent::__construct();
		$this->setId('useroffice');
		$this->setSaveParametersInSession(true);
		$this->setDefaultSort('ID');
		$this->setDefaultDir('desc');
		$this->setUseAjax(true);
		
		$this->currentUserID = Mage::getSingleton('admin/session')->getUser()->getId();
		$this->currentRoleID = implode('', Mage::getSingleton('admin/session')->getUser()->getRoles());
		
	}

	protected function _prepareCollection()
	{
		try{
			$collection =  Mage::getModel("webportal/Master_Office_UserOffice_UserOffice")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable('webportal/adminuser')), array("main_table.user_id"=>"main_table.user_id", "main_table.FirstName"=>"main_table.firstname", "main_table.LastName"=>"main_table.lastname", "main_table.UserName"=>"main_table.username",    "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("useroffice"=>$collection->getTable('webportal/apctwebuseroffice')), 'main_table.user_id = useroffice.AdminUserID', array("useroffice.ID"=>"useroffice.ID", "useroffice.AdminUserID"=>"useroffice.AdminUserID", "useroffice.OfficeID"=>"useroffice.OfficeID", "useroffice.StatusID"=> "useroffice.StatusID" ));
			$collection->getSelect()->joinLeft(array("office"=>$collection->getTable('webportal/apctweboffice')), 'useroffice.OfficeID = office.ID', array("office.ID"=>"office.ID", "office.Value"=>"office.Value"));
			$collection->getSelect()->joinLeft(array("status"=>$collection->getTable('webportal/apctstatus')), 'useroffice.StatusID = status.ID', array("status.ID"=>"status.ID", "status.Value"=>"status.Value"));
			if($this->currentRoleID != Margshri_WebPortal_VO_Master_ConfigVO::$ADMIN_ROLE_ID){
				$collection->getSelect()->Where('main_table.user_id != ?', 1);
			}
			$collection->getSelect()->Order('main_table.user_id Desc');
			$this->setCollection($collection);
			return parent::_prepareCollection();
		}catch(Exception $e){
        	return;
        }

	}


	protected function _prepareColumns()
	{

		$this->addColumn('ID', array(
				'header'    =>Mage::helper('adminhtml')->__('ID'),
				'index'     =>'main_table.user_id',
				'align'     => 'right',
				'width'    => '50px'
		));
		
		$this->addColumn('username', array(
				'header'    =>Mage::helper('adminhtml')->__('User Name'),
				'index'     =>'main_table.UserName',
		));
		
		
		$this->addColumn('firstname', array(
		 		'header'    =>Mage::helper('adminhtml')->__('First Name'),
		 		'index'     =>'main_table.FirstName',
		));
		
		$this->addColumn('lastname', array(
				'header'    =>Mage::helper('adminhtml')->__('Last Name'),
				'index'     =>'main_table.LastName',
		));
		
		
		$this->addColumn('OfficeID', array(
				'header'    =>Mage::helper('adminhtml')->__('Office'),
				'type'  => 'options',
				'index' => 'useroffice.OfficeID',
				'options' => Mage::getModel('webportal/Master_Office_Office_Office')->getResource()->getOptions()
		));
		
		$this->addColumn('StatusID', array(
				'header'    =>Mage::helper('adminhtml')->__('Status'),
				'type'  => 'options',
				'index' => 'useroffice.StatusID',
				'options' => Mage::getModel('webportal/Status_Status')->getResource()->getOptions()
		));
		
		$this->addColumn('edit', array(
				'header'    =>Mage::helper('adminhtml')->__('Edit'),
				'index'     =>'main_table.edit', 
				'align'     => 'left',
				'width'    => '50px',
				'sortable'  => false,
				'filter'    => false,
				'renderer'  => 'webportal/Backend_Master_Office_UserOffice_Renderer',
				
		));
				

		return parent::_prepareColumns();
		
	}

	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}


}

