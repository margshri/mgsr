<?php

class Yes_Master_Block_Office_Offices_Tab_OfficeTerminal extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Office Terminal');
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
        $this->setTemplate('YesMaster/officeTerminal.phtml');
    }    

    protected function _prepareLayout()
    {
            $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label'     => Mage::helper('catalog')->__('Add Terminal'),
                'onclick'   => 'return terminal.addTerminal()',
                'class'     => 'add'
            ));
        $button->setName('add_tier_terminal_button');

        $this->setChild('add_button', $button);
        return parent::_prepareLayout();
    }    
    
    public function getGridHeader()
    {
    	return array('Bank'=>'200' , "MID"=>'200', "TID"=>'200' );
    }    
    
    public function getAddButtonHtml()
    {
           return $this->getChildHtml('add_button');
    }
    
    public function getBankList()
    {
    	$model = Mage::getModel('yesmaster/bank');
        $model->setData(array());
        $columns = array("bnk.bankId","bnk.bankName");
        $limit = null;
        $whereClause = "0=0";
        $orderby ='bankId asc';
        $model->getResource()->getBank($model, $columns  ,$whereClause, $orderby , $limit  );
        return $model->getData();
    	
    }
    
    
        public function getHtmlId()
    {
            $obj 	= new Yes_Master_Block_Offices_Offices_Buttons();
    	    return $obj->getHTMLId();// "officeTerminal";
    }  
    
     public function getTerminal()
    {
            //$office = Mage::registry('current_office')
            //$officeId= $office->getData('officeID') ;
            
        $officeId= Mage::registry('current_office')->getData('officeID') ;
        
        $model = Mage::getModel('yesmaster/offices');
        $model->setData(array());
        $terminals = $model->getResource()->getOfficeTerminal($officeId );
        
        return $terminals  ;
    } 
    
}