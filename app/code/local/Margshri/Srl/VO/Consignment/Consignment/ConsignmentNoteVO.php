<?php
class Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "transport/Consignment_Consignment_ConsignmentNote";
    public static $tableAlias = "transport/mgsrconsignmentnote";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    
    protected $_ConsignmentNo;
    protected $_ConsignmentDate;
    protected $_ConsignorName;
    protected $_ConsignorAddress;
    protected $_ConsignorGstinNo;
    protected $_ConsignorMobileNo;
    protected $_ConsignorCityID;
    
    protected $_ConsigneeName;
    protected $_ConsigneeAddress;
    protected $_ConsigneeGstinNo;
    protected $_ConsigneeMobileNo;
    protected $_ConsigneeCityID;
    protected $_SourceCityID;
    protected $_SourceCityName;
    protected $_BillingStation;
    protected $_DestinationCityID;
    protected $_DestinationCityName;
    protected $_TotalWeight;
    protected $_Rate;
    protected $_UnitTypeID;
    protected $_TotalAmount;
    
    protected $_Freight;
    protected $_ToPaid;
    protected $_ToPay;
    protected $_TBB;
    protected $_Advance;
    protected $_Balance;
    protected $_ValueOfGoods;
    protected $_Description;
    protected $_Remarks;
    protected $_CommonID;
    protected $_StatusID;
    protected $_InvoiceNo;
    protected $_HsnCode;
    
    protected $_EwayBillNo;
    protected $_EwayBillExpiryDate;
    protected $_DeliveryAt;
    
    protected $_VahicaleID;
    protected $_DriverID;
    protected $_VahicaleOwnerID;

    protected $_OwnerName;
    protected $_OwnerMobileNo;
    protected $_DriverName;
    protected $_DriverMobileNo;
    
    protected $_CreatedAt;
	protected $_CreatedBy;
	protected $_UpdatedAt;
	protected $_UpdatedBy;
	
	
	protected $_VahicaleNumber;
	
	
	
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}

	public function getDataArray(){
		return $this->_data;
	}

	    
	public function getID() {
	  return $this->_ID;
	}
	public function setID($value){
	  $this->_ID = $value;
	}
	
	
	public function getConsignmentNo() {
	    return $this->_ConsignmentNo;
	}
	public function setConsignmentNo($value){
	    $this->_ConsignmentNo = $value;
	    $this->set('ConsignmentNo' , $value);
	}
	
	public function getConsignmentDate() {
	    return $this->_ConsignmentDate;
	}
	public function setConsignmentDate($value){
	    $this->_ConsignmentDate = $value;
	    $this->set('ConsignmentDate' , $value);
	}
	
	public function getConsignorName() {
	    return $this->_ConsignorName;
	}
	public function setConsignorName($value){
	    $this->_ConsignorName = $value;
	    $this->set('ConsignorName' , $value);
	}
	
	public function getConsignorAddress() {
	    return $this->_ConsignorAddress;
	}
	public function setConsignorAddress($value){
	    $this->_ConsignorAddress = $value;
	    $this->set('ConsignorAddress' , $value);
	}
	
	
	public function getConsignorGstinNo() {
	    return $this->_ConsignorGstinNo;
	}
	public function setConsignorGstinNo($value){
	    $this->_ConsignorGstinNo = $value;
	    $this->set('ConsignorGstinNo' , $value);
	}
	
	
	public function getConsignorMobileNo() {
	    return $this->_ConsignorMobileNo;
	}
	public function setConsignorMobileNo($value){
	    $this->_ConsignorMobileNo = $value;
	    $this->set('ConsignorMobileNo' , $value);
	}
	
	
	public function getConsignorCityID() {
	    return $this->_ConsignorCityID;
	}
	public function setConsignorCityID($value){
	    $this->_ConsignorCityID = $value;
	    $this->set('ConsignorCityID' , $value);
	}
	
	
	public function getConsigneeName() {
	    return $this->_ConsigneeName;
	}
	public function setConsigneeName($value){
	    $this->_ConsigneeName = $value;
	    $this->set('ConsigneeName' , $value);
	}
	
	public function getConsigneeAddress() {
	    return $this->_ConsigneeAddress;
	}
	public function setConsigneeAddress($value){
	    $this->_ConsigneeAddress = $value;
	    $this->set('ConsigneeAddress' , $value);
	}
	
	
	public function getConsigneeGstinNo() {
	    return $this->_ConsigneeGstinNo;
	}
	public function setConsigneeGstinNo($value){
	    $this->_ConsigneeGstinNo = $value;
	    $this->set('ConsigneeGstinNo' , $value);
	}
	
	
	public function getConsigneeMobileNo() {
	    return $this->_ConsigneeMobileNo;
	}
	public function setConsigneeMobileNo($value){
	    $this->_ConsigneeMobileNo = $value;
	    $this->set('ConsigneeMobileNo' , $value);
	}
	
	
	public function getConsigneeCityID() {
	    return $this->_ConsigneeCityID;
	}
	public function setConsigneeCityID($value){
	    $this->_ConsigneeCityID = $value;
	    $this->set('ConsigneeCityID' , $value);
	}
	
	
	public function getSourceCityID() {
	    return $this->_SourceCityID;
	}
	public function setSourceCityID($value){
	    $this->_SourceCityID = $value;
	    $this->set('SourceCityID' , $value);
	}
	
	
	public function getSourceCityName() {
	    return $this->_SourceCityName;
	}
	public function setSourceCityName($value){
	    $this->_SourceCityName = $value;
	    $this->set('SourceCityName' , $value);
	}
	
	
	public function getBillingStation() {
	    return $this->_BillingStation;
	}
	public function setBillingStation($value){
	    $this->_BillingStation = $value;
	    $this->set('BillingStation' , $value);
	}
	
	
	public function getDestinationCityID() {
	    return $this->_DestinationCityID;
	}
	public function setDestinationCityID($value){
	    $this->_DestinationCityID = $value;
	    $this->set('DestinationCityID' , $value);
	}
	
	
	public function getDestinationCityName() {
	    return $this->_DestinationCityName;
	}
	public function setDestinationCityName($value){
	    $this->_DestinationCityName = $value;
	    $this->set('DestinationCityName' , $value);
	}
	
	
	public function getTotalWeight() {
	    return $this->_TotalWeight;
	}
	public function setTotalWeight($value){
	    $this->_TotalWeight = $value;
	    $this->set('TotalWeight' , $value);
	}
	
	public function getRate() {
	    return $this->_Rate;
	}
	public function setRate($value){
	    $this->_Rate = $value;
	    $this->set('Rate' , $value);
	}
	
	public function getUnitTypeID() {
	    return $this->_UnitTypeID;
	}
	public function setUnitTypeID($value){
	    $this->_UnitTypeID = $value;
	    $this->set('UnitTypeID' , $value);
	}
	
	
	public function getTotalAmount() {
	    return $this->_TotalAmount;
	}
	public function setTotalAmount($value){
	    $this->_TotalAmount = $value;
	    $this->set('TotalAmount' , $value);
	}
	
	
	public function getFreight() {
	    return $this->_Freight;
	}
	public function setFreight($value){
	    $this->_Freight = $value;
	    $this->set('Freight' , $value);
	}
	
	
	public function getToPaid() {
	    return $this->_ToPaid;
	}
	public function setToPaid($value){
	    $this->_ToPaid = $value;
	    $this->set('ToPaid' , $value);
	}
	
	
	public function getToPay() {
	    return $this->_ToPay;
	}
	public function setToPay($value){
	    $this->_ToPay = $value;
	    $this->set('ToPay' , $value);
	}
	
	
	public function getTBB() {
	    return $this->_TBB;
	}
	public function setTBB($value){
	    $this->_TBB = $value;
	    $this->set('TBB' , $value);
	}
	
	
	public function getAdvance() {
	    return $this->_Advance;
	}
	public function setAdvance($value){
	    $this->_Advance = $value;
	    $this->set('Advance' , $value);
	}
	
	
	public function getBalance() {
	    return $this->_Balance;
	}
	public function setBalance($value){
	    $this->_Balance = $value;
	    $this->set('Balance' , $value);
	}
	
	
	public function getValueOfGoods() {
	    return $this->_ValueOfGoods;
	}
	public function setValueOfGoods($value){
	    $this->_ValueOfGoods = $value;
	    $this->set('ValueOfGoods' , $value);
	}
	
	
	public function getDescription() {
	    return $this->_Description;
	}
	public function setDescription($value){
	    $this->_Description = $value;
	    $this->set('Description' , $value);
	}
	
	
	public function getRemarks() {
	    return $this->_Remarks;
	}
	public function setRemarks($value){
	    $this->_Remarks = $value;
	    $this->set('Remarks' , $value);
	}
	
	
	public function getCommonID() {
	    return $this->_CommonID;
	}
	public function setCommonID($value){
	    $this->_CommonID = $value;
	    $this->set('CommonID' , $value);
	}
	
	
	public function getVahicaleID() {
	    return $this->_VahicaleID;
	}
	public function setVahicaleID($value){
	    $this->_VahicaleID = $value;
	    $this->set('VahicaleID' , $value);
	}
	
	
	public function getDriverID() {
	    return $this->_DriverID;
	}
	public function setDriverID($value){
	    $this->_DriverID = $value;
	    $this->set('DriverID' , $value);
	}
	
	
	public function getVahicaleOwnerID() {
	    return $this->_VahicaleOwnerID;
	}
	public function setVahicaleOwnerID($value){
	    $this->_VahicaleOwnerID = $value;
	    $this->set('VahicaleOwnerID' , $value);
	}
	
	
	public function getOwnerName() {
	    return $this->_OwnerName;
	}
	public function setOwnerName($value){
	    $this->_OwnerName = $value;
	    $this->set('OwnerName' , $value);
	}
	
	
	public function getOwnerMobileNo() {
	    return $this->_OwnerMobileNo;
	}
	public function setOwnerMobileNo($value){
	    $this->_OwnerMobileNo = $value;
	    $this->set('OwnerMobileNo' , $value);
	}
	
	
	public function getDriverName() {
	    return $this->_DriverName;
	}
	public function setDriverName($value){
	    $this->_DriverName = $value;
	    $this->set('DriverName' , $value);
	}
	
	
	public function getDriverMobileNo() {
	    return $this->_DriverMobileNo;
	}
	public function setDriverMobileNo($value){
	    $this->_DriverMobileNo = $value;
	    $this->set('DriverMobileNo' , $value);
	}
	
	
	public function getCreatedAt() {
	    return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
	    $this->_CreatedAt = $value;
	    $this->set('CreatedAt' , $value);
	}
	
	
	public function getStatusID() {
	    return $this->_StatusID;
	}
	public function setStatusID($value){
	    $this->_StatusID = $value;
	    $this->set('StatusID' , $value);
	}
	
	
	public function getInvoiceNo() {
	    return $this->_InvoiceNo;
	}
	public function setInvoiceNo($value){
	    $this->_InvoiceNo = $value;
	    $this->set('InvoiceNo' , $value);
	}
	
	public function getHsnCode() {
	    return $this->_HsnCode;
	}
	public function setHsnCode($value){
	    $this->_HsnCode = $value;
	    $this->set('HsnCode' , $value);
	}
	
	 
	
	
	public function getEwayBillNo() {
	    return $this->_EwayBillNo;
	}
	public function setEwayBillNo($value){
	    $this->_EwayBillNo = $value;
	    $this->set('EwayBillNo' , $value);
	}
	
	
	public function getEwayBillExpiryDate() {
	    return $this->_EwayBillExpiryDate;
	}
	public function setEwayBillExpiryDate($value){
	    $this->_EwayBillExpiryDate = $value;
	    $this->set('EwayBillExpiryDate' , $value);
	}
	
	public function getDeliveryAt() {
	    return $this->_DeliveryAt;
	}
	public function setDeliveryAt($value){
	    $this->_DeliveryAt = $value;
	    $this->set('DeliveryAt' , $value);
	}
	
	 
	
	
	public function getCreatedBy() {
	    return $this->_CreatedBy;
	}
	public function setCreatedBy($value){
	    $this->_CreatedBy = $value;
	    $this->set('CreatedBy' , $value);
	}
	
	
	public function getUpdatedAt() {
	    return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value){
	    $this->_UpdatedAt = $value;
	    $this->set('UpdatedAt' , $value);
	}
	
	
	public function getUpdatedBy() {
	    return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value){
	    $this->_UpdatedBy = $value;
	    $this->set('UpdatedBy' , $value);
	}

	
	public function getVahicaleNumber() {
	    return $this->_VahicaleNumber;
	}
	public function setVahicaleNumber($value){
	    $this->_VahicaleNumber = $value;
	}
	
	
    public function __construct(){
    	$model = Mage::getModel(self::$modelName);
    	$tableName = $model->getResource()->getMainTable();

    	$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
    	$this->setDefaultAdapter($con);
    	$this->_db = $con;
    	$this->setTableName($tableName);
    }
    

    public function setTableName($tableName){
    	$this->_name =$tableName;
    	parent::_setupTableName();
    }

    public function getTableName(){
    	return $this->_name;
    }

}
