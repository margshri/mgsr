<?php
class Margshri_WebPortal_Block_Backend_Master_Bidding_CreateBid_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.edit':
				$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID")  ) );
				$html ="<a href='{$url}'  />{$row->getData('main_table.edit')}</a>";
				return $html;
			
			case 'cev.value':
				$url= 	$this->getUrl('adminhtml/customer/edit', array('id'=> $row->getData("cev.entity_id")  ) );
				$html ="<a href='{$url}'  />{$row->getData('cev.value')}</a>";
				return $html;
		}
	}
}