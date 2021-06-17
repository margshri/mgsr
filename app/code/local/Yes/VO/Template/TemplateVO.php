<?php

class Yes_VO_Template_TemplateVO
{


	public static $PRODUCT_UPLOAD_TEMPLATE_ID = 1;
	public static $PRICE_UPLOAD_TEMPLATE_ID = 2;
	public static $INVENTORY_UPLOAD_TEMPLATE_ID = 3;
	private $columnName;
	private $columnKey;
	private $columnException;
	private $columnLength;
	private $templateUrl;
	private $templateExt;
	private $attributeID;
	
	
	public function setAttributeID($attributeID)
	{
		return $this->attributeID = $attributeID;
	}
	public function getAttributeID()
	{
		return $this->attributeID;
	}
	
	
	public function getColumnName()
	{
		return $this->columnName;		
	}
	public function getColumnKey()
	{
		return $this->columnKey;
	}
	public function getColumnException()
	{
		return $this->columnException;
	}
	public function getColumnLength()
	{
		return $this->columnLength;
	}
	public function getTemplateUrl()
	{
		return $this->templateUrl;
	}
	public function getTemplateExt()
	{
		return $this->templateExt;
	}
	
	
	
	
	public function setColumnName($columnName)
	{
		$this->columnName = $columnName;
	}
	public function setColumnKey($columnKey)
	{
		$this->columnKey = $columnKey;
	}
	public function setColumnException($columnException)
	{
		$this->columnException = $columnException;
	}
	public function setColumnLength($columnLength)
	{
		$this->columnLength = $columnLength;
	}
	public function setTemplateUrl($templateUrl)
	{
		$this->templateUrl = $templateUrl;
	}
	public function setTemplateExt($templateExt)
	{
		$this->templateExt = $templateExt;
	}
        
}