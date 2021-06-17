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

class Mconnectsolutiions_Bestsellerproducts_Block_Adminhtml_Bestsellerproducts_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'bestsellerproducts';
        $this->_controller = 'adminhtml_bestsellerproducts';
        
        $this->_updateButton('save', 'label', Mage::helper('bestsellerproducts')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bestsellerproducts')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('bestsellerproducts_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'bestsellerproducts_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'bestsellerproducts_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('bestsellerproducts_data') && Mage::registry('bestsellerproducts_data')->getId() ) {
            return Mage::helper('bestsellerproducts')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('bestsellerproducts_data')->getTitle()));
        } else {
            return Mage::helper('bestsellerproducts')->__('Add Item');
        }
    }
}
