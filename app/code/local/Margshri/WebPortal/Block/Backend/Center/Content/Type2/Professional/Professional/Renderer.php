<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type2_Professional_Professional_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row)
	{

		switch ($this->getColumn()->getIndex()) {
			case 'professional.edit':
				$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("professional.ID"), 'CustomerID'=> $row->getData("entity_id"),  "FirstName"=>$row->getData("firstname"),  "LastName"=>$row->getData("lastname") ) );
				$html ="<a href='{$url}'  />{$row->getData('professional.edit')}</a>";
				return $html;
			
			
	        case 'created_at':
	            if($row->getData('created_at') != null && $row->getData('created_at') != ""){
	                $html = date("M d, Y h:i:s A", strtotime($row->getData('created_at') . "+330 minutes"));
	            }
    	        return $html;
	     }

	}
}