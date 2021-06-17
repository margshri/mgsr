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
class Mconnectsolutiions_Bestsellerproducts_Block_Adminhtml_Bestsellerproducts extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {

    $this->_controller = 'adminhtml_bestsellerproducts';
    $this->_blockGroup = 'bestsellerproducts';
    $this->_headerText = Mage::helper('bestsellerproducts')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('bestsellerproducts')->__('Add Item');
    parent::__construct();
  }
}
