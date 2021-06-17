<?php
class Dakiya_Model_Mysql4_Job_CronJob_CronJob extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('dakiya/localuserbookingrequest', 'RequestID');
	}
	
}