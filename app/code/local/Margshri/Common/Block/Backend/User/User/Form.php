<?php
class Margshri_Common_Block_Backend_User_User_Form extends Mage_Adminhtml_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate("common/user/user/form.phtml");
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
                    'onclick'   => 'userFormJS.submit(); ',
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
    	   return 'UserForm';
    }
    
    public function getUserVO(){
        return Mage::registry('CurrentUserVO');
    }
    
    public function getNamePrefixOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Master_NamePrefix_NamePrefixVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getAreaOptions(){
        $areaOptions = array();
        $areaModel = Mage::getModel(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
        $areaOptions = $areaModel->getResource()->getActiveOptions();
        return $areaOptions;
    }
    
    public function getGenderOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Master_Gender_GenderVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getBloodGroupOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Master_BloodDonation_BloodGroupVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getStatusOptions(){
        $options = array();
        $model = Mage::getModel(Margshri_Common_VO_Status_StatusVO::$modelName);
        $options = $model->getResource()->getOptions();
        return $options;
    }
    
    public function getYesNoOptions(){
        $options = array('1'=>'Yes', '0'=>'No');
        return $options;
    }
    
}
