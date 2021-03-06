<?php
/**
 * M-Connect Solutions.
 *
 * NOTICE OF LICENSE
 *

 *
 * @category   Catalog
 * @package   Mconnectsolutiions_Bestsellerproducts
 * @author      M-Connect Solutions (http://www.magentoconnect.us)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mconnectsolutiions_Bestsellerproducts_Block_Adminhtml_Bestsellerproducts_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('bestsellerproducts_form', array('legend'=>Mage::helper('bestsellerproducts')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bestsellerproducts')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('bestsellerproducts')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('bestsellerproducts')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('bestsellerproducts')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('bestsellerproducts')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('bestsellerproducts')->__('Content'),
          'title'     => Mage::helper('bestsellerproducts')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getBestsellerproductsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getBestsellerproductsData());
          Mage::getSingleton('adminhtml/session')->setBestsellerproductsData(null);
      } elseif ( Mage::registry('bestsellerproducts_data') ) {
          $form->setValues(Mage::registry('bestsellerproducts_data')->getData());
      }
      return parent::_prepareForm();
  }
}
