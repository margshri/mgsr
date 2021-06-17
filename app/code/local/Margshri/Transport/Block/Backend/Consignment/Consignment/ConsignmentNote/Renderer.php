<?php
class Margshri_Transport_Block_Backend_Consignment_Consignment_ConsignmentNote_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.Edit':
				if(Margshri_Helper_Utility::isACLAllowed("admin/transport/consignment/consignmentnote/edit")){
					$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID")) );
					$html ="<a href='{$url}'  />{$row->getData('main_table.Edit')}</a>";
				}	
				return $html;
				
			case 'main_table.Print':
			    if(Margshri_Helper_Utility::isACLAllowed("admin/transport/consignment/consignmentnote/print")){
    			    $url= 	$this->getUrl('*/*/print', array('ID'=> $row->getData("main_table.ID")) );
    			    $html ="<a href='{$url}'  />{$row->getData('main_table.Print')}</a>";
			    }
			    return $html;
				
		}
	}
}