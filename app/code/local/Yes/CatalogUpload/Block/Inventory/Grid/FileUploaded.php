<?php

class Yes_CatalogUpload_Block_Inventory_Grid_FileUploaded extends Mage_Adminhtml_Block_Widget_Grid //MageCoreInherit_Grid
{

    
    public function __construct()
    { 
    	parent::__construct();
        $this->setId('flieuploaded');
        $this->setSaveParametersInSession(true);
        $this->setDefaultSort('UploadID');
        $this->setDefaultDir('desc');
        $this->setUseAjax(true);
        
    }

   protected function _prepareCollection()
    {    
    	$collection =  Mage::getModel("yescatalogupload/fileUpload")->getCollection()
    		->addFieldToFilter('TemplateID',Yes_VO_Template_TemplateVO::$INVENTORY_UPLOAD_TEMPLATE_ID)
    		->addOrder('UploadID', 'DESC');
    	$this->setCollection($collection);
    	return parent::_prepareCollection();
    }
    

     protected function _prepareColumns()
    {
    	
        $this->addColumn('uploadId', array(
            'header'    =>Mage::helper('adminhtml')->__('Id'),
            'index'     =>'UploadID',
            'align'     => 'left',
            'width'    => '30px'
        ));

        
        $this->addColumn('fileName', array(
        		'header'    =>Mage::helper('adminhtml')->__('File Name'),
        		'index'     =>'FileName',
        		'width'    => '100px',
        ));
        
        $this->addColumn('referenceName', array(
        		'header'    =>Mage::helper('adminhtml')->__('Reference Name'),
        		'index'     =>'ReferenceName',
        		'width'    => '100px',
        ));
        
        
        $this->addColumn('rowProcessed', array(
        		'header'    =>Mage::helper('adminhtml')->__('Rows Processed'),
        		'index'     =>'RowsProcessed',
        		'width'    => '100px',
        ));

        
        $this->addColumn('rowError', array(
        		'header'    =>Mage::helper('adminhtml')->__('Rows Error'),
        		'index'     =>'NRowsError',
        		'width'    => '100px',
        ));
        
        /*
        $this->addColumn('rowSuccess', array(
        		'header'    =>Mage::helper('adminhtml')->__('Rows Success'),
        		'index'     =>'NRowsSuccessed',
        		'width'    => '100px',
        ));
        
        
        $this->addColumn('successLog', array(
        		'header'    =>Mage::helper('adminhtml')->__('Success Log'),
        		'index'     =>'SuccessFileURL',
        		'width'    => '100px',
        ));
        
        */
        
        $this->addColumn('errorFile', array(
        		'header'    =>Mage::helper('adminhtml')->__('Error File'),
        		'index'     =>'ErrorFileName',
        		'width'    => '100px',
        ));
        
        /*
        $this->addColumn('statusID', array(
        		'header'    =>Mage::helper('adminhtml')->__('Status'),
        		'index'     =>'StatusID',
        		'width'    => '100px',
        ));
		*/

        $this->addColumn('StatusID', array(
        		'header'    =>Mage::helper('adminhtml')->__('Status'),
        		'index'     =>'StatusID',
        		'align'     => 'left',
        		'width'    => '100px',
        		'type'  => 'options',
        		'options' => Mage::getModel('yescatalogupload/fileUpload')->getResource()->getOptionArray()
        ));
        
        $outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $this->addColumn('UploadeddAt', array(
        		'header'    =>Mage::helper('adminhtml')->__('Uploaded At'),
        		'index'     =>'UploadeddAt',
        		'align'     => 'left',
        		'width'    => '30px',
        		'type'      => 'datetime',
        		'format' => $outputFormat,
        		'time' => true,
        ));
        
        
        /*
        $this->addColumn('uploadedAt', array(
            'header'    =>Mage::helper('adminhtml')->__('Uploaded At'),
            'type'  => 'datetime',
            'index'     =>'UploadeddAt', 
            'width'    => '100px'
        ));
    
        */
        
        /*
        $this->addColumn('consignorOfficeName', array(
            'header'    =>Mage::helper('adminhtml')->__('Consignor Office'),
            'index'     =>'consignorOffice.officeId',
            'align'     => 'left',
            'width'    => '100px',
            'type'  => 'options',
           'options' => Mage::getModel('springommasters/offices')->getResource()->getOptionArray()       
        ));
        
        */
        
         
        

        return parent::_prepareColumns();
    }

    
    /**
     * Add mass-actions to grid
     */
    protected function _prepareMassaction()
    {
        return;

        //Commented for future use
        //$this->setMassactionIdField('entityId');
        //$this->getMassactionBlock()->setFormFieldName('types');
        //$requestParam= $this->getRequestParameter();
        //$url =$this->getUrl('*/*/setStatus') . "status/" . StatusVO::$PLANPRODUCTSTATUS_VOID ."/";
        //$this->getMassactionBlock()->addItem('Void', array(
        //    'label'         => Mage::helper('index')->__('Void'),
        //   'url'           => $url,
       // ));
        
    

        //return $this;
    }
    
   public function getGridUrl()
    {
        $url = $this->getUrl('*/*/grid'  , array('_current'=>true  ) );
        return $url;
    }

    public function getRowUrl($row)
    {
        //return $this->getUrl('*/*/edit', array('GrnProductEntityId' => $row->getData('GrnProductEntityId') ) );
        
    }
        
}