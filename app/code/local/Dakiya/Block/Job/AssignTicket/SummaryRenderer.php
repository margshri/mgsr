<?php
class Dakiya_Block_Job_AssignTicket_SummaryRenderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

	public function render(Varien_Object $row){
		switch ($this->getColumn()->getIndex()) {
			case 'au.username':
				$url  = $this->getUrl('*/*/showGrid', array('AssignToUserID'=> $row->getData("main_table.AssignTO") ) );
				$html = "<a href='{$url}' target = '_blank' />{$row->getData('au.username')}</a>";
				return $html;
		}
		return;
	}
}