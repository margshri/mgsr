<?php
class Margshri_WebPortal_VO_LocationSelector_LocationVO extends Margshri_WebPortal_VO_BaseVO{
	
	protected $_CountryID;
	protected $_StateID;
	protected $_DistrictID;
	protected $_CityID;

	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}
	
	public function getDataArray(){
		return $this->_data;
	}
	
	    
	public function getCountryID() 
	{
	  return $this->_CountryID;
	}
	
	public function setCountryID($value) 
	{
	  $this->_CountryID = $value;
	  $this->set('CountryID' , $value);
	}	 
 	
 	 
	public function getStateID() 
	{
	  return $this->_StateID;
	}
	
	public function setStateID($value) 
	{
	  $this->_StateID = $value;
	  $this->set('StateID' , $value);
	} 
	
	    
	public function getDistrictID() 
	{
	  return $this->_DistrictID;
	}
	
	public function setDistrictID($value) 
	{
	  $this->_DistrictID = $value;
	  $this->set('DistrictID' , $value);
	}
	
	    
	public function getCityID() 
	{
	  return $this->_CityID;
	}
	
	public function setCityID($value) 
	{
	  $this->_CityID = $value;
	  $this->set('CityID' , $value);
	}
}