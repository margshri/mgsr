<?php 

class Yes_Master_Block_Office_Offices_Grid_Offices extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
       	parent::__construct();
        $this->setId('officesGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('OfficeID');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {   
    	/*
        $collection =  Mage::getModel("yesmaster/offices")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
        */
    	
    	$model = Mage::getModel("yesmaster/offices");
    	$this->_resourceCollectionName = $model->getResourceName() ."_collection" ;
    	
    	$resource =Mage::getResourceSingleton($model->getResourceName() , array("model"=> "yesmaster/offices" ,  "primery_key"=>"OfficeID"));
    	$collection  = Mage::getResourceModel($this->_resourceCollectionName, $resource );
    	
    	$collection->joinLeft(array('state'=>$resource->getTable('yesmaster/state')), "main_table.stateId= state.stateId ", array('statename'=>'stateName' , 'state.stateId'=>'stateId'  ));
     	
    	$this->setCollection($collection);
    	
    	return parent::_prepareCollection();
    	
    }

    protected function _prepareColumns()
    {
		
    	
        $this->addColumn('OfficeID', array(
            'header'    =>Mage::helper('adminhtml')->__('ID'),
            'index'     =>'OfficeID',
            'align'     => 'right',
            'width'    => '50px'
        ));

        $this->addColumn('OfficeName', array(
            'header'    =>Mage::helper('adminhtml')->__('Office Name'),
            'index'     =>'OfficeName'
        ));

        $this->addColumn('OfficeCode', array(
            'header'    =>Mage::helper('adminhtml')->__('Office Code'),
            'index'     =>'OfficeCode'
        ));
     
     
        $this->addColumn('stateName', array(
        		'header'    =>Mage::helper('adminhtml')->__('State'),
        		'index'     =>'state.stateId',
        		'align'     => 'left',
        		'width'    => '100px',
        		'type'  => 'options',
        		'options' => Mage::getModel('yesmaster/state')->getResource()->getOptionArray()
        ));

       
              
         return parent::_prepareColumns();
    }
    
    public function getGridUrl()
    {
    	
    	return $this->getUrl('*/*/offices', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
    	
    	return $this->getUrl('*/*/editOffice', array('OfficeID' => $row->getData('OfficeID')));
    }

 
}

