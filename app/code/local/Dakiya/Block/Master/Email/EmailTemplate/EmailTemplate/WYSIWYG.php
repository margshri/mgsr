<?php
class Dakiya_Block_Master_Email_EmailTemplate_EmailTemplate_WYSIWYG extends Mage_Adminhtml_Block_Widget_Form{ 
    
    public function __construct(){
        parent::__construct();
    }
  
    
	protected function _prepareLayout(){
        // Load Wysiwyg on demand and Prepare layout
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
            $block->setCanLoadTinyMce(true);
        }
        parent::_prepareLayout();
    }
    
    
    protected function _prepareForm(){
    	
    	$form   = new Varien_Data_Form(array(
    			'id'        => 'edit_form',
    			'action'    => $this->getUrl('*/*/save'),
    			'method'    => 'post'
    	));
    
    	$fieldset   = $form->addFieldset('base_fieldset', array(
    			//'legend'    => Mage::helper('dakiya')->__("Some Information"),
    			'class'     => 'fieldset-wide',
    	));
    
    	$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');
    	$fieldset->addField('Content', 'editor', array(
    			'name'      => 'Content',
    			'label'     => Mage::helper('dakiya')->__('Content'),
    			'title'     => Mage::helper('dakiya')->__('Content'),
    			'style'     => 'height: 500px;',
    			'wysiwyg'   => true,
    			'required'  => false,
    			'config'    => $wysiwygConfig
    	));
    	
    	$this->setForm($form);
    
    	return parent::_prepareForm();
    }
    
}