<?php 

class Yes_Master_Helper_Data extends Mage_Core_Helper_Abstract 
{
	public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array())
	{
		$json = Zend_Json::encode($valueToEncode, $cycleCheck, $options);
		/* @var $inline Mage_Core_Model_Translate_Inline */
		$inline = Mage::getSingleton('core/translate_inline');
		if ($inline->isAllowed()) {
			$inline->setIsJson(true);
			$inline->processResponseBody($json);
			$inline->setIsJson(false);
		}
	
		return $json;
	}
 	
	
	public function cleanData(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}
	
	public function setContentTypeForExport($filename, $contentType)
	{
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: " . $contentType);
	}
	
	
	public function no_to_words($no , $valueType="int")
	{
		$words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred ','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
	
		if($valueType=="decimal"){
			if($no ==0) return "Zero Zero";
			if(array_key_exists("$no",$words)) {
				return $words["$no"];
			} else {
				$unit=$no%10;
				$ten =(int)($no/10)*10;
				return $words["$ten"]." ".$words["$unit"];
			}
		}
	
		if($no == 0){
			return ' ';
		}
		else {
			$novalue='';$highno=$no;$remainno=0;$value=100;$value1=1000;
			while($no>=100)    {
				if(($value <= $no) &&($no  < $value1))    {
					$novalue=$words["$value"];
					$highno = (int)($no/$value);
					$remainno = $no % $value;
					break;
				}
				$value= $value1;
				$value1 = $value * 100;
			}
			if(array_key_exists("$highno",$words)) {
				return $words["$highno"]." ".$novalue." ". $this->no_to_words($remainno);
			} else {
				$unit=$highno%10;
				$ten =(int)($highno/10)*10;
				return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->no_to_words($remainno);
			}
	
		}
	
	}
	
	public function renderFilter($filter , $whereClause =null){
		// $filter = Mage::helper('adminhtml')->prepareFilterString($this->getRequest()->getParam('filter'));
	
		$keys = array_keys($filter) ;
		for($cntr=0; $cntr<count($filter); $cntr++)
		{
		 
	
		if(is_array($filter[$keys[$cntr]] )){
			if(array_key_exists('from', $filter[$keys[$cntr]]) || array_key_exists('to', $filter[$keys[$cntr]])  ){
			if( $whereClause !=''){
			$whereClause .= " and " ;
			}
			}
	
				if(array_key_exists('from', $filter[$keys[$cntr]]) && array_key_exists('to', $filter[$keys[$cntr]])  ){
				$whereClause .= "date(" .$keys[$cntr] . ") >= '" . $this->dateString($filter[$keys[$cntr] ]['from'],  $filter[$keys[$cntr]]['locale'] ) . "' and date(" . $keys[$cntr] . ") <= '" . $this->dateString($filter[$keys[$cntr] ]['to'],  $filter[$keys[$cntr]]['locale']  ). "'";
				} elseif(array_key_exists('from', $filter[$keys[$cntr]])   ){
				$whereClause .= "date(" .$keys[$cntr] . ") >= '" . $this->dateString($filter[$keys[$cntr] ]['from'],  $filter[$keys[$cntr]]['locale'] ) . "'" ;
			}elseif(array_key_exists('to', $filter[$keys[$cntr]])   ){
					$whereClause .= "date(" .$keys[$cntr] . ") <= '" . $this->dateString($filter[$keys[$cntr] ]['to'],  $filter[$keys[$cntr]]['locale'] ) . "'" ;
				}
				 
	
				} else {
				if( $whereClause !=''){
				$whereClause .= " and " ;
			}
	
			$col = str_replace("#", ".", $keys[$cntr]);
			$whereClause .= $col  . " like '%" . $filter[$keys[$cntr]] . "%'" ;
			//$whereClause .= $keys[$cntr] . " like '%" . $filter[$keys[$cntr]] . "%'" ;
				}
				 
				 
			}
			if($whereClause==''){
			$whereClause='0=0';
			}
				return $whereClause ;
			}
	
			private function dateString($value, $locale)
			{
			if($locale== 'en_US'){
			return substr($value, 6,2) . "/" . substr($value, 0,2) . "/" . substr($value, 3,2)   ;
			}
	
			}
	
			public function dateConvertor($dateValue, $convertor)
			{
			$strSeparator    = substr( $dateValue  ,2,1) ; //find date separator
			$strValue        = explode($strSeparator, $dateValue);
			if($convertor =="UKtoUS")
			{
			return $strValue[1]."/". $strValue[0]."/".$strValue[2];
			}
			 
			}
	
		 
	
 	
 
}
 