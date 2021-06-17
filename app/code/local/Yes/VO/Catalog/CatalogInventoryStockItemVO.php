<?php

class Yes_VO_Catalog_CatalogInventoryStockItemVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = 'item_id';

	public static $STOCK_ID = 1;
	public static $USE_CONFIG_MIN_QTY = 1;
	public static $IS_QTY_DECIMAL = 0;
	public static $USE_CONFIG_BACKORDERS = 1;
	public static $USE_CONFIG_MIN_SALE_QTY = 1;
	public static $USE_CONFIG_MAX_SALE_QTY = 1;
	public static $IS_IN_STOCK = 1;
	public static $LOW_STOCK_DATE = null;
	public static $USE_CONFIG_NOTIFY_STOCK_QTY = 1;
	public static $USE_CONFIG_MANAGE_STOCK = 1;
	public static $STOCK_STATUS_CHANGED_AUTO = 0;
	public static $USE_CONFIG_QTY_INCREMENTS = 1;
	public static $USE_CONFIG_ENABLE_QTY_INC = 1;
	public static $IS_DECIMAL_DIVIDED = 0;
	
	
	private $item_id;
	private $product_id;
	private $stock_id;
	private $qty;
	//private $min_qty;
	private $use_config_min_qty;
	private $is_qty_decimal;
	//private $backorders;
	private $use_config_backorders;
	//private $min_sale_qty;
	private $use_config_min_sale_qty;
	//private $max_sale_qty;
	private $use_config_max_sale_qty;
	private $is_in_stock;
	private $low_stock_date;
	//private $notify_stock_qty;
	private $use_config_notify_stock_qty;
	//private $manage_stock;
	private $use_config_manage_stock;
	private $stock_status_changed_auto;
	private $use_config_qty_increments;
	//private $qty_increments;
	private $use_config_enable_qty_inc;
	//private $enable_qty_increments;
	private $is_decimal_divided;
	
	
	
	
	
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setItemId($item_id)
	{
		$this->item_id = $item_id;
		$this->set('item_id' , $item_id);
	}
	public function getItemId()
	{
		return $this->item_id;
	}
	
	
	public function setProductId($product_id)
	{
		$this->product_id = $product_id;
		$this->set('product_id' , $product_id);
	}
	public function getProductId()
	{
		return $this->product_id;
	}
	
	public function setStockId($stock_id)
	{
		$this->stock_id = $stock_id;
		$this->set('stock_id' , $stock_id);
	}
	public function getStockId()
	{
		return $this->stock_id;
	}
	
	public function setQty($qty)
	{
		$this->qty = $qty;
		$this->set('qty' , $qty);
	}
	public function getQty()
	{
		return $this->qty;
	}
	
	public function setUseConfigMinQty($use_config_min_qty)
	{
		$this->use_config_min_qty = $use_config_min_qty;
		$this->set('use_config_min_qty' , $use_config_min_qty);
	}
	public function getUseConfigMinQty()
	{
		return $this->use_config_min_qty;
	}
	
	public function setIsQtyDecimal($is_qty_decimal)
	{
		$this->is_qty_decimal = $is_qty_decimal;
		$this->set('is_qty_decimal' , $is_qty_decimal);
	}
	public function getIsQtyDecimal()
	{
		return $this->is_qty_decimal;
	}
	
	public function setUseConfigBackorders($use_config_backorders)
	{
		$this->use_config_backorders = $use_config_backorders;
		$this->set('use_config_backorders' , $use_config_backorders);
	}
	public function getUseConfigBackorders()
	{
		return $this->use_config_backorders;
	}
	
	public function setUseConfigMinSaleQty($use_config_min_sale_qty)
	{
		$this->use_config_min_sale_qty = $use_config_min_sale_qty;
		$this->set('use_config_min_sale_qty' , $use_config_min_sale_qty);
	}
	public function getUseConfigMinSaleQty()
	{
		return $this->use_config_min_sale_qty;
	}
	
	public function setUseConfigMaxSaleQty($use_config_max_sale_qty)
	{
		$this->use_config_max_sale_qty = $use_config_max_sale_qty;
		$this->set('use_config_max_sale_qty' , $use_config_max_sale_qty);
	}
	public function getUseConfigMaxSaleQty()
	{
		return $this->use_config_max_sale_qty;
	}
	
	public function setIsInStock($is_in_stock)
	{
		$this->is_in_stock = $is_in_stock;
		$this->set('is_in_stock' , $is_in_stock);
	}
	public function getIsInStock()
	{
		return $this->is_in_stock;
	}
	
	public function setLowStockDate($low_stock_date)
	{
		$this->low_stock_date = $low_stock_date;
		$this->set('low_stock_date' , $low_stock_date);
	}
	public function getLowStockDate()
	{
		return $this->low_stock_date;
	}
	
	public function setUseConfigNotifyStockQty($use_config_notify_stock_qty)
	{
		$this->use_config_notify_stock_qty = $use_config_notify_stock_qty;
		$this->set('use_config_notify_stock_qty' , $use_config_notify_stock_qty);
	}
	public function getUseConfigNotifyStockQty()
	{
		return $this->use_config_notify_stock_qty;
	}
	
	public function setUseConfigManageStock($use_config_manage_stock)
	{
		$this->use_config_manage_stock = $use_config_manage_stock;
		$this->set('use_config_manage_stock' , $use_config_manage_stock);
	}
	public function getUseConfigManageStock()
	{
		return $this->use_config_manage_stock;
	}
	
	public function setStockStatusChangedAuto($stock_status_changed_auto)
	{
		$this->stock_status_changed_auto = $stock_status_changed_auto;
		$this->set('stock_status_changed_auto' , $stock_status_changed_auto);
	}
	public function getStockStatusChangedAuto()
	{
		return $this->stock_status_changed_auto;
	}
	
	
	public function setUseConfigQtyIncrements($use_config_qty_increments)
	{
		$this->use_config_qty_increments = $use_config_qty_increments;
		$this->set('use_config_qty_increments' , $use_config_qty_increments);
	}
	public function getUseConfigQtyIncrements()
	{
		return $this->use_config_qty_increments;
	}
	
	public function setUseConfigEnableQtyInc($use_config_enable_qty_inc)
	{
		$this->use_config_enable_qty_inc = $use_config_enable_qty_inc;
		$this->set('use_config_enable_qty_inc' , $use_config_enable_qty_inc);
	}
	public function getUseConfigEnableQtyInc()
	{
		return $this->use_config_enable_qty_inc;
	}
	
	public function setIsDecimalDivided($is_decimal_divided)
	{
		$this->is_decimal_divided = $is_decimal_divided;
		$this->set('is_decimal_divided' , $is_decimal_divided);
	}
	public function getIsDecimalDivided()
	{
		return $this->is_decimal_divided;
	}
	
	
	
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/inventoryUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/cataloginventorystockitem');
		
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
	
	}
	
	public function setTableName($tableName)
	{
		$this->_name =$tableName;
		parent::_setupTableName();
	}
	
	public function getTableName(){
		return $this->_name;
	}
	
	
	

        
}