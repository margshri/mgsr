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

$installer = $this;

$installer->startSetup();

$installer->run("DROP TABLE IF EXISTS {$this->getTable('bestsellerproducts')};
CREATE TABLE {$this->getTable('bestsellerproducts')} (
  `bestsellerproducts_id` int(11) unsigned NOT NULL auto_increment,
  `sku` varchar(255) NULL default '',
  `products_date` date NULL,
  PRIMARY KEY (`bestsellerproducts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


$installer->run("INSERT INTO {$this->getTable('core_config_data')} (`scope`,`scope_id`,`path`,`value`) values ('default','0','bestsellerproducts/mconnectsolutiionsgeneral/date_picker_fromhidden', 'NULL');");
$installer->run("INSERT INTO {$this->getTable('core_config_data')} (`scope`,`scope_id`,`path`,`value`) values ('default','0','bestsellerproducts/mconnectsolutiionsgeneral/date_picker_tohidden', 'NULL');");

$installer->endSetup();
