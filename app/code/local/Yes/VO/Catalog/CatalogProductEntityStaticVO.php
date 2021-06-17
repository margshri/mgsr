<?php

class Yes_VO_Catalog_CatalogProductEntityStaticVO 
{
	
	Public static  $ENTITY_TYPE_ID = 4;
	Public static  $ATTRIBUTE_SET_ID = 4;
	public static  $TYPE_ID = 'simple';
	public static  $STATUS = 1;
	public static  $VISIBILITY = 4;
	
	private $store_id;
	private $website_id;
	private $category_id;
	private $sku;
	
	
	public function setStoreId($storeId)
	{
		$this->store_id = $storeId;
		$this->set('store_id' , $storeId);
	}
	public function getStoreId()
	{
		return $this->store_id;
	}
	
	public function setWebsiteId($website_id)
	{
		$this->website_id = $website_id;
	}
	public function getWebsiteId()
	{
		return $this->website_id;
	}
	
	
	public function setCategoryId($category_id)
	{
		$this->category_id = $category_id;
	}
	public function getCategoryId()
	{
		return $this->category_id;
	}
	
	
	public function setSku($sku)
	{
		$this->sku = $sku;
		
	}
	public function getSku()
	{
		return $this->sku;
	}
	
	
	
	
	
	
	
	
	
	
        
}