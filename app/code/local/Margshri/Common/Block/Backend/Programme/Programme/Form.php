<?php
class Margshri_Common_Block_Backend_Programme_Programme_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("common/programme/programme/form.phtml");
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
                    'onclick'   => 'programmeFormJS.submit(); ',
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
    	   return 'ProgrammeForm';
    }
    
    public function getProgrammeVO(){
        return Mage::registry('CurrentProgrammeVO');
    }
    
    public function getProgrammeTypeOptions(){
        $options = array();
        $programmeTypeModel = Mage::getModel(Margshri_Common_VO_Master_Programme_ProgrammeTypeVO::$modelName);
        $options = $programmeTypeModel->getResource()->getOptions();
        return $options;
    }
    
    public function getProgrammeStatusOptions(){
        $options = array();
        $programmeStatusModel = Mage::getModel(Margshri_Common_VO_Master_Programme_ProgrammeStatusVO::$modelName);
        $options = $programmeStatusModel->getResource()->getOptions();
        return $options;
    }
    
}
