<?php
class Yes_Master_Block_Office_UserOffice_Grid_UserOffice extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
      	parent::__construct();
        $this->setId('userOfficeGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('user_id');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }  
 	
 	protected function _prepareCollection()
    {  
    	$collection =  Mage::getModel("yesmaster/userOffice")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    } 
    
    protected function _prepareColumns()
    {
    	
    	
        $this->addColumn('user_id', array(
            'header'    =>Mage::helper('adminhtml')->__('ID'),
            'index'     =>'user_id',
            'align'     => 'right',
            'width'    => '50px'
        ));

        $this->addColumn('username', array(
            'header'    =>Mage::helper('adminhtml')->__('User Name'),
            'index'     =>'username'
        ));

        $this->addColumn('firstname', array(
            'header'    =>Mage::helper('adminhtml')->__('First Name'),
            'index'     =>'firstname'
        ));
        
        
        $this->addColumn('lastname', array(
            'header'    =>Mage::helper('adminhtml')->__('Last Name'),
            'index'     =>'lastname'
        ));

		/*        
        $this->addColumn('OfficeName', array(
            'header'    =>Mage::helper('adminhtml')->__('Office Name'),
            'index'     =>'OfficeName'
        ));
       */
        
        $this->addColumn('OfficeID', array(
        		'header'    =>Mage::helper('adminhtml')->__('Office Name'),
        		'index'     =>'OfficeID',
        		'align'     => 'right',
        		'type'  => 'options',
        		'options' => Mage::getModel('yesmaster/offices')->getResource()->getOptionArray()
        ));
        

         return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/userOfficeGrid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/editUserOffice', array('user_id' => $row->getData('user_id')));
    }
    
}