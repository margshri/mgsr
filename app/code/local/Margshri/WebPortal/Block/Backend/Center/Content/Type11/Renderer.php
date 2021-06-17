<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type11_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

	public function render(Varien_Object $row)
	{

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.edit':
				$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID"), 'TableCode'=>$this->getColumn()->gettablecode() ) );
				$html ="<a href='{$url}'  />{$row->getData('main_table.edit')}</a>";
				return $html;
			}
	}
}