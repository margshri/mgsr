<?php
class Margshri_WebPortal_Model_Mysql4_Master_Right_BidProducts extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebbidproducts', 'ID');
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getByBidID($bidID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getLastActiveByBidID($bidID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE)
		->order("ID Desc")
		->limit(1);
		$dataObj =  $read->fetchRow($select);
		
		$dataObjs[] = $dataObj;
		$newDataObjs = array();
		foreach($dataObjs as $dataObj){
			$productDetail = $this->getProductDetailByProductID($dataObj['ProductID']);
			foreach($productDetail as $key=>$val){
				$dataObj[$key] = $val; 
			}
			$newDataObjs[] = $dataObj; 
		}
		return $newDataObjs;
	}
	
	
	public function getProductDetailByProductID($productID){
		$productDetail = array();
		$model = Mage::getModel('catalog/product');
		$products = $model->getCollection()
		->addAttributeToSelect('*')
		->addAttributeToFilter('entity_id', $productID)
		->addAttributeToSort('name', Varien_Data_Collection::SORT_ORDER_ASC)->load();
		 
		foreach ($products as $product){
			$productDetail['ProductID'] = $product->getId();
			$productDetail['ProductName'] = $product->getName();
			$productDetail['ProductCode'] = $product->getsku();
			$productDetail['ProductImage'] = $product->getsmall_image();
			$productDetail['ProductDescription'] = $product->getshort_description();
			$productDetail['ProductPrice'] = $product->getprice();
			$productDetail['ProductWeight'] = $product->getweight();
			$productDetail['ProductWeightUnit'] = $product->getweight_unit();
		}
		return $productDetail;
	}

	
	public function getProductOptions(){
		$options = array();
		//$model = Mage::getModel('catalog/product');
		//$products = $model->getCollection()
		$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
		$BID_PRODUCT_CATAGORY_URL_KEY = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_PRODUCT_CATAGORY_URL_KEY);
		
		$category = Mage::getModel ('catalog/category')
		->getCollection ()
		->addAttributeToFilter ('url_key', $BID_PRODUCT_CATAGORY_URL_KEY)
		->getFirstItem ();
		
		$BID_PRODUCT_CATAGORY_ID = $category->getentity_id();
		
		$products = Mage::getModel('catalog/category')->load($BID_PRODUCT_CATAGORY_ID)
		->getProductCollection()
		->addAttributeToSelect('*')
		->addAttributeToSort('name', Varien_Data_Collection::SORT_ORDER_ASC)->load();
		 
		foreach ($products as $product){
			$options[$product->getId()] = $product->getName() . " (" . $product->getsku() . ")";
		}
		 
		return $options;
	}
	
	public function getByBidIDAndProductID($bidID, $productID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID)
		->where("ProductID =?", $productID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	 
	
	public function saveDB(Margshri_WebPortal_VO_Master_Right_BidProductsVO $bidProductsVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE 
		$bidProductsDTO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
	
		if($bidProductsVO->getID() > 0){
			
			// $dataObj = $this->getByBidIDAndProductID($bidProductsVO->getBidID(), $bidProductsVO->getProductID());
			$dataObj = $this->getByBidID($bidProductsVO->getBidID());
			
			if($dataObj !== false){
				$newBidProductsDTO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
				/* @var $newBidProductsVO Margshri_WebPortal_VO_Master_Right_BidProductsVO */
				$newBidProductsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newBidProductsDTO, $dataObj);
				
				if($bidProductsVO->getID() != $newBidProductsVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Product Mapping For This Bid  !';
					return $response;
				}
			}
			
			
			$rowSet = $bidProductsDTO->find( $bidProductsVO->getID());
			$row    = $rowSet['_data'];
			
			$bidProductsVO->setUpdatedAt($serverDate);
			$bidProductsVO->setUpdatedBy($userID);
		}else{
			
			// $dataObj = $this->getByBidIDAndProductID($bidProductsVO->getBidID(), $bidProductsVO->getProductID());
			$dataObj = $this->getByBidID($bidProductsVO->getBidID());
			if($dataObj !== false){
				
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Product Mapping For This Bid  !';
				return $response;
			}	
			
			$row = $bidProductsDTO->fetchNew();
			
			$bidProductsVO->setCreatedAt($serverDate);
			$bidProductsVO->setCreatedBy($userID);
			$bidProductsVO->setUpdatedAt($serverDate);
			$bidProductsVO->setUpdatedBy($userID);
		}
	
		foreach($bidProductsVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}