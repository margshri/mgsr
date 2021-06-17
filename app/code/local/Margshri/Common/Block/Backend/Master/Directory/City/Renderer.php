<?php
class Margshri_Common_Block_Backend_Master_Directory_City_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.Edit':
				 if(Margshri_Helper_Utility::isACLAllowed("admin/master/directory/city/edit")){
					$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID")) );
					$html ="<a href='{$url}'  />{$row->getData('main_table.Edit')}</a>";
				 }	
				return $html;
		}
	}
}