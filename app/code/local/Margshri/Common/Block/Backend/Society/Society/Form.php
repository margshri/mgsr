<?php
class Margshri_Common_Block_Backend_Society_Society_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("common/society/society/form.phtml");
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
                    'onclick'   => 'societyFormJS.submit(); ',
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
    	   return 'SocietyForm';
    }
    
    public function getSocietyVO(){
        return Mage::registry('CurrentSocietyVO');
    }
    
    public function getAreaOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getStatusOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
}
