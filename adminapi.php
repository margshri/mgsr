<?php
    header("Access-Control-Allow-Origin: *");

	error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
    

    $domain =$_SERVER["SERVER_NAME"];
    $uri  =  array();
    if($_SERVER["REQUEST_URI"] !=""){
    	$uri = explode("/", $_SERVER["REQUEST_URI"]) ;
    } 
	$uri  = array_filter($uri) ;
	if (sizeOf($uri) <3) {
	    echo 'Api url is not proper';
	    exit;
	}

	$mageFilename = getcwd() . '/app/Mage.php';

	if (!file_exists($mageFilename)) {
		echo 'Mage file not found';
		exit;
	}


	require $mageFilename;
	Mage::init('admin');
	

 

    $paths[] = BP . DS . 'app' . DS . 'code' . DS . 'local';
    $appPath = implode(PS, $paths);
    set_include_path($appPath . PS . Mage::registry('original_include_path'));
    include_once "Mage/Core/functions.php";
    include_once "Varien/Autoload.php";

	Varien_Autoload::register();
	 
 

	AdminAPI_API::isAuthentic();
 	call_user_func( 'AdminAPI_API'."::".$uri[3]);
?>
