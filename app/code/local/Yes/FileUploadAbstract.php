<?php

abstract class Yes_FileUploadAbstract
{
	abstract public function fileProcessing($recordFile,$imageFile);
	abstract public function preValidation();
	abstract public function generateFlatFile();
	
}