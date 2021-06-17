<?php
class Yes_CatalogUpload_Helper_Image  extends Mage_Catalog_Helper_Image{
    
    public function getImageURL()
    {
    	try {
    		$model = $this->_getModel();
    
    		if ($this->getImageFile()) {
    			$model->setBaseFile($this->getImageFile());
    		} else {
    			$model->setBaseFile($this->getProduct()->getData($model->getDestinationSubdir()));
    		}
    
    		if ($model->isCached()) {
    			$imagedata = file_get_contents($model->getUrl());
    			// alternatively specify an URL, if PHP settings allow
    			$base64URL = 'data:image/jpeg;base64,'. base64_encode($imagedata);
    			
    			return $base64URL;
    		} else {
    			if ($this->_scheduleRotate) {
    				$model->rotate($this->getAngle());
    			}
    
    			if ($this->_scheduleResize) {
    				$model->resize();
    			}
    
    			if ($this->getWatermark()) {
    				$model->setWatermark($this->getWatermark());
    			}
    
    			$url = $model->saveFile()->getUrl();
    		}
    	} catch (Exception $e) {
    		$url = Mage::getDesign()->getSkinUrl($this->getPlaceholder());
    	}
    	
    	$imagedata = file_get_contents($url);
    	// alternatively specify an URL, if PHP settings allow
    	$base64URL = 'data:image/jpeg;base64,'. base64_encode($imagedata);
    	   
    	return $url;
    }
}
