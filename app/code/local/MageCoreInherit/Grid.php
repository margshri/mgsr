<?php 
class  MageCoreInherit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
   /**
     * Prepare grid collection object
     */
    protected function _prepareCollection()
    {
    	
        if ($this->getCollection()) {

            $this->_preparePage();

            $columnId = $this->getParam($this->getVarNameSort(), $this->_defaultSort);
            $dir      = $this->getParam($this->getVarNameDir(), $this->_defaultDir);
            $filter   = $this->getParam($this->getVarNameFilter(), null);

            if (is_null($filter)) {
                $filter = $this->_defaultFilter;
            }

            if (is_string($filter)) {
                //$data = $this->helper('adminhtml')->prepareFilterString($filter);
                $data = $this->prepareFilterString($filter);
                $this->_setFilterValues($data);
            }
            else if ($filter && is_array($filter)) {
                $this->_setFilterValues($filter);
            }
            else if(0 !== sizeof($this->_defaultFilter)) {
                $this->_setFilterValues($this->_defaultFilter);
            }

            if (isset($this->_columns[$columnId]) && $this->_columns[$columnId]->getIndex()) {
                $dir = (strtolower($dir)=='desc') ? 'desc' : 'asc';
                $this->_columns[$columnId]->setDir($dir);
                $column = $this->_columns[$columnId]->getFilterIndex() ?
                    $this->_columns[$columnId]->getFilterIndex() : $this->_columns[$columnId]->getIndex();
                $this->getCollection()->setOrder($column , $dir);
            }

            if (!$this->_isExport) {
                $this->getCollection()->load();
                $this->_afterLoadCollection();
            }
        }

        return $this;
    }

    private function prepareFilterString($filterString)
    {
        $data = array();
        $filterString = base64_decode($filterString);
        if($filterString =="")          return $data;
        /*
         * parse_str conver some characters into _(underscore) because its taking key as a variable name and variable name has not DOT, SPACE and many more.
         parse_str($filterString, $data);
        */
        $array= explode('&', $filterString);
        foreach($array as $chunk){
        $chunk = explode('=', $chunk);
  $data[$chunk[0]] = $chunk[1];
        }
        
        
           array_walk_recursive($data, array($this, 'decodeFilter'));
        return $data;
    }
    
 /**
     * Decode URL encoded filter value recursive callback method
     *
     * @param string $value
     */
    public function decodeFilter(&$value)
    {
        $value = rawurldecode($value);
    }
     
}