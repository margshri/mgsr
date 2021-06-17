<?php

class Yes_Master_Model_Mysql4_Offices_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
/**
     * Initialize orders collection
     *
     */
    protected function _construct()
    {
        $this->_init('yesmaster/offices');
    }
	
    public function joinLeft($table, $cond, $cols='*')
    {
            $alias='';
            $tableName ='';
            if(is_array($table)){
            	$alias=key($table);
            	$tableName = $table[$alias];
            } else {
            	$alias =$table;
            	$tableName = $table;
            }
    	
    	if (!isset($this->_joinedTables[$alias])) {
            //$this->getSelect()->join(array($table=>$this->getTable($table)), $cond, $cols);
            //$this->getSelect()->joinLeft(array($table=>$table), $cond, $cols);
            $this->getSelect()->joinLeft(array($alias=>$tableName), $cond, $cols);
            $this->_joinedTables[$alias] = true;
        }
        return $this;
    }    
    
   
 
}