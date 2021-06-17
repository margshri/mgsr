<?php

class Yes_Services_TemplateManagementServices
{
	public function is_ValidProductTemplate($templateArray, $flatFileArray)
	{
		if (sizeof($templateArray) == sizeof($flatFileArray))
		{
			for($i=0 ; $i < sizeof($templateArray); $i++)
			{
				if ($templateArray[$i]->getColumnName() !== $flatFileArray[$i] )
				{
					return false;	
				}
			}
		}
		else
		{
			return false;		
		}
		
		if($i  == sizeof($templateArray))
			return true;
		else
			return false; 
	}
	
        
}