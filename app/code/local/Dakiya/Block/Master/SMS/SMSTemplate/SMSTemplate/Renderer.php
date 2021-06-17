<?php
class Dakiya_Block_Master_SMS_SMSTemplate_SMSTemplate_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.Edit':
				//if(Dakiya_Helper_Utility::isACLAllowed("admin/master/system/systemconfig/edit")){
					$url  = $this->getUrl('*/*/edit', array('TemplateID'=> $row->getData("main_table.TemplateID") ) );
					$html = "<a href='{$url}' />{$row->getData('main_table.Edit')}</a>";
					return $html;
				//}
				return;
		}

	}
}