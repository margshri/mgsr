<?php 
class Yes_CatalogUpload_ProductUploadController extends Mage_Adminhtml_Controller_Action
{
	private static $counter = 0;
	
	
	
	public function indexAction(){
		  $this->_title($this->__('Catalog Product Upload'));
		  $this->loadLayout();
		  
		  $this->_setActiveMenu('catalog');
		  $headerBlock= $this->getLayout()->createBlock('yescatalogupload/product_header')->setTemplate('Yes/CatalogUpload/Product/Header.phtml');
		  $gridBlock= $this->getLayout()->createBlock('yescatalogupload/product_grid_fileUploaded',"yescatalogupload.product.grid.fileUploaded") ;
		  
		  $headerBlock->setChild('grid',$gridBlock);
		  $this->getLayout()->getBlock('content')->append($headerBlock);
		  $this->renderLayout();
		  
	}
	public function fileUploadPageAction(){
		
		$this->_title($this->__('Product Upload'));
		$this->loadLayout();
		
		
		$headerBlock= $this->getLayout()->createBlock('yescatalogupload/product_buttons')->setTemplate('Yes/CatalogUpload/Product/info.phtml');
		$this->getLayout()->getBlock('content')->append($headerBlock);
		$this->renderLayout();
		
		
	}
	
	
 	public function uploadAction()
    {
    	if((!empty($_FILES["file"])) && (!empty($_FILES['fileImage'])))
    	{
    		
    		$model = Mage::getModel('yescatalogupload/productUpload');
    		$response = $model->fileProcessing($_FILES["file"] , $_FILES['fileImage']);
    		
    	}
    	
    	if ($response['status'] == 'FAIL')
    		Mage::getSingleton('core/session')->addError($response['message']);
    	else if($response['status'] == 'SUCCESS')
    		Mage::getSingleton('core/session')->addSuccess($response['message']);
    	$this->_redirect("*/*/fileUploadPage");
   		 	
    }// end save action
    
    
   public function saveDB($row)
   {
   		// initailize variables
   		 
   		
	   	$con = mysql_connect('localhost','root','root') or die(mysql_error());
	   	$db = mysql_select_db('firangi',$con) or die(mysql_error());
	   	
   		$entity_type_id = 4;
	   	
	   	$store_id = $row[0];
	   	$websites_id = $row[1];
	   	$attribute_set_id = $row[2];
	   	$type_id = $row[3];
	   	$category_ids = $row[4];
	   	
	   
	   	 
	   	
	   	
	   	
	   	$sku = $row[5];  //'check' . Yes_CatalogUpload_ProductUploadController::$s ;
	   	//Yes_CatalogUpload_ProductUploadController::$s = 1;
	   	
	   	$name = $row[6];

	   	$str_first =  substr($row[7],0,1);
	   	$str_first_lower = strtolower($str_first);
	   	$str_second =  substr($row[7],1,1);
	   	$str_second_lower = strtolower($str_second);
	   	
	   	//$image_format = rand() . '_' . date("Y-m-d_h:i:s") . '_' . 'img';
	   	$image = '/' . $str_first_lower . '/' . $str_second_lower . '/' . $row[7];
	   	 
	   	 
	   	$str_first =  substr($row[8],0,1);
	   	$str_first_lower = strtolower($str_first);
	   	$str_second =  substr($row[8],1,1);
	   	$str_second_lower = strtolower($str_second);
	   	
	   	//$image_format = rand() . '_' . date("Y-m-d_h:i:s") . '_' . 'small';
	   	$small_image = '/' . $str_first_lower . '/' . $str_second_lower . '/' . $row[8];
	   	
	   	$str_first =  substr($row[9],0,1);
	   	$str_first_lower = strtolower($str_first);
	   	$str_second =  substr($row[9],1,1);
	   	$str_second_lower = strtolower($str_second);
	   	
	   	//$image_format = rand() . '_' . date("Y-m-d_h:i:s") . '_' . 'thumb';
	   	$thumbnail = '/' . $str_first_lower . '/' . $str_second_lower . '/' . $row[9];
	   	
	   	$weight = $row[10];
	   	$status = $row[11];
	   	$visibility = $row[12];
	   	$description = $row[13];
	   	$short_description = $row[14];
	   	$price = $row[15];
	   	$qty = $row[16];
	   	$is_in_stock = $row[17];
	   	$tax_class_id = $row[18];
	   	
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity` (`entity_type_id`, `attribute_set_id`, `type_id`, `sku`, `created_at`, `updated_at`)
	   											VALUES ('".$entity_type_id."','".$attribute_set_id."', '".$type_id."', '".$sku."',NULL, NULL)";
	   	mysql_query($insert_query) or die(mysql_error());
	   	
	   	$select_query = "select entity_id from catalog_product_entity where sku = '$sku'";
	   	$result = mysql_query($select_query);
	   	$entity_id = mysql_fetch_array($result);
	   	
	   	
	   	$image_label=null;
	   	$small_image_label=null;
	   	$thumbnail_label=null;
	   	
	   	//date_default_timezone_set("UTC");
	   	//$date = date("Y-m-d H:i:s", time());
	   	//echo $date;
	   	//for ($i = 1; $i <= 9; $i++) {
	    //		$update_query = "UPDATE `index_process` SET `started_at` = '".$date."' WHERE process_id='".$i."'";
	   	//}
	   	
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity_varchar` (`entity_type_id`,`attribute_id`,`store_id`,`entity_id`,`value`)
															   	VALUES ('".$entity_type_id."', '71', '".$store_id."', '".$entity_id[0]."', '".$name."'),
																	   	('".$entity_type_id."', '97', '".$store_id."', '".$entity_id[0]."', 'URL'),
																	   	('".$entity_type_id."', '117', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '118', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '119', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '82', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '84', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '85', '".$store_id."', '".$entity_id[0]."', '".$image."'),
																	   	('".$entity_type_id."', '86', '".$store_id."', '".$entity_id[0]."', '".$small_image."'),
																	   	('".$entity_type_id."', '87', '".$store_id."', '".$entity_id[0]."', '".$thumbnail."'),
																	   	('".$entity_type_id."', '103', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '107', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '109', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '123', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '112', '".$store_id."', '".$entity_id[0]."', '".$image_label."'),
																	   	('".$entity_type_id."', '113', '".$store_id."', '".$entity_id[0]."', '".$small_image_label."'),
																	   	('".$entity_type_id."', '114', '".$store_id."', '".$entity_id[0]."', '".$thumbnail_label."') 
								   										ON DUPLICATE KEY UPDATE value = VALUES(`value`)";
	   	mysql_query($insert_query) or die(mysql_error());
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity_text` (`entity_type_id`,`attribute_id`,`store_id`,`entity_id`,`value`)
														   	VALUES ('".$entity_type_id."', '72', '".$store_id."', '".$entity_id[0]."', '".$description."'),
																   	('".$entity_type_id."', '73', '".$store_id."', '".$entity_id[0]."', '".$short_description."'),
																   	('".$entity_type_id."', '83', '".$store_id."', '".$entity_id[0]."', NULL),
																   	('".$entity_type_id."', '106', '".$store_id."', '".$entity_id[0]."', NULL) 
																   	ON DUPLICATE KEY UPDATE value = VALUES(`value`)";
	   	mysql_query($insert_query) or die(mysql_error());
	   	
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity_decimal` (`entity_type_id`,`attribute_id`,`store_id`,`entity_id`,`value`)
															   	VALUES ('".$entity_type_id."', '80', '".$store_id."', '".$entity_id[0]."', '".$weight."'),
																	   	('".$entity_type_id."', '75', '".$store_id."', '".$entity_id[0]."', '".$price."'),
																	   	('".$entity_type_id."', '76', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '120', '".$store_id."', '".$entity_id[0]."', NULL) 
																	   	ON DUPLICATE KEY UPDATE value = VALUES(`value`)";
	   	mysql_query($insert_query);
	   	
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity_datetime` (`entity_type_id`,`attribute_id`,`store_id`,`entity_id`,`value`)
															   	VALUES ('".$entity_type_id."', '93', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '94', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '77', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '78', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '104', '".$store_id."', '".$entity_id[0]."', NULL),
																	   	('".$entity_type_id."', '105', '".$store_id."', '".$entity_id[0]."', NULL) 
			   															ON DUPLICATE KEY UPDATE value = VALUES(`value`)";
	   	mysql_query($insert_query);
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity_int` (`entity_type_id`,`attribute_id`,`store_id`,`entity_id`,`value`)
														   	VALUES ('".$entity_type_id."', '96', '".$store_id."', '".$entity_id[0]."', '".$status."'),
																   	('".$entity_type_id."', '102', '".$store_id."', '".$entity_id[0]."', '".$visibility."'),
																   	('".$entity_type_id."', '121', '".$store_id."', '".$entity_id[0]."', '1'),
																   	('".$entity_type_id."', '122', '".$store_id."', '".$entity_id[0]."', '".$tax_class_id."'),
																   	('".$entity_type_id."', '100', '".$store_id."', '".$entity_id[0]."', '0') 
																   	ON DUPLICATE KEY UPDATE value = VALUES(`value`)";
	   	mysql_query($insert_query);
	   	 
	   	 
	   	$insert_query = "INSERT INTO `catalog_product_website` (`product_id`,`website_id`) 
	   													VALUES ('".$entity_id[0]."', '".$websites_id."')";
	   	mysql_query($insert_query);
	   	
	   	
	   	$insert_query = "INSERT INTO `catalog_category_product` (`category_id`,`product_id`,`position`)
	   													 VALUES ($category_ids, '".$entity_id[0]."', '1')";
	   	mysql_query($insert_query);
	   	 
	   
	   	$insert_query = "INSERT INTO `catalog_product_entity_media_gallery` (`attribute_id`, `entity_id`, `value`)
	   																 VALUES ('88', '".$entity_id[0]."', '".$image."')";
	   	mysql_query($insert_query);
	   	
	   	
	   	
	   	$insert_query = "INSERT INTO `catalog_product_entity_media_gallery_value` (`value_id`, `store_id`, `label`, `position`, `disabled`)  
	   																	   VALUES ('7', '".$store_id."', '', '1', '0')";
	   	mysql_query($insert_query);
	   	
	   	
	   	
	   	$insert_query = "INSERT INTO `cataloginventory_stock_item` (`product_id`, `stock_id`, `qty`, `use_config_min_qty`, 
	   																`is_qty_decimal`, `use_config_backorders`, `use_config_min_sale_qty`, 
	   																	`use_config_max_sale_qty`, `is_in_stock`, `low_stock_date`, 
	   																		`use_config_notify_stock_qty`, `use_config_manage_stock`, 
	   																		`stock_status_changed_auto`, `use_config_qty_increments`,
	   																		 `use_config_enable_qty_inc`, `is_decimal_divided`)
	   						VALUES ('".$entity_id[0]."', '1', '".$qty."', '1', '0', '1', '1', '1', '".$is_in_stock."', NULL, '1', '1', '0', '1', '1', '0')";
	   	mysql_query($insert_query);
	   	
	   		
	   	
	   	$insert_query = "INSERT INTO `cataloginventory_stock_status` (`product_id`,`website_id`,`stock_id`,`qty`,`stock_status`)
	   														  VALUES ('".$entity_id[0]."', '".$websites_id."', '1', '".$qty."', '1')
														   	  ON DUPLICATE KEY UPDATE qty = VALUES(`qty`), 
														   	                 stock_status = VALUES(`stock_status`)";
	   	mysql_query($insert_query);
	   	
	   	
	   	
	 	for ($i = 1; $i <= 9; $i++) {
	   		$process = Mage::getModel('index/process')->load($i);
	   		$process->reindexAll();
	   	} 
	  
	  
	   	
	   	self::$counter = self::$counter + 1;
	   
	   	return self::$counter;
	   	//echo "you have successfully added products";
	   	
   	
   }  // end saveDB function 
   
   
   
   
   public function gridAction()
   {
   
   		$this->loadLayout();
   		$this->getResponse()->setBody($this->getLayout()->createBlock('yescatalogupload/product_grid_fileUploaded',"yescatalogupload.product.grid.fileUploaded")->toHtml() );
        
   }
	
	
}// end class