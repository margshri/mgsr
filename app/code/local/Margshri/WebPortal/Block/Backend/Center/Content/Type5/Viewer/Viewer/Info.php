<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type5_Viewer_Viewer_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel(){
        return Mage::helper('adminhtml')->__('Viewer Info');
    }

    public function getTabTitle(){
        return $this->getTabLabel();
    }

    public function canShowTab(){
        return true;
    }

    public function isHidden(){
        return false;
    }
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('webportal/center/content/type5/viewer/viewer/entropy.phtml');
    }

    public function getViewerVO(){
        return Mage::registry('CurrentViewerVO');
    }

    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Center_Content_Type5_Viewer_ViewerStatus');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'Viewer';
    }
    
}