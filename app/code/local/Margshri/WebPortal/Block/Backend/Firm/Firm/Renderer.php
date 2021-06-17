<?php
class Margshri_WebPortal_Block_Backend_Firm_Firm_Renderer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
	
	protected $previousControllerName = 'Backend_Firm_Firm';
	public function render(Varien_Object $row){

		switch ($this->getColumn()->getIndex()) {
			case 'main_table.edit':
				if(Margshri_Helper_Utility::isACLAllowed("admin/managedate/firm/edit")){
					$url= 	$this->getUrl('*/*/edit', array('ID'=> $row->getData("main_table.ID")) );
					$html ="<a href='{$url}'  />{$row->getData('main_table.edit')}</a>";
				}	
				return $html;
		
			
			case 'main_table.SubPage':
				if(Margshri_Helper_Utility::isACLAllowed("admin/managedate/firm/subpage")){	
					$url= 	$this->getUrl('*/Backend_Center_SubPage_SubPage/', array('RecordID'=> $row->getData("main_table.ID"), 'TableCode'=>$row->getData("main_table.SubPageTableCode"), 'PreviousControllerName'=>$this->previousControllerName, 'PageTitle'=>$row->getData("main_table.Value") ) );
					$html ="<a href='{$url}'  />{$row->getData('main_table.SubPage')}</a>";
				}	
				return $html;
				

			case 'main_table.Email':
				$html ="<p style='word-break: break-all;'> {$row->getData('main_table.Email')} </p>";
				return $html;

				
			case 'main_table.TableCodes':
				$html ="<p style='word-break: break-all;'> {$row->getData('main_table.TableCodes')} </p>";
				return $html;
		}
	}
}