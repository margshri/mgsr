<?php
class Margshri_Transport_Block_Backend_Master_Vahicale_Vahicale_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("transport/master/vahicale/vahicale/form.phtml");
    }

    protected function _prepareLayout(){
    	 
    	$this->setChild('backButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Back'),
                    'onclick'   => 'window.location.href=\''.$this->getUrl('*/*/').'\'',
                    'class' => 'back'
                ))
        );

        $this->setChild('resetButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Reset'),
                    'onclick'   => 'window.location.reload()'
                ))
        );

        $this->setChild('saveButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('adminhtml')->__('Save'),
                    'onclick'   => 'vahicaleFormJS.submit(); ',
                    'class' => 'save'
                ))
        );
		
        return parent::_prepareLayout();
    }

    public function getBackButtonHtml(){
        return $this->getChildHtml('backButton');
    }

    public function getResetButtonHtml(){
        return $this->getChildHtml('resetButton');
    }

    public function getSaveButtonHtml(){
        return $this->getChildHtml('saveButton');
    }

    public function getHTMLFormID(){
    	   return 'VahicaleForm';
    }
    
    public function getVahicaleVO(){
        return Mage::registry('CurrentVahicaleVO');
    }
    
    public function getStatusOptions(){
        $options = array();
        $userModel = Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName);
        $options = $userModel->getResource()->getOptions();
        return $options;
    }
    
    public function getOwnerOptions(){
        $options = array();
        $userModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
        $options = $userModel->getResource()->getActiveOptions();
        return $options;
    }
}
