<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type2_CityDiamonds_CityDiamonds_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row)
	{

		switch ($this->getColumn()->getIndex()) {
			case 'citydiamonds.edit':
				$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("citydiamonds.ID"), 'CustomerID'=> $row->getData("entity_id"),  "FirstName"=>$row->getData("firstname"),  "LastName"=>$row->getData("lastname") ) );
				$html ="<a href='{$url}'  />{$row->getData('citydiamonds.edit')}</a>";
				return $html;
			}
	}
}