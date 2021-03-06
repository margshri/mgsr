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

class Mconnectsolutiions_Bestsellerproducts_Block_Adminhtml_Bestsellerproducts_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('bestsellerproducts_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('bestsellerproducts')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('bestsellerproducts')->__('Item Information'),
          'title'     => Mage::helper('bestsellerproducts')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('bestsellerproducts/adminhtml_bestsellerproducts_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
