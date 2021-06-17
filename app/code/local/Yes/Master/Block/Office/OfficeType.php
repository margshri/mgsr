<?php


class Yes_Master_Block_Office_OfficeType extends Mage_Adminhtml_Block_Template
{
    /**
     * Get URL of adding new record
     *
     * @return string
     */
    public function getAddNewUrl()
    {
		return $this->getUrl('*/*/edit');
    }

    /**
     * Get grid HTML
     *
     * @return unknown
     */
    public function getGridHtml()
    {
    	return $this->getChild('grid')->toHtml();
    }
}
