<?php
class Margshri_Common_Block_Backend_Customer_ManageCustomer_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'edit':
			    if(Margshri_Helper_Utility::isACLAllowed("admin/customcustomer/managecustomer/edit")){
    				$customerImage = $row->getData("CustomerImage");
    				if($customerImage != null && $customerImage != ""){
    					$customerImageArray = explode("/",$customerImage);
    					$customerImageArraySize = sizeof($customerImageArray);
    					$customerImageName = $customerImageArray[$customerImageArraySize-1]; 
    				} 
    				$url = $this->getUrl('*/*/edit', array('CustomerID'=> $row->getData("entity_id"), "CustomerImage"=>$customerImageName));
    				$html = "<a href='{$url}'  />{$row->getData('edit')}</a>";
			    }
				return $html;
		}
	}
}