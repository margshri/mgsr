<?php

class AdminAPI_WordPressMapping_InventoryBL{
    
    public static function manageProductStock(){
    	Mage::log('In AdminAPI_WordPressMapping_InventoryBL-> manageProductStock Method', null, 'wordpress.log', true);
		header('Content-Type: application/json');
		$response = array();
        try{    
        	/*
        	$productDataObj = Mage::getModel('catalog/product')->loadByAttribute('sku','3008');
            $stockDataObj = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productDataObj);
            echo json_encode($stockDataObj->getData());
	 		exit(0);
			*/

	 	    // $request_body = file_get_contents('php://input');  
		    // $jsonObj = json_decode($request_body);
		 
             // $environment = "STAGING";
             $environment = "PRODUCTION";
          
	 		 $wpParam = array();
	 		 $wpParam['wef'] = "2020-04-09";
	 		 
	 		 if($environment == "STAGING"){
	 		 	 $wpParam['webSite'] = "Herman Hansen";
	 		 	 $wpParam['configKey'] = "HERMAN_HANSEN_LAST_ORDER_ID";
	 		     $wpParam['host'] = "localhost"; 
	 		     $wpParam['user'] = "root"; 
	 		     $wpParam['pass'] = "root"; 
	 		     $wpParam['database'] = "mgsrwp";
	 		     $wpParam['tblOrder'] = "mgsrwp_posts";
	 		     $wpParam['tblOrderProduct'] = "mgsrwp_woocommerce_order_items";
	 		     $wpParam['tblOrderProductDetail'] = "mgsrwp_woocommerce_order_itemmeta";
	 		     $wpParam['tblProduct'] = "mgsrwp_posts";
	 		     $wpParam['tblProductDetail'] = "mgsrwp_postmeta";

	 		     $response = self::processManageStock($wpParam);
	 		     if($response['status'] == "fail"){
					echo json_encode($response);
					exit(0);  
	 		     }
	 		 }
	 		 
	 		 if($environment == "PRODUCTION"){
	 		 	 // Herman Hansen
				
	 		 	 $wpParam['webSite'] = "Herman Hansen";
	 		 	 $wpParam['configKey'] = "HERMAN_HANSEN_LAST_ORDER_ID";
	 		 	 $wpParam['host'] = "101.53.157.131"; 
	 		     $wpParam['user'] = "swapp"; 
	 		     $wpParam['pass'] = "Ava)!)^@)!^"; 
	 		     $wpParam['database'] = "hermanWp";
	 		     $wpParam['tblOrder'] = "hhw_posts";
	 		     $wpParam['tblOrderProduct'] = "hhw_woocommerce_order_items";
	 		     $wpParam['tblOrderProductDetail'] = "hhw_woocommerce_order_itemmeta";
	 		     $wpParam['tblProduct'] = "hhw_posts";
	 		     $wpParam['tblProductDetail'] = "hhw_postmeta";

	 		     $response = self::processManageStock($wpParam);
	 		     if($response['status'] == "fail"){
					echo json_encode($response);
					exit(0);  
	 		     }
			     

	 		     // Hottech
	 		 	 $wpParam['webSite'] = "Hottech";
	 		 	 $wpParam['configKey'] = "HOTTECH_LAST_ORDER_ID";
	 		 	 $wpParam['host'] = "101.53.157.131"; 
	 		     $wpParam['user'] = "swapp"; 
	 		     $wpParam['pass'] = "Ava)!)^@)!^"; 
	 		     $wpParam['database'] = "hottechDatabase";
	 		     $wpParam['tblOrder'] = "ht_posts";
	 		     $wpParam['tblOrderProduct'] = "ht_woocommerce_order_items";
	 		     $wpParam['tblOrderProductDetail'] = "ht_woocommerce_order_itemmeta";
	 		     $wpParam['tblProduct'] = "ht_posts";
	 		     $wpParam['tblProductDetail'] = "ht_postmeta";

	 		     $response = self::processManageStock($wpParam);
	 		     if($response['status'] == "fail"){
					echo json_encode($response);
					exit(0);  
	 		     }
	 		 }	
	 		 
	 		 echo json_encode($response);
 
		}catch(Exception $e){
			Mage::log('In InventoryBL-> manageProductStock->catch section->'.$e->getmessage() , null, 'wordpress.log', true);
			$response['status'] = "fail";
			$response['error'] = "Please contact to administrator";
			echo json_encode($response);
		}
		exit(0);
	}



