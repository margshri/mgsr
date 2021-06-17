<?php
class Margshri_Transport_Block_Backend_Master_Vahicale_Common_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.Edit':
			    if(Margshri_Helper_Utility::isACLAllowed("admin/transport/master/common/edit")){
					$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID")) );
					$html ="<a href='{$url}'  />{$row->getData('main_table.Edit')}</a>";
				}	
				return $html;
		}
	}
}