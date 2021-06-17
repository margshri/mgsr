<?php 
class Yes_Master_Block_Office_OfficeType_Grid_OfficeTypeList extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('officeTypeGrid');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('officeTypeId');
        $this->setDefaultDir('asc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {  
        $collection =  Mage::getModel("yesmaster/officeType")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
        
    }

    protected function _prepareColumns()
    {
    	
        $this->addColumn('officeTypeId', array(
            'header'    =>Mage::helper('adminhtml')->__('ID'),
            'index'     =>'OfficeTypeId',
            'align'     => 'right',
            'width'    => '50px'
        ));

        $this->addColumn('TypeName', array(
            'header'    =>Mage::helper('adminhtml')->__('Type Name'),
            'index'     =>'TypeName'
        ));

       $this->addColumn('TypeCode', array(
            'header'    =>Mage::helper('adminhtml')->__('Type Code'),
            'index'     =>'TypeCode'
        ));
        
         return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/officeTypeList', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('officeTypeId' => $row->getData('OfficeTypeId')));
    }
 
}

