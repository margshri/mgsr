<?php

class Margshri_API_AdminAPI{
    
	private static $authkey = 'G4s4cCMx2aM7lky1';
	private static $versioncode = array(1) ;
	
	public static function isAuthentic(){
		$headers = apache_request_headers();
		 
		if (!array_key_exists('Authkey',$headers)) {

   				$result=array("status"=>"fail" , 'error'=>array("Authentication key not found" ));
				echo json_encode($result);
				exit(0);        	
		}

		if($headers['Authkey'] !=Margshri_API_AdminAPI::$authkey ){
   				$result=array("status"=>"fail" , 'error'=>array("Authentication failed" ));
				echo json_encode($result);
				exit(0);        	
		}

 	    if( !in_array($headers['Versioncode']  , Margshri_API_AdminAPI::$versioncode  )){
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
	    return Margshri_AdminAPI_Common_ImportantLinks_ImportantLinksBL::getAllActiveRecord();
	}
	
	
	public static function getAdvertisement(){
	    return Margshri_API_Common_Advertisement_AdvertisementBL::getAdvertisement();
	}
	
}

?>
