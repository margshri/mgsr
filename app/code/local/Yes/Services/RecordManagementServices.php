<?php

class Yes_Services_RecordManagementServices{
	
	public function isColumnTypeValid($columnException, $columnValue){
		$errorMsg = null;
		for($rowIndex=0 ;$rowIndex < sizeof($columnException); $rowIndex++){
			if($columnException[$rowIndex] == Yes_VO_Exception_ExceptionVO::$NULLABLE){
				if(is_null($columnValue)){
					$errorMsg = "Field is empty";
					return $errorMsg;
				}
			}
			if($columnException[$rowIndex] == Yes_VO_Exception_ExceptionVO::$NUMERIC){
				if(!is_numeric($columnValue)){
					$errorMsg = "Only numeric value allowed";
					return $errorMsg;		
				}
			}
			if($columnException[$rowIndex] == Yes_VO_Exception_ExceptionVO::$STRING){
				if(!is_string($columnValue)){
					$errorMsg = "Only string value allowed";
					return $errorMsg;		
				}
			}
			if($columnException[$rowIndex] == Yes_VO_Exception_ExceptionVO::$FLOAT)	{
				if(!is_float($columnValue)){
					$errorMsg = "Only float value allowed";
					return $errorMsg;		
				}
			}
			if($columnException[$rowIndex] == Yes_VO_Exception_ExceptionVO::$BOOL){
				if(!is_bool($columnValue)){
					$errorMsg = "Only boolian value allowed";
					return $errorMsg;		
				}
			}
		}
		return $errorMsg;
	}
	
	// check column length
	public function isColumnLengthValid($columnLenght, $columnValue){
		if($columnLenght != null){
			if(strlen($columnValue) <= $columnLenght) return true;
			else return false;
		}
		else return false;
	}
	
	// image validation
	public function isImageValid($columnKey, $imageName, $imageFile){
			$flag = null;
			// if image exist in uploaded image
			for($rowIndex = 0; $rowIndex < sizeof($imageFile["name"]); $rowIndex++){
				if($imageName == $imageFile["name"][$rowIndex]){
					$flag = 1;
					
					//check image size
					$isValidImageSize = $this->is_ValidImageSize($columnKey, $imageFile["size"][$rowIndex]);
					
					// check image dimension
					//$isValidImageDimension = $this->is_ValidImageDimension($columnKey, $imageFile["name"][$rowIndex]);
					
					// check image type
					$isValidImageType = $this->is_ValidImageType($imageFile["type"][$rowIndex]);
					
					// check image extionsion
					$isValidImageExtension = $this->is_ValidImageExtension($imageFile["name"][$rowIndex]);
					
					if(is_ValidImageSize &&  $isValidImageType && $isValidImageExtension)
						return true;
					else
						return false;
				}
			}
			if(!isset($flag))
				return false;		
	}// end image validation function

	public function is_ValidImageSize($imageType, $imageSize){
		
		if ($imageType == Yes_ApplicationConstant::$BASE_IMAGE_TYPE){
			if ($imageSize <= Yes_ApplicationConstant::$BASE_IMAGE_SIZE_LIMIT )
				return true;
			else
				return false;
		}
		if ($imageType == Yes_ApplicationConstant::$SMALL_IMAGE_TYPE){
			if ($imageSize <= Yes_ApplicationConstant::$SMALL_IMAGE_SIZE_LIMIT)
				return true;
			else
				return false;
		}
		if ($imageType == Yes_ApplicationConstant::$THUMBNAIL_IMAGE_TYPE){
			if ($imageSize <= Yes_ApplicationConstant::$THUMBNAIL_IMAGE_SIZE_LIMIT)
				return true;
			else
				return false;
		}
	}
	
	/*
	public function is_ValidImageDimension($imageType, $image){
		
		list($width, $height) = getimagesize($image);
		$dimension = $width * $height;	
		if ($imageType == Yes_ApplicationConstant::$BASE_IMAGE_TYPE){
			if ($dimension <= Yes_ApplicationConstant::$BASE_IMAGE_SIZE_LIMIT )
				return true;
			else
				return false;
		}
		if ($imageType == Yes_ApplicationConstant::$SMALL_IMAGE_TYPE){
			if ($dimension <= Yes_ApplicationConstant::$SMALL_IMAGE_SIZE_LIMIT)
				return true;
			else
				return false;
		}
		if ($imageType == Yes_ApplicationConstant::$THUMBNAIL_IMAGE_TYPE){
			if ($dimension <= Yes_ApplicationConstant::$THUMBNAIL_IMAGE_SIZE_LIMIT)
				return true;
			else
				return false;
		}
	}
	*/

	public function is_ValidImageType($imageType){
		if (($imageType == "image/gif")
				|| ($imageType == "image/jpeg")
				|| ($imageType == "image/jpg")
				|| ($imageType == "image/png")){
			return true;
		}
		else 
		   return false;
	}

	public function is_ValidImageExtension($imageName){
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$extension = substr(strrchr($imageName, '.'), 1);
		if (in_array($extension, $allowedExts))
			return true;
		else
			return false;
	}
	
	public function saveImage($imageName, $imageFile){
		$flag = null;
		for($rowIndex = 0; $rowIndex < sizeof($imageFile["name"]); $rowIndex++){
			if($imageName == $imageFile["name"][$rowIndex]){
				$flag = 1;
					if ($imageFile["error"][$rowIndex] > 0)
						return false;
					else
					{
						$upload = Yes_Utility::getServerPath() . "/media/catalog/product/";
						$filename = $imageFile["name"][$rowIndex];
						$str_first =  substr($filename,0,1);
						$str_first_lower = strtolower($str_first);
						umask(0);
						if (!is_dir($upload . $str_first_lower)) {
							mkdir($upload . $str_first_lower);
						}
						$str_second =  substr($filename,1,1);
						$str_second_lower = strtolower($str_second);
						if (!is_dir($upload . $str_first_lower . '/' . $str_second_lower)) {
							mkdir($upload . $str_first_lower . '/' . $str_second_lower);
						}
						$upload_dir = $upload . $str_first_lower . '/' . $str_second_lower . '/';
						move_uploaded_file($imageFile["tmp_name"][$rowIndex],$upload . $imageFile["name"][$rowIndex]);
						return true;
						/*
						if (file_exists($upload_dir . $imageFile["name"][$rowIndex])){
							//echo $_FILES["fileImage"]["name"][$i] . " already exists.<br /> ";
							return false;
						}
						else{
							move_uploaded_file($imageFile["tmp_name"][$rowIndex],$upload_dir . $imageFile["name"][$rowIndex]);
							//echo "Stored in: " . $upload_dir . $_FILES["fileImage"]["name"][$i] . "<br /> ";
							return true;
						}
						*/
					}
				}
			}
		if(!isset($flag))
			return false;
		
	}// end saveImage function
	
        
}