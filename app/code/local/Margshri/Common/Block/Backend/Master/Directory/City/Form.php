<?php
class Margshri_Common_Block_Backend_Master_Directory_City_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("common/master/directory/city/form.phtml");
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
                    'onclick'   => 'cityFormJS.submit(); ',
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
    	   return 'CityForm';
    }
    
    public function getCityListVO(){
        return Mage::registry('CurrentCityListVO');
    }
    
    public function getDistrictListOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Directory_DistrictList_DistrictListVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getSatusOptions(){
        $options = array();
        $statusModel = Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName);
        $options = $statusModel->getResource()->getOptions();
        return $options;
    }
    
}
