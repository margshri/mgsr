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

class Mconnectsolutiions_Bestsellerproducts_Model_Autoplaysilder 
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'false', 'label'=>Mage::helper('adminhtml')->__('No')),
            array('value' => 'true', 'label'=>Mage::helper('adminhtml')->__('Yes')),
            
        );
    }
}
