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
class Mconnectsolutiions_Bestsellerproducts_Block_Bestsellerproducts extends Mage_Catalog_Block_Product_Abstract //Mage_Core_Block_Template
{
        public function _prepareLayout()
        {
            return parent::_prepareLayout();
        }

	public function _construct()
    	{

		$this->setHeader(Mage::getStoreConfig("bestsellerproducts/mconnectsolutiionsgeneral/heading"));
		$this->setItemsPerRow((int)Mage::getStoreConfig("bestsellerproducts/mconnectsolutiionsgeneral/number_of_items_per_row"));
		$this->setStoreId(Mage::app()->getStore()->getId());
		$this->setImageHeight((int)Mage::getStoreConfig("bestsellerproducts/mconnectsolutiionsgeneral/thumbnail_height"));
		$this->setImageWidth((int)Mage::getStoreConfig("bestsellerproducts/mconnectsolutiionsgeneral/thumbnail_width"));
		$this->setTimePeriod((int)Mage::getStoreConfig("bestsellerproducts/mconnectsolutiionsgeneral/time_period"));
		$this->setAddToCart((bool)Mage::getStoreConfig('bestsellerproducts/mconnectsolutiionsbutton/add_to_cart'));
		$this->setActive((bool)Mage::getStoreConfigFlag("bestsellerproducts/mconnectsolutiionsbutton/active"));
		$this->setAddToCompare((bool)Mage::getStoreConfig("bestsellerproducts/mconnectsolutiionsbutton/add_to_compare"));


    	}
        public function getBestsellerproducts()     
        { 
           if (!$this->hasData('bestsellerproducts')) {
               $this->setData('bestsellerproducts', Mage::registry('bestsellerproducts'));
           }
           return $this->getData('bestsellerproducts');

        }
        
         
}

