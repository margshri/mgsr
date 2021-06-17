<?php
class Margshri_Common_Block_Backend_User_User_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.Edit':
				if(Margshri_Helper_Utility::isACLAllowed("admin/user/edit")){
					$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID")) );
					$html ="<a href='{$url}'  />{$row->getData('main_table.Edit')}</a>";
				}	
				return $html;

			case 'main_table.Email':
				$html ="<p style='word-break: break-all;'> {$row->getData('main_table.Email')} </p>";
				return $html;

		}
	}
}