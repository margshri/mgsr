<?php
class Margshri_Transport_Block_Backend_Master_Vahicale_Owner_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("transport/master/vahicale/owner/form.phtml");
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
                    'onclick'   => 'ownerFormJS.submit(); ',
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
    	   return 'OwnerForm';
    }
    
    public function getOwnerVO(){
        return Mage::registry('CurrentOwnerVO');
    }
    
    public function getStatusOptions(){
        $options = array();
        $statusModel = Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName);
        $options = $statusModel->getResource()->getOptions();
        return $options;
    }
    
}
