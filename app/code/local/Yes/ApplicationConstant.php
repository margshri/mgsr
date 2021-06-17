<?php

class Yes_ApplicationConstant
{
	// DATA FILE SIZE LIMIT
   public static $DATA_FILE_SIZE_LIMIT = 10000000;
   
   /* IMAGE FILE SIZE LIMIT FOR DIMENTION
   public static $BASE_IMAGE_SIZE_LIMIT = 70225; //width 265 muliply height 265
   public static $SMALL_IMAGE_SIZE_LIMIT = 18225; //width 135 muliply height 135
   public static $THUMBNAIL_IMAGE_SIZE_LIMIT = 2500; //width 50 muliply height 50
   */
   
   // IMAGE FILE SIZE LIMIT
   public static $BASE_IMAGE_SIZE_LIMIT = 100000; 
   public static $SMALL_IMAGE_SIZE_LIMIT = 100000;
   public static $THUMBNAIL_IMAGE_SIZE_LIMIT = 100000;
     
   
   // IMAGE NAMES
   public static $BASE_IMAGE_TYPE = 'image';
   public static $SMALL_IMAGE_TYPE = 'small_image';
   public static $THUMBNAIL_IMAGE_TYPE = 'thumbnail';
   
   
   // TEMPLATE FILE SEPARATOR
   public static $TEMPLATE_COLUMN_SEPARATOR = "|";
   public static $FLAT_FILE_COLUMN_SEPARATOR = "|";   
   
   // TEMPLATE FILE EXTENSION
   public static $CSV_TEMPLATE_EXT = "csv";
   
   // DATA FILE TYPE
   public static $XLS_FILE_TYPE = "application/vnd.ms-excel";
   public static $XLSX_FILE_TYPE = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
   
   // IMAGE FILE TYPE
   public static $GIF_IMAGE_TYPE = "image/gif";
   public static $JPEG_IMAGE_TYPE = "image/jpeg";
   public static $JPG_IMAGE_TYPE = "image/jpg";
   public static $PNG_IMAGE_TYPE = "image/png";
   
   // DATA FILE EXTENSION
   public static $XLS_FILE_EXT = "xls";
   public static $XLSX_FILE_EXT = "xlsx";
	
   // IMAGE FILE EXTENSION
   public static $GIF_IMAGE_EXT = "gif";
   public static $JPEG_IMAGE_EXT = "jpeg";
   public static $JPG_IMAGE_EXT = "jpg";
   public static $PNG_IMAGE_EXT = "png";
   
   
   public static $PRODUCT_TEMPLATE_ID = "";
   
  
   //public static $ERROR_LOG_PATH = "";
   
   
   // Flat File Name
   public static $PRODUCT_POSTFIX_FLAT_FILE_NAME = "prod.dat";
   public static $PRICE_POSTFIX_FLAT_FILE_NAME = "price.dat";
   public static $INVENTORY_POSTFIX_FLAT_FILE_NAME = "inventory.dat";
   
   // Handler Class File Name
   public static $XLSX_HANDLER_CLASS_NAME = "xlsx/simplexlsx.class.php";
   public static $XLS_HANDLER_CLASS_NAME = "xls/reader.php";
   
   // TEMPLATE NAME
   public static $PRODUCT_TEMPLATE_NAME = "productTemplate.csv";
   
   
   /*
   public static $BASE_IMAGE_WIDTH = 265;
   public static $BASE_IMAGE_HEIGHT = 265;
   
   public static $SMALL_IMAGE_WIDTH = 135;
   public static $SMALL_IMAGE_HEIGHT = 135;
   
   public static $THUMBNAIL_IMAGE_WIDTH = 50;
   public static $THUMBNAIL_IMAGE_HEIGHT = 50;
   
   */
   
   
   
   
        
}