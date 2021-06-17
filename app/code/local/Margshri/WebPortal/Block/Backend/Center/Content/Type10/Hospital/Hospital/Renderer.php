<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type10_Hospital_Hospital_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	protected $previousActionName = 'index';
	protected $previousControllerName = 'Backend_Center_Content_Type10_Hospital_Hospital';
	
	
	public function render(Varien_Object $row)
	{
		
		switch ($this->getColumn()->getIndex()) {
			case 'main_table.edit':
				$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID"), 'TableCode'=>$this->getColumn()->gettablecode() ) );
				$html ="<a href='{$url}'  />{$row->getData('main_table.edit')}</a>";
				return $html;
				
			case 'main_table.SubPage':
				$url= 	$this->getUrl('*/Backend_Center_SubPage_SubPage/', array('RecordID'=> $row->getData("main_table.ID"), 'TableCode'=>$this->getColumn()->gettablecode(), 'PreviousControllerName'=>$this->previousControllerName, 'PreviousActionName'=>$this->previousActionName, 'PageTitle'=>$row->getData("main_table.Value") ) );
				$html ="<a href='{$url}'  />{$row->getData('main_table.SubPage')}</a>";
				return $html;
				
			}
			
			
			
			
	}
}