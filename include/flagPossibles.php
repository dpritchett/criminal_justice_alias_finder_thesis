<?php

function flagPossibles($possibles, $suspSSN, $suspName, $doNameLev, $doSSNLev, $doSoundex, $multiSearch, $doSubStr, $name_thresh, $num_thresh)
{
		include_once("class_suspect.php");
			//step through $possibles, identifying matches and discarding misses
			
	  $newSusp = array();
	  
 		while(sizeof($possibles) > 0 && $row = array_pop($possibles))
 			{
 				$flag = 0;
 				//is there an exact match?
 				if($suspSSN == $row->ssn || $suspName == $row->fname || $suspName == $row->lname)
 				{
 					$flag = 1;
 					$row->exactMatch = 1;
 				}
 				
 				//are there any edit distance matches on SSN?
  			if($doSSNLev && (levenshtein($row->ssn, $suspSSN) <= $num_thresh))
  			{
     			$flag = 1;
     			$row->ssnMatch = 1;
     		}
     		
     		//are there any soundex matches on names?
				if($doSoundex && (soundex($suspName) == soundex($row->fname)))
      		{
						$flag = 1;
						$row->fnameMatch = 1;
					}
				if($doSoundex && (soundex($suspName) == soundex($row->lname)))
      		{
						$flag = 1;
						$row->lnameMatch = 1;
					}	
					
      	//are there any edit distance matches on names?
				if($doNameLev && (levenshtein($row->fname,$suspName) <= $name_thresh))
					{
						$flag = 1;
						$row->fnameMatch = 1;
					}
				if($doNameLev && (levenshtein($row->lname,$suspName) <= $name_thresh))
					{
						$flag = 1;
						$row->lnameMatch = 1;
					}
					
				//are there any substring matches on names?
				if($doSubStr && (strlen($suspName)))
				{
					if(substr_count($row->fname,$suspName))
					{
						$flag = 1;
						$row->fnameMatch = 1;
					}
					if(substr_count($row->lname,$suspName))
					{
						$flag = 1;
						$row->lnameMatch = 1;
					}
				}
				
				//are there any substring matches on SSN?
				if($doSubStr && (strlen($suspSSN) > 0))
				{
					if(substr_count($row->ssn,$suspSSN))
					{
						$flag = 1;
						$row->ssnMatch = 1;
					}
				}
				
				if($flag == 1)	 
					 array_unshift($newSusp, $row); 
			}
		
		$possibles = $newSusp;
		
		return $possibles;	
}

?>
