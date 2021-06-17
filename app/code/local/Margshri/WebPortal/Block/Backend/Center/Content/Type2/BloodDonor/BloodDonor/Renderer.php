<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type2_BloodDonor_BloodDonor_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row)
	{

		switch ($this->getColumn()->getIndex()) {
			case 'blooddonor.edit':
				$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("blooddonor.ID"), 'CustomerID'=> $row->getData("entity_id"),  "FirstName"=>$row->getData("firstname"),  "LastName"=>$row->getData("lastname"), "BloodGroup"=>$row->getData("bloodgroup") ) );
				$html ="<a href='{$url}'  />{$row->getData('blooddonor.edit')}</a>";
				return $html;
			

			case 'gender':
				if($row->getData('gender') == 1){
					$html = "Male";	
				}elseif($row->getData('gender') == 2){
					$html = "Female";		
				}else{
					$html = '';	
				}
				return $html;
		}	

			
	}
}