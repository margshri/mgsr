<?php

class AdminAPI_API
{
	private static $authkey = 'G4s4cCMx2aM7lky1';
	//private static $authkey_ezeTap = '84ab1cfa-c4bc-42cf-bf41-ae62ee136ea1' ; // UAT:84ab1cfa-c4bc-42cf-bf41-ae62ee136ea1 , production:6971b619-f353-4fdc-9af1-1c0489549ee9
	private static $versioncode=  array(9) ;
	
	public static function isAuthentic(){
		$headers = apache_request_headers();
		 
		if (!array_key_exists('authkey',$headers)) {

   				$result=array("status"=>"fail" , 'error'=>array("Authentication key not found" ));
				echo json_encode($result);
				exit(0);        	
		}

		if($headers['authkey'] !=AdminAPI_API::$authkey ){
   				$result=array("status"=>"fail" , 'error'=>array("Authentication failed" ));
				echo json_encode($result);
				exit(0);        	
		}

 	    if( !in_array($headers['versioncode']  , AdminAPI_API::$versioncode  )){

    				$result=array("status"=>"versionfailed" , 'error'=>"Please update your app with latest release" );
 				echo json_encode($result);
 				exit(0);        	
 		}

	}

	public static function adminLogin(){
		return AdminAPI_User_UserBL::getUser();
	}

	public static function getFlightNoSalesInfo(){
		return AdminAPI_Flight_FlightBL::getFlightNoSalesInfo();
	}

	public static function getFlightNoSaleReasons(){
		return AdminAPI_Flight_FlightBL::getFlightNoSaleReasons();
	}


	public static function saveFlightNoSaleReasons(){
		return AdminAPI_Flight_FlightBL::saveFlightNoSaleReasons();
	}

	public static function getPrincipals(){
		return AdminAPI_AviationSales_SalesBL::getPrincipals();
	}

	public static function getPaymentTypes(){
		return AdminAPI_AviationSales_SalesBL::getPaymentTypes();
	}

	public static function getServerDate(){
		return AdminAPI_AviationSales_SalesBL::getServerDate();
	}

	public static function getEmployeeName(){
		return AdminAPI_AviationSales_SalesBL::getEmployeeName();
	}

	public static function getUnixTimeStamp(){
		return AdminAPI_AviationSales_SalesBL::getUnixTimeStamp();
	}

	public static function getFlight(){
		return AdminAPI_AviationSales_SalesBL::getFlight();
	}

	public static function applyAviationCoupon(){
		return AdminAPI_AviationSales_SalesBL::applyAviationCoupon();
	}


	public static function getIndigoOnFlightPayment(){
		return AdminAPI_AviationSales_SalesBL::getIndigoOnFlightPayment();
	}


	public static function getCLPCustomerDetail(){
		return AdminAPI_AviationSales_SalesBL::getCLPCustomerDetail();
	}

	public static function getBindProductList(){
		return AdminAPI_AviationSales_SalesBL::getBindProductList();
	}

	public static function getPromotionsPrincipalByWef(){
		return AdminAPI_AviationSales_SalesBL::getPromotionsPrincipalByWef();
	}

	public static function getPaymentCardList(){
		return AdminAPI_AviationSales_SalesBL::getPaymentCardList();
	}


	public static function getPromotionAction(){
		return AdminAPI_AviationSales_SalesBL::getPromotionAction();
	}


	public static function getOTPForRedeemCLP(){
		return AdminAPI_AviationSales_SalesBL::getOTPForRedeemCLP();
	}

	public static function verifyOTPForRedeemCLP(){
		return AdminAPI_AviationSales_SalesBL::verifyOTPForRedeemCLP();
	}


	public static function saveAviationSale(){
		return AdminAPI_AviationSales_SalesBL::saveAviationSale();
	}

	public static function addCustomer(){
		return AdminAPI_AviationSales_SalesBL::addCustomer();
	}

	public static function resendOTPAddCustomer(){
		return AdminAPI_AviationSales_SalesBL::resendOTPAddCustomer();
	}

	public static function verifyOTPAddCustomer(){
		return AdminAPI_AviationSales_SalesBL::verifyOTPAddCustomer();
	}


	public static function getUniqueTxnId(){
		return AdminAPI_AviationSales_SalesBL::getUniqueTxnId();
	}
	
	public static function getInvoiceList(){
		return AdminAPI_AviationSales_SalesBL::getInvoiceList();
	}
	 
	public static function sendInvoiceonMail(){
		return AdminAPI_AviationSales_SalesBL::sendInvoiceonMail();
	}

	public static function saveRetailSale(){
		return AdminAPI_RetailSales_SalesBL::saveRetailSale();
	}

	public static function cancelRetailInvoice(){
		return AdminAPI_RetailSales_SalesBL::cancelRetailSale();
	}
	
	public static function manageWordPressStock(){
	    return AdminAPI_WordPressMapping_InventoryBL::manageProductStock();
	}
	 
	public static function getBaseStockForOfflineSale(){
		return AdminAPI_RetailSales_SalesBL::getBaseStockForOfflineSale();
	}
	
	
	
	
	public static function getImportantLinksSrl(){
	    return AdminAPI_RetailSales_SalesBL::getBaseStockForOfflineSale();
	}
	
}

?>