	private static function processManageStock($wpParam){
	  Mage::log('In AdminAPI_WordPressMapping_InventoryBL-> processManageStock Method' , null, 'wordpress.log', true);	 
	  $response = array();
	  $isWpDbConnOpen = false;
	  $isWpTxnStart = false;
	  $isMageTxnStart = false;

      try{    
		 
		    
	 		$wef = $wpParam['wef'];
	 		$webSite = $wpParam['webSite'];
	 		$configKey = $wpParam['configKey'];
	 		$host = $wpParam['host']; $user = $wpParam['user']; $pass = $wpParam['pass']; $database = $wpParam['database'];
 		    

	 		$tblOrder = $wpParam['tblOrder'];
	 		$tblOrderProduct = $wpParam['tblOrderProduct'];
	 		$tblOrderProductDetail = $wpParam['tblOrderProductDetail'];

 		    $tblProduct = $wpParam['tblProduct'];
 		    $tblProductDetail = $wpParam['tblProductDetail'];
	 		 
             // get last order id from system config for client website
 		     $systemConfigDTO = new Swapp_VO_SystemConfigVO();
             $systemConfigModel = Mage::getModel('swapp/Masters_SystemConfig'); 
             $systemConfigDataObj = $systemConfigModel->getResource()->getByConfigKey($configKey);
             $lastOrderId = $systemConfigDataObj['ConfigValue'];
             Mage::log($webSite . '=> last order id =>' . $lastOrderId, null, 'wordpress.log', true);

             // make database connection with client website database
             $conn = mysqli_connect($host, $user, $pass, $database);
             if (mysqli_connect_errno()) {
             	 Mage::throwException($webSite . "=> database connection failed : " . mysqli_connect_error() );
             }
             $isWpDbConnOpen = true;
             Mage::log($webSite . '=> database connection opened.' , null, 'wordpress.log', true);

			 // Turn autocommit off
			 mysqli_autocommit($conn,FALSE);
			 $isWpTxnStart = true;
			 // $lastOrderId = 0;
             // get new sale from client website
             $query = "select odr.ID orderId, ifnull(opdqty.meta_value, 0) saleQty, pd.meta_value productCode 
                        from " . $tblOrderProduct . " op
                        inner join " . $tblOrderProductDetail . " opdqty on op.order_item_id = opdqty.order_item_id and opdqty.meta_key = '_qty'
                        inner join " . $tblOrderProductDetail . " opdprod on op.order_item_id = opdprod.order_item_id and opdprod.meta_key = '_product_id'
                        inner join " . $tblProduct . " prod on opdprod.meta_value = prod.ID and prod.post_type = 'product'
                        inner join " . $tblProductDetail . " pd on prod.ID = pd.post_id and pd.meta_key = '_sku'
                        inner join " . $tblOrder . " odr on op.order_id = odr.ID  and odr.post_type = 'shop_order' and op.order_item_type = 'line_item'
                        where odr.ID > " . $lastOrderId . " and date(odr.post_date) >= '" . $wef . "'";
            // Mage::log($webSite . '=> sale query =>' . $query , null, 'wordpress.log', true);
             $dataObjs = mysqli_query($conn, $query);
             
             /*
             $orderProductDataObjs = array();
             while($dataObj = mysqli_fetch_assoc($dataObjs)) {
             	$orderProductDataObjs[] = $dataObj;
             }
             echo json_encode($orderProductDataObjs);
	     exit(0);	
	     */		 
			 
             if (mysqli_num_rows($dataObjs) > 0) {
             	 Mage::log($webSite.'=> total new sale products found=> ' . sizeof($dataObjs), null, 'wordpress.log', true);
                 $totalNewOrder = 0;
                 $orderId = null;
                 while($dataObj = mysqli_fetch_assoc($dataObjs)) {
                     
                     if($orderId != null){
                     	if($orderId != $dataObj['orderId']){
                     		$totalNewOrder++;
                     	}
                     }else{
                     	$totalNewOrder++;
                     }

                     $orderId = $dataObj['orderId'];
                     $productCode = $dataObj['productCode'];
                 	 $saleQty = $dataObj['saleQty'];

                 	 // get product stock from center database (dbanewsite/dealsbyava) by productCode/sku
                 	 $productDataObj = Mage::getModel('catalog/product')->loadByAttribute('sku',$productCode);
                     $stockDataObj = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productDataObj);

                     if($stockDataObj == null || $stockDataObj == ""){
                     	Mage::log($webSite.'=> stock not found product code in center database (dbanewsite/dealsbyava)=> '.$productCode, null, 'wordpress.log', true);
                     	continue;
                     }

					
                     // update (minus stock) product stock in center database (dbanewsite/dealsbyava)
                     $stockDataArr = $stockDataObj->getData();
                     if(sizeof($stockDataArr)>0){
                     	$stockQty = (int)$stockDataArr['qty'];
                     	if($stockQty>0){
                     		Mage::log($webSite . '=> productCode ' . $productCode . ' stockQty' . $stockQty . ' saleQty' . $saleQty, null, 'wordpress.log', true);

                     		
                     		if($saleQty > $stockQty){
                     			$stockQty = 0;
                     		}else{
                     			$stockQty = $stockQty - $saleQty;
                     		}

                     		$stockDataObj->setData('qty', $stockQty);  
                     		$stockDataObj->setData('is_in_stock', ($stockQty > 0) ? 1 : 0); // is 0 or 1
							$stockDataObj->setData('manage_stock', 1); // should be 1 to make something out of stock
							$stockDataObj->save();
							 
                     	}
                     }else{
                     	Mage::log($webSite . '=> productCode ' . $productCode . ' stock already zero so update (minus stock) not happened.' , null, 'wordpress.log', true);
                     }
                     
                 } // end while loop
                 Mage::log($webSite . '=> total new sale found=> ' . $totalNewOrder , null, 'wordpress.log', true);

                 // update center database (dbanewsite/dealsbyava) system config client website last order id
                 if($orderId != null && $orderId > $lastOrderId){
                 	Mage::log($webSite . '=> updated last order id =>' . $orderId , null, 'wordpress.log', true);

                 	$data = array('ConfigValue' => $orderId);

					$where = array(
					    'ConfigKey = ?' => $configKey
					);
					$systemConfigDTO->getAdapter()->beginTransaction();
					$isMageTxnStart = true;
					$systemConfigDTO->getAdapter()->update('swapp_systemconfig', $data, $where);
					
                 }

             }else{
             	Mage::log($webSite . '=> new sale not found.' , null, 'wordpress.log', true);
             } 

             // get client all active product list with stock
             $query = "select prod.ID productId, pd.meta_value productCode 
                        from " . $tblProduct . " prod 
                        inner join " . $tblProductDetail . " pd on prod.ID = pd.post_id
                        where prod.post_type = 'product' and prod.post_status = 'publish' and pd.meta_key = '_sku' ";
             $dataObjs = mysqli_query($conn, $query);

             // update product stock center db (dbanewsite(dealsbyava)) to client db (harmen hansen or hottech)
             if (mysqli_num_rows($dataObjs) > 0) {
             	 Mage::log($webSite . '=> total active product found=>' . sizeof($dataObjs) , null, 'wordpress.log', true);
                 while($dataObj = mysqli_fetch_assoc($dataObjs)) {
                 	 $productId = $dataObj['productId'];
                 	 $productCode = $dataObj['productCode'];
                 	 $productDataObj = Mage::getModel('catalog/product')->loadByAttribute('sku',$productCode);
                     $stockDataObj = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productDataObj);
                     $stockDataArr = $stockDataObj->getData();
                     if(sizeof($stockDataArr)){
                     	$stockQty = (int)$stockDataArr['qty'];
                     	if($stockQty >= 0){
                     		$query = "update " . $tblProductDetail . " set meta_value = " . $stockQty . "
                        				where post_id = " . $productId . " and meta_key = '_stock' ";
                     		mysqli_query($conn, $query);
                     		Mage::log($webSite . '=> update ' . $tblProductDetail . " Qty=>" . $stockQty . " for productId " . $productId . " and productCode " . $productCode  , null, 'wordpress.log', true);


                     		if($stockQty == 0){
                     			$query = "update " . $tblProductDetail . " set meta_value = 'outofstock' 
                        				where post_id = " . $productId . " and meta_key = '_stock_status' ";
                        		mysqli_query($conn, $query);

                        		Mage::log($webSite . '=> update ' . $tblProductDetail . " Qty=>" . $stockQty . " and stock status=> outofstock for productId " . $productId . " and productCode " . $productCode  , null, 'wordpress.log', true);
                     		}
                     		
                     	}	
                     }
                 }
             }else{
             	Mage::log($webSite . '=> active products not found.' , null, 'wordpress.log', true);
             }

             if (!mysqli_commit($conn)) {
             	  Mage::throwException($webSite . "=> Commit transaction failed. ");   
			 }
             $isWpTxnStart = false;

             mysqli_close($conn);
             $isWpDbConnOpen = false;
             Mage::log($webSite . '=> database connection closed.' , null, 'wordpress.log', true);
             
             if($isMageTxnStart){
             	$systemConfigDTO->getAdapter()->commit();
			 	$isMageTxnStart = false;
             }

             Mage::log('Successfully processed Manage Stock. ', null, 'wordpress.log', true);	
			 $response['status'] = "success";
		}catch(Exception $e){
			
			if($isWpTxnStart){
				mysqli_rollback($conn);
			}

			if($isWpDbConnOpen){
				mysqli_close($conn);
			}

			if($isMageTxnStart){
				$systemConfigDTO->getAdapter()->rollBack();
			}

			Mage::log('In AdminAPI_WordPressMapping_InventoryBL->processManageStock->catch section ' . $e->getmessage() , null, 'wordpress.log', true);	
			$response['status'] = "fail";
			$response['error'] = $e->getmessage(); 
		}
		return $response;
	}
}

?>
