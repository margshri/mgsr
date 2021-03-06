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

class Mconnectsolutiions_Bestsellerproducts_Model_Styles 
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'none', 'label'=>Mage::helper('adminhtml')->__('None')),
            array('value' => 'slide', 'label'=>Mage::helper('adminhtml')->__('Slide')),
            array('value' => 'fade', 'label'=>Mage::helper('adminhtml')->__('Fade')),
            array('value' => 'kick', 'label'=>Mage::helper('adminhtml')->__('Kick')),
	        array('value' => 'transfer', 'label'=>Mage::helper('adminhtml')->__('Transfer')),
            array('value' => 'shuffle', 'label'=>Mage::helper('adminhtml')->__('Shuffle')),
            array('value' => 'explode', 'label'=>Mage::helper('adminhtml')->__('Explode')),
            array('value' => 'turnOver', 'label'=>Mage::helper('adminhtml')->__('TurnOver')),
	        array('value' => 'chewyBars', 'label'=>Mage::helper('adminhtml')->__('ChewyBars')),
        );
    }
}
